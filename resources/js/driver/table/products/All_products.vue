<template>
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb breadcrumb-pipes">
            <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
            <!-- <li class="breadcrumb-item"><a href="#">Library</a></li> -->
            <li class="breadcrumb-item active" aria-current="page">All Products</li>
        </ol>
    </nav>

    <div class="row">

    </div>

    <h4 class="badge d-block bg-primary" v-if="products_category.length === 0">
        لايوجد بيانات لعرضها
    </h4>
    <div class="row card" id="table-hover-row">
        <div class="card-header">
            <h4 class="card-title py-1">Products rows</h4>
            <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal"
                data-bs-target="#showCategories" @click="get_categories">Show Categories</button>
        </div>
        <!-- --------modeladd start -------------------------  -->
        <div class="modal fade text-start" id="showCategories" tabindex="-1" aria-labelledby="myModalLabel33"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Add Category Form</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="#">
                        <div class="modal-body">
                            <label>Choose Category: </label>
                            <div class="mb-1">
                                <select class="form-select" @change="get_products_category($event.target.value)">
                                    <option value="">Choose category ...</option>
                                    <option v-for="cat in categories" key="cat.index" :value="cat.id">{{ cat.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- --------modeladd end   -------------------------  -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>type</th>
                    <!-- <th>Profit</th> -->
                    <th>Photo</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Thickness</th>

                    <th>Created at</th>

                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(prod, index) in products_category" :key="index">
                    <td>
                        {{ prod.id }}
                    </td>
                    <td>
                        {{ prod.name }}
                    </td>
                    <td>
                        {{ prod.desc }}
                    </td>
                    <td>
                        {{ prod.type }}
                    </td>
                    <!-- <td>
                        {{prod.profit}}
                    </td> -->
                    <td>
                        <img class="prod-img" :src="getUserImageSrc(prod.file)" alt="Product Image">
                    </td>
                    <td>
                        {{ prod.Width }}
                    </td>
                    <td>
                        {{ prod.Height }}
                    </td>
                    <td>
                        {{ prod.Thickness }}
                    </td>
                    <td>
                        {{ prod.created_at }}
                    </td>
                    <td>
                        <button @click="products_sub(prod.id)" type="button"
                            class="btn btn-icon btn-primary waves-effect waves-float waves-light me-1">
                            <i class="fa-solid fa-eye"></i>
                        </button>

                        <button @click="showProduct(prod.id)" data-bs-toggle="modal" data-bs-target="#editProduct"
                            type="button" class="btn btn-icon btn-warning waves-effect waves-float waves-light">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>

                        <button @click="deletePrroduct(prod.id)" type="button"
                            class="btn btn-icon btn-danger waves-effect waves-float waves-light mx-1">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- --------modeladd start -------------------------  -->
    <div class="modal fade text-start" id="editProduct" tabindex="-1" aria-labelledby="myModalLabel33"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Form</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#">
                    <div class="modal-body">
                        <label>Name: </label>
                        <div class="mb-1">
                            <input type="text" placeholder="Name" class="form-control" v-model="prod_name">
                        </div>

                        <label>Description: </label>
                        <div class="mb-1">
                            <input type="text" placeholder="Description" class="form-control" v-model="prod_desc">
                        </div>

                        <label>Type: </label>
                        <div class="mb-1">
                            <input type="text" placeholder="Description" class="form-control" v-model="prod_type">
                        </div>

                        <!-- <label>Profit: </label>
                        <div class="mb-1">
                            <input type="number" placeholder="Description" class="form-control" v-model="prod_profit">
                        </div> -->

                        <label>Photo: </label>
                        <div class="mb-1">
                            <input type="file" placeholder="Description" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click="edit_product(prod_id)" type="button"
                            class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal">Edit
                            Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- --------modeladd end   -------------------------  -->
</template>

<script>
import Swal from "sweetalert2";

export default {
    data() {
        return {
            categories: [],
            products_category: [],
            products: [],
            product: [],
            cat_id: null,
            prod_id: null,
            prod_name: null,
            prod_desc: null,
            prod_type: null,
            // prod_profit:null,
            prod_photo: null,
            prod_width: null,
            prod_height: null,
            prod_thickness: null,


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
        get_products() {
            axios.get('/api/products').then(response => {
                this.products = response.data.products;
                console.log('products :', this.products);
            })
        },
        get_categories() {
            axios.get('/api/categories').
                then(response => {
                    this.categories = response.data.categories;
                    console.log("category: ", this.categories);
                })
        },
        get_products_category(id) {
            this.cat_id = id;
            axios.get(`/api/products/category/${id}`)
                .then(response => {
                    this.products_category = response.data.products;
                    console.log('products_category:', this.products_category);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        showProduct(id) {
            try {
                axios.get(`/api/products/${id}`)
                    .then((response) => {
                        this.product = response.data.product;
                        console.log('product: ', this.product);
                        this.cat_id = this.product.category_id;
                        this.prod_id = this.product.id;
                        this.prod_name = this.product.name;
                        this.prod_desc = this.product.desc;
                        this.prod_type = this.product.type;
                        // this.prod_profit = this.product.profit;
                    })
            } catch (error) {
                console.error("Error editing category:", error);
                this.showErrorMessage("Failed to edit.");
            }
        },
        edit_product(id_product) {
            try {
                const data = new FormData();
                data.append("category_id", this.cat_id);
                data.append("name", this.prod_name);
                data.append("desc", this.prod_desc);
                data.append("type", this.prod_type);
                // data.append("profit", this.prod_profit);
                data.append("Width", this.prod_width);
                data.append("Height", this.prod_height);
                data.append("Thickness", this.prod_thickness);
                data.append("file", this.prod_photo);
                console.log('data : ', data);

                axios.post(`/api/products/${id_product}`, data)
                    .then((response) => {
                        this.product = response.data.product;
                        console.log('product edit: ', response.data.product);
                        this.get_products_category(this.cat_id);
                        this.prod_id = null;
                        this.prod_name = null;
                        this.prod_desc = null;
                        this.prod_type = null;
                        // this.prod_profit =null;
                        this.prod_photo = null;
                        this.prod_width = null;
                        this.prod_height = null;
                        this.prod_thickness = null;
                        this.showSuccessMessage('Edit product successfully');
                    })
            } catch (error) {
                console.error("Error editing category:", error);
                this.showErrorMessage("Failed to edit.");
            }

        },
        deletePrroduct(id) {
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
                        await axios.delete(`/api/products/${id}`);
                        this.get_products();
                        this.showSuccessMessage("product deleted successfully.");
                    } catch (error) {
                        console.error("Error deleting product:", error);
                        this.showErrorMessage("Failed to delete product.");
                    }
                }
            });
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

    },
    mounted() {
        this.get_products()
    }
}
</script>

<style scoped>
.prod-img {
    width: 50px;
}
</style>