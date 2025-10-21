<template>
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb breadcrumb-pipes">
            <li class="breadcrumb-item"><router-link to="/">{{ $t('Home') }}</router-link></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $t('Offers') }}</li>
        </ol>
    </nav>

    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $t('Offers') }}</h4>
                    <button type="button" class="btn btn-gradient-primary" data-bs-toggle="modal"
                        data-bs-target="#add_offer_modal">{{ $t('Add') }}</button>
                </div>

                <!-- Add Offer Modal -->
                <div class="modal fade text-start" id="add_offer_modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ $t('Add') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form>
                                <div class="modal-body">
                                    <label>{{ $t('Name') }}</label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Name" class="form-control" v-model="add_name">
                                    </div>
                                    <label>{{ $t('Price') }}</label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="Price" class="form-control" v-model="add_price">
                                    </div>
                                    <label>{{ $t('Old price') }}</label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="Old Price" class="form-control" v-model="add_old_price">
                                    </div>
                                    <!-- add shipping_price and delivery_price -->
                                    <label>{{ $t('delivery time') }}</label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="delivery time" class="form-control" v-model="add_delivery_price">
                                    </div>
                                    <label>{{ $t('shipping price') }}</label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="shipping price" class="form-control" v-model="add_shipping_price">
                                    </div>

                                    <label>{{ $t('Description') }}</label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Description" class="form-control" v-model="add_desc">
                                    </div>
                                    <label>{{ $t('Photo') }}</label>
                                    <div class="mb-1">
                                        <input type="file" class="form-control" @change="handleFileUpload" accept="image/*" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button @click="add_offer" type="button" class="btn btn-primary" data-bs-dismiss="modal">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Offer Modal -->
                <div class="modal fade text-start" id="edit_offer_modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ $t('Edit') }}</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form>
                                <div class="modal-body">
                                    <label>{{ $t('Name') }}</label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Name" class="form-control" v-model="editData.name">
                                    </div>
                                    <label>{{ $t('Price') }}</label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="Price" class="form-control" v-model="editData.price">
                                    </div>
                                    <label>{{ $t('Old price') }}</label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="Old Price" class="form-control" v-model="editData.old_price">
                                    </div>
                                    <!-- add shipping_price and delivery_price -->
                                    <label>{{ $t('delivery time') }}</label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="delivery time" class="form-control" v-model="editData.delivery_price">
                                    </div>
                                    <label>{{ $t('shipping price') }}</label>
                                    <div class="mb-1">
                                        <input type="number" placeholder="shipping price" class="form-control" v-model="editData.shipping_price">
                                    </div>
                                    <label>{{ $t('Description') }}</label>
                                    <div class="mb-1">
                                        <input type="text" placeholder="Description" class="form-control" v-model="editData.description">
                                    </div>
                                    <label>{{ $t('Photo') }}</label>
                                    <div class="mb-1">
                                        <input type="file" class="form-control" @change="handleFileUpdate" accept="image/*" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button @click="edit_offer(editData.id)" type="button" class="btn btn-primary" data-bs-dismiss="modal">Edit Offer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ $t('ID') }}</th>
                                <th>{{ $t('Name') }}</th>
                                <th>{{ $t('Photo') }}</th>
                                <th>{{ $t('Description') }}</th>
                                <th>{{ $t('Price') }}</th>
                                <th>{{ $t('Old price') }}</th>
                                <th>{{ $t('shipping price') }}</th>
                                <th>{{ $t('delivery time') }}</th>
                                <th>{{ $t('Actions') }}</th>
                            </tr>

                        </thead>
                        <tbody>
                            <tr v-for="(offer, index) in offers" :key="index">
                                <td>{{ offer.id }}</td>
                                <td>{{ offer.name }}</td>
                                <td><img :src="getOfferImageSrc(offer.file)" alt="Offer Image" width="50"></td>
                                <td>{{ offer.description }}</td>
                                <td>{{ offer.price }}</td>
                                <td>{{ offer.old_price }}</td>
                                <td>{{ offer.shipping_price }}</td>
                                <td>{{ offer.delivery_price }}</td>
                                <td>
                                 
                                    <button @click="show_offer(offer.id)" data-bs-toggle="modal" data-bs-target="#edit_offer_modal"
                                     type="button" class="btn btn-icon btn-primary waves-effect waves-float waves-light me-1 btn-warning"><i class="fa-regular fa-pen-to-square"></i></button>
                                    <button @click="delete_offer(offer.id)" type="button" class="btn btn-icon btn-danger waves-effect waves-float waves-light me-1"><i class="fa-regular fa-trash-can"></i></button>
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
            offers: [],
            add_name: "",
            add_price: null,
            add_old_price: null,
            add_desc: "",
            add_file: "",
            add_shipping_price: null,
            add_delivery_price: null,
            editData: {
                id: null,
                name: "",
                price: null,
                old_price: null,
                shipping_price: null,
                delivery_price: null,
                description: "",
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
        getOfferImageSrc(image) {
            return image ? `/storage/${image}` : '/img/load.png';
        },
        get_all() {
            axios.get('/api/offers').then(response => {
                this.offers = response.data.offers;  // تأكد من التوافق مع الاستجابة
            });
        },
        add_offer() {
            const data = new FormData();
            data.append("name", this.add_name);
            data.append("price", this.add_price);
            data.append("old_price", this.add_old_price);
            data.append("description", this.add_desc);
            data.append("shipping_price", this.add_shipping_price);
            data.append("delivery_price", this.add_delivery_price);
            data.append("file", this.add_file);

            axios.post('/api/offers', data)
                .then(() => {
                    this.get_all();
                    this.resetAddForm();
                    this.showSuccessMessage("Offer added successfully");
                })
                .catch(error => {
                    console.error(error);
                    this.showErrorMessage("Failed to add offer");
                });
        },
        edit_offer(id) {
            const data = new FormData();
            data.append("name", this.editData.name);
            data.append("price", this.editData.price);
            data.append("old_price", this.editData.old_price);
            data.append("shipping_price", this.editData.shipping_price);
            data.append("delivery_price", this.editData.delivery_price);
            data.append("description", this.editData.description);
            if (this.edit_file) {
                data.append("file", this.edit_file);
            }

            axios.post(`/api/offers/${id}`, data)
                .then(() => {
                    this.get_all();
                    this.showSuccessMessage("Offer updated successfully");
                })
                .catch(error => {
                    console.error(error);
                    this.showErrorMessage("Failed to update offer");
                });
        },
        delete_offer(id) {
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
                    await axios.delete(`/api/offers/${id}`);
                    this.get_all();
                    this.showSuccessMessage("product deleted successfully.");
                    } catch (error) {
                    console.error("Error deleting product:", error);
                    this.showErrorMessage("Failed to delete product.");
                    }
                }
            });
        },
        show_offer(id) {
            axios.get(`/api/offers/${id}`)
                .then(response => {
                    this.editData = response.data.offer; // استخدام response.data.offer لتحديث بيانات العرض
                })
                .catch(error => {
                    console.error(error);
                    this.showErrorMessage("Failed to load offer data");
                });
        },
        resetAddForm() {
            this.add_name = "";
            this.add_price = null;
            this.add_old_price = null;
            this.add_desc = "";
            this.add_file = null;
            this.add_shipping_price = null;
            this.add_delivery_price = null;
        },
        showSuccessMessage(message) {
            Swal.fire({
                title: message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        },
        showErrorMessage(message) {
            Swal.fire({
                title: message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
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
