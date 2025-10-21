<template>
<nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb breadcrumb-pipes">
        <li class="breadcrumb-item"><router-link to="/">{{ $t("Home") }}</router-link></li>
        <!-- <li class="breadcrumb-item"><a href="#">Library</a></li> -->
        <li class="breadcrumb-item active" aria-current="page">{{ $t("Add") }}</li>
    </ol>
</nav>

<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $t("Add") }}</h4>
                </div>
                <div class="card-body">
                    <form class="form" @submit.prevent="add_product">
                        <div class="row">
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="mb-1">
                                    <label class="form-label" for="first-name-column">{{ $t("Name") }}</label>
                                    <input type="text" id="first-name-column" class="form-control" placeholder="Name" v-model="add_name">
                                </div>
                            </div>
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="mb-1">
                                    <label class="form-label" for="Discreption-column">{{ $t("Description") }}</label>
                                    <input type="text" id="Discreption-column" class="form-control" placeholder="Discreption" v-model="add_desc">
                                </div>
                            </div>
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="mb-1">
                                    <label class="form-label" for="type-column">{{ $t("Type") }}</label>
                                    <input type="number" id="type-column" class="form-control" placeholder="Type" v-model="add_type">
                                </div>
                            </div>
                            <div class="col-md-6 col-12 col-lg-6">
                                <div class="mb-1">
                                    <label class="form-label" for="file-column">{{ $t("Photo") }}</label>
                                    <input
                                        type="file"
                                        class="form-control"
                                        id="prodImg"
                                        aria-describedby="prodImg"
                                        tabindex="7"
                                        @change="handleFileUpload"
                                        accept="image/*"
                                        />
                                </div>
                            </div>
                            <!-- <div class="col-md-6 col-12 col-lg-6">
                                <div class="mb-1">
                                    <label class="form-label" for="file-column">Photo</label>
                                    <input type="file" id="file-column" class="form-control" @change="handleFileUpload">
                                </div>
                            </div> -->

                            <!-- <div class="col-md-6 col-12 col-lg-3">
                                <div class="mb-1">
                                    <label class="form-label" for="Profit-floating">Profit</label>
                                    <input type="number" id="Profit-floating" class="form-control" placeholder="0" v-model="add_profit">
                                </div>
                            </div> -->

                            <div class="col-md-6 col-12 col-lg-3">
                                <div class="mb-1">
                                    <label class="form-label" for="width-floating">{{ $t("Width") }}</label>
                                    <input type="number" id="width-floating" class="form-control" placeholder="0" v-model="add_width">
                                </div>
                            </div>

                            <div class="col-md-6 col-12 col-lg-3">
                                <div class="mb-1">
                                    <label class="form-label" for="hieght-floating">{{ $t("Height") }}</label>
                                    <input type="number" id="hieght-floating" class="form-control" placeholder="0" v-model="add_height">
                                </div>
                            </div>

                            <div class="col-md-6 col-12 col-lg-3">
                                <div class="mb-1">
                                    <label class="form-label" for="thickness-floating">{{ $t("Thickness") }}</label>
                                    <input type="number" id="thickness-floating" class="form-control" placeholder="0" v-model="add_thickness">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-prev waves-effect waves-float waves-light" @click="products_category">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left align-middle me-sm-25 me-0"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                                    <span class="align-middle d-sm-inline-block d-none">{{ $t("Previous") }}</span>
                                </button>
                                <div>
                                    <button type="submit"  class="btn btn-success btn-submit waves-effect waves-float waves-light mx-1">{{ $t("Submit") }}</button>
                                    <button type="reset" class="btn btn-outline-secondary waves-effect">{{ $t("Reset") }}</button>
                                </div>
                            </div>
                            <!-- <div class="col-12">
                                <button type="reset" class="btn btn-primary me-1 waves-effect waves-float waves-light">Submit</button>
                            </div> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</template>

<script>
import Swal from "sweetalert2";

export default {
    props: ['id'],
    data() {
        return {
            // add product
            add_name: '',
            add_desc: '',
            add_type: '',
            // add_profit: null,
            add_photo: null,
            add_width: null,
            add_height: null,
            add_thickness: null,
        }
    },
    methods: {
        products_category(){
            this.$router.push({ name: "products_category", params: { id: this.id } });
        }, 
        handleFileUpload(event) {
           this.add_photo = event.target.files[0]; // احصل على الملف المحدد
        },
    

        add_product(){
            const data = new FormData();
                data.append("category_id", this.id);
                data.append("name", this.add_name);
                data.append("desc", this.add_desc);
                data.append("type", this.add_type);
                // data.append("profit", this.add_profit);
                data.append("Width", this.add_width);
                data.append("Height", this.add_height);
                data.append("Thickness", this.add_thickness);
                data.append("file", this.add_photo);
            console.log('data : ',data);
            axios
                .post('/api/products', data)
                .then(() => {

                this.showSuccessMessage("Add Product to Catedory successfully");
                // this.$router.push({ name: "products_category", params: { id: this.id } });
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
      
    },
}
</script>

<style>

</style>