<template>
  <div class="card">
    <form action="" @submit.prevent="updateUser">
      <div class="card-header">
        <h4 class="card-title">{{ $t('Edit Admin Information') }}</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-xl-4 col-md-6 col-12">
            <div class="mb-1">
              <label for="fname" class="form-label">{{ $t('FIRST NAME') }}</label>
              <input
                type="text"
                class="form-control"
                id="fname"
                name="fname"
                v-model="fname"
                aria-describedby="fname"
                tabindex="1"
                autofocus
                :placeholder="user.fname"
              />
            </div>
          </div>
          <div class="col-xl-4 col-md-6 col-12">
            <div class="mb-1">
              <label for="lname" class="form-label">{{ $t('LAST NAME') }}</label>
              <input
                type="text"
                class="form-control"
                id="lname"
                name="lname"
                v-model="lname"
                aria-describedby="lname"
                tabindex="4"
                autofocus
                :placeholder="user.lname"
              />
            </div>
          </div>
          <div class="col-xl-4 col-md-6 col-12">
            <div class="mb-1">
              <label for="phoneNumber" class="form-label">{{ $t('PHONE NUMBER') }}</label>
              <input
                type="text"
                class="form-control"
                id="phoneNumber"
                name="phoneNumber"
                v-model="phoneNumber"
                aria-describedby="phoneNumber"
                tabindex="5"
                autofocus
                :placeholder="user.phoneNumber"
              />
            </div>
          </div>
          <div class="col-xl-4 col-md-6 col-12">
            <div class="mb-1">
              <label for="location" class="form-label">{{ $t('Address') }}</label>
              <input
                type="text"
                class="form-control"
                id="location"
                name="location"
                v-model="location"
                aria-describedby="Address"
                tabindex="6"
                autofocus
                :placeholder="user.location"
              />
            </div>
          </div>
          <div class="col-xl-4 col-md-6 col-12 mb-1 mb-md-0">
            <label for="email" class="form-label">{{ $t('Email') }}</label>
            <input
              type="text"
              class="form-control"
              id="email"
              name="email"
              v-model="email"
              aria-describedby="email"
              tabindex="7"
              :placeholder="user.email"
            />
          </div>
          <div class="col-xl-4 col-md-6 col-12">
            <label for="personImage" class="form-label">{{ $t('personImage') }}  {{ $t('(optional)') }}</label>
            <!-- <input type="file" class="form-control" id="personImage" name="personImage" placeholder="john@example.com" aria-describedby="personImage" tabindex="7" /> -->
            <input
              type="file"
              class="form-control"
              id="personImage"
              aria-describedby="personImage"
              tabindex="7"
              @change="handleImageChange"
              accept="image/*"
            />
          </div>

        <div class="card-body">
          <h2>{{ $t('Roles') }}</h2>
          <div class="form-check" v-for="role in allRoles" :key="role.id">
            <input
              type="checkbox"
              class="form-check-input"
              :id="role.name"
              :value="role.name"
              v-model="selectedRoles"
            />
            <label class="form-check-label" :for="role.name">{{ role.name }}</label>
          </div>
        </div>

        </div>
        <button type="submit" class="btn btn-primary">{{ $t('Update') }}</button>
        <router-link
          to="/show/all-user"
          class="btn btn-outline-danger suspend-user waves-effect mx-3"
          >{{ $t('Back') }}</router-link
        >
      </div>
    </form>
  </div>
</template>

 <script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
  data() {
    return {
      user: [],
      allRoles: [],
      adminRoles: [],
      fname: "",
      lname: "",
      email: "",
      phoneNumber: "",
      location: "",
      personImage: null,
      selectedRoles: [],
    };
  },
  methods: {
    getuser() {
        axios.get(`/api/getAdmin/${this.$route.params.id}`).then((response) => {
            this.user = response.data.admin;
            this.allRoles = response.data.allRoles;
            this.adminRoles = response.data.adminRoles;
            this.selectedRoles = this.adminRoles ? this.adminRoles.slice() : [];
            this.fname = response.data.admin.fname;
            this.lname = response.data.admin.lname;
            this.email = response.data.admin.email;
            this.phoneNumber = response.data.admin.phoneNumber;
            this.location = response.data.admin.location;
            this.personImage = response.data.admin.personImage;
        })
        .catch((error) => {
            if (error.response.status === 403) {
                this.$router.push({ name: 'Unauthenticated' });
            } else {
                console.error(error);
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
      data.append("fname", this.fname);
      data.append("lname", this.lname);
      data.append("email", this.email);
      data.append("location", this.location);
      data.append("phoneNumber", this.phoneNumber);
      data.append("personImage", this.personImage);
      data.append("selectedRoles", this.selectedRoles.join(','));
      axios
        .post(`/api/editAdmin/${this.$route.params.id}`, data)
        .then(() => {
          this.getuser();
          this.showSuccessMessage();
          this.$router.push("/show/all-user");
        });
    },
    showSuccessMessage() {
      Swal.fire({
        position: "top-start",
        icon: "success",
        title: "تم تعديل البيانات بنجاح",
        showConfirmButton: false,
        timer: 1500,
        customClass: {
          confirmButton: "btn btn-primary",
        },
        buttonsStyling: false,
      });
    },
  },
  mounted() {
    this.getuser();
  },
  created() {
    this.getuser();
  },
};
</script>

 <style>
</style>
