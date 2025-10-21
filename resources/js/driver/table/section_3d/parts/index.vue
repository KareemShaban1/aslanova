<template>
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb breadcrumb-pipes">
            <li class="breadcrumb-item"><router-link to="/">{{ $t('Home') }}</router-link></li>
            <!-- <li class="breadcrumb-item"><a href="#">Library</a></li> -->
            <li class="breadcrumb-item active" aria-current="page">{{ $t('Parts 3d') }}</li>
        </ol>
    </nav>

    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $t('Parts 3d') }}</h4>
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

                                    <label>{{ $t('Price') }}  </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Description"
                                            class="form-control item-description" v-model="add_price">
                                    </div>

                                    <label>{{ $t('3D Name') }}  </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="3d Name" class="form-control item-description"
                                            v-model="add_name_3d">
                                    </div>

                                    <label>{{ $t('Image Url') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="3d Name" class="form-control item-description"
                                            v-model="add_image_url">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button @click="add_method" type="button"
                                        class="btn btn-primary waves-effect waves-float waves-light"
                                        data-bs-dismiss="modal">{{ $t('Add') }}</button>
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

                                    <label>{{ $t('Price') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Description" class="form-control"
                                            v-model="editData.price">
                                    </div>

                                    <label>{{ $t('3D Name') }}  </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Model id" class="form-control"
                                            v-model="editData.name_3d">
                                    </div>
                                    <label>{{ $t('Image Url') }} </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Model id" class="form-control"
                                            v-model="editData.image_url">
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
                                <th>{{ $t('3D Name') }}</th>
                                <th>{{ $t('Image Url') }}</th>
                                <th>{{ $t('Created at') }}</th>
                                <th>{{ $t('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(part, index) in parts" :key="index">
                                <td>
                                    {{ part.id }}
                                </td>
                                <td>
                                    {{ part.name }}
                                </td>

                                <td>
                                    {{ part.price }}
                                </td>
                                <td>
                                    {{ part['3d_name'] }}
                                </td>
                                <td>
                                    {{ part.image_url }}
                                </td>
                                <td>
                                    {{ part.created_at }}
                                </td>
                                <td>

                                    <button @click="show_method(part.id)" data-bs-toggle="modal"
                                        data-bs-target="#editcategory" type="button"
                                        class="btn btn-icon btn-warning waves-effect waves-float waves-light">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>

                                    <button @click="delete_method(part.id)" type="button"
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
            parts: [],
            // for create
            add_name: "",
            add_price: "",
            add_name_3d: "",
            add_image_url: "",
            // for edit
            editData: {
                id_item: null,
                name: "",
                price: "",
                name_3d: "",
                image_url: "",
            },

        }
    },
    methods: {
        get_all() {
            axios.get('/api/parts').
                then(response => {
                    this.parts = response.data.data;
                    console.log("parts: ", this.parts);
                })
        },
        add_method() {
            const data = new FormData();
            data.append("name", this.add_name);
            data.append("price", this.add_price);
            data.append("image_url", this.add_image_url);
            data.append("3d_name", this.add_name_3d);

            axios
                .post('/api/parts', data)
                .then(() => {
                    this.get_all();
                    this.add_name = "";
                    this.add_price = "";
                    this.add_name_3d = "";
                    this.add_image_url = "";
                    this.showSuccessMessage("Add successfully");
                });
        },
        edit_method(id) {
            try {
                const data = {
                    name: this.editData.name,
                    price: this.editData.price,
                    image_url: this.editData.image_url,
                    '3d_name': this.editData.name_3d
                };

                axios.put(`/api/parts/${id}`, data)
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

                axios.get(`/api/parts/${id}`)
                    .then((response) => {
                        const fetchData = response.data.data;
                        this.editData.id_item = fetchData.id;
                        this.editData.name = fetchData.name;
                        this.editData.price = fetchData.price;
                        this.editData.image_url = fetchData.image_url;
                        this.editData.name_3d = fetchData['3d_name'];
                        console.log('fetch show data: ', this.editData);
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
                        await axios.delete(`/api/parts/${id}`);
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
