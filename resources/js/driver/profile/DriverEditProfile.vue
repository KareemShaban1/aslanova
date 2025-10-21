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
          <!-- <div class="col-xl-4 col-md-6 col-12 mb-1 mb-md-0">
            <label for="email" class="form-label">Email</label>
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
          </div> -->
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
        </div>

        <div class="row">
          <div class="col-6 col-md-4">

              <button type="submit" class="btn btn-primary m-2">{{ $t('Update') }}</button>
              <router-link
                to="/profile"
                class="btn btn-outline-danger suspend-user waves-effect m-2"
                >{{ $t('Back') }}</router-link
              >
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

 <script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
  // props: {user : Array} ,
  data() {
    return {
      user: [],
      fname: "",
      lname: "",
    //   email: "",
      phoneNumber: "",
      location: "",
      personImage: null,
    };
  },
  methods: {
    getuser() {
      axios.get("/get-admin").then((response) => {
        this.user = response.data.adminInfo;
        this.fname = response.data.adminInfo.fname;
        this.lname = response.data.adminInfo.lname;
        // this.email = response.data.adminInfo.email;
        this.phoneNumber = response.data.adminInfo.phoneNumber;
        this.location = response.data.adminInfo.location;
        this.personImage = response.data.adminInfo.personImage;
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
    //   data.append("email", this.email);
      data.append("location", this.location);
      data.append("phoneNumber", this.phoneNumber);
      data.append("personImage", this.personImage);
      axios
        .post(`/api/driver/index/profile/${this.$route.params.id}/edit`, data)
        .then(() => {
          this.getuser();
          this.showSuccessMessage();
          this.$router.push("/profile");
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
