<template>
	<div class="cart-view">
	  <!-- Header -->
	  <div class="cart-header d-flex justify-content-between align-items-center mb-4">
	    <h2 class="fw-bold"><i class="fa-solid fa-cart-shopping me-2"></i>{{ $t('myCart') }}</h2>
	    <button @click="handleCheckout" class="btn btn-gradient">
	      {{ $t('Checkout') }}
	      <i class="fa-solid fa-arrow-right ms-2"></i>
	    </button>
	  </div>
        
	  <!-- Cart Items -->
	  <div v-if="Object.keys(cartItems).length > 0">
	    <div class="cart-items-container">
	      <div v-for="(item, id) in cartItems" :key="id" class="cart-item shadow-sm">
	        <div class="d-flex align-items-center gap-3">
		<img :src="getUserImageSrc(item.file)" alt="product" class="cart-item-img" />
		<div class="flex-grow-1">
		  <div class="d-flex justify-content-between align-items-center mb-1">
		    <h5 class="mb-0 fw-semibold">{{ item.name }}</h5>
		    <button @click="removeFromCart(id)" class="btn btn-sm btn-outline-danger">
		      <i class="fa fa-trash"></i>
		    </button>
		  </div>
		  <p class="text-muted small mb-2">{{ item.quantity }} × {{ item.price }}€</p>
		  <h6 class="fw-bold text-primary mb-3">{{ item.price * item.quantity }} €</h6>
        
		  <div class="quantity-controls">
		    <button @click="updateQuantity(id, -1)" class="btn-quantity">−</button>
		    <span class="quantity mx-2">{{ item.quantity }}</span>
		    <button @click="updateQuantity(id, 1)" class="btn-quantity">+</button>
		  </div>
        
		  <div v-if="item.partsBreakdown?.length || item.texturesBreakdown?.length" class="mt-3 details">
		    <div v-if="item.partsBreakdown?.length" class="details-section">
		      <h6 class="fw-semibold mb-2">{{ $t('Parts details') }}</h6>
		      <ul class="details-list">
		        <li v-for="part in item.partsBreakdown" :key="part.name">
			<span>{{ part.name }}</span>
			<span>{{ part.price }} €</span>
		        </li>
		      </ul>
		    </div>
        
		    <div v-if="item.texturesBreakdown?.length" class="details-section mt-2">
		      <h6 class="fw-semibold mb-2">{{ $t('Texture details') }}</h6>
		      <ul class="details-list">
		        <li v-for="texture in item.texturesBreakdown" :key="texture.name">
			<span>{{ texture.name }}</span>
			<span>{{ texture.price }} €</span>
		        </li>
		      </ul>
		    </div>
		  </div>
		</div>
	        </div>
	      </div>
	    </div>
        
	    <!-- Total -->
	    <div class="cart-summary card shadow-sm p-3 mt-4">
	      <h4 class="fw-bold text-end mb-0">
	        {{ $t('total') }}: <span class="text-primary">{{ total }} €</span>
	        <span v-if="shipping_price === 0" class="text-success">(+ {{ $t('Free Delivery') }})</span>
	        <span v-else class="text-muted">(+ {{ shipping_price }} € {{ $t('shipping price') }})</span>
	      </h4>
	    </div>
	  </div>
        
	  <!-- Empty State -->
	  <div v-else class="empty-cart text-center py-5">
	    <i class="fa-solid fa-cart-arrow-down fa-3x text-muted mb-3"></i>
	    <p class="text-muted">{{ $t('noItemsInCart') }}</p>
	  </div>
	</div>
        </template>
        
<script>
import axios from 'axios';
import { computed, ref } from 'vue';
import { useCartStore } from './cartStore';
import { useRouter } from "vue-router";

export default {
  setup() {
    const cartStore = useCartStore();
    cartStore.fetchCartItems();
    const user = ref(null);
    // const cartItems = computed(() => Object.values(cartStore.cartItems));
    const cartItems = computed(() => cartStore.cartItems);
    const total = computed(() => cartStore.total);
    const shipping_price = computed(() => cartStore.totalShipping);
    const router = useRouter();

    console.log("Cart Items Array:", cartItems.value); // تصحيح: عرض العناصر في السلة

    const getUserImageSrc = (photo) => {
      return photo ? `/storage/${photo}` : '/img/load.png';
    };

    const getUser = async () => {
      try {
        const response = await axios.get("/getuser");
        user.value = response.data;
        if (user.value && user.value.email) {
          email.value = user.value.email;
        }
        console.log("User info:", user.value);
      } catch (error) {
        console.log("User not logged in.");
      }
    };

    const handleCheckout = async () => {
      await getUser();
      if (user.value) {
        router.push("/dashboard/order");
      } else {
        window.location.href = "/login";
      }
    };

    return {
      cartItems,
      total,
      shipping_price,
      getUserImageSrc,
      handleCheckout,
      updateQuantity: cartStore.updateQuantity,
      removeFromCart: cartStore.removeFromCart,
    };
  },
};
</script>


<style scoped>
.cart-view {
  padding: 20px;
  max-width: 1000px;
  margin: 0 auto;
}

.cart-header h2 {
  font-size: 1.8rem;
}

.btn-gradient {
  background: linear-gradient(90deg, #007bff, #00bfff);
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  transition: 0.3s;
}
.btn-gradient:hover {
  background: linear-gradient(90deg, #0069d9, #0095cc);
}

.cart-items-container {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.cart-item {
  background: #fff;
  border-radius: 10px;
  padding: 15px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.cart-item:hover {
  transform: translateY(-3px);
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.08);
}

.cart-item-img {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 10px;
}

.btn-quantity {
  background: #f8f9fa;
  border: 1px solid #ccc;
  width: 32px;
  height: 32px;
  font-weight: bold;
  border-radius: 6px;
  transition: all 0.2s;
}
.btn-quantity:hover {
  background-color: #007bff;
  color: #fff;
  border-color: #007bff;
}

.details-section {
  background: #f8f9fa;
  border-radius: 8px;
  padding: 10px;
}
.details-list {
  list-style: none;
  padding: 0;
  margin: 0;
}
.details-list li {
  display: flex;
  justify-content: space-between;
  padding: 4px 0;
  border-bottom: 1px dashed #ddd;
  font-size: 0.9rem;
}
.details-list li:last-child {
  border-bottom: none;
}

.cart-summary {
  background-color: #fff;
  border-radius: 10px;
}

.empty-cart {
  display: flex;
  flex-direction: column;
  align-items: center;
}
</style>