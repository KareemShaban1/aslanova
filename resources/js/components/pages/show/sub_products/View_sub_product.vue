<template>
    <!-- BEGIN: Content-->

    <div class="content-overlay"></div>
    <div ></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">{{ $t("Product Details") }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><router-link to="/">{{ $t("Home") }}</router-link></li>
                                <li class="breadcrumb-item"><router-link to="/dashboard/categories">{{ $t("Categories")
                                        }}</router-link></li>
                                <li class="breadcrumb-item active">{{ $t("Details") }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- app e-commerce details start -->
            <section class="app-ecommerce-details">
                <div class="card">
                    <!-- Product Details starts -->
                    <div class="card-body">
                        <div class="row my-2">
                            <div class="col-12 col-md-4 d-flex align-items-center justify-content-center mb-2 mb-md-0">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img :src="getUserImageSrc(sub_product.file)" class="img-fluid product-img"
                                        alt="product image" />
                                </div>
                            </div>
                            <div class="col-12 col-md-4">

                                <h2>{{ $t("Product Name") }} :</h2>
                                <h2 class="mt-1">{{ sub_product.name }}</h2>
                                <hr />

                                <div class="row">
                                    <div class=" col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="avatar bg-light-primary p-50 mb-1">
                                                    <div class="avatar-content">
                                                        <i class="fa-solid fa-text-width"></i>
                                                    </div>
                                                </div>
                                                <h4 class="fw-bolder">{{ $t("Width") }}</h4>
                                                <p class="card-text">{{ sub_product.Width }} cm</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="avatar bg-light-primary p-50 mb-1">
                                                    <div class="avatar-content">
                                                        <i class="fa-solid fa-text-height"></i>
                                                    </div>
                                                </div>
                                                <h4 class="fw-bolder">{{ $t("Height") }}</h4>
                                                <p class="card-text">{{ sub_product.Height }} cm</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-6">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <div class="avatar bg-light-primary p-50 mb-1">
                                                    <div class="avatar-content">
                                                        <i class="fa-solid fa-down-left-and-up-right-to-center"></i>
                                                    </div>
                                                </div>
                                                <h4 class="fw-bolder">{{ $t("Thickness") }}</h4>
                                                <p class="card-text">{{ sub_product.Thickness }} cm</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <h2>{{ $t("Price") }} :</h2>
                                <!-- <span class="card-text item-company">By <a href="#" class="company-name">Apple</a></span> -->
                                <div class="ecommerce-details-price d-flex flex-wrap mt-1">
                                    <h2 class="item-price me-1">{{ sub_product.price }} $</h2>
                                </div>
                                <!-- <p class="card-text">Available - <span class="text-success">In stock</span></p> -->
                                <div class="d-flex flex-column flex-sm-row pt-1">
                                    <a href="#" class="btn btn-primary btn-cart me-0 me-sm-1 mb-1 mb-sm-0">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        <span class="add-to-cart"> Add to cart</span>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Product Details ends -->

                    <!-- Item features starts -->
                    <div class="item-features">
                        <div class="row">
                            <h2 class="text-center">Features</h2>

                            <div class="mx-1">
                                <h4>{{ $t("Description") }}</h4>
                                <p class="mx-2">
                                    {{ sub_product.desc }}
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit consectetur nulla quo
                                    atque cumque fugiat, ducimus quis reiciendis quam est, debitis provident eum dolorum
                                    ipsam similique illum dolorem iure ut.
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit consectetur nulla quo
                                    atque cumque fugiat, ducimus quis reiciendis quam est, debitis provident eum dolorum
                                    ipsam similique illum dolorem iure ut.
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit consectetur nulla quo
                                    atque cumque fugiat, ducimus quis reiciendis quam est, debitis provident eum dolorum
                                    ipsam similique illum dolorem iure ut.
                                </p>
                            </div>
                            <hr class="my-2">
                            <div class="row">
                                <div class=" col-6 col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="avatar bg-light-primary p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i class="fa-solid fa-circle-dollar-to-slot"></i>
                                                </div>
                                            </div>
                                            <h4 class="fw-bolder">{{ $t("Capital") }}</h4>
                                            <p class="card-text">{{ sub_product.capital }} $</p>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-6 col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="avatar bg-light-primary p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i data-feather="shield"></i>
                                                </div>
                                            </div>
                                            <h4 class="fw-bolder">{{ $t("Quantity") }}</h4>
                                            <p class="card-text">{{ sub_product.quantity }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-6 col-md-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <div class="avatar bg-light-primary p-50 mb-1">
                                                <div class="avatar-content">
                                                    <i class="fa-solid fa-font-awesome"></i>
                                                </div>
                                            </div>
                                            <h4 class="fw-bolder">{{ $t("Type") }}</h4>
                                            <p class="card-text">{{ sub_product.type }}</p>
                                        </div>
                                    </div>
                                </div>
                        
                            </div>
                        </div>
                    </div>
                    <!-- Item features ends -->
                    <hr class="my-2">
                    <div class="card-body">
                        <div class="mt-4 mb-2 text-center">
                            <h4>Related Products</h4>
                            <p class="card-text">People also search for this items</p>
                        </div>
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide" v-for="(prod, index) in related_product" :key="index">
                                    <a href="#">
                                        <div class="item-heading">
                                            <h5 class="text-truncate mb-0">{{ prod.name }}</h5>
                                            <small class="text-body">by Apple</small>
                                        </div>
                                        <div class="img-container w-50 mx-auto py-75">
                                            <img :src="getUserImageSrc(prod.file)" class="img-fluid" alt="image" />
                                        </div>
                                        <div class="item-meta">
                                            <p class="card-text text-primary mb-0">
                                                {{ prod.price }} <span>$</span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- app e-commerce details end -->

        </div>
    </div>
    <!-- END: Content-->
</template>

<!-- <script>
import Swiper from "swiper";
import "swiper/css/swiper.css"; // Import Swiper styles
export default {
props: ['id'],
data(){
    return {
        sub_product: [],
        // related_product: [],
        related_product:   { name: 'Product 1', desc: 'Description 1', file: 'image1.jpg' },
        
    }
},
methods:{
    getUserImageSrc(photo) {
        if (photo) {
            return `/storage/${photo}`;
        } else {
        return '/img/load.png'
        }
    },
    get_sub_product_info(){
        axios.get(`/api/sub-products/${this.id}`)
        .then(response => {
            this.sub_product = response.data.data;
            console.log('sub_product:', this.sub_product);
        })
        .catch(error => {
            console.log(error);
        });
    },
    get_related_products(id){
        axios.get(`/api/sub-products/subproduct/${id}`)
            .then(response => {
                this.related_product = response.data.data;
                console.log('related_product:', this.related_product);
            })
            .catch(error => {
                console.log(error);
            });
    },
    products_sub_products(id){
            this.$router.push({ name: "sub_product2", params: { id: id } });
        }, 
},
mounted() {
    this.get_sub_product_info();
    setTimeout(() => {
        this.get_related_products(this.sub_product.product_id);
        console.log('OK');
    }, 500); // 2000 ميلي ثانية = 2 ثانية
    new Swiper(".swiper-container", {
      slidesPerView: 3,
      spaceBetween: 30,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
},

}
</script> -->


<script>
import Swiper from "swiper";
import "swiper/css/swiper.css"; // Import Swiper styles
export default {
    props: ['id'],
    data() {
        return {
            sub_product: [],
            related_product: []
        };
    },
    methods: {
        getUserImageSrc(photo) {
            if (photo) {
                return `/storage/${photo}`;
            } else {
                return '/img/load.png';
            }
        },
        async get_sub_product_info() {
            try {
                const response = await axios.get(`/api/sub-products/${this.id}`);
                this.sub_product = response.data.data;
                this.get_related_products(this.sub_product.product_id);
            } catch (error) {
                console.log(error);
            }
        },
        async get_related_products(id) {
            try {
                const response = await axios.get(`/api/sub-products/subproduct/${id}`);
                this.related_product = response.data.data;
                this.$nextTick(() => {
                    this.initSwiper();
                });
            } catch (error) {
                console.log(error);
            }
        },
        initSwiper() {
  new Swiper(".swiper-container", {
    slidesPerView: 1, // Default to 1 slide per view
    spaceBetween: 30,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      1000: { // For medium screens (e.g., tablets)
        slidesPerView: 3, // 2 slides per view
      },
      768: { // For medium screens (e.g., tablets)
        slidesPerView: 2, // 2 slides per view
      },
      576: { // For small screens (e.g., mobile)
        slidesPerView: 1, // 1 slide per view
      },
    },
  });
},
        products_sub_products(id) {
            this.$router.push({ name: "sub_product2", params: { id: id } });
        },
    },
    mounted() {
        this.get_sub_product_info();
    },
};
</script>



<style>
/* Add any necessary styles for Swiper */
.swiper-container {
    width: 100%;
    padding: 20px 0;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    /* Center slide text vertically */
    display: -webkit-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    align-items: center;
}

.img-container {
    display: flex;
    justify-content: center;
    align-items: center;
}
.modal-backdrop {
    z-index: 99 !important;
}
</style>
