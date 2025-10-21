<template>
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb breadcrumb-pipes">
            <li class="breadcrumb-item">
                <router-link to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Edit Sub Product
            </li>
        </ol>
    </nav>

    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $t("Edit Sub Product") }}</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" @submit.prevent="update">
                            
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="mb-1">
                                    <div>
                                        <p>{{ $t("Current Image") }}</p>
                                        <img :src="getUserImageSrc(fetchData.file)" width="100" height="100" alt="">
                                    </div>
                                    <label class="form-label" for="file-column">{{ $t("Photo") }}</label>
                                    <input type="file" class="form-control" id="prodImg" @change="handleFileUpload"
                                        accept="image/*" />
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">{{ $t("Name") }}</label>
                                        <input type="text" id="name" class="form-control" placeholder="Name"
                                            v-model="fetchData.name" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="color">{{ $t("Color") }}</label>
                                        <input type="text" id="color" class="form-control" placeholder="Color"
                                            v-model="fetchData.color" />
                                    </div>
                                </div>


                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="description">{{ $t("Description") }}</label>
                                        <input type="text" id="description" class="form-control"
                                            placeholder="Description" v-model="fetchData.desc" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="capital">{{ $t("Capital") }}</label>
                                        <input type="number" id="capital" class="form-control" placeholder="Capital"
                                            v-model="fetchData.capital" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="price">{{ $t("Price") }}</label>
                                        <input type="number" id="price" class="form-control" placeholder="Price"
                                            v-model="fetchData.price" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="quantity">{{ $t("Quantity") }}</label>
                                        <input type="number" id="quantity" class="form-control" placeholder="Quantity"
                                            v-model="fetchData.quantity" />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="delivery_price">{{ $t("delivery time") }}</label>
                                        <input type="text" id="delivery_price" class="form-control" placeholder="delivery price"
                                            v-model="fetchData.delivery_price" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="shipping_price">{{ $t("shipping price") }}</label>
                                        <input type="number" id="shipping_price" class="form-control" placeholder="shipping price"
                                            v-model="fetchData.shipping_price" />
                                    </div>
                                </div>
                                <hr>

                                <div class="col-md-6 col-12 col-lg-6">
                                    <div v-if="fetchData.video">
                                        <p>{{ $t("Current video") }}</p>
                                        <video :src="getVideo(fetchData.video)" controls width="300"></video>
                                    </div>
                                    <div v-else>
                                        <p class="text-primary">{{ $t("No video to show") }}</p>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="video">{{ $t("vedio") }}</label>
                                        <input type="file" class="form-control" id="video" @change="handleVideoUpload"
                                            accept="video/*" />
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div v-if="!parsedImages || parsedImages.length === 0" class="col-12">
                                        <h5 class="text-center text-primary">No images available.</h5>
                                    </div>
                                    <div v-else class="card-body">
                                        <div class="mt-4 mb-2 text-center">
                                            <h4>{{ $t("Product Images") }}</h4>
                                        </div>
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide" v-for="(image, index) in parsedImages"
                                                    :key="index">
                                                    <a href="#">
                                                        <div class="img-container w-50 mx-auto py-75">
                                                            <img :src="getUserImageSrc(image)" class="img-fluid"
                                                                alt="image" />
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div v-for="(image, index) in images" :key="index" class="mb-2 col-md-4">
                                        <label class="form-label" :for="'image-' + index">Image {{ index + 1 }}</label>
                                        <input type="file" class="form-control" :id="'image-' + index"
                                            @change="handleImageUpload($event, index)" accept="image/*" />
                                    </div>

                                    <button type="button" class="btn btn-primary my-1" @click="addImageField">
                                        {{ $t("Add Product Images ") }}
                                    </button>

                                    <div class="mt-3" v-if="images.length > 0">
                                        <h5>Uploaded Images:</h5>
                                        <ul>
                                            <li v-for="(image, index) in images" :key="'preview-' + index">
                                                {{ image ? image.name : 'No file selected' }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>



                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev waves-effect waves-float waves-light"
                                        @click="products_category(fetchData.prod_id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-arrow-left align-middle me-sm-25 me-0">
                                            <line x1="19" y1="12" x2="5" y2="12"></line>
                                            <polyline points="12 19 5 12 12 5"></polyline>
                                        </svg>
                                        <span class="align-middle d-sm-inline-block d-none">{{ $t("Previous") }}</span>
                                    </button>
                                    <div>
                                        <button type="submit"
                                            class="btn btn-success btn-submit waves-effect waves-float waves-light mx-1">{{ $t("Submit") }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Swal from "sweetalert2";
import axios from "axios";
import Swiper from "swiper";
import "swiper/css/swiper.css"; // Import Swiper styles

export default {
    props: ["id"],
    data() {
        return {
            fetchData: {
                prod_id: "",
                sub_prod_id: "",
                name: "",
                desc: "",
                type: "",
                capital: "",
                price: "",
                quantity: "",
                Width: "",
                Height: "",
                Thickness: "",
                file: "",
                color: "",
                shipping_price: "",
                delivery_price: "",
                images: [],
                video: "",
            },
            parsedImages: [],
            photo: null,
            video: null,
            images: [],
        };
    },
    // computed: {
    //     parsedImages() {
    //         // فصل النص JSON إلى مصفوفة من أسماء الصور فقط
    //         return this.fetchData.images ? JSON.parse(this.fetchData.images).map(image => image.split('/').pop()) : [];
    //     }
    // },
    methods: {
        // إضافة حقل جديد
        addImageField() {
            this.images.push(null); // إضافة عنصر فارغ
        },
        // تحميل الصورة في الفهرس المحدد
        handleImageUpload(event, index) {
            const file = event.target.files[0];

            if (file) {
                // تحديث الصورة في الفهرس المحدد
                this.images.splice(index, 1, file);
            }
        },
        products_category(id) {
            this.$router.push({
                name: "sub_products",
                params: { id: id },
            });
        },
        handleFileUpload(event) {
            this.photo = event.target.files[0];
            console.log('photo: ', this.photo);

        },
        handleVideoUpload(event) {
            this.video = event.target.files[0];
            console.log('video: ', this.video);
        },
        showProduct(id) {
            try {
                axios.get(`/api/sub-products/${id}`)
                    .then((response) => {
                        const fetchD = response.data.data;
                        console.log('sub-products f: ', fetchD);
                        this.fetchData.prod_id = fetchD.product_id;
                        this.fetchData.sub_prod_id = fetchD.id;
                        this.fetchData.desc = fetchD.desc;
                        this.fetchData.type = fetchD.type;
                        this.fetchData.capital = fetchD.capital;
                        this.fetchData.price = fetchD.price;
                        this.fetchData.quantity = fetchD.quantity;
                        this.fetchData.Width = fetchD.Width;
                        this.fetchData.Height = fetchD.Height;
                        this.fetchData.Thickness = fetchD.Thickness;
                        this.fetchData.file = fetchD.file;
                        this.fetchData.video = fetchD.video;
                        this.fetchData.color = fetchD.color;
                        this.fetchData.name = fetchD.name;
                        this.fetchData.shipping_price = fetchD.shipping_price;
                        this.fetchData.delivery_price = fetchD.delivery_price;
                        this.fetchData.images = fetchD.images;
                        // this.images = fetchD.images;
                        this.parsedImages = JSON.parse(this.fetchData.images).map(image => image.split('/').pop());
                        console.log('fetchdata  :', this.parsedImages);
                        this.$nextTick(() => {
                            this.initSwiper();
                        });

                    })
            } catch (error) {
                console.error("Error editing category:", error);
                this.showErrorMessage("Failed to edit.");
            }
        },

        update() {
            const data = new FormData();
            data.append("id", this.fetchData.sub_prod_id);
            data.append("product_id", this.fetchData.prod_id);
            data.append("name", this.fetchData.name);
            data.append("desc", this.fetchData.desc);
            data.append("type", this.fetchData.type);
            data.append("capital", this.fetchData.capital);
            data.append("price", this.fetchData.price);
            data.append("quantity", this.fetchData.quantity);
            // data.append("Width", this.fetchData.Width);
            // data.append("Height", this.fetchData.Height);
            data.append("Thickness", this.fetchData.Thickness);
            data.append("color", this.fetchData.color);
            data.append("delivery_price", this.fetchData.delivery_price);
            data.append("shipping_price", this.fetchData.shipping_price);
            data.append("file", this.photo);
            data.append("video", this.video);
            // data.append("images", JSON.stringify(this.images));

            this.images.forEach((image, index) => {
                if (image) {
                    data.append(`images[${index}]`, image); // إضافة كل صورة إلى FormData
                }
            });


            axios.post(`/api/sub-products/${this.id}`, data)
                .then((response) => {
                    this.showSuccessMessage();
                    console.log('response: ', response.data.data);

                    // if (response.data.status == 202) {
                    //     this.$router.push({ name: 'gradeslist' });
                    // } else {
                    //     this.showErrorMessage("هناك خطأ في عملية التعديل");
                    // }
                })
                .catch((error) => {
                    // this.showErrorMessage("حدث خطأ أثناء التعديل");
                    console.error(error);
                });
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
        showSuccessMessage(text) {
            Swal.fire({
                position: "top-start",
                icon: "success",
                title: text,
                showConfirmButton: false,
                timer: 1500,
                customClass: { confirmButton: "btn btn-primary" },
                buttonsStyling: false,
            });
        },
    },
    mounted() {
        this.showProduct(this.id);
    },
};
</script>

<style scoped>
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
</style>
