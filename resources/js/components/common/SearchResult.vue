<template>
	<div class="container py-5">
	  <h2 class="mb-4">
	    Search Results for:
	    <span class="text-primary">"{{ $route.query.q }}"</span>
	  </h2>
        
	  <div v-if="loading" class="text-center my-5">
	    <div class="spinner-border text-primary"></div>
	    <p>Loading results...</p>
	  </div>
        
	  <div v-else-if="products.length === 0" class="text-center text-muted">
	    No products found.
	  </div>
        
	  <div v-else class="row">
	    <div
	      v-for="product in products"
	      :key="product.id"
	      class="col-6 col-md-6 col-lg-6 mb-4"
	    >
	      <div
	        class="card h-100 shadow-sm border-0"
	        @click="goToProduct(product.id)"
	        style="cursor: pointer"
	      >
	      <div class="item-img text-center">
		<span @click="products_sub_products(product.id)">
		    <img class="img-fluid card-img-top" :src="getUserImageSrc(product.file)"
		        alt="img-placeholder" />
		</span>
	      </div>
	      <div class="card-body">
		<h6 class="item-name">{{ product.name.slice(0, 15) }}{{ product.name.length > 15 ? '...' : '' }}
		</h6>
		<p class="card-text item-description">{{ product.desc.slice(0, 25) }}{{ product.desc.length > 25
		    ? '...' : '' }}</p>
	      </div>
	      <div class="item-options text-center">
		<span @click="products_sub_products(product.id)" class="btn btn-light btn-wishlist">
		    <i class="fa-solid fa-eye"></i>
		    <span>{{ $t("showSubProducts") }}</span>
		</span>
	      </div>
	      </div>
	    </div>
	  </div>
	</div>
        </template>
        
        <script>
        export default {
	name: "SearchResults",
	data() {
	  return {
	    products: [],
	    loading: true,
	  };
	},
	async created() {
	  await this.fetchResults();
	},
	watch: {
	  '$route.query.q': 'fetchResults',
	},
	methods: {
	  async fetchResults() {
	    const query = this.$route.query.q;
	    if (!query) return;
	    this.loading = true;
        
	    try {
	      const response = await axios.get(`/api/products/search`, {
	        params: { q: query },
	      });
	      this.products = response.data.products || response.data.data || response.data || [];
	    } catch (error) {
	      console.error("❌ Error fetching search results:", error);
	      this.products = [];
	    } finally {
	      this.loading = false;
	    }
	  },
	  getUserImageSrc(photo) {
	    return photo ? `/storage/${photo}` : "/img/load.png";
	  },
	  goToProduct(id) {
	    this.$router.push({ name: "show_product_details", params: { id } });
	  },

	  products_sub_products(id) {
	    this.$router.push({ name: "show_product_details", params: { id } });
	  },
	},
        };
        </script>
        