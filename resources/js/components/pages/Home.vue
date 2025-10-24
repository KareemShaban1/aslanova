<template>
  <!-- 🖼 Hero Carousel -->
  <div
    id="carouselExample"
    class="carousel slide hero-carousel"
    data-bs-ride="carousel"
    data-bs-interval="4000"
  >
    <div class="carousel-indicators">
      <button
        v-for="(ad, index) in ads"
        :key="'indicator-' + index"
        type="button"
        class="btn-scroll"
        data-bs-target="#carouselExample"
        :data-bs-slide-to="index"
        :class="{ active: index === 0 }"
        :aria-label="'Slide ' + (index + 1)"
      ></button>
    </div>

    <div class="carousel-inner">
      <div
        v-for="(ad, index) in ads"
        :key="index"
        class="carousel-item"
        :class="{ active: index === 0 }"
      >
        <a :href="ad.url" target="_blank">
          <img
            :src="getUserImageSrc(ad.image)"
            class="d-block w-100 hero-image"
            alt="ad image"
          />
        </a>
      </div>
    </div>

    <button
      class="carousel-control-prev"
      type="button"
      data-bs-target="#carouselExample"
      data-bs-slide="prev"
    >
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button
      class="carousel-control-next"
      type="button"
      data-bs-target="#carouselExample"
      data-bs-slide="next"
    >
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Start Category 3D Section -->
  <div class="product-section">
    <div class="container">
      <div class="row">
        <!-- End Column 1 -->
        <div id="swiper-container-1" class="swiper-container">
          <transition-group
            name="fadeInRight"
            tag="div"
            class="text-center"
            mode="out-in"
          >
            <h3 class="title">
              {{ $t("Our Category 3D") }}
            </h3>
            <p>
              {{
                $t(
                  "This section to show our category and choose your products to sales"
                )
              }}
            </p>
          </transition-group>
          <transition-group
            name="fadeInRight"
            tag="div"
            class="swiper-wrapper"
            mode="out-in"
          >
            <!-- <div class="swiper-wrapper"> -->
            <!-- Start Column 2 -->
            <div
              class="col-12 col-md-4 mb-5 mb-md-0 swiper-slide fadeInRight"
              v-for="(prod, index) in categories3d"
              :key="index"
            >
              <div class="product-item" @click="goToCategory3D(prod.id)">
                <!-- <img src="./images/product-1.png" class="img-fluid product-thumbnail" alt="Nordic Chair"> -->
                <img
                  :src="getUserImageSrc(prod.file)"
                  class="img-fluid product-thumbnail img-swipper rounded-top"
                  alt="image"
                />
                <h6 class="item-name">
                  {{ prod.name.slice(0, 15)
                  }}{{ prod.name.length > 15 ? "..." : "" }}
                </h6>
              </div>
            </div>
          </transition-group>
          <!-- </div> -->
          <div id="swiper-button-next-1" class="swiper-button-next"></div>
          <div id="swiper-button-prev-1" class="swiper-button-prev"></div>
        </div>
        <!-- End Column 2 -->
      </div>
    </div>
  </div>
  <!-- End Category 3D Section -->

  <!-- Start Product Section  "our category" -->
  <div class="product-section" style="background: white">
    <div class="container">
      <div class="row">
        <!-- End Column 1 -->
        <div id="swiper-container-2" class="swiper-container">
          <transition-group
            name="fadeInRight"
            tag="div"
            class="text-center"
            mode="out-in"
          >
            <h3 class="title">
              {{ $t("Our Category") }}
            </h3>
            <p>
              {{
                $t(
                  "This section to show our category and choose your products to sales"
                )
              }}
            </p>
          </transition-group>
          <transition-group
            name="fadeInRight"
            tag="div"
            class="swiper-wrapper"
            mode="out-in"
          >
            <!-- <div class="swiper-wrapper"> -->
            <!-- Start Column 2 -->
            <div
              class="col-4 mb-5 mb-md-0 swiper-slide fadeInRight"
              v-for="(prod, index) in categories"
              :key="index"
            >
              <div class="product-item" @click="goToCategory(prod.id)">
                <!-- <img src="./images/product-1.png" class="img-fluid product-thumbnail" alt="Nordic Chair"> -->
                <img
                  :src="getUserImageSrc(prod.file)"
                  class="img-fluid img-swipper rounded-top"
                  alt="image"
                />
                <h6 class="item-name">
                  {{ prod.name.slice(0, 15)
                  }}{{ prod.name.length > 15 ? "..." : "" }}
                </h6>
              </div>
            </div>
          </transition-group>
          <!-- </div> -->
          <div id="swiper-button-next-2" class="swiper-button-next"></div>
          <div id="swiper-button-prev-2" class="swiper-button-prev"></div>
        </div>
        <!-- End Column 2 -->
      </div>
    </div>
  </div>
  <!-- End Product Section -->

  <div
    class="product-section"
    style="background: white"
    v-if="suggestedProducts.length > 0"
  >
    <div class="container">
      <div class="row">
        <div id="suggested-products-swiper" class="swiper-container">
          <transition-group
            name="fadeInRight"
            tag="div"
            class="text-center"
            mode="out-in"
          >
            <h3 class="title">
              {{ $t("Suggested Products") }}
            </h3>
            <p>
              {{ $t("This section to show our suggested products") }}
            </p>
          </transition-group>
          <transition-group
            name="fadeInRight"
            tag="div"
            class="swiper-wrapper"
            mode="out-in"
          >
            <!-- <div class="swiper-wrapper"> -->
            <!-- Start Column 2 -->
            <div
              class="col-12 col-md-4 mb-5 mb-md-0 swiper-slide fadeInRight"
              v-for="(prod, index) in suggestedProducts"
              :key="index"
            >
              <div class="product-item" @click="products_sub_products(prod.id)">
                <!-- <img src="./images/product-1.png" class="img-fluid product-thumbnail" alt="Nordic Chair"> -->
                <img
                  :src="getUserImageSrc(prod.file)"
                  class="img-fluid img-swipper rounded-top"
                  alt="image"
                />
                <h6 class="item-name">
                  {{ prod.name.slice(0, 15)
                  }}{{ prod.name.length > 15 ? "..." : "" }}
                </h6>
              </div>
            </div>
          </transition-group>
          <!-- </div> -->
          <div id="suggested-next" class="swiper-button-next"></div>
          <div id="suggested-prev" class="swiper-button-prev"></div>
        </div>
        <!-- End Column 2 -->
      </div>
    </div>
  </div>

  <!-- 🌟 Special Offers Section -->
  <section
    v-if="special_offers.length"
    class="special-offers-section text-center py-5 mt-2"
  >
    <div class="container">
      <h3 class="section-title text-gold">
        <i class="fa-solid fa-gift me-2"></i> Special Offers
      </h3>
      <p class="section-subtitle text-muted mb-5">
        Enjoy exclusive offers available for a limited time!
      </p>

      <div class="row justify-content-center">
        <div
          class="col-md-3 col-sm-6 mb-4"
          v-for="(offer, index) in special_offers"
          :key="index"
        >
          <div class="card offer-card border-0 shadow-sm rounded-4">
            <img
              v-if="offer.image"
              :src="getUserImageSrc(offer.image)"
              class="card-img-top offer-image"
              alt="offer"
            />
            <div class="card-body">
              <h5 class="fw-bold text-dark">{{ offer.title }}</h5>
              <p class="small text-muted">{{ offer.text }}</p>
              <a
                :href="offer.url"
                target="_blank"
                class="btn btn-gold btn-sm rounded-pill"
              >
                View Offer <i class="fa-solid fa-arrow-right ms-1"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Start Product Section -->
  <div class="product-section" v-if="related_product.length > 0">
    <div class="container">
      <div class="row">
        <!-- End Column 1 -->
        <div id="swiper-container-3" class="swiper-container">
          <transition-group
            name="fadeInRight"
            tag="div"
            class="text-center"
            mode="out-in"
          >
            <h3 class="title" v-if="related_product.length > 0">
              {{ $t("Discounts Products") }}
            </h3>
            <p v-if="related_product.length > 0">
              {{
                $t(
                  "This section to show our category and choose your products to sales"
                )
              }}
            </p>
          </transition-group>
          <transition-group
            name="fadeInRight"
            tag="div"
            class="swiper-wrapper"
            mode="out-in"
          >
            <!-- <div class="swiper-wrapper"> -->
            <!-- Start Column 2 -->
            <div
              class="col-12 col-md-4 mb-5 mb-md-0 swiper-slide fadeInRight"
              v-for="(prod, index) in related_product"
              :key="index"
            >
              <span class="product-item" @click="viewOfferDetails(prod.id)">
                <!-- <img src="./images/product-1.png" class="img-fluid product-thumbnail" alt="Nordic Chair"> -->
                <img
                  :src="getUserImageSrc(prod.file)"
                  class="img-fluid product-thumbnail img-swipper rounded-top"
                  alt="image"
                />
                <h6 class="item-name">
                  {{ prod.name.slice(0, 15)
                  }}{{ prod.name.length > 15 ? "..." : "" }}
                </h6>
                <strong class="product-price">
                  <span class="text-danger px-1">
                    <del
                      >{{ prod.old_price }}<i class="fa-solid fa-euro-sign"></i
                    ></del>
                  </span>
                  <span
                    >{{ prod.price }} <i class="fa-solid fa-euro-sign"></i
                  ></span>
                </strong>
              </span>
            </div>
            <!-- End Column 2 -->
          </transition-group>
          <!-- </div> -->
          <div v-if="related_product.length > 0">
            <div id="swiper-button-next-3" class="swiper-button-next"></div>
            <div id="swiper-button-prev-3" class="swiper-button-prev"></div>
          </div>
        </div>
        <!-- End Column 2 -->
      </div>
    </div>
  </div>
  <!-- End Product Section -->
