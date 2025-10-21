<template>
	<div class="cart-view container py-4">
	  <!-- Header -->
	  <div class="d-flex justify-content-between align-items-center mb-4">
	    <h2 class="text-primary fw-bold">{{ $t('My order') }}</h2>
	    <router-link to="/dashboard/cart" class="btn btn-outline-primary">
	      <i class="fa-solid fa-basket-shopping me-2"></i>{{ $t('Back to View Cart') }}
	    </router-link>
	  </div>
        
	  <!-- Cart Items -->
	  <div v-if="cartItemsArray.length">
	    <div class="card shadow-sm p-3 mb-4">
	      <h4 class="text-secondary mb-3"><i class="fa-solid fa-cart-shopping me-2"></i>{{ $t('Cart Summary') }}</h4>
	      <div v-for="(item, index) in cartItemsArray" :key="index" class="cart-item border-bottom py-3 d-flex mb-3">
	        <img :src="getUserImageSrc(item.file)" alt="product" class="cart-item-img me-3 rounded">
	        <div class="flex-grow-1">
		<div class="d-flex justify-content-between align-items-center">
		  <h5 class="fw-semibold">{{ item.name }}</h5>
		  <button @click="item.showConfirm = !item.showConfirm" class="btn btn-sm btn-outline-danger">
		    <i class="fa fa-trash"></i>
		  </button>
		</div>
		<p class="mb-1">{{ item.quantity }} × 
		   {{ item.price }} <i class="fa-solid fa-euro-sign"></i> = 
		  <span class="fw-bold">{{ item.price * item.quantity }} <i class="fa-solid fa-euro-sign"></i></span>
		</p>
        
		<div v-if="item.partsBreakdown?.length || item.texturesBreakdown?.length" class="mt-2">
		  <h6 class="fw-semibold">{{ $t('Details') }}</h6>
		  <ul class="small text-muted mb-0">
		    <li v-for="part in item.partsBreakdown" :key="part.name">{{ part.name }} - {{ part.price }}€</li>
		    <li v-for="texture in item.texturesBreakdown" :key="texture.name">{{ texture.name }} - {{ texture.price }}€</li>
		  </ul>
		</div>
        
		<div v-if="item.showConfirm" class="mt-3 bg-light p-2 rounded text-center">
		  <p class="mb-2">{{ $t('Are You Sure To Remove This Item From The cart ?') }}</p>
		  <button @click="removeFromCart(item.id)" class="btn btn-danger btn-sm me-2">{{ $t('Confirm') }}</button>
		  <button @click="cancelRemove(item.id)" class="btn btn-secondary btn-sm">{{ $t('Cancel') }}</button>
		</div>
	        </div>
	      </div>
	       <!-- Total -->
	    <div class="text-end mb-4">
		<h4 class="fw-bold">
		  {{ $t('Total') }}:
		  {{ total }} <i class="fa-solid fa-euro-sign"></i>
		  <span v-if="shipping_price === 0" class="text-success">(+ {{ $t('Free Delivery') }})</span>
		  <span v-else class="text-success">(+ {{ shipping_price }} <i class="fa-solid fa-euro-sign"></i> {{ $t('shipping price') }})</span>
		</h4>
	        </div>
	    </div>
        
	   
        
	    <!-- Location -->
	    <div class="card shadow-sm p-3 mb-4">
	      <h4 class="text-primary"><i class="fa-solid fa-location-dot me-2"></i>{{ $t('Location Data') }}</h4>
        
	      <div class="row mt-3">
	        <div class="col-md-6">
		<label for="savedLocations">{{ $t('Saved Locations') }}</label>
		<select id="savedLocations" v-model="location.location_id" @change="fillLocationData" class="form-select">
		  <option v-for="loc in locations" :key="loc.id" :value="loc.id">
		    {{ loc.first_name }} {{ loc.last_name }} - {{ loc.country }}
		  </option>
		</select>
	        </div>
	        <div class="col-md-6 d-flex align-items-end">
		<button @click="handleCheckout" class="btn btn-outline-primary w-100">
		  <i class="fa-solid fa-plus"></i> {{ $t('Add New Location') }}
		</button>
	        </div>
	      </div>
        
	      <div class="mt-3">
	        <p><strong>{{ $t('Name') }}:</strong> {{ location.first_name }} {{ location.last_name }}</p>
	        <p><strong>{{ $t('House Number') }}:</strong> {{ location.street }} {{ location.house_number }}, {{ location.country }}</p>
	        <p><strong>{{ $t('Zip Code') }}:</strong> {{ location.zipcode }}</p>
	        <p><strong>{{ $t('Phone') }}:</strong> {{ location.phone }}</p>
	      </div>
	    </div>
        
	    <!-- Payment -->
	    <div class="card shadow-sm p-3">
	      <h4 class="text-primary mb-3"><i class="fa-solid fa-credit-card me-2"></i>{{ $t('Choose checkout method') }}</h4>
	      <div class="form-check">
	        <input class="form-check-input" type="radio" value="email" v-model="selectedMethod" id="emailCheckout" />
	        <label class="form-check-label" for="emailCheckout">
		<i class="fas fa-envelope"></i>
		{{ $t('Vor Kasse') }}
		</label>
	      </div>
	      <div class="form-check">
	        <input class="form-check-input" type="radio" value="paypal" v-model="selectedMethod" id="paypalCheckout" />
	        <label class="form-check-label" for="paypalCheckout">
		<i class="fab fa-paypal"></i>
		{{ $t('Paypal checkout') }}
	</label>
	      </div>

	      <div class="form-check">
	        <input class="form-check-input" type="radio" value="credit card" v-model="selectedMethod" id="credit cardCheckout" />
	        <label class="form-check-label" for="credit cardCheckout">
		<i class="fas fa-credit-card"></i>
		{{ $t('credit card') }}
		</label>
	      </div>
        
	      <div class="mt-3 text-end">
	        <button
		v-if="selectedMethod === 'email'"
		@click="emailCheckoutProcess"
		class="btn btn-primary"
		:disabled="loading"
	        >
		<i class="fas fa-envelope"></i> {{ loading ? $t('Processing...') : $t('Vor Kasse') }}
	        </button>
        
	        <button
		v-if="selectedMethod === 'paypal'"
		@click="proceedToCheckout"
		class="btn btn-warning text-dark"
		:disabled="loading"
	        >
		<i class="fab fa-paypal"></i> {{ loading ? $t('Processing...') : $t('Paypal checkout') }}
	        </button>

	        <button
		v-if="selectedMethod === 'credit card'"
		@click="stripeCheckoutProcess"
		class="btn btn-primary"
		:disabled="loading"
	        >
		<i class="fas fa-credit-card"></i> {{ loading ? $t('Processing...') : $t('credit card') }}
	        </button>
	      </div>
	    </div>
	  </div>
        
	  <div v-else class="text-center py-5 text-muted">
	    <i class="fa-solid fa-cart-arrow-down fa-3x mb-3"></i>
	    <p>{{ $t('noItemsInCart') }}</p>
	    <router-link to="/shop" class="btn btn-outline-primary">{{ $t('Continue Shopping') }}</router-link>
	  </div>
        
	  <!-- Add Location Modal -->
	  <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered">
	      <div class="modal-content border-0 shadow-lg">
	        <div class="modal-header text-white" style="background-color: #d9b382 !important;">
		<h5 class="modal-title text-white">{{ $t('Add New Location') }}</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
	        </div>
	        <form @submit.prevent="saveLocation">
		<div class="modal-body">
		  <div v-for="field in ['first_name', 'last_name', 'country', 'street', 'house_number', 'zipcode', 'phone']" :key="field" class="mb-3">
		    <label :for="field" class="form-label">{{ $t(field.replace('_', ' ')) }}</label>
		    <input :id="field" v-model="location[field]" type="text" class="form-control" required />
		  </div>
		</div>
		<div class="modal-footer">
		  <button type="submit" class="btn btn-success">{{ $t('Save Location') }}</button>
		</div>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>
        </template>
        

