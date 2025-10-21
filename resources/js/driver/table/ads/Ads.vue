<template>
  <nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb breadcrumb-pipes">
      <li class="breadcrumb-item">
        <router-link to="/">{{ $t("Home") }}</router-link>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ $t("Ads") }}
      </li>
    </ol>
  </nav>

  <div class="row" id="table-hover-row">
    <div class="col-12">
      <div class="card">
        <div
          class="card-header d-flex justify-content-between align-items-center"
        >
          <h4 class="card-title">{{ $t("Ads List") }}</h4>
          <button
            type="button"
            class="btn btn-gradient-primary"
            data-bs-toggle="modal"
            data-bs-target="#addAdModal"
          >
            {{ $t("Add New Ad") }}
          </button>
        </div>

        <!-- ADD MODAL -->
        <div
          class="modal fade text-start"
          id="addAdModal"
          tabindex="-1"
          aria-labelledby="addAdModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">{{ $t("Add Advertisement") }}</h4>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>

              <form @submit.prevent="addAd">
                <div class="modal-body">
                  <div class="mb-3">
                    <label>{{ $t("Type") }}</label>
                    <select class="form-control" v-model="form.type" required>
                      <option value="banner">{{ $t("Banner") }}</option>
                      <option value="special_offer">
                        {{ $t("Special Offer") }}
                      </option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label>{{ $t("Title") }}</label>
                    <input
                      v-model="form.title"
                      type="text"
                      class="form-control"
                      placeholder="Title"
                      required
                    />
                  </div>

                  <div class="mb-3">
                    <label>{{ $t("Description") }}</label>
                    <textarea
                      v-model="form.description"
                      class="form-control"
                      placeholder="Description"
                    ></textarea>
                  </div>

                  <div class="mb-3">
                    <label>{{ $t("URL") }}</label>
                    <input
                      v-model="form.url"
                      type="text"
                      class="form-control"
                      placeholder="https://..."
                    />
                  </div>

                  <div class="mb-3">
                    <label>{{ $t("Photo") }}</label>
                    <input
                      type="file"
                      class="form-control"
                      @change="handleFileUpload"
                      accept="image/*"
                    />
                  </div>
                </div>

                <div class="modal-footer">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="loading"
                  >
                    <span
                      v-if="loading"
                      class="spinner-border spinner-border-sm me-2"
                    ></span>
                    {{ $t("Create") }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- EDIT MODAL -->
        <div
          class="modal fade text-start"
          id="editAdModal"
          tabindex="-1"
          aria-labelledby="editAdModalLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">{{ $t("Edit Advertisement") }}</h4>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>

              <form @submit.prevent="updateAd">
                <div class="modal-body">
                  <div class="mb-3">
                    <label>{{ $t("Type") }}</label>
                    <select
                      class="form-control"
                      v-model="editForm.type"
                      required
                    >
                      <option value="banner">{{ $t("Banner") }}</option>
                      <option value="special_offer">
                        {{ $t("Special Offer") }}
                      </option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label>{{ $t("Title") }}</label>
                    <input
                      v-model="editForm.title"
                      type="text"
                      class="form-control"
                      placeholder="Title"
                      required
                    />
                  </div>

                  <div class="mb-3">
                    <label>{{ $t("Description") }}</label>
                    <textarea
                      v-model="editForm.description"
                      class="form-control"
                      placeholder="Description"
                    ></textarea>
                  </div>

                  <div class="mb-3">
                    <label>{{ $t("URL") }}</label>
                    <input
                      v-model="editForm.url"
                      type="text"
                      class="form-control"
                      required
                    />
                  </div>

                  <div class="mb-3">
                    <label>{{ $t("Photo") }}</label>
                    <input
                      type="file"
                      class="form-control"
                      @change="handleEditFileUpload"
                      accept="image/*"
                    />
                  </div>
                </div>

                <div class="modal-footer">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="loading"
                  >
                    <span
                      v-if="loading"
                      class="spinner-border spinner-border-sm me-2"
                    ></span>
                    {{ $t("Save Changes") }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ $t("Type") }}</th>
                <th>{{ $t("Title") }}</th>
                <th>{{ $t("URL") }}</th>
                <th>{{ $t("Photo") }}</th>
                <th>{{ $t("Created At") }}</th>
                <th>{{ $t("Actions") }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(ad, index) in ads" :key="ad.id">
                <td>{{ index + 1 }}</td>
                <td>{{ ad.type }}</td>
                <td>{{ ad.title }}</td>
                <td>{{ ad.url }}</td>
                <td>
                  <img
                    :src="getImage(ad.image)"
                    alt="Ad Image"
                    class="img-thumbnail"
                    width="100"
                  />
                </td>
                <td>{{ formatDate(ad.created_at) }}</td>
                <td>
                  <button
                    @click="editAd(ad)"
                    data-bs-toggle="modal"
                    data-bs-target="#editAdModal"
                    class="btn btn-sm btn-warning me-1"
                  >
                    <i class="fa fa-edit"></i>
                  </button>
                  <button
                    @click="deleteAd(ad.id)"
                    class="btn btn-sm btn-danger"
                  >
                    <i class="fa fa-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <div v-if="ads.length === 0" class="text-center py-4">
            <em>{{ $t("No ads found.") }}</em>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";
import axios from "axios";

export default {
  data() {
    return {
      ads: [],
      loading: false,
      form: {
        type: "banner",
        title: "",
        description: "",
        url: "",
        image: null,
      },
      editForm: {
        id: null,
        type: "banner",
        title: "",
        description: "",
        url: "",
        image: null,
      },
    };
  },
  methods: {
    async getAds() {
      try {
        const { data } = await axios.get("/api/advertisements");
        this.ads = data.data || [];
      } catch (error) {
        console.error("Error fetching ads:", error);
      }
    },

    handleFileUpload(e) {
      this.form.image = e.target.files[0];
    },
    handleEditFileUpload(e) {
      this.editForm.image = e.target.files[0];
    },

    getImage(photo) {
      return photo ? `/storage/${photo}` : "/img/load.png";
    },

    formatDate(date) {
      return new Date(date).toLocaleString();
    },

    async addAd() {
      try {
        this.loading = true;
        const formData = new FormData();
        Object.keys(this.form).forEach((key) => {
          if (this.form[key]) formData.append(key, this.form[key]);
        });

        await axios.post("/api/advertisements", formData);
        this.showSuccess("Advertisement added successfully");
        this.getAds();
        this.resetForm(this.form);
      } catch (error) {
        console.error(error);
        this.showError("Failed to add advertisement");
      } finally {
        this.loading = false;
      }
    },

    editAd(ad) {
      this.editForm.id = ad.id;
      this.editForm.url = ad.url;
      this.editForm.type = ad.type;
      this.editForm.title = ad.title;
      this.editForm.description = ad.description;
      this.editForm.image = null;
    },

    async updateAd() {
      try {
        this.loading = true;
        const formData = new FormData();
        formData.append("url", this.editForm.url);
        formData.append("type", this.editForm.type);
        formData.append("title", this.editForm.title);
        formData.append("description", this.editForm.description);
        if (this.editForm.image) formData.append("image", this.editForm.image);

        await axios.post(`/api/advertisement/${this.editForm.id}`, formData);
        this.showSuccess("Advertisement updated successfully");
        this.getAds();
        this.resetForm(this.editForm);
      } catch (error) {
        console.error(error);
        this.showError("Failed to update advertisement");
      } finally {
        this.loading = false;
      }
    },

    async deleteAd(id) {
      const confirm = await Swal.fire({
        title: this.$t("Are you sure?"),
        text: this.$t("This action cannot be undone."),
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: this.$t("Yes, delete it!"),
        cancelButtonText: this.$t("Cancel"),
      });

      if (!confirm.isConfirmed) return;

      try {
        await axios.delete(`/api/advertisements/${id}`);
        this.showSuccess("Advertisement deleted successfully");
        this.getAds();
      } catch (error) {
        console.error(error);
        this.showError("Failed to delete advertisement");
      }
    },

    showSuccess(msg) {
      Swal.fire({
        icon: "success",
        title: msg,
        timer: 1500,
        showConfirmButton: false,
      });
    },
    showError(msg) {
      Swal.fire({ icon: "error", title: "Error", text: msg });
    },
    resetForm(obj) {
      for (let key in obj) obj[key] = key === "type" ? "banner" : "";
    },
  },

  mounted() {
    this.getAds();
  },
};
</script>

<style scoped>
.img-thumbnail {
  border-radius: 10px;
  object-fit: cover;
}
.prod-img {
  width: 50px;
}
</style>
