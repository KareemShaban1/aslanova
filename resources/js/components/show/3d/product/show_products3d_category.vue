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

                    <section id="ecommerce-Products3d" class="grid-view">
                        <div class="card ecommerce-card" v-for="(prod, index) in paginatedProducts3d" :key="index">
                            <div class="item-img text-center">
                                <span>
                                    <img class="img-fluid card-img-top" :src="getUserImageSrc(prod.file)"
                                        alt="img-placeholder" />
                                </span>
                            </div>
                            <div class="card-body">
                                <h6 class="item-name">{{ prod.name.slice(0, 15) }}{{ prod.name.length > 15 ? '...' : ''
                                    }}
                                </h6>
                                <p class="card-text item-description"
                                    v-if="prod.desc && prod.desc.trim() !== '' && prod.desc.trim().toLowerCase() !== 'null'">
                                    {{ prod.desc.slice(0, 25) }}{{ prod.desc.length > 25 ? '...' : '' }}
                                </p>
                                <h6 class="item-price">{{ prod.price }} <i class="fa-solid fa-euro-sign"></i></h6>
                            </div>
                            <div class="item-options text-center">
                                <span @click="Product3d(prod.id)" class="btn btn-light btn-wishlist">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>{{ $t('ShowProducts3d') }}</span>
                                </span>
                            </div>
                        </div>
                    </section>
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

    <!-- END: Content-->
</template>


<script>
import _ from 'lodash';

export default {
    props: ['id'],
    data() {
        return {
            categoryId: this.id,
            Products3d: [],
            searchQuery: "", // استعلام البحث
            currentPage: 1,
            Products3dPerPage: 15, // عدد المنتجات في كل صفحة
            pageOptions: [5, 10, 15, 20, 25, 30], // خيارات لعدد المنتجات في الصفحة
        }
    },
    computed: {
        filteredProducts3d() {
            return this.Products3d.filter((prod) => {
                return prod.name.toLowerCase().includes(this.searchQuery.toLowerCase());
            });
        },
        paginatedProducts3d() {
            const start = (this.currentPage - 1) * this.Products3dPerPage;
            const end = start + this.Products3dPerPage;
            return this.filteredProducts3d.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredProducts3d.length / this.Products3dPerPage);
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
        get_Products3d() {
            axios.get(`/api/Categorys_3d/${this.id}/products_3d`)
                .then(response => {
                    this.Products3d = response.data.products;
                    console.log('Products3d:', this.Products3d);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        Product3d(id) {
            this.$router.push(`/dashboard/product-3d/${id}`);
        },
        changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        changeProducts3dPerPage(event) {
            this.Products3dPerPage = parseInt(event.target.value);
            this.currentPage = 1; // إعادة تعيين الصفحة الحالية إلى الأولى
        },
    },
    mounted() {
        this.get_Products3d();
    },

}
</script>

<style>
.ecommerce-card {
    margin-bottom: 20px;
    max-width: 350px;
    flex: 1 1 350px;
    /* يسمح للبطاقة بالنمو والإنكماش ولكن لا يقل عرضها عن 350px */
}
</style>