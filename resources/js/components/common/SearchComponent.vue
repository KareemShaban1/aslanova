<template>
  <div class="search-section position-relative">
    <div class="input-group">
      <input
        v-model="searchQuery"
        @input="handleTyping"
        type="text"
        class="form-control"
        :placeholder="placeholder"
      />
      <button @click="performSearch" class="btn btn-primary">
        <i class="fa fa-search"></i>
      </button>
    </div>

    <!-- 🔍 Results -->
    <div
      v-if="searchQuery && (isSearching || searchResults.length > 0)"
      class="search-results bg-white shadow-sm border rounded mt-2 position-absolute w-100 z-10"
      style="max-height: 300px; overflow-y: auto"
    >
      <div v-if="isSearching" class="p-3 text-center text-muted">
        Searching...
      </div>

      <ul
        v-else-if="searchResults.length > 0"
        class="list-group list-group-flush"
      >
        <li
          v-for="product in searchResults"
          :key="product.id"
          class="list-group-item list-group-item-action d-flex align-items-center justify-content-between"
          @click="selectProduct(product)"
          style="cursor: pointer"
        >
          <div class="d-flex align-items-center" @click="products_sub_products(product.id)">
            <!-- image -->
            <span>
              <img
                class="img-fluid card-img-top"
                :src="getUserImageSrc(product.file)"
                alt="img-placeholder"
                style="height: 50px; width: 50px"
              />
            </span>
            <div>
              <strong>{{ product.name }}</strong
              ><br />
              <small class="text-muted">{{ product.category?.name }}</small>
            </div>
          </div>
          <span class="text-primary fw-bold">
            {{ product.price ? "$" + product.price : "—" }}
          </span>
        </li>
      </ul>

      <div v-else class="p-3 text-center text-muted">No results found</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "SearchComponent",
  props: {
    placeholder: {
      type: String,
      default: "Search for products...",
    },
  },
  data() {
    return {
      searchQuery: "",
      searchResults: [],
      typingTimer: null,
      isSearching: false,
    };
  },
  methods: {
    products_sub_products(id) {
      this.$router.push({ name: "Sub_product2", params: { id } });
    },
    handleTyping() {
      // Reset debounce timer
      clearTimeout(this.typingTimer);
      // Run search 400ms after last keystroke
      this.typingTimer = setTimeout(() => {
        this.performSearch();
      }, 400);
    },

    async performSearch() {
      const query = this.searchQuery.trim();

      // Stop if empty
      if (!query) {
        this.searchResults = [];
        return;
      }

      this.isSearching = true;

      try {
        const response = await axios.get(`/api/products/search`, {
          params: { q: query },
        });

        // Flexible data extraction (to handle both Laravel pagination & custom format)
        this.searchResults =
          response.data.products || response.data.data || response.data || [];
      } catch (error) {
        console.error("❌ Error while searching:", error);
        this.searchResults = [];
      } finally {
        this.isSearching = false;
      }
    },
    getUserImageSrc(photo) {
      if (photo) {
        return `/storage/${photo}`;
      } else {
        return "/img/load.png";
      }
    },

    async selectProduct(product) {
      this.searchQuery = product.name;
      console.log("product: ", product);

      // Store user search history
      try {
        const user = await axios.get(`/getuser`);
        const user_id = user.data.id;

        if (product.id && user_id) {
          await axios.post(`/api/products/user-search-history`, {
            product_id: product.id,
            user_id: user_id,
          });
        }
      } catch (error) {
        console.error("❌ Error while storing user search history:", error);
      }

      this.searchResults = [];

      // Emit event to parent component
      this.$emit("product-selected", product);

      // Redirect to product details page
      this.$router.push({ name: "show_product", params: { id: product.id } });
    },
  },
  beforeDestroy() {
    // Clean up timer
    if (this.typingTimer) {
      clearTimeout(this.typingTimer);
    }
  },
};
</script>

<style scoped>
.search-results {
  margin-top: 20px;
  z-index: 1000;
}

.search-section {
  width: 100%;
}

@media (max-width: 768px) {
  .search-results {
    max-height: 250px;
  }
}
</style>
