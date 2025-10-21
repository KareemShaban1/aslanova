<template>
    <!-- BEGIN: Content-->
    <div class="ecommerce-application">
        <div class="content-wrapper">

            <!-- Header with Breadcrumb and Search/Filter Bar -->
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


            <!-- Product Grid -->
            <div class="content-detached">
                <div class="content-body ">
                    <section id="ecommerce-products" class="grid-view">
                        <div class="card ecommerce-card" v-for="(cat, index) in paginatedProducts" :key="index">
                            <div class="item-img text-center">
                                <span @click="products_category(cat.id)">
                                    <img class="img-fluid card-img-top" style="max-width: 350px;"
                                        :src="getUserImageSrc(cat.file)" alt="img-placeholder" />
                                </span>
                            </div>
                            <div class="card-body">
                                <h6 class="item-name">{{ cat.name.slice(0, 15) }}{{ cat.name.length > 15 ? '...' : '' }}</h6>
                                <p class="card-text item-description">{{ cat.desc.slice(0, 25) }}{{ cat.desc.length > 25 ? '...' : '' }}</p>
                            </div>
                            <div class="item-options text-center">
                                <span @click="products_category(cat.id)" class="btn btn-light btn-wishlist">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>{{ $t('showProducts') }}</span>
                                </span>
                            </div>
                        </div>
                    </section>

                    <!-- Pagination -->
                    <section id="ecommerce-pagination" class="row mt-3">
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
        get_categories() {
            axios.get('/api/categories').
                then(response => {
                    this.categories = response.data.categories;
                    console.log("category: ", this.categories);
                })
        },
        products_category(id) {
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
    }
}
</script>

<style >
/* تنسيقات عامة لقسم المنتجات */
#ecommerce-products {
    display: grid !important;
    grid-template-columns: repeat(4, 1fr) !important; /* 5 أعمدة متساوية العرض */
    gap: 20px; /* المسافة بين العناصر */
    padding: 20px; /* تباعد داخلي */
}

/* تنسيقات البطاقة (Card) */
.ecommerce-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    border: 1px solid #e0e0e0; /* إطار خفيف */
    border-radius: 8px; /* زوايا مدورة */
    overflow: hidden; /* لمنع تجاوز المحتوى */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* تأثيرات انتقالية */
}

.ecommerce-card:hover {
    transform: translateY(-5px); /* تحريك البطاقة لأعلى عند التحويم */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* إضافة ظل */
}

/* تنسيقات الصورة داخل البطاقة */
.item-img img {
    width: 100%; /* عرض الصورة بالكامل */
    height: 200px; /* ارتفاع ثابت للصور */
    object-fit: cover; /* تغطية المساحة دون تشويه */
}

/* تنسيقات نص البطاقة */
.card-body {
    padding: 15px;
    flex-grow: 1; /* لجعل النص يأخذ المساحة المتبقية */
}

.item-name {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.item-description {
    font-size: 14px;
    margin-bottom: 15px;
}

/* تنسيقات الأزرار داخل البطاقة */
.item-options {
    padding: 15px;
    width: 100%;
}

.btn-light {
    border: 1px solid #ddd;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
@media (max-width: 1292px) {
    #ecommerce-products {
        grid-template-columns: repeat(3, 1fr) !important; /* 3 أعمدة للتابلت */
    }
}
/* تعديلات للأجهزة الصغيرة (الموبايل) */
@media (max-width: 768px) {
    #ecommerce-products {
        grid-template-columns: repeat(2, 1fr) !important; /* عرض كاردين في الصف الواحد */
        gap: 10px; /* تقليل المسافة بين العناصر */
    }

    .ecommerce-card {
        margin-bottom: 10px; /* مسافة أسفل كل كارد */
    }

    .item-img img {
        height: 150px; /* تقليل ارتفاع الصور على الموبايل */
    }

    .item-name {
        font-size: 16px; /* تقليل حجم الخط للعنوان */
    }

    .item-description {
        font-size: 12px; /* تقليل حجم الخط للوصف */
    }
}

/* تعديلات للأجهزة الصغيرة جدًا (أقل من 576px) */
@media (max-width: 576px) {
    #ecommerce-products {
        grid-template-columns: 1fr !important; /* عرض كارد واحد في الصف */
    }
}

</style>