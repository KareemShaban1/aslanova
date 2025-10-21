<template>
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb breadcrumb-pipes">
            <li class="breadcrumb-item"><router-link to="/">{{ $t('Home') }}</router-link></li>
            <!-- <li class="breadcrumb-item"><a href="#">Library</a></li> -->
            <li class="breadcrumb-item active" aria-current="page">{{ $t('Products 3d') }}</li>
        </ol>
    </nav>

    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $t('Products 3d') }}</h4>
                    <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal"
                        data-bs-target="#add_model">{{ $t('Add') }}</button>
                    <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal"
                        data-bs-target="#add_part_product">{{ $t('Add Product Parts') }}</button>
                    <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal"
                        data-bs-target="#add_product_texture">{{ $t('Add Product Textures') }}</button>
                </div>
                <!-- --------modeladd start -------------------------  -->
                <div class="modal fade text-start" id="add_model" tabindex="-1" aria-labelledby="myModalLabel33"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">{{ $t('Add Product3d') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="#">
                                <div class="modal-body">
                                    <label>{{ $t('Add') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Name" class="form-control" v-model="add_name">
                                    </div>

                                    <label>{{ $t('Price') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="price" class="form-control item-description"
                                            v-model="add_price">
                                    </div>
                                    <label>{{ $t('Model Id') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="model id" class="form-control item-description"
                                            v-model="add_model">
                                    </div>
                                    <!-- add shipping_price and delivery_price -->
                                    <label> {{ $t('shipping price') }}</label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="Shipping Price"
                                            class="form-control item-description" v-model="add_shipping_price">
                                    </div>
                                    <label>{{ $t('delivery time') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Delivery Price"
                                            class="form-control item-description" v-model="add_delivery_price">
                                    </div>
                                    <label>{{ $t('Description') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Description"
                                            class="form-control item-description" v-model="add_desc">
                                    </div>
                                    <label>{{ $t('Photo') }} </label>
                                    <div class="mb-1">
                                        <input type="file" class="form-control" id="catImg" aria-describedby="catImg"
                                            tabindex="7" @change="handleFileUpload" accept="image/*" />
                                    </div>

                                    <div class="mb-1">
                                        <div class="mb-1">
                                            <label class="form-label" for="video">{{ $t('video') }}</label>
                                            <input type="file" class="form-control" id="video"
                                                @change="handleVideoUpload" accept="video/*" />
                                        </div>
                                    </div>

                                    <div>
                                        <!-- الحقول الديناميكية لتحميل الصور -->
                                        <div v-for="(image, index) in images" :key="index" class="mb-2">
                                            <label class="form-label" :for="'image-' + index">Image {{ index + 1
                                            }}</label>
                                            <input type="file" class="form-control" :id="'image-' + index"
                                                @change="handleImageUpload($event, index)" accept="image/*" />
                                        </div>

                                        <!-- زر لإضافة حقل جديد -->
                                        <button type="button" class="btn btn-primary my-1" @click="addImageField">
                                            {{ $t('Add Product Images') }}
                                        </button>

                                        <!-- عرض الصور المحملة -->
                                        <div class="mt-3" v-if="images.length > 0">
                                            <h5>{{ $t('Uploaded Images') }}</h5>
                                            <ul>
                                                <li v-for="(image, index) in images" :key="'preview-' + index">
                                                    <!-- عرض اسم الصورة فقط إذا كانت موجودة -->
                                                    {{ image ? image.name : 'No file selected' }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button @click="add_method" type="button"
                                        class="btn btn-primary waves-effect waves-float waves-light"
                                        data-bs-dismiss="modal">{{ $t('Create') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- --------modeladd end   -------------------------  -->
                <!-- --------modeladd part product start -------------------------  -->
                <div class="modal fade text-start" id="add_part_product" tabindex="-1" aria-labelledby="myModalLabel33"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">{{ $t('Add product part Form') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="#">
                                <div class="modal-body">
                                    <label>{{ $t('Choose Product3d') }} </label>
                                    <div class="mb-1">
                                        <select class="form-select" v-model="selectedProduct3d">
                                            <option value="" disabled>{{ $t('Select Product3d') }}</option>
                                            <option v-for="product in products_3d" :key="product.id"
                                                :value="product.id">
                                                {{ product.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <label>{{ $t('Choose Part') }} </label>
                                    <div class="mb-1">
                                        <select class="form-select" v-model="selectedPart">
                                            <option value="" disabled>Select Part</option>
                                            <option v-for="part in parts" :key="part.id" :value="part.id">
                                                {{ part.name }}
                                            </option>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button @click="add_product_part" type="button"
                                        class="btn btn-primary waves-effect waves-float waves-light"
                                        data-bs-dismiss="modal">{{ $t('Create') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- --------modeladd part product end   -------------------------  -->
                <!-- --------modeladd texture product start -------------------------  -->
                <div class="modal fade text-start" id="add_product_texture" tabindex="-1"
                    aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">{{ $t('Add product texture Form') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="#">
                                <div class="modal-body">
                                    <label>{{ $t('Choose Product3d') }} </label>
                                    <div class="mb-1">
                                        <select class="form-select" v-model="selectedProduct3d">
                                            <option value="" disabled>Select Product3d</option>
                                            <option v-for="product in products_3d" :key="product.id"
                                                :value="product.id">
                                                {{ product.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <label>{{ $t('Choose Part') }} </label>
                                    <div class="mb-1">
                                        <select class="form-select" v-model="selectedTexture">
                                            <option value="" disabled>Select Texture</option>
                                            <option v-for="texture in textures" :key="texture.id" :value="texture.id">
                                                {{ texture.name }}
                                            </option>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button @click="add_product_texture" type="button"
                                        class="btn btn-primary waves-effect waves-float waves-light"
                                        data-bs-dismiss="modal">{{ $t('Create') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- --------modeladd texture product end   -------------------------  -->
                <!-- --------modeledit start -------------------------  -->
                <div class="modal fade text-start" id="editcategory" tabindex="-1" aria-labelledby="myModalLabel33"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">{{ $t('Edit') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form>
                                <div class="modal-body">
                                    <label>{{ $t('Name') }}</label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Name" class="form-control"
                                            v-model="editData.name">
                                    </div>

                                    <label>{{ $t('Price') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="price" class="form-control"
                                            v-model="editData.price">
                                    </div>
                                    <label>{{ $t('Model Id') }}</label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="price" class="form-control"
                                            v-model="editData.model_id">
                                    </div>
                                    <label>{{ $t('shipping price') }} </label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="Shipping Price" class="form-control"
                                            v-model="editData.shipping_price">
                                    </div>
                                    <label>{{ $t('delivery time') }}</label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Delivery Price" class="form-control"
                                            v-model="editData.delivery_price">
                                    </div>


                                    <label>{{ $t('category3d id') }}</label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="price" class="form-control"
                                            v-model="editData.category3d_id">
                                    </div>


                                    <label>{{ $t('Description') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="price" class="form-control"
                                            v-model="editData.desc">
                                    </div>

                                    <label>{{ $t('Photo') }} </label>
                                    <div class="mb-1">
                                        <input type="file" class="form-control" id="catImg" aria-describedby="catImg"
                                            tabindex="7" @change="handleFileUpdate" accept="image/*" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button @click="edit_method(editData.id_item)" type="button"
                                        class="btn btn-primary waves-effect waves-float waves-light"
                                        data-bs-dismiss="modal">{{ $t('Edit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- --------modeledit end   -------------------------  -->

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ $t('ID') }}</th>
                                <th>{{ $t('Name') }}</th>
                                <th>{{ $t('Price') }}</th>
                                <th>{{ $t('Model Id') }}</th>
                                <th>{{ $t('Photo') }}</th>
                                <th>{{ $t('shipping price') }}</th>
                                <th>{{ $t('delivery time') }}</th>
                                <th>{{ $t('Description') }}</th>
                                <th>{{ $t('Created at') }}</th>
                                <th>{{ $t('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product3d, index) in products_3d" :key="index">
                                <td>
                                    {{ product3d.id }}
                                </td>
                                <td>
                                    {{ product3d.name }}
                                </td>

                                <td>
                                    {{ product3d.price }}
                                </td>
                                <td>
                                    {{ product3d.model_id }}
                                </td>
                                <td>
                                    <img class="prod-img" :src="getUserImageSrc(product3d.file)" alt="Product Image">
                                </td>
                                <td>
                                    {{ product3d.shipping_price ? product3d.shipping_price : "free delivery" }}
                                </td>
                                <td>
                                    {{ product3d.delivery_price ? product3d.delivery_price : "-" }}
                                </td>
                                <td>
                                    {{ product3d.desc ? product3d.desc.slice(0, 20) + (product3d.desc.length > 20 ?
                                    '...' : '') : '' }}
                                </td>
                                <td>
                                    {{ product3d.created_at }}
                                </td>
                                <td>

                                    <!-- <button @click="show_method(product3d.id)" data-bs-toggle="modal"
                                        data-bs-target="#editcategory" type="button"
                                        class="btn btn-icon btn-warning waves-effect waves-float waves-light">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button> -->
                                    <button @click="edit(product3d.id)" type="button"
                                        class="btn btn-icon btn-warning waves-effect waves-float waves-light">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>

                                    <button @click="delete_method(product3d.id)" type="button"
                                        class="btn btn-icon btn-danger waves-effect waves-float waves-light mx-1">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import Swal from "sweetalert2";
import { useRoute } from "vue-router";

export default {
    data() {
        const categoryId = useRoute().params.id;
        return {
            categoryId,
            products_3d: [],
            parts: [],
            textures: [],
            add_name: "",
            add_price: "",
            add_model: "",
            add_desc: "",
            add_file: "",
            add_shipping_price: "",
            add_delivery_price: "",
            edit_file: "",
            selectedProduct3d: null,
            selectedPart: null,
            selectedTexture: null,

            add_video: null,
            images: [],

            // for edit
            editData: {
                id_item: null,
                name: "",
                price: "",
                model_id: "",
                category3d_id: categoryId,
                desc: "",
                file: "",
                shipping_price: "",
                delivery_price: "",
            },

        }
    },
    methods: {
        edit(id) {
            this.$router.push({ name: "editproduct_3d", params: { id: id } });
        },
        addImageField() {
            this.images.push(null); // إضافة عنصر فارغ
        },
        handleImageUpload(event, index) {
            const file = event.target.files[0];
            if (file) {
                // تحديث الصورة في الفهرس المحدد
                this.images.splice(index, 1, file);
            }
        },
        handleVideoUpload(event) {
            this.add_video = event.target.files[0];
        },
        handleFileUpload(event) {
            console.log(event.target.files);

            this.add_file = event.target.files[0]; // احصل على الملف المحدد
        },
        handleFileUpdate(event) {
            console.log(event.target.files[0]);

            this.edit_file = event.target.files[0];

            console.log(this.edit_file);

            // احصل على الملف المحدد
        },
        getUserImageSrc(photo) {
            if (photo) {
                return `/storage/${photo}`;
            } else {
                return '/img/load.png'
            }
        },
        get_all() {
            axios.get(`/api/Categorys_3d/${this.categoryId}/products_3d`)
                .then(response => {
                    this.products_3d = response.data.products;
                    console.log("products_3d: ", this.products_3d);
                })
                .catch(error => {
                    console.error("هناك خطأ في جلب المنتجات: ", error);
                });
        }
        ,
        get_all_parts() {
            axios.get('/api/parts').
                then(response => {
                    this.parts = response.data.data;
                    console.log("parts: ", this.parts);
                })
        },
        get_all_textures() {
            axios.get('/api/textures').
                then(response => {
                    this.textures = response.data.data;
                    console.log("textures: ", this.textures);
                })
        },
        add_method() {
            const data = new FormData();
            data.append("name", this.add_name);
            data.append("price", this.add_price);
            data.append("model_id", this.add_model);
            data.append("desc", this.add_desc);
            data.append("category3d_id", this.categoryId);
            data.append("file", this.add_file);
            data.append("shipping_price", this.add_shipping_price);
            data.append("delivery_price", this.add_delivery_price);
            data.append("video", this.add_video);
            // إضافة الصور من المصفوفة images
            this.images.forEach((image, index) => {
                if (image) {
                    data.append(`images[${index}]`, image); // إضافة كل صورة إلى FormData
                }
            });

            axios
                .post('/api/products_3d', data)
                .then(() => {
                    this.get_all();
                    this.add_name = "";
                    this.add_price = "";
                    this.add_model = "";
                    this.showSuccessMessage("Add successfully");
                });
        },
        add_product_part() {
            const data = {
                product_id: this.selectedProduct3d,
                part_id: this.selectedPart
            };

            axios.post('/api/product_parts', data)
                .then(response => {
                    this.showSuccessMessage("Product part created");
                    console.log("Product part created: ", response.data);
                })
                .catch(error => {
                    console.error("Error adding product part: ", error);
                    this.showErrorMessage("Error adding product part");
                    // Handle the error, show an error message to the user
                });
        },
        add_product_texture() {
            const data = {
                product_id: this.selectedProduct3d,
                texture_id: this.selectedTexture
            };

            axios.post('/api/product_textures', data)
                .then(response => {
                    this.showSuccessMessage("Product texture created");
                    console.log("Product texture created: ", response.data);
                })
                .catch(error => {
                    console.error("Error adding product texture: ", error);
                    this.showErrorMessage("Error adding product texture");
                    // Handle the error, show an error message to the user
                });
        },
        edit_method(id) {
            try {

                const data = new FormData();
                data.append("name", id);
                data.append("name", this.editData.name);
                data.append("price", this.editData.price);
                data.append("model_id", this.editData.model_id);
                data.append("desc", this.editData.desc);
                data.append("category3d_id", this.editData.category3d_id);
                data.append("file", this.edit_file);
                data.append("shipping_price", this.editData.shipping_price);
                data.append("delivery_price", this.editData.delivery_price);
                if (this.editData.file) {
                    data.append("file", this.editData.file);

                }
                axios.post(`/api/products_3d/${id}`, data)
                    .then((response) => {
                        // this.category = response.data.category;
                        console.log('Product edited successfully:', response.data.product);
                        this.get_all();
                        this.showSuccessMessage('Update data successfuly');
                    })
            } catch (error) {
                console.error("Error editing category:", error);
                this.showErrorMessage("Failed to edit.");
            }
        },
        show_method(id) {
            try {
                axios.get(`/api/products_3d/${id}`)
                    .then((response) => {
                        const fetchData = response.data.product;
                        this.editData.id_item = fetchData.id;
                        this.editData.name = fetchData.name;
                        this.editData.price = fetchData.price;
                        this.editData.model_id = fetchData.model_id;
                        this.editData.category3d_id = fetchData.category3d_id;
                        this.editData.desc = fetchData.desc;
                        this.editData.file = fetchData.file;
                        this.editData.shipping_price = fetchData.shipping_price;
                        this.editData.delivery_price = fetchData.delivery_price;

                        console.log('fetchData: ', this.editData);
                    })
            } catch (error) {
                console.error("Error editing :", error);
                this.showErrorMessage("Failed to edit.");
            }
        },
        products_category(id) {
            this.$router.push({ name: "products_category", params: { id: id } });
        },
        showSuccessMessage(text) {
            Swal.fire({
                position: "top-start",
                icon: "success",
                title: text,
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                    confirmButton: "btn btn-primary",
                },
                buttonsStyling: false,
            });
        },
        showErrorMessage(message) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: message,
            });
        },
        delete_method(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await axios.delete(`/api/products_3d/${id}`);
                        this.get_all();
                        this.showSuccessMessage("Deleted successfully.");
                    } catch (error) {
                        console.error("Error Deleting Item:", error);
                        this.showErrorMessage("Failed to Delete Item.");
                    }
                }
            });
        },
    },
    mounted() {
        this.get_all();
        this.get_all_parts();
        this.get_all_textures();
    }
}
</script>
<style scoped>
.prod-img {
    width: 50px;
}
</style>