</template>

<script>
import Swiper from "swiper";
import "swiper/css/swiper.css";
import { useCartStore } from "../cart/cartStore";

export default {
  data() {
    return {
      sub_product: [],
      categories: [],
      categories3d: [],
      related_product: [],
      ads: [],
      special_offers: [],
      isVisible: false,
      suggestedProducts: [],
    };
  },
  setup() {
    const cartStore = useCartStore();
    return { cartStore };
  },
  methods: {
    checkPaymentSuccess() {
      const paymentSuccess = localStorage.getItem("successPayment");

      if (paymentSuccess === "true") {
        this.cartStore.clearCart();
        localStorage.removeItem("successPayment");
        console.log("تم تفريغ السلة بعد عملية الدفع الناجحة");
      }
    },
    getUserImageSrc(photo) {
      if (photo) {
        return `/storage/${photo}`;
      } else {
        return "/img/load.png";
      }
    },
    async get_sub_product() {
      try {
        const response = await axios.get(`/api/sub-products`);
        this.sub_product = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
    products_sub_products(id) {
      this.$router.push({ name: "show_product_details", params: { id } });
    },
    async get_ads() {
      try {
        const response = await axios.get(`/api/advertisements`, {
          params: {
            type: "banner",
          },
        });
        this.ads = response.data.data;
        this.$nextTick(() => {
          this.initSwiper();
        });
      } catch (error) {
        console.log(error);
      }
    },
    async get_special_offers() {
      try {
        const response = await axios.get(`/api/advertisements`, {
          params: {
            type: "special_offer",
          },
        });
        this.special_offers = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },
    async get_related_products() {
      try {
        const response = await axios.get(`/api/offers`);
        this.related_product = response.data.offers;
        this.$nextTick(() => {
          this.initSwiper();
        });
      } catch (error) {
        console.log(error);
      }
    },
    async get_categories() {
      try {
        const response = await axios.get(`/api/categories`);
        this.categories = response.data.categories;
        this.$nextTick(() => {
          this.initSwiper();
        });
      } catch (error) {
        console.log(error);
      }
    },
    async get_categories3D() {
      try {
        const response = await axios.get(`/api/category_main_3d`);
        this.categories3d = response.data.categories;
        this.$nextTick(() => {
          this.initSwiper();
        });
      } catch (error) {
        console.log(error);
      }
    },
    goToCategory(id) {
      this.$router
        .push({ name: "show_Products_category", params: { id: id } })
        .catch((err) => {});
    },
    goToCategory3D(id) {
      this.$router
        .push({ name: "Categories3d", params: { id: id } })
        .catch((err) => {});
    },
    goToOffer(id) {
      this.$router
        .push({ name: "view_sub_product", params: { id: id } })
        .catch((err) => {});
    },
    viewOfferDetails(id) {
      this.$router.push({ name: "ShowOffer", params: { id: id } });
    },
    initSwiper() {
      const swiperConfigs = [
        {
          id: "#swiper-container-1",
          next: "#swiper-button-next-1",
          prev: "#swiper-button-prev-1",
        },
        {
          id: "#swiper-container-2",
          next: "#swiper-button-next-2",
          prev: "#swiper-button-prev-2",
        },
        {
          id: "#swiper-container-3",
          next: "#swiper-button-next-3",
          prev: "#swiper-button-prev-3",
        },
        {
          id: "#special-offers-swiper",
          next: "#special-offers-next",
          prev: "#special-offers-prev",
        },
        {
          id: "#suggested-products-swiper",
          next: "#suggested-next",
          prev: "#suggested-prev",
        },
      ];

      swiperConfigs.forEach((config) => {
        let swiperContainer = document.querySelector(
          `${config.id} .swiper-wrapper`
        );
        let slidesCount = swiperContainer ? swiperContainer.children.length : 0;

        // Destroy any existing Swiper instance for re-initialization
        if (document.querySelector(config.id)?.swiper) {
          document.querySelector(config.id).swiper.destroy(true, true);
        }

        new Swiper(config.id, {
          slidesPerView: 1,
          spaceBetween: 10,
          loop: slidesCount > 3, // loop only if enough slides
          autoplay: {
            delay: 3000, // 3 seconds
            disableOnInteraction: false,
          },
          navigation: {
            nextEl: config.next,
            prevEl: config.prev,
          },
          breakpoints: {
            576: { slidesPerView: 2 },
            768: { slidesPerView: 3 },
            1200: { slidesPerView: 4 },
          },
          speed: 800, // transition speed
          grabCursor: true,
          centeredSlides: false,
          allowTouchMove: slidesCount > 1,
        });
      });
    },

    handleProductSelected(product) {
      console.log("Product selected from search:", product);
      // Handle any additional logic when a product is selected
    },

    async getSuggestedProducts() {
      try {
        const user = await axios.get(`/getuser`);
        const user_id = user.data.id;
        if (user_id) {
          const response = await axios.get(`/api/products/suggested-products`, {
            params: {
              user_id: user_id,
            },
          });

          this.suggestedProducts = response.data.products;
          this.$nextTick(() => {
            this.initSwiper();
          });
        }
      } catch (error) {
        console.error(error);
      }
    },
  },
  mounted() {
    this.get_related_products();
    this.get_categories();
    this.get_categories3D();
    this.get_sub_product();
    this.get_ads();
    this.get_special_offers();
    this.checkPaymentSuccess();
    this.getSuggestedProducts();
  },
};
</script>

<style scoped>
.carousel-inner {
  width: 100%;
  height: 500px;
  padding-top: 30px;
}

.carousel-item {
  width: 100%;
  height: 100%;
  /* يضمن أن كل العناصر داخل الكاروسيل لها نفس الارتفاع */
}

.carousel-item img {
  width: 100%;
  height: 100%;
  /* يجعل الصورة تملأ العنصر */
  object-fit: cover;
  /* يمنع التشوه ويجعل الصورة تغطي العنصر */
}

/* ✅ ضبط الاستجابة للأجهزة المختلفة */
@media (max-width: 1024px) {
  /* الأجهزة اللوحية */
  .carousel-inner {
    height: 400px;
    /* تقليل الارتفاع للآيباد */
  }
}

@media (max-width: 768px) {
  /* الموبايل */
  .carousel-inner {
    height: 300px;
    /* تقليل الارتفاع للموبايل */
  }
}

.hero {
  width: 100vw;
  height: 500px;
}

.hero .swiper-container {
  width: 100%;
  height: 100%;
}
.swiper-container {
  width: 100%;
  padding: 20px 0;
}

.swiper-slide {
  display: flex;
  justify-content: center;
  align-items: center;
}

.swiper-button-next,
.swiper-button-prev {
  color: #000;
  transition: opacity 0.3s;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
  opacity: 0.7;
}

.hero .swiper-slide {
  display: flex;
  align-items: center;
  justify-content: center;
}

.hero .ad-image {
  width: 100%;
  height: 500px;
  /* جعل الصورة تمتد لكامل الشاشة */
  object-fit: contain;
  /* لضبط الصورة بشكل متناسق */
  transition: transform 0.3s ease-in-out;
}

.hero .ad-image:hover {
  transform: scale(1.03);
}

.hero .swiper-button-next,
.hero .swiper-button-prev {
  color: white;
  /* لون الأسهم */
  background: rgba(0, 0, 0, 0.5);
  /* خلفية نصف شفافة */
  padding: 10px;
  border-radius: 50%;
}

.hero .swiper-pagination-bullet-active {
  background: #ffffff;
  /* لون النقطة النشطة */
}

/* تنسيقات عامة للشرائح */
.swiper-slide {
  width: 100%;
  /* تأكد من أن الشرائح تأخذ العرض الكامل */
  margin-right: 10px;
  /* المسافة بين الشرائح */
  display: flex;
  /* لجعل المحتوى داخل الشريحة يظهر بشكل مرن */
  justify-content: center;
  /* توسيط المحتوى أفقيًا */
  align-items: center;
  /* توسيط المحتوى عموديًا */
  background: transparent !important;
}

/* تنسيقات الصور داخل الشرائح */
.swiper-slide img {
  width: 100%;
  /* العرض الكامل للشريحة */
  height: 150px;
  /* ارتفاع ثابت للصور */
  object-fit: cover;
  /* تغطية المساحة المحددة دون تشويه الصورة */
  border-radius: 8px;
  /* زوايا مدورة للصور */
}

/* تنسيقات عامة لأزرار التنقل */
.swiper-button-next,
.swiper-button-prev {
  position: absolute;
  /* تحديد الموضع المطلق */
  top: 50%;
  /* توسيط عموديًا */
  transform: translateY(-50%);
  /* توسيط عموديًا */
  width: 40px;
  /* عرض الزر */
  height: 40px;
  /* ارتفاع الزر */
  background-color: rgba(0, 0, 0, 0.5);
  /* لون الخلفية مع شفافية */
  border-radius: 50%;
  /* جعل الزر دائريًا */
  color: white;
  /* لون الأيقونة */
  display: flex;
  /* توسيط الأيقونة داخليًا */
  justify-content: center;
  align-items: center;
  cursor: pointer;
  /* تغيير المؤشر إلى يد */
  transition: background-color 0.3s ease;
  /* تأثير انتقالي عند التغيير */
}

/* تغيير لون الخلفية عند التحويم */
.swiper-button-next:hover,
.swiper-button-prev:hover {
  background-color: rgba(0, 0, 0, 0.8);
  /* لون خلفية أغمق عند التحويم */
}

/* تنسيقات الزر التالي (Next) */
.swiper-button-next {
  right: 10px;
  /* تحديد المسافة من الجانب الأيمن */
}

/* تنسيقات الزر السابق (Prev) */
.swiper-button-prev {
  left: 10px;
  /* تحديد المسافة من الجانب الأيسر */
}

/* تنسيقات الأيقونات داخل الأزرار */
.swiper-button-next::after,
.swiper-button-prev::after {
  font-size: 20px;
  /* حجم الأيقونة */
  font-weight: bold;
  /* سمك الخط */
}

/* تعديلات للأجهزة الصغيرة (الموبايل) */
@media (max-width: 576px) {
  .swiper-slide {
    width: calc(33.33% - 10px) !important;
    /* عرض الشريحة لتناسب 3 شرائح */
  }

  .swiper-slide img {
    height: 120px !important;
    /* ارتفاع أقل للصور على الموبايل */
  }
}

.carousel-indicators button {
  background-color: #d9b382 !important;
}

.special-offers-section {
  position: relative;
}

.offer-card {
  transition: all 0.3s ease-in-out;
  background: #fff;
}

.offer-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.offer-image-wrapper {
  height: 180px;
  overflow: hidden;
}

.offer-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: all 0.3s ease;
}

.offer-card:hover .offer-image {
  transform: scale(1.05);
}

/* 🧩 Recommended Products Slider */
.ecommerce-card {
  background-color: #fff;
  transition: all 0.3s ease;
}

.ecommerce-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.btn-gold {
  background-color: #d9b382;
  color: #fff;
  border: none;
  transition: 0.3s;
}

.btn-gold:hover {
  background-color: #c29b67;
}

.swiper-button-next,
.swiper-button-prev {
  color: #d9b382;
  transition: opacity 0.3s;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
  opacity: 0.7;
}

.text-gold {
  color: #d9b382;
}
</style>
