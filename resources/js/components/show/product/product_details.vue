<template>
  <div v-if="product" class="product-details container py-5">
    <div class="row align-items-center g-5">
      <!-- 🖼️ Product Image -->
      <div class="col-md-6">
        <div
          class="image-wrapper shadow-sm rounded-4 overflow-hidden position-relative"
        >
          <img
            :src="getUserImageSrc(activeVariant?.file || product.file)"
            class="img-fluid main-image"
            :alt="product.name"
          />
          <div
            class="badge bg-color position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill"
          >
            {{ activeVariant?.color || "Default" }}
          </div>
        </div>

        <!-- 🖼️ Additional Images & Videos -->
        <div
          v-if="
            (activeVariant?.images && activeVariant.images.length) ||
            (activeVariant?.video && activeVariant.video.length)
          "
          class="variant-gallery mt-4"
        >
          <h5 class="mb-3 fw-semibold">Gallery</h5>

          <div class="d-flex flex-wrap gap-3">
            <!-- Images -->
            <div
              v-for="(img, index) in activeVariant.images"
              :key="'img-' + index"
              class="gallery-item shadow-sm rounded overflow-hidden"
              style="width: 120px; height: 120px; cursor: pointer"
              @click="openPopup('image', img)"
            >
              <img
                :src="getUserImageSrc(img)"
                class="img-fluid h-100 w-100 object-fit-cover"
                alt="variant image"
              />
            </div>

            <!-- Videos -->
            <div
              v-for="(vid, index) in activeVariant.video"
              :key="'vid-' + index"
              class="gallery-item shadow-sm rounded overflow-hidden position-relative"
              style="width: 120px; height: 120px; cursor: pointer"
              @click="openPopup('video', vid)"
            >
              <video
                :src="getUserImageSrc(vid)"
                class="w-100 h-100 object-fit-cover"
                muted
              ></video>
              <i
                class="fa fa-play position-absolute top-50 start-50 translate-middle text-white fs-3"
                style="pointer-events: none"
              ></i>
            </div>
          </div>
        </div>

        <!-- 🎨 Variants -->
        <div v-if="product.sub_product?.length" class="variants mt-4">
          <h5 class="mb-3 fw-semibold">Available Colors</h5>
          <div class="d-flex flex-wrap gap-3">
            <div
              v-for="variant in product.sub_product"
              :key="variant.id"
              class="variant-item shadow-sm"
              :class="{ active: activeVariant?.id === variant.id }"
              @click="selectVariant(variant)"
            >
              <img :src="getUserImageSrc(variant.file)" :alt="variant.color" />
              <small class="mt-1 text-capitalize">{{ variant.color }}</small>
            </div>
          </div>
        </div>
      </div>

      <!-- 🧾 Product Info -->
      <div class="col-md-6">
        <div class="product-info">
          <h2 class="fw-bold mb-3">
            {{ activeVariant?.name || product.name }}
          </h2>
          <p class="text-muted mb-3">
            {{ activeVariant?.desc || product.desc }}
          </p>

          <div class="d-flex align-items-center gap-3 mb-4">
            <h3 class="price mb-0">€{{ activeVariant?.price || "—" }}</h3>
            <small class="text-secondary">
              Shipping: €{{ activeVariant?.shipping_price || "—" }}
            </small>
          </div>

          <button class="btn btn-add-cart" @click="addToCart(activeVariant)">
            <i class="fa fa-cart-plus me-2"></i> Add to Cart
          </button>

          <div class="item-features">
            <div class="row py-1">
              <h2 class="text-center">{{ $t("Features") }}</h2>

              <hr class="my-2" />
              <div class="row px-2">
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="card text-center">
                    <div
                      class="card-body d-flex flex-column justify-content-center align-items-center"
                    >
                      <div class="avatar bg-light-primary p-50 mb-1">
                        <div class="avatar-content">
                          <i class="fa-solid fa-text-width fs-2"></i>
                        </div>
                      </div>
                      <h4 class="fw-bolder">{{ $t("Width") }}</h4>
                      <p class="card-text">
                        {{ activeVariant?.Width || product.Width }} cm
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="card text-center">
                    <div
                      class="card-body d-flex flex-column justify-content-center align-items-center"
                    >
                      <div class="avatar bg-light-primary p-50 mb-1">
                        <div class="avatar-content">
                          <i class="fa-solid fa-text-height fs-2"></i>
                        </div>
                      </div>
                      <h4 class="fw-bolder">{{ $t("Height") }}</h4>
                      <p class="card-text">
                        {{ activeVariant?.Height || product.Height }} cm
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="card text-center">
                    <div
                      class="card-body d-flex flex-column justify-content-center align-items-center"
                    >
                      <div class="avatar bg-light-primary p-50 mb-1">
                        <div class="avatar-content">
                          <i
                            class="fa-solid fa-down-left-and-up-right-to-center fs-2"
                          ></i>
                        </div>
                      </div>
                      <h4 class="fw-bolder">{{ $t("Thickness") }}</h4>
                      <p class="card-text">
                        {{ activeVariant?.Thickness || product.Thickness }} cm
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                  <div class="card text-center">
                    <div
                      class="card-body d-flex flex-column justify-content-center align-items-center"
                    >
                      <div class="avatar bg-light-primary p-50 mb-1">
                        <div class="avatar-content">
                          <i class="fa-solid fa-droplet fs-2"></i>
                        </div>
                      </div>
                      <h4 class="fw-bolder">{{ $t("Color") }}</h4>
                      <p class="card-text">
                        {{ activeVariant?.color || product.color }}
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                  <div class="card text-center">
                    <div
                      class="card-body d-flex flex-column justify-content-center align-items-center"
                    >
                      <div class="avatar bg-light-primary p-50 mb-1">
                        <div class="avatar-content">
                          <i class="fa-solid fa-dolly fs-2"></i>
                        </div>
                      </div>
                      <h4 class="fw-bolder">{{ $t("shipping price") }}</h4>
                      <p
                        class="card-text"
                        v-if="
                          activeVariant?.shipping_price ||
                          product.shipping_price > 0
                        "
                      >
                        {{
                          activeVariant?.shipping_price ||
                          product.shipping_price
                        }}
                        <i class="fa-solid fa-euro-sign"></i>
                      </p>
                      <p class="card-text" v-else>{{ $t("Free Delivery") }}</p>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                  <div class="card text-center">
                    <div
                      class="card-body d-flex flex-column justify-content-center align-items-center"
                    >
                      <div class="avatar bg-light-primary p-50 mb-1">
                        <div class="avatar-content">
                          <i class="fa-solid fa-clock fs-2"></i>
                        </div>
                      </div>
                      <h4 class="fw-bolder">{{ $t("Shipping in") }}</h4>
                      <p class="card-text">
                        {{ activeVariant.delivery_price }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div v-else class="text-center py-5">
    <div class="spinner-border text-warning"></div>
    <p class="mt-3">Loading product details...</p>
  </div>

  <!-- 🔲 Popup Modal -->
<div
v-if="showPopup"
class="popup-overlay d-flex justify-content-center align-items-center"
@click.self="closePopup"
>
<div class="popup-content position-relative">
  <button
    class="btn-close position-absolute top-0 end-0 m-3 bg-white rounded-circle"
    @click="closePopup"
  ></button>

  <img
    v-if="popupType === 'image'"
    :src="popupSrc"
    class="img-fluid rounded shadow"
    style="max-height: 80vh; max-width: 90vw; object-fit: contain;"
  />

  <video
    v-else-if="popupType === 'video'"
    :src="popupSrc"
    class="rounded shadow"
    controls
    autoplay
    style="max-height: 80vh; max-width: 90vw; object-fit: contain;"
  ></video>
</div>
</div>

</template>

<script>
import axios from "axios";
import { useCartStore } from "../../cart/cartStore";
import Swal from "sweetalert2";
export default {
  props: ["id"],
  data() {
    return {
      product: null,
      activeVariant: null,
      mainMedia: null, // new: current displayed media (image/video)
      mainMediaType: "image", // new: "image" or "video"
      showPopup: false,
    popupType: null,  
    popupSrc: null,   
    };
  },
  setup() {
    const cartStore = useCartStore();

    const addToCartWithToast = (product) => {
      // Add product to cart
      cartStore.addToCart(product);

      // Show success toast with product details
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: `${product.name} added to cart!`,
        text: `Price: ${product.price} €`,
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
    async getProductDetails() {
      try {
        const response = await axios.get(
          `/api/products/product-details/${this.id}`
        );
        this.product = response.data.product;

        if (this.product.sub_product?.length) {
          this.activeVariant = this.product.sub_product[0];

          // 🧠 Fix parsing issue for images & videos
          this.normalizeMedia(this.activeVariant);
        }

        this.setDefaultMainMedia();
      } catch (error) {
        console.error(error);
      }
    },

    normalizeMedia(variant) {
      // Ensure images are an array
      if (variant.images) {
        if (typeof variant.images === "string") {
          try {
            variant.images = JSON.parse(variant.images);
          } catch {
            // fallback if it's comma-separated string
            variant.images = variant.images.split(",").map((i) => i.trim());
          }
        }
      } else {
        variant.images = [];
      }

      // Ensure video is an array
      if (variant.video) {
        if (typeof variant.video === "string") {
          try {
            variant.video = JSON.parse(variant.video);
          } catch {
            variant.video = [variant.video];
          }
        }
      } else {
        variant.video = [];
      }
    },

    setDefaultMainMedia() {
      // Prefer video > image > placeholder
      if (this.activeVariant?.video?.length) {
        this.mainMedia = this.activeVariant.video[0];
        this.mainMediaType = "video";
      } else if (this.activeVariant?.images?.length) {
        this.mainMedia = this.activeVariant.images[0];
        this.mainMediaType = "image";
      } else {
        this.mainMedia = this.activeVariant?.file || this.product?.file;
        this.mainMediaType = "image";
      }
    },

    setMainMedia(type, src) {
      this.mainMediaType = type;
      this.mainMedia = src;
    },
    selectVariant(variant) {
      this.activeVariant = variant;
      this.normalizeMedia(variant);
      this.setDefaultMainMedia();
    },
    getUserImageSrc(photo) {
      return photo ? `/storage/${photo}` : "/img/load.png";
    },

    openPopup(type, src) {
    this.popupType = type;
    this.popupSrc = this.getUserImageSrc(src);
    this.showPopup = true;
  },

  closePopup() {
    this.showPopup = false;
    this.popupSrc = null;
  },
  },
  mounted() {
    this.getProductDetails();
  },
};
</script>

<style scoped>
.product-details {
  color: #333;
}

.image-wrapper {
  background-color: #fff;
  border: 1px solid #eee;
  transition: transform 0.3s ease;
}

.image-wrapper:hover {
  transform: scale(1.02);
}

.main-image {
  width: 100%;
  object-fit: cover;
  border-radius: 10px;
}

.bg-color {
  background-color: #d9b382 !important;
  color: #fff;
  font-size: 0.85rem;
  font-weight: 600;
}

.variants .variant-item {
  cursor: pointer;
  text-align: center;
  width: 80px;
  border: 2px solid transparent;
  border-radius: 10px;
  padding: 6px;
  transition: all 0.3s ease;
  background: #fff;
}

.variants .variant-item img {
  width: 100%;
  border-radius: 6px;
  height: 60px;
  object-fit: cover;
}

.variants .variant-item:hover {
  border-color: #d9b382;
  transform: translateY(-2px);
}

.variants .variant-item.active {
  border-color: #d9b382;
  box-shadow: 0 3px 8px rgba(217, 179, 130, 0.4);
}

.btn-add-cart {
  background-color: #d9b382;
  color: #fff;
  padding: 0.75rem 2rem;
  font-size: 1.1rem;
  border-radius: 10px;
  border: none;
  transition: all 0.3s ease;
}

.btn-add-cart:hover {
  background-color: #b6916a;
  transform: translateY(-3px);
}

.price {
  color: #d9b382;
  font-weight: bold;
}

.specs ul {
  line-height: 1.7;
}

@media (max-width: 767px) {
  .product-details {
    text-align: center;
  }
  .variants .variant-item {
    width: 70px;
  }
  .btn-add-cart {
    width: 100%;
  }
}

.popup-overlay {
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0, 0, 0, 0.8);
	z-index: 1050;
	backdrop-filter: blur(3px);
        }
        
        .popup-content {
	position: relative;
	max-width: 90vw;
	max-height: 90vh;
        }
        
        .btn-close {
	z-index: 10;
        }
        
</style>
