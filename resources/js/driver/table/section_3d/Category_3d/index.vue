<template>
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb breadcrumb-pipes">
            <li class="breadcrumb-item"><router-link to="/">{{ $t('Home') }}</router-link></li>
            <!-- <li class="breadcrumb-item"><a href="#">Library</a></li> -->
            <li class="breadcrumb-item active" aria-current="page">{{ $t('Category 3d') }}</li>
        </ol>
    </nav>

    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $t('Category 3d') }}</h4>
                    <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal"
                        data-bs-target="#add_model">{{ $t('Add') }}</button>
                </div>
                <!-- --------modeladd start -------------------------  -->
                <div class="modal fade text-start" id="add_model" tabindex="-1" aria-labelledby="myModalLabel33"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">{{ $t('Add') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="#">
                                <div class="modal-body">
                                    <label>{{ $t('Name') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Name" class="form-control" v-model="add_name">
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
                                </div>
                                <div class="modal-footer">
                                    <button @click="add_method" type="button"
                                        class="btn btn-primary waves-effect waves-float waves-light"
                                        data-bs-dismiss="modal">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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

                                    <label>{{ $t('Description') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Description" class="form-control"
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
                                        data-bs-dismiss="modal">Edit Category</button>
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
                                <th>{{ $t('Photo') }}</th>
                                <th>{{ $t('Description') }}</th>
                                <th>{{ $t('Created at') }}</th>
                                <th>{{ $t('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="(Category3d, index) in Categorys_3d" :key="index">
                                <td>
                                    {{ Category3d.id }}
                                </td>
                                <td>
                                    {{ Category3d.name }}
                                </td>

                                <td>
                                    <img class="prod-img" :src="getUserImageSrc(Category3d.file)" alt="Category Image">
                                </td>
                                <td>
                                    {{ Category3d.desc }}
                                </td>

                                <td>
                                    {{ Category3d.created_at }}
                                </td>
                                <td>
                                    <button @click="Products_category(Category3d.id)" type="button"
                                        class="btn btn-icon btn-primary waves-effect waves-float waves-light me-1">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button @click="show_method(Category3d.id)" data-bs-toggle="modal"
                                        data-bs-target="#editcategory" type="button"
                                        class="btn btn-icon btn-warning waves-effect waves-float waves-light">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>

                                    <button @click="delete_method(Category3d.id)" type="button"
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
        const categoryMainId = useRoute().params.id;
        return {
            categoryMainId,
            Categorys_3d: [],
            add_name: "",
            add_desc: "",
            add_file: "",
            edit_file: "",
            selectedCategory3d: null,
            // for edit
            editData: {
                id_item: null,
                name: "",
                desc: "",
                file: "",
            },

        }
    },
    methods: {
        handleFileUpload(event) {
            this.add_file = event.target.files[0]; // احصل على الملف المحدد
        },
        handleFileUpdate(event) {
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
            axios.get('/api/Categorys_3d').
                then(response => {
                    this.Categorys_3d = response.data.categories;
                    console.log("Categorys_3d: ", this.Categorys_3d);
                })
        },
        add_method() {
            const data = new FormData();
            data.append("name", this.add_name);
            data.append("desc", this.add_desc);
            data.append("categorymain3d_id", this.categoryMainId);
            data.append("file", this.add_file);
            console.log(data);

            axios
                .post('/api/Categorys_3d', data)
                .then(() => {
                    this.get_all();
                    this.add_name = "";
                    this.add_model = "";
                    this.showSuccessMessage("Add successfully");
                });
        },

        edit_method(id) {
            try {
                const data = new FormData();
                data.append("name", this.editData.name);
                data.append("desc", this.editData.desc);
                data.append("categorymain3d_id", this.categoryMainId);
                if (this.edit_file) {
                    data.append("file", this.edit_file);
                }

                console.log('FormData being sent:', { ...data });
                console.log('Name field value:', this.editData.name); // Check value

                axios.post(`/api/Categorys_3d/${id}`, data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then((response) => {
                        console.log('Category edited successfully:', response.data);
                        this.get_all();
                        this.showSuccessMessage('Update data successfully');
                    })
                    .catch((error) => {
                        console.error("Error editing category:", error);
                        if (error.response) {
                            console.error("Response data:", error.response.data);
                        }
                        this.showErrorMessage("Failed to edit.");
                    });
            } catch (error) {
                console.error("Error in edit_method:", error);
                this.showErrorMessage("Failed to edit.");
            }
        }


        ,
        show_method(id) {
            try {
                axios.get(`/api/Categorys_3d/${id}`)
                    .then((response) => {
                        const fetchData = response.data.category;
                        this.editData.id_item = fetchData.id;
                        this.editData.name = fetchData.name;
                        this.editData.desc = fetchData.desc;
                        this.editData.file = fetchData.file;

                        console.log('fetch show data: ', this.editData);
                    })
            } catch (error) {
                console.error("Error editing :", error);
                this.showErrorMessage("Failed to edit.");
            }
        },
        Products_category(id) {
            this.$router.push(`/Products3d_category/${id}`);
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
                        await axios.delete(`/api/Categorys_3d/${id}`);
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
    }
}
</script>
<style scoped>
.prod-img {
    width: 50px;
}
</style>