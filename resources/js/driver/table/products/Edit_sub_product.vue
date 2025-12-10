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
                                    <input type="file" 
                                        class="form-control" 
                                        :class="{ 'is-invalid': errors.photo }"
                                        id="prodImg" 
                                        @change="handleFileUpload"
                                        accept="image/*" />
                                    <div v-if="errors.photo" class="invalid-feedback d-block">
                                        {{ errors.photo }}
                                    </div>
                                    <small class="form-text text-muted">
                                        {{ $t("Image hints: Max size 5MB, formats: JPG, PNG, GIF, WEBP") }}
                                    </small>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="name">{{ $t("Name") }}</label>
                                        <input type="text" 
                                            id="name" 
                                            class="form-control" 
                                            :class="{ 'is-invalid': errors.name }"
                                            placeholder="Name"
                                            v-model="fetchData.name" />
                                        <div v-if="errors.name" class="invalid-feedback d-block">
                                            {{ errors.name }}
                                        </div>
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
                                        <input type="number" 
                                            id="capital" 
                                            class="form-control" 
                                            :class="{ 'is-invalid': errors.capital }"
                                            placeholder="Capital"
                                            v-model="fetchData.capital" 
                                            min="0" 
                                            step="0.01" />
                                        <div v-if="errors.capital" class="invalid-feedback d-block">
                                            {{ errors.capital }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="price">{{ $t("Price") }}</label>
                                        <input type="number" 
                                            id="price" 
                                            class="form-control" 
                                            :class="{ 'is-invalid': errors.price }"
                                            placeholder="Price"
                                            v-model="fetchData.price" 
                                            min="0" 
                                            step="0.01" />
                                        <div v-if="errors.price" class="invalid-feedback d-block">
                                            {{ errors.price }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 col-lg-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="quantity">{{ $t("Quantity") }}</label>
                                        <input type="number" 
                                            id="quantity" 
                                            class="form-control" 
                                            :class="{ 'is-invalid': errors.quantity }"
                                            placeholder="Quantity"
                                            v-model="fetchData.quantity" 
                                            min="0" />
                                        <div v-if="errors.quantity" class="invalid-feedback d-block">
                                            {{ errors.quantity }}
                                        </div>
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
                                        <input type="number" 
                                            id="shipping_price" 
                                            class="form-control" 
                                            :class="{ 'is-invalid': errors.shipping_price }"
                                            placeholder="shipping price"
                                            v-model="fetchData.shipping_price" 
                                            min="0" 
                                            step="0.01" />
                                        <div v-if="errors.shipping_price" class="invalid-feedback d-block">
                                            {{ errors.shipping_price }}
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="col-md-6 col-12 col-lg-6">
                                    <div v-if="fetchData.video">
                                        <p>{{ $t("Current video") }}</p>
                                        <video :key="fetchData.video" :src="getVideo(fetchData.video)" controls width="300"></video>
                                    </div>
                                    <div v-else>
                                        <p class="text-primary">{{ $t("No video to show") }}</p>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="video">{{ $t("vedio") }}</label>
                                        <input type="file" 
                                            class="form-control" 
                                            :class="{ 'is-invalid': errors.video }"
                                            id="video" 
                                            @change="handleVideoUpload"
                                            accept="video/*" />
                                        <div v-if="errors.video" class="invalid-feedback d-block">
                                            {{ errors.video }}
                                        </div>
                                        <small class="form-text text-muted">
                                            {{ $t("Video hints: Max size 50MB, formats: MP4, AVI, MOV, WEBM") }}
                                        </small>
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
                                        <input type="file" 
                                            class="form-control" 
                                            :class="{ 'is-invalid': errors[`images.${index}`] }"
                                            :id="'image-' + index"
                                            @change="handleImageUpload($event, index)" 
                                            accept="image/*" />
                                        <div v-if="errors[`images.${index}`]" class="invalid-feedback d-block">
                                            {{ errors[`images.${index}`] }}
                                        </div>
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
                                            class="btn btn-success btn-submit waves-effect waves-float waves-light mx-1"
                                            :disabled="isSubmitting">
                                            <span v-if="isSubmitting" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                            {{ isSubmitting ? $t("Updating...") : $t("Submit") }}
                                        </button>
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
            errors: {},
            isSubmitting: false,
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
            const errorKey = `images.${index}`;

            // Clear previous error
            if (this.errors[errorKey]) {
                delete this.errors[errorKey];
            }

            if (file) {
                // Validate image
                const validation = this.validateImage(file);
                if (validation.isValid) {
                    this.images.splice(index, 1, file);
                } else {
                    this.errors[errorKey] = validation.message;
                    event.target.value = ''; // Clear the input
                }
            }
        },
        products_category(id) {
            this.$router.push({
                name: "sub_products",
                params: { id: id },
            });
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            
            // Clear previous error
            if (this.errors.photo) {
                delete this.errors.photo;
            }

            if (file) {
                // Validate image
                const validation = this.validateImage(file);
                if (validation.isValid) {
                    this.photo = file;
                } else {
                    this.errors.photo = validation.message;
                    event.target.value = ''; // Clear the input
                }
            }
        },
        handleVideoUpload(event) {
            const file = event.target.files[0];
            
            // Clear previous error
            if (this.errors.video) {
                delete this.errors.video;
            }

            if (file) {
                // Validate video
                const validation = this.validateVideo(file);
                if (validation.isValid) {
                    this.video = file;
                    console.log('Video selected and validated:', file.name, file.size, file.type);
                } else {
                    this.errors.video = validation.message;
                    event.target.value = ''; // Clear the input
                    this.video = null;
                }
            } else {
                // If no file selected, clear the video
                this.video = null;
                console.log('No video file selected');
            }
        },
        // Validate image file
        validateImage(file) {
            const maxSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            
            if (!allowedTypes.includes(file.type)) {
                return {
                    isValid: false,
                    message: this.$t('Invalid image format. Allowed: JPG, PNG, GIF, WEBP')
                };
            }
            
            if (file.size > maxSize) {
                return {
                    isValid: false,
                    message: this.$t('Image size exceeds 5MB limit')
                };
            }
            
            return { isValid: true };
        },
        // Validate video file
        validateVideo(file) {
            const maxSize = 50 * 1024 * 1024; // 50MB
            const allowedTypes = ['video/mp4', 'video/avi', 'video/quicktime', 'video/x-msvideo', 'video/webm'];
            
            if (!allowedTypes.includes(file.type)) {
                return {
                    isValid: false,
                    message: this.$t('Invalid video format. Allowed: MP4, AVI, MOV, WEBM')
                };
            }
            
            if (file.size > maxSize) {
                return {
                    isValid: false,
                    message: this.$t('Video size exceeds 50MB limit')
                };
            }
            
            return { isValid: true };
        },
        // Validate form fields
        validateForm() {
            this.errors = {};
            let isValid = true;

            // Validate name
            if (!this.fetchData.name || this.fetchData.name.trim() === '') {
                this.errors.name = this.$t('Name is required');
                isValid = false;
            }

            // Validate price
            if (this.fetchData.price === '' || this.fetchData.price === null || this.fetchData.price < 0) {
                this.errors.price = this.$t('Price must be a positive number');
                isValid = false;
            }

            // Validate quantity
            if (this.fetchData.quantity === '' || this.fetchData.quantity === null || this.fetchData.quantity < 0) {
                this.errors.quantity = this.$t('Quantity must be a positive number');
                isValid = false;
            }

            // Validate capital
            if (this.fetchData.capital !== '' && this.fetchData.capital !== null && this.fetchData.capital < 0) {
                this.errors.capital = this.$t('Capital must be a positive number');
                isValid = false;
            }

            // Validate shipping_price
            if (this.fetchData.shipping_price !== '' && this.fetchData.shipping_price !== null && this.fetchData.shipping_price < 0) {
                this.errors.shipping_price = this.$t('Shipping price must be a positive number');
                isValid = false;
            }

            return isValid;
        },
        showProduct(id) {
            axios.get(`/api/sub-products/${id}`)
                .then((response) => {
                    const fetchD = response.data.data;
                    console.log('sub-products f: ', fetchD);
                    this.fetchData.prod_id = fetchD.product_id;
                    this.fetchData.sub_prod_id = fetchD.id;
                    this.fetchData.desc = fetchD.desc || '';
                    this.fetchData.type = fetchD.type || '';
                    this.fetchData.capital = fetchD.capital || 0;
                    this.fetchData.price = fetchD.price || 0;
                    this.fetchData.quantity = fetchD.quantity || 0;
                    this.fetchData.Width = fetchD.Width || '';
                    this.fetchData.Height = fetchD.Height || '';
                    this.fetchData.Thickness = fetchD.Thickness || '';
                    this.fetchData.file = fetchD.file || '';
                    this.fetchData.video = fetchD.video || '';
                    this.fetchData.color = fetchD.color || '';
                    this.fetchData.name = fetchD.name || '';
                    this.fetchData.shipping_price = fetchD.shipping_price || 0;
                    this.fetchData.delivery_price = fetchD.delivery_price || '';
                    this.fetchData.images = fetchD.images || '[]';
                    
                    try {
                        if (this.fetchData.images && this.fetchData.images !== '[]') {
                            this.parsedImages = JSON.parse(this.fetchData.images).map(image => image.split('/').pop());
                        } else {
                            this.parsedImages = [];
                        }
                    } catch (error) {
                        console.error('Error parsing images:', error);
                        this.parsedImages = [];
                    }
                    
                    console.log('fetchdata  :', this.parsedImages);
                    this.$nextTick(() => {
                        if (this.parsedImages && this.parsedImages.length > 0) {
                            this.initSwiper();
                        }
                    });
                })
                .catch((error) => {
                    console.error("Error loading product:", error);
                    const errorMessage = error.response?.data?.message 
                        || error.message 
                        || this.$t('Failed to load product data');
                    this.showErrorMessage(errorMessage);
                });
        },

        update() {
            // Clear previous errors
            this.errors = {};

            // Validate form
            if (!this.validateForm()) {
                this.showErrorMessage(this.$t('Please fix the validation errors before submitting'));
                // Scroll to first error
                this.$nextTick(() => {
                    const firstError = document.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
                return;
            }

            // Check if there are file validation errors
            if (Object.keys(this.errors).length > 0) {
                this.showErrorMessage(this.$t('Please fix the file validation errors before submitting'));
                return;
            }

            this.isSubmitting = true;

            // Final check - verify video is still set before creating FormData
            console.log('Before FormData creation - video state:', {
                video: this.video,
                isFile: this.video instanceof File,
                videoName: this.video?.name,
            });

            const data = new FormData();
            data.append("id", this.fetchData.sub_prod_id);
            data.append("product_id", this.fetchData.prod_id);
            data.append("name", this.fetchData.name);
            data.append("desc", this.fetchData.desc || '');
            data.append("type", this.fetchData.type || '');
            data.append("capital", this.fetchData.capital || 0);
            data.append("price", this.fetchData.price);
            data.append("quantity", this.fetchData.quantity);
            data.append("Thickness", this.fetchData.Thickness || '');
            data.append("color", this.fetchData.color || '');
            data.append("delivery_price", this.fetchData.delivery_price || '');
            data.append("shipping_price", this.fetchData.shipping_price || 0);
            
            if (this.photo && this.photo instanceof File) {
                data.append("file", this.photo);
                console.log('Photo file appended:', this.photo.name, this.photo.size);
            }
            
            if (this.video && this.video instanceof File) {
                data.append("video", this.video, this.video.name);
                console.log('Video file appended to FormData:', {
                    name: this.video.name,
                    size: this.video.size,
                    type: this.video.type,
                    lastModified: this.video.lastModified
                });
            } else {
                console.warn('No video file to append', {
                    video: this.video,
                    type: typeof this.video,
                    isFile: this.video instanceof File
                });
            }
            
            // Log FormData contents for debugging
            console.log('FormData contents:');
            for (let pair of data.entries()) {
                if (pair[1] instanceof File) {
                    console.log(pair[0] + ': File - ' + pair[1].name + ' (' + pair[1].size + ' bytes)');
                } else {
                    console.log(pair[0] + ': ' + pair[1]);
                }
            }

            this.images.forEach((image, index) => {
                if (image) {
                    data.append(`images[${index}]`, image);
                }
            });

            // Don't set Content-Type header - browser will set it automatically with boundary for FormData
            axios.post(`/api/sub-products/${this.id}`, data)
                .then((response) => {
                    this.isSubmitting = false;
                    const updatedData = response.data.data;
                    console.log('Update response: ', updatedData);
                    console.log('Video in response: ', updatedData?.video);
                    
                    this.showSuccessMessage(this.$t('Product updated successfully'));
                    
                    // Reload the page after a short delay to ensure the update is complete
                    // Use force reload to bypass cache
                    setTimeout(() => {
                        window.location.reload(true);
                    }, 1500);
                })
                .catch((error) => {
                    this.isSubmitting = false;
                    console.error(error);
                    
                    // Handle validation errors from backend
                    if (error.response && error.response.status === 422) {
                        const validationErrors = error.response.data.errors || {};
                        const errorMessage = error.response.data.message || this.$t('Validation failed. Please check the form for errors');
                        this.errors = {};
                        
                        // Map backend errors to our errors object
                        Object.keys(validationErrors).forEach(key => {
                            this.errors[key] = Array.isArray(validationErrors[key]) 
                                ? validationErrors[key][0] 
                                : validationErrors[key];
                        });
                        
                        // Show specific error message if available, otherwise show first field error
                        const firstError = Object.values(this.errors)[0];
                        const displayMessage = errorMessage !== 'Validation failed. Please check the form for errors' 
                            ? errorMessage 
                            : (firstError || errorMessage);
                        
                        this.showErrorMessage(displayMessage);
                        
                        // Scroll to first error
                        this.$nextTick(() => {
                            const firstErrorElement = document.querySelector('.is-invalid');
                            if (firstErrorElement) {
                                firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        });
                    } else {
                        const errorMessage = error.response?.data?.message 
                            || error.response?.data?.error
                            || error.message 
                            || this.$t('An error occurred while updating the product');
                        this.showErrorMessage(errorMessage);
                    }
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
                position: "top-center",
                icon: "success",
                title: text || this.$t('Operation completed successfully'),
                showConfirmButton: false,
                timer: 1500,
                customClass: { confirmButton: "btn btn-primary" },
                buttonsStyling: false,
            });
        },
        showErrorMessage(message) {
            Swal.fire({
                position: "top-center",
                icon: "error",
                title: this.$t('Error'),
                text: message || this.$t('An error occurred'),
                confirmButtonText: this.$t('OK'),
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

.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

.form-text {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #6c757d;
}

.btn:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}
</style>
