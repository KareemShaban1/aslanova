<template>
    <div class="d-flex justify-content-start breadcrumb-wrapper my-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ms-1">
                <li class="breadcrumb-item"><router-link to="/">{{ $t('home') }}</router-link></li>
                <li class="breadcrumb-item"><router-link to="/dashboard/profile">{{ $t('Profile') }}</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $t('Edit Your Information') }}</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <form action="" @submit.prevent="updateUser">

            <div class="card-header">
                <h4 class="card-title">{{ $t('Edit Your Information') }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1">
                            <label for="fname" class="form-label">{{ $t('FIRST NAME') }}</label>
                            <input type="text" class="form-control" id="fname" name="fname" v-model="fname"
                                aria-describedby="fname" tabindex="1" autofocus :placeholder="user.fname" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1">
                            <label for="lname" class="form-label">{{ $t('LAST NAME') }}</label>
                            <input type="text" class="form-control" id="lname" name="lname" v-model="lname"
                                aria-describedby="lname" tabindex="4" autofocus :placeholder="user.lname" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1">
                            <label for="phoneNumber" class="form-label">{{ $t('PHONE NUMBER') }}</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber"
                                v-model="phoneNumber" aria-describedby="phoneNumber" tabindex="5" autofocus
                                :placeholder="user.phoneNumber" />
                        </div>
                    </div>
                    <!-- <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1">
                            <label for="location" class="form-label">{{ $t('Address') }}</label>
                            <input type="text" class="form-control" id="location" name="location" v-model="location"
                                aria-describedby="Address" tabindex="6" autofocus :placeholder="user.location" />
                        </div>
                    </div> -->
                    <div class="col-xl-4 col-md-6 col-12">
                        <label for="personImage" class="form-label">{{ $t('personImage') }} {{ $t('(optional)')
                            }}</label>
                        <input type="file" class="form-control" id="personImage" aria-describedby="personImage"
                            tabindex="7" @change="handleImageChange" accept="image/*" />
                    </div>
                </div>

                <!-- Location Details Section -->
                <div class="row mt-4" v-if="lastLocation">
                    <div class="col-12">
                        <h5 class="mb-3">{{ $t('Location Details') }}</h5>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1">
                            <label for="location_first_name" class="form-label">{{ $t('First Name') }}</label>
                            <input type="text" class="form-control" id="location_first_name" name="location_first_name"
                                v-model="locationData.first_name" tabindex="8" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1">
                            <label for="location_last_name" class="form-label">{{ $t('Last Name') }}</label>
                            <input type="text" class="form-control" id="location_last_name" name="location_last_name"
                                v-model="locationData.last_name" tabindex="9" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1">
                            <label for="location_country" class="form-label">{{ $t('Country') }}</label>
                            <input type="text" class="form-control" id="location_country" name="location_country"
                                v-model="locationData.country" tabindex="10" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1">
                            <label for="location_city" class="form-label">{{ $t('City') }}</label>
                            <input type="text" class="form-control" id="location_city" name="location_city"
                                v-model="locationData.city" tabindex="11" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1">
                            <label for="location_street" class="form-label">{{ $t('Street') }}</label>
                            <input type="text" class="form-control" id="location_street" name="location_street"
                                v-model="locationData.street" tabindex="12" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1">
                            <label for="location_house_number" class="form-label">{{ $t('House Number') }}</label>
                            <input type="text" class="form-control" id="location_house_number" name="location_house_number"
                                v-model="locationData.house_number" tabindex="13" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1">
                            <label for="location_zip_code" class="form-label">{{ $t('Zip Code') }}</label>
                            <input type="text" class="form-control" id="location_zip_code" name="location_zip_code"
                                v-model="locationData.zip_code" tabindex="14" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1">
                            <label for="location_phone" class="form-label">{{ $t('Phone') }}</label>
                            <input type="text" class="form-control" id="location_phone" name="location_phone"
                                v-model="locationData.phone" tabindex="15" />
                        </div>
                    </div>
                </div>
                <div class="row mt-2" v-else>
                    <div class="col-12">
                        <p class="text-muted">{{ $t('No location found. Location details will be saved when you add your first location.') }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 col-md-4">
                        <button type="submit" class="btn btn-primary m-2">{{ $t('Update') }}</button>
                        <router-link to="/dashboard/profile" class="btn btn-outline-danger suspend-user waves-effect m-2">{{
                            $t('Back') }}
                        </router-link>
                    </div>
                </div>
            </div>

        </form>
    </div>

</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
export default {
    // props: {user : Array} ,
    data() {
        return {
            user: [],
            fname: '',
            lname: '',
            // email: '',
            phoneNumber: '',
            location: '',
            personImage: null,
            locationData: {
                id: null,
                first_name: '',
                last_name: '',
                country: '',
                city: '',
                street: '',
                house_number: '',
                zip_code: '',
                phone: '',
            },
        }
    },
    computed: {
        // Get the last (most recent) location from user locations
        lastLocation() {
            if (this.user.locations && this.user.locations.length > 0) {
                // Sort by created_at descending and get the first one (most recent)
                const sorted = [...this.user.locations].sort((a, b) => {
                    const dateA = new Date(a.created_at || 0);
                    const dateB = new Date(b.created_at || 0);
                    return dateB - dateA;
                });
                return sorted[0];
            }
            return null;
        }
    },
    methods: {
        // Get user from DB
        getuser() {
            axios.get("/getuser").then((response) => {
                this.user = response.data;
                this.fname = response.data.fname;
                this.lname = response.data.lname;
                // this.email = response.data.email;
                this.phoneNumber = response.data.phoneNumber;
                this.location = response.data.location;
                this.personImage = response.data.personImage;

                // Populate location data if last location exists
                if (response.data.locations && response.data.locations.length > 0) {
                    // Sort by created_at descending and get the first one (most recent)
                    const sorted = [...response.data.locations].sort((a, b) => {
                        const dateA = new Date(a.created_at || 0);
                        const dateB = new Date(b.created_at || 0);
                        return dateB - dateA;
                    });
                    const lastLocation = sorted[0];
                    
                    this.locationData = {
                        id: lastLocation.id,
                        first_name: lastLocation.first_name || '',
                        last_name: lastLocation.last_name || '',
                        country: lastLocation.country || '',
                        city: lastLocation.city || '',
                        street: lastLocation.street || '',
                        house_number: lastLocation.house_number || '',
                        zip_code: lastLocation.zip_code || '',
                        phone: lastLocation.phone || '',
                    };
                } else {
                    // Reset location data if no locations exist
                    this.locationData = {
                        id: null,
                        first_name: '',
                        last_name: '',
                        country: '',
                        city: '',
                        street: '',
                        house_number: '',
                        zip_code: '',
                        phone: '',
                    };
                }
            });
        },
        // Send update image
        handleImageChange(event) {
            this.personImage = event.target.files[0]; // احصل على الملف المحدد

        },
        // this function to sent requeste to update user in DB
        updateUser() {
            const data = new FormData();
            data.append('fname', this.fname);
            data.append('lname', this.lname);
            // data.append('email', this.email);
            data.append('location', this.location);
            data.append('phoneNumber', this.phoneNumber);
            data.append('personImage', this.personImage);
            
            // Add location data if it exists
            if (this.locationData.id) {
                data.append('location_id', this.locationData.id);
            }
            data.append('location_first_name', this.locationData.first_name || '');
            data.append('location_last_name', this.locationData.last_name || '');
            data.append('location_country', this.locationData.country || '');
            data.append('location_city', this.locationData.city || '');
            data.append('location_street', this.locationData.street || '');
            data.append('location_house_number', this.locationData.house_number || '');
            data.append('location_zip_code', this.locationData.zip_code || '');
            data.append('location_phone', this.locationData.phone || '');
            
            axios.post(`/api/dashboard/profile/${this.$route.params.id}/edit`, data).then(() => {
                this.getuser();
                this.showSuccessMessage();
                this.$router.push('/dashboard/profile');
            }).catch((error) => {
                console.error('Error updating profile:', error);
                Swal.fire({
                    position: 'top-start',
                    icon: 'error',
                    title: 'حدث خطأ أثناء التحديث',
                    showConfirmButton: false,
                    timer: 1500,
                });
            });
        },
        // Confirm message when user send request successfully
        showSuccessMessage() {
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم تعديل البيانات بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        },


    },
    mounted() {
        this.getuser();
    },
    created() {
        this.getuser();
    },
}
</script>

<style></style>
