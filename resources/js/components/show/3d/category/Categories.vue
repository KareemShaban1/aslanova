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

                        <div class="card ecommerce-card" v-for="(cat, index) in paginatedProducts" :key="index">
                            <div class="item-img text-center">
                                <span @click="Products3d_category(cat.id)">
                                    <img class="img-fluid card-img-top" style="max-width: 350px;"
                                        :src="getUserImageSrc(cat.file)" alt="img-placeholder" />
                                </span>
                            </div>
                            <div class="card-body">
                                <h6 class="item-name">{{ cat.name.slice(0, 15) }}{{ cat.name.length > 15 ? '...' : '' }}</h6>
                                <p class="card-text item-description">{{ cat.desc.slice(0, 25) }}{{ cat.desc.length > 25 ? '...' : '' }}</p>
                            </div>
                            <div class="item-options text-center">
                                <span @click="Products3d_category(cat.id)" class="btn btn-light btn-wishlist">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>{{ $t('showProducts3D') }}</span>
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
</template>

<script>
import axios from "axios";
import { useRoute } from "vue-router";

export default {
    data() {
        const categoryMainId = useRoute().params.id;

        return {
            categoryMainId,
            categories3d: [],
            searchQuery: "", // استعلام البحث
            currentPage: 1,
            productsPerPage: 15, // عدد المنتجات في كل صفحة
            pageOptions: [5, 10, 15, 20, 25, 30], // خيارات لعدد المنتجات في الصفحة
            isLoggedIn: false, // متغير لتحديد حالة تسجيل الدخول
        };
    },
    computed: {
        filteredcategories3d() {
            return this.categories3d.filter((cat) => {
                return cat.name.toLowerCase().includes(this.searchQuery.toLowerCase());
            });
        },
        paginatedProducts() {
            const start = (this.currentPage - 1) * this.productsPerPage;
            const end = start + this.productsPerPage;
            return this.filteredcategories3d.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredcategories3d.length / this.productsPerPage);
        },
        // دالة مساعدة لإنشاء مصفوفة من الأرقام للترقيم
        totalPagesArray() {
            return Array.from({ length: this.totalPages }, (v, k) => k + 1);
        },
    },
    methods: {
        getUserImageSrc(photo) {
            if (photo) {
                return `/storage/${photo}`;
            } else {
                return '/img/load.png';
            }
        },
        get_categories3d() {
            axios
                .get(`/api/category_main_3d/${this.categoryMainId}/Categorys_3d`)
                .then((response) => {

                    this.categories3d = response.data.category3d;
                    console.log("category: ", this.categories3d);
                })
                .catch((error) => {
                    console.error("Error fetching categories:", error);
                });
        },
        Products3d_category(id) {
            this.$router.push(`/dashboard/show-products3d/${id}`);
        },

        changePage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },
        changeProductsPerPage(event) {
            this.productsPerPage = parseInt(event.target.value);
            this.currentPage = 1; // إعادة تعيين الصفحة الحالية إلى الأولى
        },
        searchcategories3d() {
            this.currentPage = 1; // إعادة تعيين الصفحة عند البحث
        },
        checkUserLogin() {
            axios
                .get("/getuser")
                .then((response) => {
                    if (response.data.loggedIn) {
                        this.isLoggedIn = true;
                    } else {
                        this.isLoggedIn = false;
                    }
                })
                .catch((error) => {
                    console.error("حدث خطأ أثناء التحقق من حالة تسجيل الدخول:", error);
                    this.isLoggedIn = false;
                });
        },
    },
    mounted() {
        this.get_categories3d();
        this.checkUserLogin();
        // console.log(`${process.env.MIX_API_URL}`);
    },
};
</script>

<style scoped>
.cat-hover {
    cursor: pointer;
}

.card-img-top {
    width: 85% !important;
}

/* تحسين مظهر أزرار الترقيم */
.pagination .page-item .page-link {
    color: #007bff;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    cursor: default;
}

/* تحسين مظهر الفلاتر */
.filter-heading {
    font-weight: bold;
    margin-bottom: 10px;
}

/* تحسين مظهر بطاقة المنتجات */
.ecommerce-card {
    margin-bottom: 20px;
    max-width: 350px;
    flex: 1 1 350px;
    /* يسمح للبطاقة بالنمو والإنكماش ولكن لا يقل عرضها عن 350px */
}


/* تحسين استجابة التصميم للبطاقات */
@media (max-width: 1200px) {
    .ecommerce-card {
        flex: 1 1 300px;
        min-width: 300px;
    }
}

@media (max-width: 768px) {
    .ecommerce-card {
        flex: 1 1 100%;
        min-width: 100%;
    }
}

/* تحسين مظهر الزر غير النشط */
.btn-wishlist.disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
