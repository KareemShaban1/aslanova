<template>
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb breadcrumb-pipes">
            <li class="breadcrumb-item"><router-link to="/">{{ $t("Home") }}</router-link></li>
            <!-- <li class="breadcrumb-item"><a href="#">Library</a></li> -->
            <li class="breadcrumb-item active" aria-current="page">{{ $t("Category") }}</li>
        </ol>
    </nav>

    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $t("Categories") }}</h4>
                    <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal"
                        data-bs-target="#addcategory">{{ $t("Add") }}</button>
                </div>
                <!-- --------modeladd start -------------------------  -->
                <div class="modal fade text-start" id="addcategory" tabindex="-1" aria-labelledby="myModalLabel33"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">{{ $t("Add Category") }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="#">
                                <div class="modal-body">
                                    <label>{{ $t("Name") }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Name" class="form-control" v-model="add_name">
                                    </div>

                                    <label>{{ $t("Description") }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Description"
                                            class="form-control item-description" v-model="add_desc">
                                    </div>
                                    <label>{{ $t("Photo") }} </label>
                                    <div class="mb-1">
                                        <input type="file" class="form-control" id="catImg" aria-describedby="catImg"
                                            tabindex="7" @change="handleFileUpload" accept="image/*" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button @click="add_category" type="button"
                                        class="btn btn-primary waves-effect waves-float waves-light"
                                        data-bs-dismiss="modal">{{ $t("Add") }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- --------modeladd end   -------------------------  -->
                <!-- --------modeledit start -------------------------  -->
                <div class="modal fade text-start" id="editcategory" tabindex="-1" aria-labelledby="myModalLabel33"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">{{ $t("Edit") }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form>
                                <div class="modal-body">
                                    <label>{{ $t("Name") }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Name" class="form-control"
                                            v-model="category_name">
                                    </div>

                                    <label>{{ $t("Description") }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Description" class="form-control"
                                            v-model="category_desc">
                                    </div>
                                    <label>{{ $t("Photo") }} </label>
                                    <div class="mb-1">
                                        <input type="file" class="form-control" id="catImg" aria-describedby="catImg"
                                            tabindex="7" @change="handleFileUpload" accept="image/*" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button @click="edit_category(category_id)" type="button"
                                        class="btn btn-primary waves-effect waves-float waves-light"
                                        data-bs-dismiss="modal">{{ $t("Edit") }}</button>
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
                                <th>{{ $t("ID") }}</th>
                                <th>{{ $t("Name") }}</th>
                                <th>{{ $t("Description") }}</th>
                                <th>{{ $t("Photo") }}</th>
                                <th>{{ $t("Created at") }}</th>
                                <th>{{ $t("Actions") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(cat, index) in categories" :key="index">
                                <td>
                                    {{ cat.id }}
                                </td>
                                <td>
                                    {{ cat.name }}
                                </td>

                                <td>
                                    {{ cat.desc }}
                                </td>
                                <td>
                                    <img class="prod-img" :src="getUserImageSrc(cat.file)" alt="Category Image">
                                </td>
                                <td>
                                    {{ cat.created_at }}
                                </td>
                                <td>
                                    <button @click="products_category(cat.id)" type="button"
                                        class="btn btn-icon btn-primary waves-effect waves-float waves-light me-1">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button @click="showCategory(cat.id)" data-bs-toggle="modal"
                                        data-bs-target="#editcategory" type="button"
                                        class="btn btn-icon btn-warning waves-effect waves-float waves-light">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>

                                    <button @click="deleteCategory(cat.id)" type="button"
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

export default {
    data() {
        return {
            categories: [],
            category: [],
            // for create
            add_name: "",
            add_desc: "",
            add_photo: "",
            // for edit
            category_name: "",
            category_desc: "",
            category_id: null,


        }
    },
    methods: {
        handleFileUpload(event) {
            this.add_photo = event.target.files[0]; // احصل على الملف المحدد
        },
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
        add_category() {
            const data = new FormData();
            data.append("name", this.add_name);
            data.append("desc", this.add_desc);
            data.append("file", this.add_photo);

            axios
                .post('/api/categories', data)
                .then(() => {
                    this.get_categories();
                    this.add_name = "";
                    this.add_desc = "";
                    this.add_photo = "";
                    this.showSuccessMessage("Add category successfully");
                });
        },
        edit_category(id) {
            try {
                const data = new FormData();
                data.append("name", this.category_name);
                data.append("desc", this.category_desc);
                data.append("file", this.add_photo);

                axios.post(`/api/categories/${id}`, data)
                    .then((response) => {
                        this.category = response.data.category;
                        console.log('category edit: ', response.data.category);
                        this.get_categories();
                        this.category_name = '';
                        this.category_desc = '';
                        this.add_photo = "";
                        this.category_id = null;
                        this.showSuccessMessage('تم تعديل الصنف بنجاح');
                    })
            } catch (error) {
                console.error("Error editing category:", error);
                this.showErrorMessage("Failed to edit.");
            }
        },
        showCategory(id) {
            try {

                axios.get(`/api/categories/${id}`)
                    .then((response) => {
                        this.category = response.data.category;
                        console.log('category: ', this.category);
                        this.category_name = this.category.name;
                        this.category_desc = this.category.desc;
                        this.category_id = this.category.id;
                    })
            } catch (error) {
                console.error("Error editing category:", error);
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
        deleteCategory(id) {
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
                        await axios.delete(`/api/categories/${id}`);
                        this.get_categories();
                        this.showSuccessMessage("Category deleted successfully.");
                    } catch (error) {
                        console.error("Error deleting category:", error);
                        this.showErrorMessage("Failed to delete category.");
                    }
                }
            });
        },
    },
    mounted() {
        this.get_categories();
        // console.log(`${process.env.MIX_API_URL}`);
    }
}
</script>

<style scoped>
.prod-img {
    width: 50px;
}
</style>