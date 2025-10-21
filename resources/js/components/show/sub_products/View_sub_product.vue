<template>
    <!-- BEGIN: Content-->

    <div class="content-overlay"></div>
    <div></div>
    <div class="content-wrapper p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">{{ $t("Product Details") }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><router-link to="/">{{ $t("Home") }}</router-link></li>
                                <li class="breadcrumb-item">
                                    <router-link :to="`/dashboard/show-sub-products/${sub_product.product_id}`">
                                        {{ $t("Products") }}
                                    </router-link>
                                </li>
                                <li class="breadcrumb-item active">{{ $t("Details") }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <!-- Product Details starts -->
                <div class="card-body show-prod-page">
                    <div class="row my-2">
                        <div class="col-12 col-md-4 d-flex align-items-center justify-content-center mb-2">
                            <div class="d-flex align-items-center justify-content-center">
                                <img :src="getUserImageSrc(sub_product.file)" class="img-fluid product-img"
                                    alt="product image" @click="openModal(sub_product.file, 'image')" />
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <h2>{{ sub_product.name }}</h2>
                            <h5 class="py-1">
                                <span class="item-price text-black border border-1 border-primary rounded px-1 my-1">
                                    <span class="">
                                        <i class="fa-solid fa-clock"></i>
                                    </span>
                                    <span class="px-1">{{ $t("Shipping in") }} :</span>
                                    <span>{{ sub_product.delivery_price }}</span>
                                </span>
                            </h5>
                            <div class="ecommerce-details-price d-flex align-items-center flex-wrap my-2">
                                <h2 class="item-price me-1 text-black">
                                    {{ sub_product.price }}
                                    <i class="fa-solid fa-euro-sign"></i>
                                </h2>
                                <h5 class="me-1">
                                    <span class="text-black" v-if="sub_product.shipping_price > 0">
                                        + {{ sub_product.shipping_price }}
                                        <i class="fa-solid fa-euro-sign"></i>
                                        {{ $t("Delivery Cost") }}
                                    </span>
                                    <span class="text-success" v-else>
                                        {{ $t("Free Delivery") }}
                                    </span>
                                </h5>
                                <h5 class="item-price text-black">
                                    <span>{{ $t("Included vat") }}</span>
                                </h5>
                            </div>

                            <div>
                                <button @click="addToCart(sub_product)" class="btn btn-primary p-1">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    <span class="px-1">{{ $t("Add to cart") }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div v-if="hasMedia" class="container bg-white rounded-3 mb-3">
                            <div class="swiper swiper-container-1" id="swiper-container-1">
                                <div class="swiper-wrapper">
                                    <!-- فيديو -->
                                    <div class="swiper-slide" v-if="sub_product.video"
                                        @click="openModal(sub_product.video, 'video')">
                                        <div class="media-wrapper">
                                            <video :src="getVideo(sub_product.video)" class="media-element"></video>
                                            <div class="video-icon">
                                                <i class="fas fa-play"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- صور -->
                                    <div class="swiper-slide" v-for="(image, index) in parsedImages" :key="index"
                                        @click="openModal(image, 'image')">
                                        <div class="media-wrapper">
                                            <img :src="getUserImageSrc(image)" class="media-element"
                                                alt="Product thumbnail" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div v-else class="text-center">

                        </div>

                        <div class="modal fade text-start" id="large" tabindex="-1" aria-labelledby="myModalLabel17"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body text-center position-relative">
                                        <!-- أزرار التنقل -->
                                        <button class="btn btn-primary modal-btn prev-btn" @click="prevMedia">
                                            <i class="fa-solid fa-circle-chevron-left fs-1"></i>
                                        </button>

                                        <!-- عرض الصورة أو الفيديو داخل المودال -->
                                        <template v-if="modalType === 'image'">
                                            <img :src="getUserImageSrc(modalContent)" class="modal-media img-fluid" />
                                        </template>

                                        <template v-else-if="modalType === 'video'">
                                            <video :src="getVideo(modalContent)" controls
                                                class="modal-media img-fluid"></video>
                                        </template>

                                        <button class="btn btn-primary modal-btn next-btn" @click="nextMedia">
                                            <i class="fa-solid fa-circle-chevron-right fs-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Product Details ends -->
                <!-- Item features starts -->
                <div class="item-features">
                    <div class="row py-1">
                        <h2 class="text-center">{{ $t("Features") }}</h2>
                        <div class="mx-1">
                            <h4>{{ $t("Description") }}</h4>
                            <p class="mx-2">
                                {{ sub_product.desc }}
                            </p>
                        </div>
                        <hr class="my-2">
                        <div class="row px-2">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card text-center">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <div class="avatar bg-light-primary p-50 mb-1">
                                            <div class="avatar-content">
                                                <i class="fa-solid fa-text-width fs-2"></i>
                                            </div>
                                        </div>
                                        <h4 class="fw-bolder">{{ $t("Width") }}</h4>
                                        <p class="card-text">{{ sub_product.Width }} cm</p>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-12 col-md-6 col-lg-4">
                                <div class="card text-center">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <div class="avatar bg-light-primary p-50 mb-1">
                                            <div class="avatar-content">
                                                <i class="fa-solid fa-text-height fs-2"></i>
                                            </div>
                                        </div>
                                        <h4 class="fw-bolder">{{ $t("Height") }}</h4>
                                        <p class="card-text">{{ sub_product.Height }} cm</p>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-12 col-md-6 col-lg-4">
                                <div class="card text-center">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <div class="avatar bg-light-primary p-50 mb-1">
                                            <div class="avatar-content">
                                                <i class="fa-solid fa-down-left-and-up-right-to-center fs-2"></i>
                                            </div>
                                        </div>
                                        <h4 class="fw-bolder">{{ $t("Thickness") }}</h4>
                                        <p class="card-text">{{ sub_product.Thickness }} cm</p>
                                    </div>
                                </div>
                            </div>

                            <div class=" col-12 col-md-6 col-lg-4">
                                <div class="card text-center">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <div class="avatar bg-light-primary p-50 mb-1">
                                            <div class="avatar-content">
                                                <i class="fa-solid fa-droplet fs-2"></i>
                                            </div>
                                        </div>
                                        <h4 class="fw-bolder">{{ $t("Color") }}</h4>
                                        <p class="card-text">{{ sub_product.color }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class=" col-12 col-md-6 col-lg-4">
                                <div class="card text-center">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <div class="avatar bg-light-primary p-50 mb-1">
                                            <div class="avatar-content">
                                                <i class="fa-solid fa-dolly fs-2"></i>
                                            </div>
                                        </div>
                                        <h4 class="fw-bolder">{{ $t("shipping price") }}</h4>
                                        <p class="card-text" v-if="sub_product.shipping_price > 0">{{
                                            sub_product.shipping_price }}
                                            <i class="fa-solid fa-euro-sign"></i>
                                        </p>
                                        <p class="card-text" v-else>{{ $t("Free Delivery") }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class=" col-12 col-md-6 col-lg-4">
                                <div class="card text-center">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <div class="avatar bg-light-primary p-50 mb-1">
                                            <div class="avatar-content">
                                                <i class="fa-solid fa-clock fs-2"></i>
                                            </div>
                                        </div>
                                        <h4 class="fw-bolder">{{ $t("Shipping in") }}</h4>
                                        <p class="card-text">{{ sub_product.delivery_price }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Item features ends -->
                <hr class="my-2">
                <div class="product-section">
                    <div class="container">
                        <div class="row">
                            <div id="swiper-container-2" class="swiper-container-2">
                                <transition-group name="fadeInRight" tag="div" class="text-center" mode="out-in">
                                    <h3 class="title">
                                        {{ $t('RelatedProducts') }}
                                    </h3>
                                </transition-group>

                                <transition-group name="fadeInRight" tag="div" class="swiper-wrapper" mode="out-in">
                                    <!-- <div class="swiper-wrapper"> -->
                                    <!-- Start Column 2 -->
                                    <div class="col-4  mb-5 mb-md-0  swiper-slide fadeInRight"
                                        v-for="(prod, index) in related_product" :key="index">
                                        <div class="product-item" @click="show(prod.id)">
                                            <!-- <img src="./images/product-1.png" class="img-fluid product-thumbnail" alt="Nordic Chair"> -->
                                            <img :src="getUserImageSrc(prod.file)"
                                                class="img-fluid img-swipper rounded-top" alt="image" />
                                            <h6 class="item-name">{{ prod.name.slice(0, 15) }}{{ prod.name.length > 15 ?
                                                '...' : '' }}
                                            </h6>
                                            <h6 class="item-name">{{ prod.price }} <i class="fa-solid fa-euro-sign"></i>
                                            </h6>
                                        </div>
                                    </div>
                                </transition-group>
                                <!-- </div> -->
                                <div id="swiper-button-prev-2" class="swiper-button-prev"></div>
                                <div id="swiper-button-next-2" class="swiper-button-next"></div>
                            </div>
                            <!-- End Column 2 -->
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- END: Content-->
</template>
<script>
import { bottom } from '@popperjs/core';
import { useCartStore } from '../../../components/cart/cartStore';
import Swiper from "swiper";
import "swiper/css/swiper.css"; // Import Swiper styles
export default {
    props: ['id'],
    data() {
        return {
            addToCart: useCartStore().addToCart,
            sub_product: [],
            related_product: [],
            modalContent: null,
            modalType: null,
            currentIndex: 0,
            isImageModalOpen: false,
            selectedImage: null,
        };
    },
    computed: {
        parsedImages() {
            // فصل النص JSON إلى مصفوفة من أسماء الصور فقط
            return this.sub_product.images ? JSON.parse(this.sub_product.images).map(image => image.split('/').pop()) : [];
        },
        hasMedia() {
            return this.sub_product.video || (this.parsedImages && this.parsedImages.length > 0);
        },
        allMedia() {
            let media = [];
            if (this.sub_product.video) {
                media.push({ type: "video", content: this.sub_product.video });
            }
            if (this.parsedImages.length > 0) {
                this.parsedImages.forEach((image) => {
                    media.push({ type: "image", content: image });
                });
            }
            return media;
        },

    },
    methods: {
        // فتح المودال وعرض الصورة
        openImageModal(image) {
            this.selectedImage = image;
            this.isImageModalOpen = true;
        },
        // إغلاق المودال
        closeImageModal() {
            this.isImageModalOpen = false;
        },
        openModal(content, type) {
            this.modalContent = content;
            this.modalType = type;
            this.currentIndex = this.allMedia.findIndex((item) => item.content === content);
            let modal = new bootstrap.Modal(document.getElementById("large"));
            modal.show();
        },
        nextMedia() {
            if (this.currentIndex < this.allMedia.length - 1) {
                this.currentIndex++;
            } else {
                this.currentIndex = 0;
            }
            this.updateModalContent();
        },
        prevMedia() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
            } else {
                this.currentIndex = this.allMedia.length - 1;
            }
            this.updateModalContent();
        },
        updateModalContent() {
            this.modalContent = this.allMedia[this.currentIndex].content;
            this.modalType = this.allMedia[this.currentIndex].type;
        },
        getVideo(video) {
            if (video) {
                return `/storage/${video}`;
            } else {
                return '/img/load.png';
            }
        },
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
                console.log('sub_product:', this.sub_product);

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
            new Swiper("#swiper-container-1", {
                slidesPerView: 'auto',
                spaceBetween: 10,
                freeMode: false,           // مهم جداً
                watchOverflow: true,       // يمنع ظهور السحب إذا العناصر قليلة
                grabCursor: true,
                scrollbar: {
                    el: '.swiper-scrollbar',
                    hide: true,
                },
                breakpoints: {
                    1000: { slidesPerView: 3 },
                    768: { slidesPerView: 3 },
                    576: { slidesPerView: 3 },
                },
            });


            // Swiper الثاني
            new Swiper("#swiper-container-2", {
                slidesPerView: 'auto', // تغيير إلى 'auto'
                spaceBetween: 15,
                watchOverflow: true, // إخفاء العناصر الزائدة
                watchSlidesProgress: true,
                navigation: {
                    nextEl: "#swiper-button-next-2",
                    prevEl: "#swiper-button-prev-2",
                },
                breakpoints: {
                    1200: {
                        slidesPerView: 3,
                        spaceBetween: 15
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 15
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 10
                    },
                    576: {
                        slidesPerView: 3,
                        spaceBetween: 8
                    }
                }
            });
        },
        products_sub_products(id) {
            this.$router.push({ name: "sub_product2", params: { id: id } });
        },
        show(id) {
            this.$router.push({ name: "view_sub_product", params: { id: id } });
        },
    },
    mounted() {
        this.get_sub_product_info();
    },
};
</script>

<style scoped>
.related-prod {
    cursor: pointer !important;
}

.product-img {
    max-width: 100%;
    max-height: 200px;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-img:hover {
    transform: scale(1.05);
}

.image-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.show-prod-page .modal-content {
    padding: 0 !important;
    border-radius: 0 !important;
    max-width: 90%;
    max-height: 90vh;
    overflow: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: none !important;
    border: none !important;
}

.modal-image {
    max-width: 100%;
    max-height: 80vh;
    border-radius: 8px;
    object-fit: contain;
}

.image-modal {
    cursor: pointer;
}

.modal-content {
    background-color: transparent !important;
    border: none !important;
}

.modal-body {
    padding: 0 !important;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-media {
    max-width: 100%;
    max-height: 80vh;
    border-radius: 8px;
    object-fit: contain;
}

.modal-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1001;
    width: 50px;
    height: 50px;
    border-radius: 50% !important;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.modal-btn:hover {
    opacity: 1;
}

.prev-btn {
    left: 10px;
}

.next-btn {
    right: 10px;
}

@media (max-width: 768px) {
    .modal-btn {
        width: 40px;
        height: 40px;
    }

    .prev-btn {
        left: 5px;
    }

    .next-btn {
        right: 5px;
    }

    .fa-circle-chevron-left,
    .fa-circle-chevron-right {
        font-size: 1.5rem !important;
    }
}

/* تعديلات للشاشات الصغيرة جدًا */
@media (max-width: 576px) {
    .modal-btn {
        width: 35px;
        height: 35px;
    }

    .fa-circle-chevron-left,
    .fa-circle-chevron-right {
        font-size: 1.2rem !important;
    }
}

/* ******************************************************************* */

.swiper-slide {
    cursor: pointer;
}

.video-container,
.img-container {
    width: 100%;
    height: auto;
    display: flex;
    justify-content: center;
    align-items: center;
}

.video-container video,
.img-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 8px;
}

.show-prod-page .modal-content {
    background-color: transparent !important;
    padding: 0 !important;
    border-radius: 0 !important;
    max-width: 90%;
    max-height: 90vh;
    overflow: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: none !important;
    border: none !important;
}

.modal-media {
    max-width: 100%;
    max-height: 80vh;
    border-radius: 8px;
    object-fit: contain;
}


/* .swiper-container-1 .swiper-slide, */
.swiper-container-2 .swiper-slide {
    width: 100%;
    margin-right: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent !important;
}

/* .swiper-container-1 .swiper-slide img,
.swiper-container-1 .swiper-slide video, */
.swiper-container-2 .swiper-slide img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
}

#swiper-container-2 {
    position: relative;
    overflow: hidden;
    padding: 0 30px;
}

.swiper-button-next-2,
.swiper-button-prev-2 {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
    z-index: 10;
    /* ضروري لتكون فوق السلايدر */
}

.swiper-button-next-2 {
    right: 10px;
}

.swiper-button-prev-2 {
    left: 10px;
}


@media (max-width: 576px) {

    /* .swiper-container-1 .swiper-slide, */
    .swiper-container-2 .swiper-slide {
        width: calc(33.33% - 10px) !important;
    }

    /* 
    .swiper-container-1 .swiper-slide img,
    .swiper-container-1 .swiper-slide video, */
    .swiper-container-2 .swiper-slide img {
        height: 120px !important;
    }

    .swiper-button-next-2,
    .swiper-button-prev-2 {
        width: 24px;
        height: 24px;
    }
}

.swiper-container-1 {
    overflow: hidden;
    padding: 0 !important;
    margin: 0 auto;
}

.swiper-wrapper {
    display: flex;
}

.swiper-slide {
    flex-shrink: 0;
    width: 110px;
    margin-right: 10px;
}

.media-wrapper {
    width: 80%;
    height: 130px;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
    background: #f9f9f9;
    border: 1px solid #ddd;
}

.media-element {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.video-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 20px;
    color: white;
    background: rgba(0, 0, 0, 0.4);
    padding: 8px;
    border-radius: 50%;
}

@media (max-width: 576px) {
    .swiper-slide {
        width: 120px;
        margin-right: 8px;
    }

    .media-wrapper {
        height: 120px;
    }
}
</style>