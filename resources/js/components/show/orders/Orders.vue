<template>
    <div class="container mt-4">
      <h1 class="mb-4">{{ $t('manageOrders') }}</h1>
  
      <div v-if="loading" class="alert alert-info">{{ $t('loading') }}</div>
      <div v-if="error" class="alert alert-danger">{{ $t('errorFetchingOrders') }} {{ error }}</div>
  
      <div v-if="orders.length > 0" class="row">
        <div v-for="order in orders" :key="order.id" class="col-md-4 mb-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">{{ $t('orderNumber') }}: {{ order.order_number }}</h5>
              <p class="card-text"><strong>{{ $t('userId') }}:</strong> {{ order.user_id }}</p>
              <p class="card-text"><strong>{{ $t('address') }}:</strong> {{ order.address }}</p>
              <p class="card-text"><strong>{{ $t('totalPrice') }}:</strong> ${{ order.totalprice.toFixed(2) }}</p>
              <div class="mb-3">
                <label :for="'status-' + order.id" class="form-label">{{ $t('status') }}</label>
                <select :id="'status-' + order.id" v-model="order.status" @change="updateOrder(order)" class="form-select">
                  <option value="pending">{{ $t('pending') }}</option>
                  <option value="completed">{{ $t('completed') }}</option>
                  <option value="cancelled">{{ $t('cancelled') }}</option>
                </select>
              </div>
              <button @click="deleteOrder(order.id)" class="btn btn-danger">{{ $t('delete') }}</button>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <div class="alert alert-warning">{{ $t('noOrdersFound') }}</div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        orders: [],
        loading: true,
        error: null,
        isLoggedIn: false,
        activeLink: 1
      };
    },
    methods: {
      async fetchOrders() {
        this.loading = true;
        try {
          const response = await axios.get('localhost/api/orders');
          this.orders = response.data.orders;
        } catch (err) {
          this.error = this.$t('errorFetchingOrders') + ' ' + err.message;
        } finally {
          this.loading = false;
        }
      },
      async updateOrder(order) {
        try {
          await axios.put(`localhost/api/orders/${order.id}`, {
            status: order.status
          });
        } catch (err) {
          this.error = this.$t('errorUpdatingOrder') + ' ' + err.message;
        }
      },
      async deleteOrder(orderId) {
        try {
          await axios.delete(`localhost/api/orders/${orderId}`);
          this.orders = this.orders.filter(order => order.id !== orderId);
        } catch (err) {
          this.error = this.$t('errorDeletingOrder') + ' ' + err.message;
        }
      }
    },
    mounted() {
      this.fetchOrders();
    }
  };
  </script>
  