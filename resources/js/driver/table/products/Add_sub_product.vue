<template>
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb breadcrumb-pipes">
            <li class="breadcrumb-item">
                <router-link to="/">{{ $t("Home") }}</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $t("Add Sub Product") }}
            </li>
        </ol>
    </nav>

    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $t("Add Sub Product") }}</h4>
                    </div>
                    <div class="card-body">
                        <form class="form" @submit.prevent="add_product">
                            <div class="row">
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">{{ $t("Name") }}</label>
                                        <input type="text" id="name" class="form-control"
                                            placeholder="Name" v-model="add_name" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="file-column">{{ $t("Photo") }}</label>
                                        <input type="file" class="form-control" id="prodImg" @change="handleFileUpload"
                                            accept="image/*" />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="color">{{ $t("Color") }}</label>
                                        <input type="text" id="color" class="form-control" placeholder="Color"
                                            v-model="add_color" />
                                    </div>
                                </div>

                                <!-- الحقول الإضافية -->

                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="description">{{ $t("Description") }}</label>
                                        <input type="text" id="description" class="form-control"
                                            placeholder="Description" v-model="add_desc" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="capital">{{ $t("Capital") }}</label>
                                        <input type="number" id="capital" class="form-control" placeholder="Capital"
                                            v-model="add_capital" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="price">{{ $t("Price") }}</label>
                                        <input type="number" id="price" class="form-control" placeholder="Price"
                                            v-model="add_price" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="quantity">{{ $t("Quantity") }}</label>
                                        <input type="number" id="quantity" class="form-control" placeholder="Quantity"
                                            v-model="add_quantity" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="delivery_price">{{ $t("delivery time") }}</label>
                                        <input type="text" id="delivery_price" class="form-control" placeholder="delivery price"
                                            v-model="add_delivery_price" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="shipping_price">{{ $t("shipping price") }}</label>
                                        <input type="number" id="shipping_price" class="form-control" placeholder="shipping price"
                                            v-model="add_shipping_price" />
                                    </div>
                                </div>

                                <hr>

                                <div class="col-md-6 col-12 col-lg-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="video">{{ $t("vedio") }}</label>
                                        <input type="file" class="form-control" id="video" @change="handleVideoUpload"
                                            accept="video/*" />
                                    </div>
                                </div>

                                <hr>

                                <div>
                                    <!-- الحقول الديناميكية لتحميل الصور -->
                                    <div v-for="(image, index) in images" :key="index" class="mb-2 col-md-4">
                                        <label class="form-label" :for="'image-' + index">Image {{ index + 1 }}</label>
                                        <input type="file" class="form-control" :id="'image-' + index"
                                            @change="handleImageUpload($event, index)" accept="image/*" />
                                    </div>

                                    <!-- زر لإضافة حقل جديد -->
                                    <button type="button" class="btn btn-primary my-1" @click="addImageField">
                                        {{ $t("Add Product Images") }}
                                    </button>

                                    <!-- عرض الصور المحملة -->
                                    <div class="mt-3" v-if="images.length > 0">
                                        <h5>Uploaded Images:</h5>
                                        <ul>
                                            <li v-for="(image, index) in images" :key="'preview-' + index">
                                                <!-- عرض اسم الصورة فقط إذا كانت موجودة -->
                                                {{ image ? image.name : 'No file selected' }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>



                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-primary btn-prev waves-effect waves-float waves-light"
                                        @click="products_category">
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
                                        <!-- <button type="reset"
                                            class="btn btn-outline-secondary waves-effect">Reset</button> -->
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

export default {
    props: ["id"],
    data() {
        return {
            add_name: "",
            add_desc: "",
            add_capital: null,
            add_price: null,
            add_quantity: null,
            add_photo: null,
            add_color: null,
            add_delivery_price: null,
            add_shipping_price: null,
            add_color: null,
            add_video: null,
            images: [], // لتخزين الصور
        };
    },
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
        products_category() {
            this.$router.push({
                name: "sub_products",
                params: { id: this.id },
            });
        },
        handleFileUpload(event) {
            this.add_photo = event.target.files[0];
        },
        handleVideoUpload(event) {
            this.add_video = event.target.files[0];
        },
        add_product() {
            const data = new FormData();
            data.append("product_id", this.id);
            data.append("name", this.add_name);
            data.append("file", this.add_photo);
            data.append("color", this.add_color);
            data.append("description", this.add_desc);
            data.append("capital", this.add_capital);
            data.append("price", this.add_price);
            data.append("quantity", this.add_quantity);
            data.append("delivery_price", this.add_delivery_price);
            data.append("shipping_price", this.add_shipping_price);
            data.append("video", this.add_video);

            // إضافة الصور من المصفوفة images
            this.images.forEach((image, index) => {
                if (image) {
                    data.append(`images[${index}]`, image); // إضافة كل صورة إلى FormData
                }
            });


            axios.post("/api/sub-products", data).then(() => {
                this.showSuccessMessage("Add Sub Product to Product successfully");
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
};
</script>
