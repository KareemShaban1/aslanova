<template>
  <!-- BEGIN: Content-->

  <div class="content-overlay"></div>
  <div></div>
  <div class="content-wrapper p-0">
    <div class="content-header row">
      <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
          <div class="col-12">
            <h2 class="content-header-title float-start mb-0">
              {{ $t("Offer Details") }}
            </h2>
            <div class="breadcrumb-wrapper">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <router-link to="/">{{ $t("Home") }}</router-link>
                </li>
                <li class="breadcrumb-item">
                  <router-link :to="`/dashboard/Offer`">
                    {{ $t("Offers") }}
                  </router-link>
                </li>
                <li class="breadcrumb-item active">{{ $t("Details") }}</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="content-body">
      <!-- app e-commerce details start -->
      <section class="app-ecommerce-details">
        <div class="card">
          <!-- Product Details starts -->
          <div class="card-body show-prod-page">
            <div class="row my-2">
              <div
                class="col-12 col-md-3 d-flex align-items-center justify-content-center mb-2 mb-md-0"
              >
                <div class="d-flex align-items-center justify-content-center">
                  <!-- الصورة مع حدث النقر لفتح المودال -->
                  <img
                    :src="getUserImageSrc(sub_product.file)"
                    class="img-fluid product-img"
                    alt="product image"
                    @click="openImageModal(sub_product.file)"
                  />
                </div>
              </div>

              <!-- المودال لعرض الصورة -->
              <div
                v-if="isImageModalOpen"
                class="image-modal"
                @click="closeImageModal"
              >
                <div class="modal-content">
                  <img
                    :src="getUserImageSrc(selectedImage)"
                    class="modal-image"
                    alt="modal image"
                  />
                </div>
              </div>
              <div class="col-12 col-md-3 my-2">
                <h2>{{ sub_product.name }}</h2>
                <h5 class="py-1">
                  <span
                    class="item-price text-black border border-1 border-primary rounded px-1 my-1"
                  >
                    <span class="">
                      <i class="fa-solid fa-clock"></i>
                    </span>
                    <span class="px-1">{{ $t("Shipping in") }} :</span>
                    <span>{{ sub_product.delivery_price }}</span>
                  </span>
                </h5>
                <div
                  class="ecommerce-details-price d-flex align-items-center flex-wrap my-2"
                >
                  <h2 class="item-price me-1 text-black">
                    {{ sub_product.price }}
                    <i class="fa-solid fa-euro-sign"></i>
                  </h2>
                  <h5 class="me-1">
                    <span
                      class="text-black"
                      v-if="sub_product.shipping_price > 0"
                    >
                      + {{ sub_product.shipping_price }}
                      <i class="fa-solid fa-euro-sign"></i>
                      {{ $t("Delivery Cost") }}
                    </span>
                    <span class="text-success" v-else>
                      {{ $t("Free Delivery") }}
                    </span>
                  </h5>
                  <h5 class="item-price text-black">
                    <span>{{ $t("Included vat") }}</span>
                  </h5>
                </div>
                <div>
                  <button
                    @click="addToCart(sub_product)"
                    class="btn btn-primary btn-cart"
                  >
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="add-to-cart">{{ $t("Add to cart") }}</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- Product Details ends -->

          <!-- Item features starts -->
          <div class="item-features">
            <div class="row py-1">
              <h2 class="text-center">{{ $t("Features") }}</h2>

              <div class="mx-1">
                <h4>{{ $t("Description") }}</h4>
                <p class="mx-2">
                  {{ sub_product.description }}
                </p>
              </div>
              <hr class="my-2" />
              <div class="row px-2">
                <div class="col-3">
                  <div class="card text-center">
                    <div class="card-body align-items-center">
                      <div class="avatar bg-light-primary p-50 mb-1">
                        <div class="avatar-content">
                          <i class="fa-solid fa-dolly fs-2"></i>
                        </div>
                      </div>
                      <h4 class="fw-bolder">{{ $t("shipping price") }}</h4>
                      <p class="card-text">
                        {{ sub_product.shipping_price }}
                        <i class="fa-solid fa-euro-sign"></i>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-3">
                  <div class="card text-center">
                    <div class="card-body align-items-center">
                      <div class="avatar bg-light-primary p-50 mb-1">
                        <div class="avatar-content">
                          <i class="fa-solid fa-clock fs-2"></i>
                        </div>
                      </div>
                      <h4 class="fw-bolder">{{ $t("delivery time") }}</h4>
                      <p class="card-text">{{ sub_product.delivery_price }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Item features ends -->
          <hr class="my-2" />
          <div class="card-body" v-if="Offers.length > 0">
            <div class="mt-4 mb-2 text-center">
              <h4>{{ $t("Related Offers") }}</h4>
            </div>
            <div class="swiper-container">
              <div class="swiper-wrapper">
                <div
                  class="swiper-slide related-prod"
                  v-for="(prod, index) in Offers"
                  :key="index"
                >
                  <span @click="show(prod.id)">
                    <div class="item-heading">
                      <h5 class="text-truncate mb-0">{{ prod.name }}</h5>
                    </div>
                    <div class="img-container w-50 mx-auto py-75">
                      <img
                        :src="getUserImageSrc(prod.file)"
                        class="img-fluid"
                        alt="image"
                      />
                    </div>
                    <div class="item-meta">
                      <p class="card-text text-primary mb-0">
                        {{ prod.price }}
                        <span><i class="fa-solid fa-euro-sign"></i></span>
                      </p>
                    </div>
                  </span>
                </div>
              </div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
          <div v-else>
            <div class="alert alert-warning" role="alert"></div>
          </div>
        </div>
      </section>
      <!-- app e-commerce details end -->
    </div>
  </div>
  <!-- END: Content-->
</template>
<script>
import Swiper from "swiper";
import "swiper/css/swiper.css";
import { useCartStore } from "../../../components/cart/cartStore";

export default {
  props: ["id"],
  data() {
    return {
      sub_product: {},
      Offers: [],
      features: [
        {
          label: this.$t("Width"),
          value: "",
          unit: "cm",
          icon: "fa-solid fa-text-width",
        },
        {
          label: this.$t("Height"),
          value: "",
          unit: "cm",
          icon: "fa-solid fa-text-height",
        },
        {
          label: this.$t("Thickness"),
          value: "",
          unit: "cm",
          icon: "fa-solid fa-down-left-and-up-right-to-center",
        },
      ],
      extraFeatures: [
        {
          label: this.$t("Capital"),
          value: "",
          icon: "fa-solid fa-circle-dollar-to-slot",
        },
        { label: this.$t("Quantity"), value: "", icon: "fa-solid fa-shield" },
        { label: this.$t("Type"), value: "", icon: "fa-solid fa-font-awesome" },
      ],
    };
  },
  setup() {
    const cartStore = useCartStore();

    const addToCartWithToast = (product) => {
      console.log("addToCartWithToast product: ", product);
      // Add product to cart
      cartStore.addToCart(product);

      // Show success toast with product details
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: `${product.name} added to cart!`,
        text: `Price: ${product.price} $`,
        showConfirmButton: false,
        timer: 2000,
        toast: true,
        customClass: {
          confirmButton: "btn btn-primary",
          popup: "swal2-show",
          container: "swal2-container",
        },
        imageUrl: product.file ? `/storage/${product.file}` : "/img/load.png",
        imageWidth: 80,
        imageHeight: 80,
        buttonsStyling: false,
      });
    };

    return {
      addToCart: addToCartWithToast,
    };
  },
  methods: {
    getUserImageSrc(photo) {
      return photo ? `/storage/${photo}` : "/img/load.png";
    },
    async get_Offer_info() {
      try {
        const response = await axios.get(`/api/offers/${this.id}`);
        this.sub_product = response.data.offer;
        this.features[0].value = this.sub_product.Width;
        this.features[1].value = this.sub_product.Height;
        this.features[2].value = this.sub_product.Thickness;
        this.extraFeatures[0].value = `${this.sub_product.capital} $`;
        this.extraFeatures[1].value = this.sub_product.quantity;
        this.extraFeatures[2].value = this.sub_product.type;
        this.get_Offers();
      } catch (error) {
        console.error(error);
      }
    },
    async get_Offers() {
      try {
        const response = await axios.get(`/api/offers`);
        console.log(response);

        this.Offers = response.data.offers;
        console.log(this.Offers);

        this.$nextTick(this.initSwiper);
      } catch (error) {
        console.error(error);
      }
    },
    initSwiper() {
      new Swiper(".swiper-container", {
        slidesPerView: 1,
        spaceBetween: 30,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        breakpoints: {
          1000: { slidesPerView: 3 },
          768: { slidesPerView: 2 },
          576: { slidesPerView: 1 },
        },
      });
    },
    ShowOffer(id) {
      this.$router.push({ name: "ShowOffer", params: { id } });
    },
  },
  mounted() {
    this.get_Offer_info();
  },
};
</script>

<style>
.swiper-container {
  width: 100%;
  padding: 20px 0;
}

.swiper-slide {
  text-align: center;
  font-size: 18px;
  background: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
}

.img-container {
  display: flex;
  justify-content: center;
  align-items: center;
}

.circal {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  margin: 5px !important;
  border: 2px solid var(--mainColor);
  cursor: pointer;
  overflow: hidden;
}

.circal img {
  width: 100%;
  height: 100%;
  background-size: auto;
}

.old-price {
  color: red;
  text-decoration: line-through;
  margin-right: 10px;
}
</style>
