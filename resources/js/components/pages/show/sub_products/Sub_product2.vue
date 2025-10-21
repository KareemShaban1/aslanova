<template>
  <!-- BEGIN: Content-->
  <div class="ecommerce-application">
    <div class="content-overlay"></div>
    <div></div>
    <div class="content-wrapper container-xxl p-0">
      <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
          <div class="row breadcrumbs-top">
            <div class="col-12">
              <h2 class="content-header-title float-start mb-0">
                {{ $t("Products") }}
              </h2>
              <div class="breadcrumb-wrapper">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <router-link to="/">{{ $t("Homesss") }}</router-link>
                  </li>
                  <li class="breadcrumb-item">
                    <router-link to="/dashboard/categories">{{
                      $t("Categories")
                    }}</router-link>
                  </li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="content-detached">
        <div class="content-body">
          <!-- E-commerce Content Section Starts -->
          <section id="ecommerce-header">
            <div class="row">
              <div class="col-sm-12">
                <div class="ecommerce-header-items">
                  <div class="result-toggler">
                    <button
                      class="navbar-toggler shop-sidebar-toggler"
                      type="button"
                      data-bs-toggle="collapse"
                    >
                      <span class="navbar-toggler-icon d-block d-lg-none"
                        ><i data-feather="menu"></i
                      ></span>
                    </button>
                    <div class="search-results">
                      results found : {{ products.length }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
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
          <!-- اختيار عدد المنتجات المعروضة -->
          <section id="products-per-page" class="products-per-page">
            <div class="row mt-1">
              <div class="col-8 col-md-3">
                <div class="input-group input-group-merge">
                  <label
                    for="products-per-page-select"
                    class="form-label mx-2"
                    >{{ $t("productsPerPage") }}</label
                  >
                  <select
                    id="products-per-page-select"
                    class="form-select"
                    v-model="productsPerPage"
                    @change="changeProductsPerPage"
                  >
                    <option
                      v-for="option in pageOptions"
                      :key="option"
                      :value="option"
                    >
                      {{ option }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
          </section>

          <!-- عرض المنتجات -->
          <section id="ecommerce-products" class="grid-view">
            <div
              class="card ecommerce-card"
              v-for="(prod, index) in paginatedProducts"
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
                <h6 class="item-name">{{ prod.name }}</h6>
                <p class="card-text item-description">{{ prod.desc }}</p>
                <h6 class="item-price">{{ prod.price }} $</h6>
              </div>
              <div class="item-options text-center">
                <span
                  @click="view_sub_product(prod.id)"
                  class="btn btn-light btn-wishlist"
                >
                  <i class="fa-solid fa-eye"></i>
                  <span>Show Products</span>
                </span>
                <!-- <button @click="addToCart(prod)" class="btn btn-primary">
                  <i class="fa-solid fa-cart-shopping"></i>
                  <span class="">{{ $t("Add to cart") }}</span>
                </button> -->
              </div>
            </div>
          </section>

          <!-- أزرار الترقيم -->
          <section id="ecommerce-pagination">
            <div class="row">
              <div class="col-sm-12">
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center mt-2">
                    <!-- الزر السابق -->
                    <li
                      class="page-item prev-item"
                      :class="{ disabled: currentPage === 1 }"
                    >
                      <a
                        class="page-link"
                        href="#"
                        aria-label="Previous"
                        @click.prevent="changePage(currentPage - 1)"
                      >
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>

                    <!-- عناصر الصفحات -->
                    <li
                      class="page-item"
                      v-for="page in totalPages"
                      :key="page"
                      :class="{ active: currentPage === page }"
                    >
                      <a
                        class="page-link"
                        href="#"
                        @click.prevent="changePage(page)"
                        >{{ page }}</a
                      >
                    </li>

                    <!-- الزر التالي -->
                    <li
                      class="page-item next-item"
                      :class="{ disabled: currentPage === totalPages }"
                    >
                      <a
                        class="page-link"
                        href="#"
                        aria-label="Next"
                        @click.prevent="changePage(currentPage + 1)"
                      >
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav>
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
import _ from "lodash";
import { useCartStore } from "../../cart/cartStore";
import Swal from "sweetalert2";

export default {
  props: ["id"],
  setup() {
    const cartStore = useCartStore();

    const addToCartWithToast = (product) => {
      console.log("addToCartWithToast product: ", product);
      // Add product to cart
      cartStore.addToCart(product);

      // Show success toast with product details
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: `${product.name} added to cart!`,
        text: `Price: ${product.price} $`,
        showConfirmButton: false,
        timer: 2000,
        toast: true,
        customClass: {
          confirmButton: "btn btn-primary",
        },
        buttonsStyling: false,
      });
    };

    return {
      addToCart: addToCartWithToast,
    };
  },
  data() {
    return {
      products: [],
      searchQuery: "", // استعلام البحث
      currentPage: 1,
      productsPerPage: 15, // عدد المنتجات في كل صفحة
      pageOptions: [5, 10, 15, 20, 25, 30], // خيارات لعدد المنتجات في الصفحة
    };
  },
  computed: {
    filteredProducts() {
      return this.products.filter((prod) => {
        return prod.name.toLowerCase().includes(this.searchQuery.toLowerCase());
      });
    },
    paginatedProducts() {
      const start = (this.currentPage - 1) * this.productsPerPage;
      const end = start + this.productsPerPage;
      return this.filteredProducts.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.filteredProducts.length / this.productsPerPage);
    },
  },
  methods: {
    getUserImageSrc(photo) {
      if (photo) {
        return `/storage/${photo}`;
      } else {
        return "/img/load.png";
      }
    },
    get_products() {
      axios
        .get(`/api/sub-products/subproduct/${this.id}`)
        .then((response) => {
          this.products = response.data.data;
          console.log("products:", this.products);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    view_sub_product(id) {
      this.$router.push({ name: "view_sub_product", params: { id: id } });
    },
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },
    changeProductsPerPage(event) {
      this.productsPerPage = parseInt(event.target.value);
      this.currentPage = 1; // إعادة تعيين الصفحة الحالية إلى الأولى
    },
  },
  mounted() {
    this.get_products();
  },
};
</script>

<style></style>