<script>
import axios from 'axios';
import { computed, ref, onMounted, watch } from 'vue';
import { useCartStore } from './cartStore';

export default {
  setup() {
    const cartStore = useCartStore();
    const loading = ref(false);
    const cartItemsArray = computed(() => Object.values(cartStore.cartItems));
    const total = computed(() => cartStore.total);
    const shipping_price = computed(() => cartStore.totalShipping);

    const user = ref(null); // لتخزين بيانات المستخدم
    const email = ref('');
    const selectedMethod = ref(null);
    const isButtonHidden = ref(false);
    const locations = ref([]);
    const location = ref({
      first_name: '',
      last_name: '',
      country: '',
      street: '',
      house_number: '',
      zipcode: '',
      phone: '',
      location_id: null,
    });
    const getUserImageSrc = (photo) => {
      return photo ? `/storage/${photo}` : '/img/load.png';
    };
    const getUser = async () => {
      try {
        const response = await axios.get("/getuser");
        user.value = response.data;

        // تحديث قيمة البريد الإلكتروني
        if (user.value && user.value.email) {
          email.value = user.value.email;
        }
        console.log("User info:", user.value);

        // جلب المواقع المرتبطة بالمستخدم
        if (user.value && user.value.locations) {
          locations.value = user.value.locations.map(loc => ({
            ...loc,
            first_name: loc.first_name || user.value.first_name ,
            last_name: loc.last_name || user.value.last_name
          }));
        }
        console.log("User Locations:", locations.value);
      } catch (error) {
        window.location.href = "/login";
      }
    };
    // تخزين البيانات الأصلية عند اختيار الموقع
    const originalLocation = ref(null);

    const fillLocationData = () => {
      const selectedLocation = locations.value.find(loc => loc.id === location.value.location_id);
      if (selectedLocation) {
        location.value.first_name = selectedLocation.first_name;
        location.value.last_name = selectedLocation.last_name;
        location.value.country = selectedLocation.country;
        location.value.street = selectedLocation.street;
        location.value.house_number = selectedLocation.house_number;
        location.value.zipcode = selectedLocation.zip_code;
        location.value.phone = selectedLocation.phone;
        location.value.location_id = selectedLocation.id;

        // حفظ البيانات الأصلية عند التحديد
        originalLocation.value = { ...location.value };
      }
    };

    const resetButtonVisibility = () => {
      isButtonHidden.value = false;  // إظهار الزر عند تغيير طريقة الدفع
    };

    // مراقبة التغييرات فقط إذا كانت البيانات الأصلية مختلفة
    watch(
      () => ({
        first_name: location.value.first_name,
        last_name: location.value.last_name,
        country: location.value.country,
        street: location.value.street,
        house_number: location.value.house_number,
        zipcode: location.value.zipcode,
        phone: location.value.phone,
      }),
      () => {
        if (originalLocation.value) {
          const hasChanged =
            location.value.first_name !== originalLocation.value.first_name ||
            location.value.last_name !== originalLocation.value.last_name ||
            location.value.country !== originalLocation.value.country ||
            location.value.street !== originalLocation.value.street ||
            location.value.house_number !== originalLocation.value.house_number ||
            location.value.zipcode !== originalLocation.value.zipcode ||
            location.value.phone !== originalLocation.value.phone;

          if (hasChanged) {
            location.value.location_id = null;
          }
        }
      }
    );

    const handleCheckout = async () => {
      await getUser(); // فحص حالة تسجيل الدخول

      if (user.value) {
        // إذا كان المستخدم مسجلاً
        // proceedToCheckout();
        const modal = new bootstrap.Modal(document.getElementById('checkoutModal'));
        modal.show();
      } else {
        // إذا لم يكن المستخدم مسجلاً
        window.location.href = "/login";
      }
    };
    const proceedToCheckout = () => {
      if (
        !location.value.first_name ||
        !location.value.last_name ||
        !location.value.country ||
        !location.value.street ||
        !location.value.house_number ||
        !location.value.zipcode ||
//         !location.value.location ||
        !location.value.phone
      ) {
        alert('Please fill in all location details.');
        return;
      }

      const data = cartItemsArray.value.map(item => ({
        id: item.id || null, // تضمين id إذا كان موجودًا
        desc: item.desc || null, // تضمين desc إذا كان موجودًا
        name: item.name,
        price: item.price,
        quantity: item.quantity,
        shipping_price: item.shipping_price,
        partsBreakdown: item.partsBreakdown || [], // تضمين partsBreakdown إذا كان موجودًا
        texturesBreakdown: item.texturesBreakdown || [], // تضمين texturesBreakdown إذا كان موجودًا
      }));

      axios.post('/payment', {
        items: data,
        total: total.value,
        shipping_price: shipping_price.value,
        user: user.value, // إرسال بيانات المستخدم إذا كانت موجودة
        location: location.value // إرسال الموقع
      })
        .then(response => {
          if (response.data.success) {
            // إعادة التوجيه إلى رابط PayPal
            localStorage.setItem('successPayment', 'true');
            window.location.href = response.data.redirect_url;
          } else {
            // معالجة الخطأ (إظهار رسالة أو إشعار)
            alert(response.data.message || 'Failed to create PayPal order.');
          }
        })
        .catch(error => {
          console.error('Error during checkout:', error);
        });
    };
    const emailCheckoutProcess = () => {
      // Validation: Ensure all fields are filled
      if (
        !location.value.first_name ||
        !location.value.last_name ||
        !location.value.country ||
        !location.value.street ||
        !location.value.house_number ||
        !location.value.zipcode ||
//         !location.value.location ||
        !location.value.phone
      ) {
        alert('Please fill in all location details.');
        return;
      }
      isButtonHidden.value = true;
      console.log('cat item :', cartItemsArray);


      const data = cartItemsArray.value.map(item => ({
        id: item.id || null, // تضمين id إذا كان موجودًا
        desc: item.desc || null, // تضمين desc إذا كان موجودًا
        name: item.name,
        price: item.price,
        quantity: item.quantity,
        shipping_price: item.shipping_price,
        partsBreakdown: item.partsBreakdown || [], // تضمين partsBreakdown إذا كان موجودًا
        texturesBreakdown: item.texturesBreakdown || [], // تضمين texturesBreakdown إذا كان موجودًا
      }));

      axios.post('/email/payment', {
        items: data,
        total: total.value,
        shipping_price: shipping_price.value,
        user: user.value, // إرسال بيانات المستخدم إذا كانت موجودة
        location: location.value // إرسال الكائن الخاص بالموقع
      })
        .then(response => {
          if (response.data.success) {
            cartStore.clearCart(); 
            window.location.href = response.data.redirect_url;
          } else {
            alert(response.data.message || 'Failed to create order.');
          }
        })
        .catch(error => {
          console.error('Error during checkout:', error);
        });
    };

    const stripeCheckoutProcess = async () => {
  if (
    !location.value.first_name ||
    !location.value.last_name ||
    !location.value.country ||
    !location.value.street ||
    !location.value.house_number ||
    !location.value.zipcode ||
    !location.value.phone
  ) {
    alert('Please fill in all location details.');
    return;
  }

  loading.value = true;
  const data = cartItemsArray.value.map(item => ({
    id: item.id,
    name: item.name,
    price: item.price,
    quantity: item.quantity,
  }));

  try {
    const response = await axios.post('/stripe/payment', {
      items: data,
      total: total.value,
      shipping_price: shipping_price.value,
      user: user.value,
      location: location.value,
    });

    if (response.data.success) {
      window.location.href = response.data.url;
    } else {
      alert(response.data.message || 'Stripe payment failed.');
    }
  } catch (error) {
    console.error('Stripe payment error:', error);
  } finally {
    loading.value = false;
  }
};

    // تحميل بيانات المستخدم عند تحميل الصفحة
    onMounted(() => {
      getUser();
    });
    return {
      cartItemsArray,
      total,
      shipping_price,
      location,
      locations,
      isButtonHidden,
      resetButtonVisibility,
      email,
      getUserImageSrc,
      handleCheckout,
      emailCheckoutProcess,
      proceedToCheckout,
      fillLocationData,
      selectedMethod,
      stripeCheckoutProcess,
      loading,
    };
  },
};
</script>

