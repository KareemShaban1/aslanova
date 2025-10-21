<template>
    <div class="cart-view">
        <h2 class="cart-title">{{ $t('myCart') }}</h2>

        <div v-if="cartItemsArray.length > 0">
            <div v-for="(item, index) in cartItemsArray" :key="index" class="cart-item">
                <img :src="getUserImageSrc(item.file)" alt="product" class="cart-item-img">
                
                <div class="cart-item-info">
                    <h4 class="cart-item-name">{{ item.name }}</h4>
                    <p class="cart-item-price">
                        <button @click="decreaseQuantity(item.id)" class="btn-quantity">-</button>
                        <span class="quantity">{{ item.quantity }}</span>
                        <button @click="increaseQuantity(item.id)" class="btn-quantity">+</button>
                        x ${{ item.price }}
                    </p>
                </div>

                <button @click="removeFromCart(item.id)" class="btn-remove">
                    {{ $t('remove') }}
                </button>
            </div>

            <div class="cart-total">
                <h3>{{ $t('total') }}: <span>${{ total }}</span></h3>
            </div>

            <button @click="handleCheckout" class="btn-checkout">
                {{ $t('checkout') }}
            </button>
        </div>

        <div v-else class="cart-empty">
            <p>{{ $t('noItemsInCart') }}</p>
        </div>
    </div>
</template>

<script>
import { computed, ref } from 'vue';
import { useCartStore } from './cartStore';

export default {
    setup() {
        const cartStore = useCartStore();
        const user = ref(null); // لتخزين بيانات المستخدم

        const cartItemsArray = computed(() => Object.values(cartStore.cartItems));
        const total = computed(() => cartStore.total);

        const getUserImageSrc = (photo) => {
            return photo ? `/storage/${photo}` : '/img/load.png';
        };

        const removeFromCart = (id) => {
            cartStore.removeFromCart(id);
        };

        const increaseQuantity = (id) => {
            cartStore.increaseQuantity(id);
        };

        const decreaseQuantity = (id) => {
            cartStore.decreaseQuantity(id);
            if (cartStore.cartItems[id]?.quantity === 0) {
                removeFromCart(id); // إزالة المنتج إذا وصلت الكمية إلى صفر
            }
        };

        const getUser = async () => {
            try {
                const response = await axios.get("/getuser");
                user.value = response.data;
            } catch (error) {
                console.log("User not logged in.");
            }
        };

        const handleCheckout = async () => {
            await getUser();

            if (user.value) {
                proceedToCheckout();
            } else {
                window.location.href = "/login";
            }
        };

        const proceedToCheckout = () => {
            const data = cartItemsArray.value.map(item => ({
                name: item.name,
                price: item.price,
                quantity: item.quantity
            }));

            axios.post('/payment', {
                items: data,
                total: total.value,
                user: user.value
            })
            .then(response => {
                if (response.data.success) {
                    window.location.href = response.data.redirect_url;
                } else {
                    alert(response.data.message || 'Failed to create PayPal order.');
                }
            })
            .catch(error => {
                console.error('Error during checkout:', error);
            });
        };

        return {
            cartItemsArray,
            total,
            increaseQuantity,
            getUserImageSrc,
            removeFromCart,
            decreaseQuantity,
            handleCheckout,
            proceedToCheckout,
        };
    },
};
</script>

<style scoped>
.cart-view {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    max-width: 800px;
    margin: 100px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.cart-title {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
    text-align: center;
}

.cart-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #fff;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.cart-item-img {
    width: 70px;
    height: 70px;
    border-radius: 8px;
    object-fit: cover;
}

.cart-item-info {
    flex-grow: 1;
    margin-left: 15px;
}

.cart-item-name {
    font-size: 18px;
    font-weight: 500;
    color: #555;
}

.cart-item-price {
    font-size: 14px;
    color: #777;
    margin-top: 5px;
}

.btn-remove {
    background-color: #e74c3c;
    color: #fff;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.btn-remove:hover {
    background-color: #c0392b;
}

.btn-checkout {
    display: block;
    background-color: #2ecc71;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    margin: 20px auto 0;
    transition: background-color 0.3s ease;
}

.btn-checkout:hover {
    background-color: #27ae60;
}

.cart-total {
    text-align: right;
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-top: 10px;
}

.cart-total span {
    color: #e74c3c;
}

.cart-empty {
    text-align: center;
    font-size: 18px;
    color: #999;
    padding: 30px 0;
}

.btn-quantity {
    background-color: #ddd;
    color: #333;
    border: none;
    padding: 5px 10px;
    font-size: 14px;
    margin: 0 5px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.btn-quantity:hover {
    background-color: #bbb;
}

.quantity {
    font-size: 16px;
    font-weight: bold;
    margin: 0 5px;
}
</style>
