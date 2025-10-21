<template>
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb breadcrumb-pipes">
            <li class="breadcrumb-item"><router-link to="/">{{ $t('Home') }}</router-link></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $t('Category Main 3D') }}</li>
        </ol>
    </nav>

    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $t('Category Main 3D') }}</h4>
                    <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal"
                        data-bs-target="#add_model">{{ $t('Add') }}</button>
                </div>

                <!-- Modal for adding category -->
                <div class="modal fade text-start" id="add_model" tabindex="-1" aria-labelledby="myModalLabel33"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">{{ $t('Add') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form>
                                <div class="modal-body">
                                    <label>{{ $t('Name') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Name" class="form-control" v-model="add_name">
                                    </div>

                                    <label>{{ $t('Description') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Description" class="form-control"
                                            v-model="add_desc">
                                    </div>

                                    <label>{{ $t('Photo') }} </label>
                                    <div class="mb-1">
                                        <input type="file" class="form-control" @change="handleFileUpload"
                                            accept="image/*" />
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

                <!-- Modal for editing category -->
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
                                        <input type="file" class="form-control" @change="handleFileUpdate"
                                            accept="image/*" />
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
                <!-- categories_main_3d -->
                <!-- Table for displaying categories -->
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

                            <tr v-for="(Category3d, index) in categories_main_3d" :key="index">
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
                                    <button @click="CategoryMain_Catigory(Category3d.id)" type="button"
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

export default {
    data() {
        return {
            categories_main_3d: [],
            add_name: "",
            add_desc: "",
            add_file: "",
            edit_file: "",
            selectedCategory3d: null,
            editData: {
                id_item: null,
                name: "",
                desc: "",
                file: "",
            },
        };
    },
    methods: {
        handleFileUpload(event) {
            this.add_file = event.target.files[0];
        },
        handleFileUpdate(event) {
            this.edit_file = event.target.files[0];
        },
        getUserImageSrc(photo) {
            return photo ? `/storage/${photo}` : '/img/load.png';
        },
        get_all() {
            axios.get('/api/category_main_3d').then(response => {
                this.categories_main_3d = response.data.categories;
            });
        },
        add_method() {
            const data = new FormData();
            data.append("name", this.add_name);
            data.append("desc", this.add_desc);
            data.append("file", this.add_file);

            axios
                .post('/api/category_main_3d', data)
                .then(() => {
                    this.get_all();
                    this.add_name = "";
                    this.add_desc = "";
                    this.add_file = null;
                    this.showSuccessMessage("Add successfully");
                });
        },
        edit_method(id) {
            const data = new FormData();
            data.append("name", this.editData.name);
            data.append("desc", this.editData.desc);
            if (this.edit_file) {
                data.append("file", this.edit_file);
            }

            axios
                .post(`/api/category_main_3d/${id}`, data)
                .then(() => {
                    this.get_all();
                    this.showSuccessMessage("Edit successfully");
                });
        },
        delete_method(id) {
            axios
                .delete(`/api/category_main_3d/${id}`)
                .then(() => {
                    this.get_all();
                    this.showSuccessMessage("Delete successfully");
                });
        },
        show_method(id) {
            axios
                .get(`/api/category_main_3d/${id}`)
                .then(response => {
                    this.editData.id_item = response.data.category.id;
                    this.editData.name = response.data.category.name;
                    this.editData.desc = response.data.category.desc;
                    this.editData.file = response.data.category.file;
                });
        },
        CategoryMain_Catigory(id) {
            this.$router.push(`/Category-3d/${id}`);
        },
        showSuccessMessage(message) {
            Swal.fire({
                title: message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
    },
    mounted() {
        this.get_all();
    }
};
</script>
<style scoped>
.prod-img {
    width: 50px;
}
</style>
