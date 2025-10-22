<template>
    <div class="ecommerce-application">
        <div class="content-wrapper">

            <div class="content-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                <!-- Breadcrumbs and Title -->
                <div class="d-flex align-items-center justify-content-center mb-2 mb-md-0">
                    <h2 class="content-header-title mb-1">
                        <router-link to="/">{{ $t('home') }}</router-link>
                    </h2>

                    <h4 class="mx-1">|</h4>

                    <h4 class="content-header-title mb-1">
                        <router-link to="/dashboard/categories">{{ $t('categories') }}</router-link>
                    </h4>
                </div>

                <!-- Search and Filter Controls -->
                <div class="d-flex align-items-center">
                    <div class="me-2 w-auto">
                        <div class="input-group input-group-merge">
                            <input type="text" class="form-control search-product" id="shop-search"
                                aria-label="Search..." aria-describedby="shop-search" v-model="searchQuery"
                                @input="searchCategories" :placeholder="$t('Search...')" />
                            <span class="input-group-text">
                                <i data-feather="search" class="text-muted"></i>
                            </span>
                        </div>
                    </div>
                    <div class="w-auto">
                        <select id="products-per-page-select" class="form-select" v-model="productsPerPage"
                            @change="changeProductsPerPage">
                            <option v-for="option in pageOptions" :key="option" :value="option">
                                {{ option }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="content-detached">
                <div class="content-body">
                    <section id="ecommerce-products" class="grid-view">
                        <div class="card ecommerce-card" v-for="(prod, index) in paginatedProducts" :key="index">
                            <div class="item-img text-center">
                                <span @click="products_sub_products(prod.id)">
                                    <img class="img-fluid card-img-top" :src="getUserImageSrc(prod.file)"
                                        alt="img-placeholder" />
                                </span>
                            </div>
                            <div class="card-body">
                                <h6 class="item-name">{{ prod.name.slice(0, 15) }}{{ prod.name.length > 15 ? '...' : '' }}
                                </h6>
                                <p class="card-text item-description">{{ prod.desc.slice(0, 25) }}{{ prod.desc.length > 25
                                    ? '...' : '' }}</p>
                            </div>
                            <div class="item-options text-center">
                                <span @click="products_sub_products(prod.id)" class="btn btn-light btn-wishlist">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>{{ $t("showSubProducts") }}</span>
                                </span>
                            </div>
                        </div>
                    </section>

                    <!-- Pagination -->
                    <section id="ecommerce-pagination" class="row">
                        <div class="col-sm-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center mt-2">
                                    <li class="page-item prev-item" :class="{ 'disabled': currentPage === 1 }">
                                        <a class="page-link" href="#" aria-label="Previous"
                                            @click.prevent="changePage(currentPage - 1)">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item" v-for="page in totalPages" :key="page"
                                        :class="{ 'active': currentPage === page }">
                                        <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                                    </li>
                                    <li class="page-item next-item" :class="{ 'disabled': currentPage === totalPages }">
                                        <a class="page-link" href="#" aria-label="Next"
                                            @click.prevent="changePage(currentPage + 1)">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    props: ['id'],
    data() {
        return {
            products: [],
            searchQuery: "",
            currentPage: 1,
            productsPerPage: 15,
            pageOptions: [5, 10, 15, 20, 25, 30],
        }
    },
    computed: {
        filteredProducts() {
            return this.products.filter((prod) => prod.name.toLowerCase().includes(this.searchQuery.toLowerCase()));
        },
        paginatedProducts() {
            const start = (this.currentPage - 1) * this.productsPerPage;
            return this.filteredProducts.slice(start, start + this.productsPerPage);
        },
        totalPages() {
            return Math.ceil(this.filteredProducts.length / this.productsPerPage);
        }
    },
    methods: {
        getUserImageSrc(photo) {
            return photo ? `/storage/${photo}` : '/img/load.png';
        },
        get_products() {
            axios.get(`/api/products/category/${this.id}`)
                .then(response => this.products = response.data.products)
                .catch(error => console.error(error));
        },
        products_sub_products(id) {
            this.$router.push({ name: "show_product_details", params: { id } });
        },
        changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        changeProductsPerPage(event) {
            this.productsPerPage = parseInt(event.target.value);
            this.currentPage = 1;
        },
    },
    mounted() {
        this.get_products();
    },
}
</script>

<style>
.grid-view {
    display: flex !important;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}
</style>
