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
                    <h4 class="card-title">{{ $t('Materiales 3D') }}</h4>
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

                                    <label>{{ $t('3D Name') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Description"
                                            class="form-control item-description" v-model="add_3d_name">
                                    </div>

                                    <label>{{ $t('Order') }} </label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="order" class="form-control item-description"
                                            v-model="add_order">
                                    </div>

                                    <label>{{ $t('Parent Id') }} </label>
                                    <div class="mb-1">
                                        <select class="form-select" v-model="add_parent_id">
                                            <option value="" disabled>Select Parent</option>
                                            <option v-for="material in materials" :key="material.id"
                                                :value="material.id">
                                                {{ material.name }}
                                            </option>
                                        </select>
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

                                    <label>{{ $t('3D Name') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Description" class="form-control"
                                            v-model="editData.name_3d">
                                    </div>

                                    <label>{{ $t('Order') }} </label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="Order" class="form-control"
                                            v-model="editData.order">
                                    </div>
                                    <label>{{ $t('Parent Id') }}  </label>
                                    <div class="mb-1">
                                        <select class="form-select" v-model="add_parent_id">
                                            <option value="" disabled>Select Parent</option>
                                            <option v-for="material in materials" :key="material.id"
                                                :value="material.id">
                                                {{ material.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button @click="edit_method(editData.id_item)" type="button"
                                        class="btn btn-primary waves-effect waves-float waves-light"
                                        data-bs-dismiss="modal">{{ $t('Edit') }} </button>
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
                                <th>{{ $t('3D Name') }}</th>
                                <th>{{ $t('Order') }}</th>
                                <th>{{ $t('Parent Id') }}</th>
                                <th>{{ $t('Created at') }}</th>
                                <th>{{ $t('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(material, index) in materials" :key="index">
                                <td>
                                    {{ material.id }}
                                </td>
                                <td>
                                    {{ material.name }}
                                </td>

                                <td>
                                    {{ material['3d_name'] }}
                                </td>
                                <td>
                                    {{ material.order }}
                                </td>
                                <td>
                                    {{ material.parent_id }}
                                </td>
                                <td>
                                    {{ material.created_at }}
                                </td>
                                <td>
                                    <button @click="textures(material.id)" type="button"
                                        class="btn btn-icon btn-primary waves-effect waves-float waves-light me-1">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button @click="show_method(material.id)" data-bs-toggle="modal"
                                        data-bs-target="#editcategory" type="button"
                                        class="btn btn-icon btn-warning waves-effect waves-float waves-light">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>

                                    <button @click="delete_method(material.id)" type="button"
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
            materials: [],
            // for create
            add_name: "",
            add_3d_name: "",
            add_parent_id: "",
            add_order: "",
            // for edit
            editData: {
                id_item: null,
                name: "",
                name_3d: "",
                order: "",
                parent_id: "",
            },

        }
    },
    methods: {
        get_all() {
            axios.get('/api/materials').
                then(response => {
                    this.materials = response.data.data;
                    console.log("materials: ", this.materials);
                })
        },

        add_method() {
            const data = new FormData();
            data.append("name", this.add_name);
            data.append("3d_name", this.add_3d_name);
            data.append("order", this.add_order);
            data.append("parent_id", this.add_parent_id);

            axios
                .post('/api/materials', data)
                .then(() => {
                    this.get_all();
                    this.add_name = "";
                    this.add_3d_name = "";
                    this.add_order = "";
                    this.add_parent_id = "";
                    this.showSuccessMessage("Add successfully");
                });
        },
        edit_method(id) {
            try {
                const data = {
                    id: this.editData.id_item,
                    name: this.editData.name,
                    '3d_name': this.editData.name_3d,
                    parent_id: this.editData.parent_id,
                    order: this.editData.order
                };

                axios.put(`/api/materials/${id}`, data)
                    .then((response) => {
                        // this.category = response.data.category;
                        console.log('Product edited successfully:', response.data.data);
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

                axios.get(`/api/materials/${id}`)
                    .then((response) => {
                        const fetchData = response.data.data;
                        this.editData.id_item = fetchData.id;
                        this.editData.name = fetchData.name;
                        this.editData.name_3d = fetchData['3d_name'];
                        this.editData.order = fetchData.order;
                        this.editData.parent_id = fetchData.parent_id;
                        console.log('fetch show data: ', this.editData);
                    })
            } catch (error) {
                console.error("Error editing :", error);
                this.showErrorMessage("Failed to edit.");
            }
        },
        textures(id) {
            this.$router.push(`texture-3d/${id}`);
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
                        await axios.delete(`/api/materials/${id}`);
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
