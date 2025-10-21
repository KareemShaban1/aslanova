<template>
    <li class="nav-item" @click.self="isOpen = false">
        <a class="custom-nav-link" href="#" @click.prevent="toggleDropdown">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="custom-cart-icon">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span class="custom-badge">{{ totalItems }}</span>
        </a>
        <ul v-if="isOpen" class="custom-dropdown-menu" @click.stop>
            <li class="custom-dropdown-header">
                <div class="custom-header">
                    <h4 class="custom-title">{{ $t('myCart') }}</h4>
                    <div class="custom-items-count">{{ totalItems }} {{ $t('items') }}</div>
                </div>
            </li>
            <li class="custom-scrollable-container">
                <div v-if="Object.keys(cartItems).length === 0" class="custom-no-items text-center">
                    <p>{{ $t('noItemsInCart') }}</p>
                </div>
                <div v-for="(item, id) in cartItems" :key="id" class="custom-list-item">
                    <div class="custom-item-body">
                        <img class="custom-product-img" :src="getUserImageSrc(item.file)" alt="product">
                        <div class="custom-media-heading">
                            <h6 class="custom-item-title">{{ item.name }}</h6>
                        </div>
                        <div class="custom-quantity-controls">
                            <button class="custom-btn-cart" @click="updateQuantity(id, -1)">-</button>
                            <span>{{ item.quantity }}</span>
                            <button class="custom-btn-cart" @click="updateQuantity(id, 1)">+</button>
                        </div>
                        <h5 class="custom-item-price">{{ item.price * item.quantity }}
			<i class="fa-solid fa-euro-sign"></i>
		    </h5>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="custom-cart-item-remove" @click="removeFromCart(id)">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
            </li>
            <li class="custom-dropdown-footer" v-if="Object.keys(cartItems).length > 0">
                <div class="custom-total d-flex justify-content-between">
                    <h6>{{ $t('total') }}:</h6>
                    <h6 class="custom-total-price">{{ total }}
			<i class="fa-solid fa-euro-sign"></i>
		    </h6>
                    <h6>{{ $t('shipping price') }}:</h6>
                    <h6 class="custom-total-price">{{ shipping_price }}
			<i class="fa-solid fa-euro-sign"></i>
		    </h6>
                </div>
                <router-link to="/dashboard/cart" class="custom-checkout-btn">{{ $t('viewCart') }}</router-link>
            </li>
        </ul>
    </li>
</template>
<script>
import { computed, ref, watch, onMounted, onBeforeUnmount } from 'vue';
import { useCartStore } from './cartStore';
export default {
    setup() {
        const cartStore = useCartStore();
        const isOpen = ref(false);
        cartStore.fetchCartItems();
        watch(() => cartStore.cartItems, (newItems) => {
            console.log("Cart items updated", newItems);
        }, { deep: true });
        const cartItems = computed(() => cartStore.cartItems);
        const total = computed(() => cartStore.total);
        const totalItems = computed(() => cartStore.totalItems);
        const shipping_price = computed(() => cartStore.totalShipping);

        const toggleDropdown = () => {
            isOpen.value = !isOpen.value;
        };
        const closeDropdown = (event) => {
            if (!event.target.closest('.nav-item')) {
                isOpen.value = false;
            }
        };
        const getUserImageSrc = (photo) => {
            return photo ? `/storage/${photo}` : '/img/load.png';
        };
        onMounted(() => {
            document.addEventListener('click', closeDropdown);
        });
        onBeforeUnmount(() => {
            document.removeEventListener('click', closeDropdown);
        });
        return {
            cartItems,
            total,
            totalItems,
            shipping_price,
            isOpen,
            toggleDropdown,
            addToCart: cartStore.addToCart,
            removeFromCart: cartStore.removeFromCart,
            updateQuantity: cartStore.updateQuantity,
            getUserImageSrc,
        };
    }
};
</script>

<style scoped>
.nav-item {
    position: relative;
    list-style-type: none;
    padding: 10px;
}

.custom-cart-icon {
    color: aliceblue;
}

.custom-no-items {
    color: var(--mainColor);
}

.custom-dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    min-width: 300px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.custom-nav-link {
    display: flex;
    align-items: center;
    color: white;
    position: relative;
}

.custom-badge {
    font-size: 12px;
    background-color: var(--secondaryColor);
    color: white;
    border-radius: 10px;
    padding: 2px 6px;
    position: absolute;
    top: -20px;
    right: -10px;
}

.custom-dropdown-header,
.custom-dropdown-footer {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    color: var(--mainColor);
}

.custom-scrollable-container {
    max-height: 200px;
    overflow-y: auto;
    padding: 10px;
}

.custom-product-img {
    width: 60px;
    height: auto;
    border-radius: 5px;
    margin-right: 10px;
}

.custom-item-body {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    color: var(--mainColor);

}

.custom-item-body * {
    display: flex;
    align-items: center !important;
    justify-content: space-evenly !important;
}

.custom-media-heading {
    flex: 1;
}

.custom-item-title {
    font-size: 14px;
    margin: 0;
    color: #333;
    display: flex;
    align-items: center;
}

.custom-item-by {
    font-size: 12px;
    color: #777;
}

.custom-quantity-controls {
    display: flex;
    align-items: center;
}

.custom-btn-cart {
    padding: 2px 10px;
    background-color: var(--mainColor);
    color: white;
    border: none;
    border-radius: 4px;
    margin: 0 5px;
    cursor: pointer;
}

.custom-item-price {
    font-size: 14px;
    color: #333;
    display: flex;
    align-items: center;
    justify-content: center;
}

.custom-checkout-btn {
    display: block;
    text-align: center;
    padding: 10px;
    background-color: var(--mainColor);
    color: white;
    border-radius: 4px;
    text-decoration: none;
    margin-top: 10px;
}

.custom-total {
    font-size: 16px;
}

.custom-total-price {
    color: #007bff;
}
</style>