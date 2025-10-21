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
                            <h2 class="content-header-title float-start mb-0"><router-link to="/">{{$t('home')}}</router-link></h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><router-link to="/">{{$t('home')}}</router-link></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <div class="mb-1 breadcrumb-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="grid"></i></button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="app-todo.html"><i class="me-1" data-feather="check-square"></i><span class="align-middle">Todo</span></a><a class="dropdown-item" href="app-chat.html"><i class="me-1" data-feather="message-square"></i><span class="align-middle">Chat</span></a><a class="dropdown-item" href="app-email.html"><i class="me-1" data-feather="mail"></i><span class="align-middle">Email</span></a><a class="dropdown-item" href="app-calendar.html"><i class="me-1" data-feather="calendar"></i><span class="align-middle">Calendar</span></a></div>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="content-detached ">
                <div class="content-body">
                    <!-- E-commerce Content Section Starts -->
                    <!-- E-commerce Content Section Starts -->

                    <!-- background Overlay when sidebar is shown  starts-->
                    <div class="body-content-overlay"></div>
                    <!-- background Overlay when sidebar is shown  ends-->

                    <!-- E-commerce Search Bar Starts -->
                    <!-- <section id="ecommerce-searchbar" class="ecommerce-searchbar">
                        <div class="row mt-1">
                            <div class="col-sm-12">
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control search-product" id="shop-search" placeholder="Search Product" aria-label="Search..." aria-describedby="shop-search" />
                                    <span class="input-group-text"><i data-feather="search" class="text-muted"></i></span>
                                </div>
                            </div>
                        </div>
                    </section> -->
                    <section id="ecommerce-searchbar" class="ecommerce-searchbar">
      <div class="row mt-1">
        <div class="col-sm-12">
          <div class="input-group input-group-merge">
            <input
              type="text"
              class="form-control search-product"
              id="shop-search"
              placeholder="Search Category"
              aria-label="Search..."
              aria-describedby="shop-search"
              v-model="searchQuery"
              @input="searchCategories"
            />
            <span class="input-group-text">
              <i data-feather="search" class="text-muted"></i>
            </span>
          </div>
        </div>
      </div>
    </section>

                    <!-- E-commerce Search Bar Ends -->
                <!-- اختيار عدد المنتجات المعروضة -->
                    <section id="products-per-page" class="products-per-page">
                        <div class="row mt-1">
                            <div class="col-8 col-md-3">
                                <div class="input-group input-group-merge">
                                    <label for="products-per-page-select" class="form-label mx-2">{{$t('productsPerPage')}}</label>
                                    <select id="products-per-page-select" class="form-select" v-model="productsPerPage" @change="changeProductsPerPage">
                                        <option v-for="option in pageOptions" :key="option" :value="option">{{ option }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- E-commerce Products Starts -->
                    <section id="ecommerce-products" class="grid-view">
      <div
        class="card ecommerce-card"
        v-for="(cat, index) in paginatedProducts"
        :key="index"
      >
        <div class="item-img text-center">
          <span @click="products_category(cat.id)">
            <img
              class="img-fluid card-img-top"
              :src="getUserImageSrc(cat.file)"
              alt="img-placeholder"
            />
          </span>
        </div>
        <div class="card-body">
          <h6 class="item-name">
            {{ cat.name }}
          </h6>
          <p class="card-text item-description">{{ cat.desc }}</p>
        </div>
        <div class="item-options text-center">
          <span @click="products_category(cat.id)" class="btn btn-light btn-wishlist">
            <i class="fa-solid fa-eye"></i>
            <span>Show Products</span>
          </span>
          <button class="btn btn-primary btn-cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="add-to-cart">Show Details</span>
          </button>
        </div>
      </div>
    </section>
                    <!-- E-commerce Products Ends -->

                    <!-- E-commerce Pagination Starts -->
                   <!-- أزرار الترقيم -->
                <section id="ecommerce-pagination">
                    <div class="row">
                        <div class="col-sm-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center mt-2">
                                    <!-- الزر السابق -->
                                    <li class="page-item prev-item" :class="{ 'disabled': currentPage === 1 }">
                                        <a class="page-link" href="#" aria-label="Previous" @click.prevent="changePage(currentPage - 1)">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <!-- عناصر الصفحات -->
                                    <li class="page-item" v-for="page in totalPages" :key="page" :class="{ 'active': currentPage === page }">
                                        <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                                    </li>

                                    <!-- الزر التالي -->
                                    <li class="page-item next-item" :class="{ 'disabled': currentPage === totalPages }">
                                        <a class="page-link" href="#" aria-label="Next" @click.prevent="changePage(currentPage + 1)">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </section>

                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
</template>

<script>
export default {
    data() {
        return {
            categories: [],
            searchQuery: "", // استعلام البحث
            currentPage: 1,
            productsPerPage: 15, // عدد المنتجات في كل صفحة
            pageOptions: [5, 10, 15, 20, 25, 30], // خيارات لعدد المنتجات في الصفحة
        }
    },
    computed: {
        filteredCategories() {
        return this.categories.filter((cat) => {
            return cat.name.toLowerCase().includes(this.searchQuery.toLowerCase());
        });
        },
        paginatedProducts() {
            const start = (this.currentPage - 1) * this.productsPerPage;
            const end = start + this.productsPerPage;
            return this.filteredCategories.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredCategories.length / this.productsPerPage);
        }
  },
    methods: {
        getUserImageSrc(photo) {
            if (photo) {
                return `/storage/${photo}`;
            } else {
            return '/img/load.png'
            }
        },
        get_categories(){
            axios.get('/api/categories').
            then(response => {
                this.categories = response.data.categories;
                console.log("category: " , this.categories);
            })
        },
        products_category(id){
            this.$router.push({ name: "show_Products_category", params: { id: id } });
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
        this.get_categories();
        // console.log(`${process.env.MIX_API_URL}`);
    }
}
</script>

<style>
.cat-hover{
    cursor: pointer;
}

.card-img-top{
    width: 85%  !important;
}
</style>