<style scoped>
.btn-paypal {
  background-color: #FFD700;
  /* اللون الرئيسي لزر PayPal */
  color: #000;
  /* لون الخط */
  border: none;
  border-radius: 5px;
  /* لجعل الزاوية منحنية */
  padding: 10px 20px;
  font-size: 16px;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  /* للتباعد بين الأيقونة والنص */
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

.btn-paypal:hover {
  background-color: #005a9e;
  /* لون مميز عند التمرير فوق الزر */
  color: #fff;
}

.btn-paypal i {
  font-size: 20px;
  /* حجم الأيقونة */
}

.btn-email {
  background-color: #007bff;
  /* اللون الرئيسي لزر البريد الإلكتروني */
  color: white;
  /* لون الخط */
  border: none;
  border-radius: 5px;
  /* لجعل الزاوية منحنية */
  padding: 10px 20px;
  font-size: 16px;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  /* للتباعد بين الأيقونة والنص */
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

.btn-email:hover {
  background-color: #0056b3;
  /* لون مميز عند التمرير فوق الزر */
}

.btn-email i {
  font-size: 20px;
  /* حجم الأيقونة */
}


/* ******** end style btn checkout ****************** */

.btns {
  display: flex;
  gap: 10px;
}

.desc {
  text-align: start;
  margin-top: 5px;
}

.confirm-remove {
  width: 400px;
  height: 250px;
  box-shadow: 15px 15px 15px gray;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #eee;
  padding: 25px;
  border-radius: 15px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.cart-view {
  padding: 20px;
  max-width: 1200px;
  margin: 0 auto;
}

/* .cart-items-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 20px;
} */

.cart-item {
  width: 100%;
  /* max-width: 300px; */
  /* الحد الأقصى لعرض كل كارت */
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
}

.cart-item-img {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 8px;
  margin-bottom: 10px;
}

.cart-item-info {
  flex-grow: 1;
}

.quantity-controls {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.btn-quantity {
  background-color: #f0f0f0;
  color: #333;
  border: 1px solid #ccc;
  padding: 5px 10px;
  font-size: 18px;
  cursor: pointer;
  border-radius: 4px;
}

.btn-quantity:hover {
  background-color: #e0e0e0;
}

.quantity {
  display: flex;
  justify-content: center;
  align-items: center;

  font-size: 18px;
}

.payment-section {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
}

.btn-remove,
.btn-confirm,
.btn-cancel,
.btn-checkout {
  background-color: #007bff;
  color: white;
  padding: 8px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

/* .btn-remove:hover,
.btn-confirm:hover,
.btn-cancel:hover,
.btn-checkout:hover {
  background-color: #0056b3;
}

.btn-cancel {
  background-color: #dc3545;
}

.btn-cancel:hover {
  background-color: #c82333;
} */

.cart-total {
  text-align: right;
  font-size: 20px;
  font-weight: bold;
  margin-top: 20px;
}

.parts-section {
  flex: 1;
  padding: 15px;
  background-color: #f9f9f9;
  border-radius: 8px;
}

.parts-section h4 {
  margin-bottom: 10px;
  font-size: 1.2rem;
  color: #333;
  border-bottom: 2px solid #e0e0e0;
  padding-bottom: 5px;
}

.parts-section ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.parts-section li {
  font-size: 1rem;
  color: #555;
  margin-bottom: 8px;
  display: flex;
  justify-content: space-between;
  padding: 5px 0;
  border-bottom: 1px solid #e0e0e0;
}

.parts-section:last-child {
  border-bottom: none;
}

.parts-section .item-name {
  flex: 1;
}

.parts-section .item-price {
  flex: 0 0 auto;
  margin-left: 10px;
  font-weight: bold;
}
</style>