<template>
    <!-- BEGIN: Content-->
    <div class=" ecommerce-application">
      <div class="content-overlay"></div>
      <div ></div>
      <div class="content-wrapper container-xxl p-0">
          <div class="content-header row">
              <div class="content-header-left col-md-9 col-12 mb-2">
                  <div class="row breadcrumbs-top">
                      <div class="col-12">
                          <h2 class="content-header-title float-start mb-0">{{ $t("Products") }}</h2>
                          <div class="breadcrumb-wrapper">
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item"><router-link to="/">{{ $t("Home") }}</router-link></li>
                                <li class="breadcrumb-item"><router-link to="/dashboard/categories">{{ $t("Categories") }}</router-link></li>
                              </ol>
                          </div>
                      </div>
                  </div>
              </div>
              
          </div>
          <div class="content-detached ">
              <div class="content-body">
                  <!-- E-commerce Content Section Starts -->
                  <!-- E-commerce Content Section Starts -->

                  <!-- background Overlay when sidebar is shown  starts-->
                  <div class="body-content-overlay"></div>
                  <!-- background Overlay when sidebar is shown  ends-->

                  <!-- E-commerce Search Bar Starts -->
                  <section id="ecommerce-searchbar" class="ecommerce-searchbar">
      <div class="row mt-1">
        <div class="col-sm-12">
          <div class="input-group input-group-merge">
            <input
              type="text"
              class="form-control search-product"
              id="shop-search"
              placeholder="Search Product"
              aria-label="Search..."
              aria-describedby="shop-search"
              v-model="searchQuery"
              @input="searchProducts"
            />
            <span class="input-group-text">
              <i data-feather="search" class="text-muted"></i>
            </span>
          </div>
        </div>
      </div>
    </section>
                  <!-- E-commerce Search Bar Ends -->

                  <!-- E-commerce Products Starts -->
                  <section id="ecommerce-products" class="grid-view">
      <div
        class="card ecommerce-card"
        v-for="(prod, index) in filteredProducts"
        :key="index"
      >
        <div class="item-img text-center">
          <span @click="view_sub_product(prod.id)">
            <img
              class="img-fluid card-img-top"
              :src="getUserImageSrc(prod.file)"
              alt="img-placeholder"
            />
          </span>
        </div>
        <div class="card-body">
          <h6 class="item-name">
            {{ prod.name }}
          </h6>
          <p class="card-text item-description">{{ prod.desc }}</p>
          <h6 class="item-price">{{ prod.price }} $</h6>
        </div>
        <div class="item-options text-center">
          <span @click="view_sub_product(prod.id)" class="btn btn-light btn-wishlist">
            <i class="fa-solid fa-eye"></i>
            <span>Show Products</span>
          </span>
          <a href="#" class="btn btn-primary btn-cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="add-to-cart">Add to cart</span>
          </a>
        </div>
      </div>
    </section>
                  <!-- E-commerce Products Ends -->

             

              </div>
          </div>
      </div>
  </div>
  <!-- END: Content-->
</template>


<script>
export default {
    props: ['id'],
    data() {
        return {
            products: [],
            searchQuery: "", // استعلام البحث
        }
    },
    computed: {
    filteredProducts() {
      return this.products.filter((prod) => {
        return prod.name.toLowerCase().includes(this.searchQuery.toLowerCase());
      });
    },
  },
    methods: {
        getUserImageSrc(photo) {
            if (photo) {
                return `/storage/${photo}`;
            } else {
            return '/img/load.png'
            }
        },
        get_products(){
            axios.get(`/api/sub-products/subproduct/${this.id}`)
                .then(response => {
                    this.products = response.data.data;
                    console.log('products:', this.products);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        view_sub_product(id){
            this.$router.push({ name: "view_sub_product", params: { id: id } });
        }, 
    },
    mounted() {
        this.get_products();
    },

}
</script>

<style>

</style>