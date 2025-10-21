<template>
    <!-- BEGIN: Content-->
    <div class="ecommerce-application">
        <div class="content-wrapper ">
            <div class="content-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                <!-- Breadcrumbs and Title -->
                <div class="d-flex align-items-center justify-content-center mb-2 mb-md-0">
                    <h2 class="content-header-title mb-1">
                        <router-link to="/">{{ $t('Home') }}</router-link>
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
                    <section id="ecommerce-offers" class="grid-view">
                        <div class="card ecommerce-card" v-for="(offer, index) in paginatedOffers" :key="index">
                            <div class="item-img text-center">
                                <span @click="viewOfferDetails(offer.id)">
                                    <img class="img-fluid card-img-top" style="max-width: 350px;"
                                        :src="getUserImageSrc(offer.file)" alt="img-placeholder" />
                                </span>
                            </div>
                            <div class="card-body">
                                <h6 class="item-name">{{ offer.name }}</h6>
                                <p class="card-text item-description">{{ offer.desc }}</p>
                                <p class="item-price">
                                    <span class="old-price">{{ offer.old_price }} <i class="fa-solid fa-euro-sign"></i></span>
                                    <span class="current-price">{{ offer.price }} <i class="fa-solid fa-euro-sign"></i></span>
                                </p>
                            </div>
                            <div class="item-options text-center">
                                <span @click="viewOfferDetails(offer.id)" class="btn btn-light btn-wishlist">
                                    <i class="fa-solid fa-eye"></i>
                                    <span>{{ $t('View Offer') }}</span>
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
                                        <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page
                                            }}</a>
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
            offers: [], // قائمة العروض
            searchQuery: "", // استعلام البحث
            currentPage: 1,
            productsPerPage: 15, // عدد العروض في كل صفحة
            pageOptions: [5, 10, 15, 20, 25, 30], // خيارات لعدد العروض في الصفحة
        }
    },
    computed: {
        filteredOffers() {
            return this.offers.filter((offer) => {
                return offer.name.toLowerCase().includes(this.searchQuery.toLowerCase());
            });
        },
        paginatedOffers() {
            const start = (this.currentPage - 1) * this.productsPerPage;
            const end = start + this.productsPerPage;
            return this.filteredOffers.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredOffers.length / this.productsPerPage);
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
        get_offers() {
            axios.get('/api/offers').
                then(response => {
                    this.offers = response.data.offers;
                    console.log("offers: ", this.offers);
                })
        },
        viewOfferDetails(id) {
            this.$router.push({ name: "ShowOffer", params: { id: id } });
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
        this.get_offers(); // جلب العروض عند تحميل المكون
    }
}
</script>

<style>
.card {
    width: 100%;
    /* جعل عرض البطاقة 100% */
}

.offer-hover {
    cursor: pointer;
}

.card-img-top {
    width: 85% !important;
}

.old-price {
    color: red;
    text-decoration: line-through;
    margin-right: 10px;
}

.current-price {
    font-weight: bold;
}
</style>
