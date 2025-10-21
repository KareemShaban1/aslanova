<template>
	<div class="search-section container my-5 position-relative">
	  <!-- Search Input -->
	  <div class="input-group">
	    <input
	      v-model="searchQuery"
	      @input="handleTyping"
	      type="text"
	      class="form-control"
	      placeholder="Search for products..."
	    />
	    <button @click="performSearch" class="btn btn-primary">
	      <i class="fa fa-search"></i>
	    </button>
	  </div>
        
	  <!-- Search Results Dropdown -->
	  <div
	    v-if="searchResults.length > 0 && searchQuery"
	    class="search-results bg-white shadow-sm border rounded mt-2 position-absolute w-100 z-10"
	    style="max-height: 300px; overflow-y: auto;"
	  >
	    <ul class="list-group list-group-flush">
	      <li
	        v-for="product in searchResults"
	        :key="product.id"
	        class="list-group-item list-group-item-action d-flex align-items-center justify-content-between"
	        @click="selectProduct(product)"
	        style="cursor: pointer;"
	      >
	        <div>
		<strong>{{ product.name }}</strong><br />
		<small class="text-muted">{{ product.category?.name }}</small>
	        </div>
	        <span class="text-primary fw-bold">$ {{ product.price ?? '—' }}</span>
	      </li>
	    </ul>
	  </div>
	</div>
        </template>
        
        <script>
        import axios from "axios";
        
        export default {
	data() {
	  return {
	    searchQuery: "",
	    searchResults: [],
	    typingTimer: null, // for debounce
	  };
	},
	methods: {
	  handleTyping() {
	    clearTimeout(this.typingTimer);
	    // wait 500ms after last keystroke
	    this.typingTimer = setTimeout(() => {
	      this.performSearch();
	    }, 500);
	  },
        
	  async performSearch() {
	    if (!this.searchQuery.trim()) {
	      this.searchResults = [];
	      return;
	    }
        
	    try {
	      const response = await axios.get(`/api/products/search?q=${this.searchQuery}`);
	      this.searchResults = response.data.products;
	    } catch (error) {
	      console.error("Search failed:", error);
	    }
	  },
        
	  selectProduct(product) {
	    this.searchQuery = product.name;
	    this.searchResults = [];
	    // You could redirect, emit event, etc.
	    // this.$router.push(`/products/${product.id}`);
	  },
	},
        };
        </script>
        
        <style scoped>
        .search-results {
	z-index: 1000;
        }
        </style>
        