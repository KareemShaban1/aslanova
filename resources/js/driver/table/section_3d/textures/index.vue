<template>
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb breadcrumb-pipes">
            <li class="breadcrumb-item"><router-link to="/">{{ $t('Home') }}</router-link></li>
            <!-- <li class="breadcrumb-item"><a href="#">Library</a></li> -->
            <li class="breadcrumb-item active" aria-current="page">{{ $t('Textures 3d') }}</li>
        </ol>
    </nav>

    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Textures 3D rows</h4>
                    <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal"
                        data-bs-target="#add_model">Add</button>
                </div>
                <!-- --------modeladd start -------------------------  -->
                <div class="modal fade text-start" id="add_model" tabindex="-1" aria-labelledby="myModalLabel33"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">Add Texture3d Form</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="#">
                                <div class="modal-body">
                                    <label>Name: </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Name" class="form-control" v-model="add_name">
                                    </div>

                                    <label>Price: </label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="Price" class="form-control item-Price"
                                            v-model="add_price">
                                    </div>

                                    <label>Url: </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Url" class="form-control item-description"
                                            v-model="add_url">
                                    </div>

                                    <label>Base color: </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Base color"
                                            class="form-control item-description" v-model="add_base_color">
                                    </div>

                                    <label>Glossiness: </label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="Glossiness"
                                            class="form-control item-description" v-model="add_glossiness">
                                    </div>

                                    <!-- <label>Material Id: </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="model id" class="form-control item-description"
                                            v-model="add_material">
                                    </div> -->
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
                <!-- --------modeladd end   -------------------------  -->
                <!-- --------modeledit start -------------------------  -->
                <div class="modal fade text-start" id="editcategory" tabindex="-1" aria-labelledby="myModalLabel33"
                    style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">Edit Form</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form>
                                <div class="modal-body">
                                    <label>Name :</label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Name" class="form-control"
                                            v-model="editData.name">
                                    </div>

                                    <label>Price: </label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="Price" class="form-control"
                                            v-model="editData.price">
                                    </div>

                                    <label>Url: </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Url" class="form-control item-description"
                                            v-model="editData.url">
                                    </div>

                                    <label>Base color: </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Base color"
                                            class="form-control item-description" v-model="editData.base_color">
                                    </div>

                                    <label>Glossiness: </label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="Description"
                                            class="form-control item-description" v-model="editData.glossiness">
                                    </div>
                                    <!-- <label>Model Id: </label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Model id" class="form-control"
                                            v-model="editData.material_id">
                                    </div> -->

                                    <label>Model Id: </label>
                                    <div class="mb-1">
                                        <select class="form-select" v-model="editData.material_id">
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
                                        data-bs-dismiss="modal">Edit</button>
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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Url</th>
                                <th>Base color</th>
                                <th>Glossiness</th>
                                <th>Material id</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in all_items" :key="index">
                                <td>
                                    {{ item.id }}
                                </td>
                                <td>
                                    {{ item.name }}
                                </td>
                                <td>
                                    {{ item.price }}
                                </td>
                                <td>
                                    {{ item.url }}
                                </td>
                                <td>
                                    {{ item.base_color }}
                                </td>
                                <td>
                                    {{ item.glossiness }}
                                </td>
                                <td>
                                    {{ item.material_id }}
                                </td>
                                <td>
                                    {{ item.created_at }}
                                </td>
                                <td>
                                    <!-- <button @click="products_category(item.id)" type="button"
                                        class="btn btn-icon btn-primary waves-effect waves-float waves-light me-1">
                                        <i class="fa-solid fa-eye"></i>
                                    </button> -->

                                    <button @click="show_method(item.id)" data-bs-toggle="modal"
                                        data-bs-target="#editcategory" type="button"
                                        class="btn btn-icon btn-warning waves-effect waves-float waves-light">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>

                                    <button @click="delete_method(item.id)" type="button"
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
        const materialId = useRoute().params.id; // يجب أن يكون داخل الدالة data() وليس خارجها
        return {
            materials: [],
            all_items: [],
            // for create
            add_name: "",
            add_price: "",
            add_url: "",
            add_base_color: "",
            add_glossiness: "",
            add_material: materialId,
            // for edit
            editData: {
                id_item: null,
                name: "",
                price: "",
                material_id: materialId,
                glossiness: "",
                base_color: "",
                url: "",
            },
        };
    },
    methods: {
        get_all() {
            axios.get(`/api/materials/${this.add_material}/textures`) // استخدم this.add_material بدلاً من this.materialId
                .then(response => {
                    this.all_items = response.data.data;
                    console.log("all_items: ", this.all_items);
                })
                .catch(error => {
                    console.error("Error fetching items: ", error);
                });
        },
        get_all_materials() {
            axios.get('/api/materials').
                then(response => {
                    this.materials = response.data.data;
                    console.log("materials: ", this.materials);
                })
        },
        add_method() {
            const data = new FormData();
            data.append("name", this.add_name);
            data.append("price", this.add_price);
            data.append("material_id", this.add_material);
            data.append("url", this.add_url);
            data.append("base_color", this.add_base_color);
            data.append("glossiness", this.add_glossiness);

            axios
                .post('/api/textures', data)
                .then(() => {
                    this.get_all();
                    this.add_name = "";
                    this.add_price = "";
                    this.add_material = "";
                    this.add_url = "";
                    this.add_glossiness = "";
                    this.add_base_color = "";
                    this.showSuccessMessage("Add successfully");
                });
        },
        edit_method(id) {
            try {
                const data = {
                    id: this.editData.id_item,
                    name: this.editData.name,
                    price: this.editData.price,
                    material_id: this.editData.material_id,
                    base_color: this.editData.base_color,
                    glossiness: this.editData.glossiness,
                    url: this.editData.url
                };

                axios.put(`/api/textures/${id}`, data)
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

                axios.get(`/api/textures/${id}`)
                    .then((response) => {
                        const fetchData = response.data.data;
                        this.editData.id_item = fetchData.id;
                        this.editData.name = fetchData.name;
                        this.editData.price = fetchData.price;
                        this.editData.glossiness = fetchData.glossiness;
                        this.editData.base_color = fetchData.base_color;
                        this.editData.url = fetchData.url;
                        this.editData.material_id = fetchData.material_id;
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
                        await axios.delete(`/api/textures/${id}`);
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
        this.get_all_materials();
    }
}
</script>
