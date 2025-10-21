import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
    state: () => ({
        cartItems: {},
    }),
    getters: {
        // حساب إجمالي سعر المنتجات (بدون الشحن)
        total: (state) => {
            return Object.values(state.cartItems).reduce((sum, item) => sum + item.price * item.quantity, 0);
        },
        // حساب إجمالي سعر التوصيل (مرة واحدة لكل منتج)
        totalShipping: (state) => {
            return Object.values(state.cartItems).reduce((sum, item) => sum + (item.shipping_price || 0), 0);
        },
        // حساب إجمالي عدد العناصر في السلة
        totalItems: (state) => {
            return Object.values(state.cartItems).reduce((sum, item) => sum + item.quantity, 0);
        },
        // حساب الإجمالي الكامل (سعر المنتجات + سعر التوصيل)
        grandTotal: (state) => {
            return state.total + state.totalShipping;
        }
    },
    actions: {
        // إضافة منتج إلى السلة
        addToCart(item) {
            if (item) {
                // إنشاء مفتاح فريد بناءً على خصائص العنصر
                const uniqueKey = JSON.stringify(item);
        
                if (this.cartItems[uniqueKey]) {
                    this.updateItemQuantity(uniqueKey, 1); // تحديث الكمية إذا كان العنصر موجودًا
                } else {
                    this.$patch((state) => {
                        state.cartItems[uniqueKey] = { 
                            ...item, 
                            quantity: 1,
                            shipping_price: parseFloat(item.shipping_price) || 0 // التأكد من أن السعر رقمي
                        };
                    });
                }
                this.saveToLocalStorage();
                this.fetchCartItems(); // تحديث السلة بعد الإضافة
            }
        },
        // إزالة منتج من السلة
        removeFromCart(itemId) {
            if (this.cartItems[itemId]) {
                this.$patch((state) => {
                    delete state.cartItems[itemId];
                });
                this.saveToLocalStorage();
                this.fetchCartItems(); // جلب القيم بعد الإزالة
            }
        },
        // تحديث كمية المنتج
        updateQuantity(itemId, change) {
            if (this.cartItems[itemId]) {
                this.updateItemQuantity(itemId, change); // استخدم دالة تحديث الكمية
                this.saveToLocalStorage();
                this.fetchCartItems(); // جلب القيم بعد التحديث
            }
        },
        // تحديث كمية المنتج (دالة مساعدة)
        updateItemQuantity(itemId, change) {
            this.$patch((state) => {
                state.cartItems[itemId].quantity += change;
                if (state.cartItems[itemId].quantity <= 0) {
                    delete state.cartItems[itemId];
                }
            });
        },
        // زيادة كمية المنتج
        increaseQuantity(itemId) {
            this.updateItemQuantity(itemId, 1);
        },
        // تقليل كمية المنتج
        decreaseQuantity(itemId) {
            this.updateItemQuantity(itemId, -1);
        },
        // جلب العناصر من localStorage
        fetchCartItems() {
            try {
                const storedCartItems = localStorage.getItem('cartItems');
                this.cartItems = this.filterInvalidItems(storedCartItems ? JSON.parse(storedCartItems) : {});
                if (!storedCartItems || Object.keys(JSON.parse(storedCartItems)).length === 0) {
                    localStorage.setItem('cartItems', JSON.stringify({}));
                }
            } catch (error) {
                console.error('Error parsing cart items from localStorage:', error);
                this.cartItems = {};
                localStorage.setItem('cartItems', JSON.stringify({}));
            }
        },
        // تصفية العناصر غير الصالحة
        filterInvalidItems(items) {
            return Object.keys(items).reduce((result, key) => {
                if (items[key] && items[key].quantity > 0) {
                    result[key] = items[key];
                }
                return result;
            }, {});
        },
        // حفظ العناصر في localStorage
        saveToLocalStorage() {
            localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
        },
        // إرسال السلة إلى الخادم (اختياري)
        clearCart() {
            this.$patch((state) => {
                state.cartItems = {};
            });
            this.saveToLocalStorage();
        },
        async sendCartToServer() {
            try {
                // تنفيذ منطق الإرسال إلى الخادم هنا
                console.log('Sending cart to server...', this.cartItems);
                
                // بعد نجاح العملية، يتم مسح السلة
                this.clearCart();
            } catch (error) {
                console.error('Error sending cart to server:', error);
            }
        }
    },
});