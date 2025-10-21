<template>
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb breadcrumb-pipes">
            <li class="breadcrumb-item"><router-link to="/">{{ $t("Home") }}</router-link></li>
            <!-- <li class="breadcrumb-item"><a href="#">Library</a></li> -->
            <li class="breadcrumb-item active" aria-current="page">{{ $t("Prooducts") }}</li>
        </ol>
    </nav>

    <div class="my-1">
        <button @click="add_product" type="button" class="btn btn-primary waves-effect waves-float waves-light mx-1">{{
            $t("Add") }}</button>
        <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#addProduct" class="btn btn-primary waves-effect waves-float waves-light mx-1">Add Product</button> -->
    </div>
    <!-- --------modeladd start -------------------------  -->
    <div class="modal fade text-start" id="editProduct" tabindex="-1" aria-labelledby="myModalLabel33"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">{{ $t("Edit") }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#">
                    <div class="modal-body">
                        <label>{{ $t("Name") }}: </label>
                        <div class="mb-1">
                            <input type="text" placeholder="Name" class="form-control" v-model="prod_name">
                        </div>

                        <label>{{ $t("Description") }}: </label>
                        <div class="mb-1">
                            <input type="text" placeholder="Description" class="form-control" v-model="prod_desc">
                        </div>

                        <label>{{ $t("Type") }}: </label>
                        <div class="mb-1">
                            <input type="number" placeholder="Description" class="form-control" v-model="prod_type">
                        </div>

                        <label>{{ $t("Width") }}: </label>
                        <div class="mb-1">
                            <input type="number" placeholder="Width" class="form-control" v-model="prod_width">
                        </div>

                        <label>{{ $t("Height") }}: </label>
                        <div class="mb-1">
                            <input type="number" placeholder="Height" class="form-control" v-model="prod_height">
                        </div>

                        <label>{{ $t("Thickness") }}: </label>
                        <div class="mb-1">
                            <input type="number" placeholder="Thickness" class="form-control" v-model="prod_thickness">
                        </div>

                        <label>{{ $t("Photo") }}: </label>
                        <div class="mb-1">
                            <input type="file" class="form-control" id="product img" aria-describedby="catImg"
                                tabindex="7" @change="handleFileUpload" accept="image/*" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click="edit_product(prod_id)" type="button"
                            class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal">{{
                            $t("Edit") }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- --------modeladd end   -------------------------  -->

    <h4 class="badge d-block bg-primary" v-if="products.length === 0">
        {{ $t("No Data") }}
    </h4>
    <div class="row card" id="table-hover-row">
        <h4 class="card-title py-1">{{ $t("Products") }}</h4>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>{{ $t("ID") }}</th>
                    <th>{{ $t("Name") }}</th>
                    <th>{{ $t("Description") }}</th>
                    <th>{{ $t("type") }}</th>
                    <!-- <th>{{ $t("Profit") }}</th> -->
                    <th>{{ $t("Photo") }}</th>
                    <th>{{ $t("Width") }}</th>
                    <th>{{ $t("Height") }}</th>
                    <th>{{ $t("Thickness") }}</th>
                    <th>{{ $t("Created at") }}</th>
                    <th>{{ $t("Actions") }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(prod, index) in products" :key="index">
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
</template>

<script>
import Swal from "sweetalert2";

export default {
    props: ['id'],
    data() {
        return {
            category: [],
            products: [],
            product: [],
            // add product
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
        handleFileUpload(event) {

            this.prod_photo = event.target.files[0]; // احصل على الملف المحدد
        },
        get_category() {
            axios.get(`/api/categories/${this.id}`)
                .then(response => {
                    this.category = response.data.category;
                    console.log('category:', this.category);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        add_product() {
            this.$router.push({ name: "add_product_category", params: { id: this.id } });
        },
        get_products() {
            axios.get(`/api/products/category/${this.id}`)
                .then(response => {
                    this.products = response.data.products;
                    console.log('products:', this.products);
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
                        this.prod_id = this.product.id;
                        this.prod_name = this.product.name;
                        this.prod_desc = this.product.desc;
                        this.prod_type = this.product.type;
                        // this.prod_profit = this.product.profit;
                        this.prod_width = this.product.Width;
                        this.prod_height = this.product.Height;
                        this.prod_thickness = this.product.Thickness;
                    })
            } catch (error) {
                console.error("Error editing category:", error);
                this.showErrorMessage("Failed to edit.");
            }
        },
        products_sub(id) {
            this.$router.push({ name: "sub_products", params: { id: id } });
        },
        edit_product(id_product) {
            try {
                const data = new FormData();
                data.append("category_id", this.id);
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
                        this.get_products();
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
        this.get_category();
        this.get_products();
    },


}
</script>

<style scoped>
.prod-img {
    width: 50px;
    /* height: 50px; */
}

table td {
    padding: 0.72rem 1rem !important;
}
</style>