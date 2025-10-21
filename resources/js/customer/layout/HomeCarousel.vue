<template>
  <div class="main-sec">
    <div class="overlay">
      <div class="content">
        <h1 class="text-light">{{ $t('Hello in our website') }}</h1>
        <div>
          <router-link to="/dashboard/categories" class="btn btn-primary">{{ $t('Our category') }}</router-link>
        </div>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="mt-4 mb-2 text-center">
      <h4>{{ $t("Related Products") }}</h4>
      <p class="card-text">{{ $t("People also search for this items") }}</p>
    </div>
    <div class="swiper-container">
      <div class="swiper-wrapper ">
        <div class="swiper-slide slide-style" v-for="(prod, index) in related_product" :key="index">
          <div @click="products_sub_products(prod.id)">
            <div class="item-heading">
              <!-- <h5 class="text-truncate mb-0">{{ prod.name }}</h5> -->
              <!-- <small class="text-body">by Apple</small> -->
            </div>
            <div class="img-container w-50 mx-auto py-75">
              <img :src="getUserImageSrc(prod.file)" class="img-fluid" alt="image" />
            </div>
            <div class="item-meta">
              <p class="card-text text-primary mb-0">
                {{ prod.name }}
              </p>
            </div>
          </div>
        </div>

      </div>
      <!-- Add Arrows -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </div>
</template>

<script>
import Swiper from "swiper";
import "swiper/css/swiper.css"; // Import Swiper styles
export default {
  data() {
    return {
      // sub_product: [],
      related_product: []
    };
  },
  methods: {
    getUserImageSrc(photo) {
      if (photo) {
        return `/storage/${photo}`;
      } else {
        return '/img/load.png';
      }
    },

    //   async get_sub_product_info() {
    //     try {
    //       const response = await axios.get(`/api/sub-products/${this.id}`);
    //       this.sub_product = response.data.data;
    //     } catch (error) {
    //       console.log(error);
    //     }
    //   },
    async get_related_products() {
      try {
        const response = await axios.get(`/api/categories`);
        this.related_product = response.data.categories;
        console.log('categories: ', this.related_product);
        this.$nextTick(() => {
          this.initSwiper();
        });
      } catch (error) {
        console.log(error);
      }
    },
    initSwiper() {
      new Swiper(".swiper-container", {
        slidesPerView: 1, // Default to 1 slide per view
        // spaceBetween: 30,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        breakpoints: {
          1000: { // For medium screens (e.g., tablets)
            slidesPerView: 3, // 2 slides per view
          },
          768: { // For medium screens (e.g., tablets)
            slidesPerView: 2, // 2 slides per view
          },
          576: { // For small screens (e.g., mobile)
            slidesPerView: 1, // 1 slide per view
          },
        },
      });
    },
    products_sub_products(id) {
      this.$router.push({ name: "Sub_product2", params: { id } });
    },

  },
  mounted() {
    this.get_related_products();
  },
};
</script>

<style>
/* Add any necessary styles for Swiper */
.swiper-container {
  width: 100%;
  padding: 20px 0;
}

.swiper-slide {
  text-align: center;
  font-size: 18px;
  background: #fff;
  /* Center slide text vertically */
  display: -webkit-box;
  display: -ms-flexbox;
  display: -webkit-flex;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  -webkit-justify-content: center;
  justify-content: center;
  -webkit-box-align: center;
  -ms-flex-align: center;
  -webkit-align-items: center;
  align-items: center;
}

.img-container {
  display: flex;
  justify-content: center;
  align-items: center;
}

.slide-style {
  background: #f8f8f8 !important;
  padding: 10px 0px;
  cursor: pointer;
}

.dark-layout .slide-style {
  background: #161d31 !important;
  padding: 10px 0px;
}

.main-sec {
  background-image: url(/img/website/sofa.webp);
  width: 100%;
  height: 50vh;
  background-position: center;
  background-size: cover;
  background-repeat: no-repeat;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  border-radius: 15px;
  /* Adding rounded corners to the main section */
  overflow: hidden;
  /* Ensures the background image respects the border radius */
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  /* Adjust the transparency here */
  display: flex;
  justify-content: center;
  align-items: center;
}

.main-sec .content {
  position: relative;
  text-align: center;
}

.main-sec .content h1 {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 1rem;
}

.main-sec .content .btn {
  padding: 0.75rem 1.5rem;
  font-size: 1.25rem;
}
</style>
