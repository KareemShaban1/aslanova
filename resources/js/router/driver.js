import { createRouter, createWebHistory } from 'vue-router'
import DriverDashboard from '../driver/DriverDashboard.vue'
import DriverProfile from '../driver/profile/DriverProfile.vue'
import DriverEditProfile from '../driver/profile/DriverEditProfile.vue'
import Allusers from '../driver/users/All-users.vue'
import UserInfo from '../driver/users/UserInfo.vue'
import Unauthenticated from '../driver/Unauthenticated.vue'
// ------------------------------- table -------------------------------
import All_category from '../driver/table/category/All_category.vue'
import Ads from '../driver/table/ads/Ads.vue'
import Products_category from '../driver/table/category/Products_category.vue'
import Add_product_category from '../driver/table/category/Add_product_category.vue'
import All_products from '../driver/table/products/All_products.vue'
import Sub_products from '../driver/table/products/Sub_products.vue'
import Add_sub_product from '../driver/table/products/Add_sub_product.vue'
import Emailpayment from '../driver/table/payment/Emailpayment.vue'
import Paypalpayment from '../driver/table/payment/Paypalpayment.vue'


// ------------------------------- Show Cards -------------------------------
import Categories from '../components/show/category/Categories.vue'

//3d
import Categories3d from '../components/show/3d/category/Categories.vue'
import show_Products3d_category from '../components/show/3d/product/show_products3d_category.vue'

// show_Products3d_category
import show_Products_category from '../components/show/product/show_products_category.vue'
import Sub_product2 from '../components/show/sub_products/Sub_product2.vue'
import View_sub_product from '../driver/table/products/View_sub_product.vue'
import Edit_sub_product from '../driver/table/products/Edit_sub_product.vue'
import ShowOffer from '../components/show/Offer/ShowOffer.vue'
// ------------------------------- 3D routes ----------------------------------
import Category_3d from '../driver/table/section_3d/Category_3d/index.vue'
import category_main_3d from '../driver/table/section_3d/Category_3d/MainCategory_3d.vue'
import Products3d_category from '../driver/table/section_3d/Category_3d/product.vue'
import Parts_3d from '../driver/table/section_3d/parts/index.vue'
import Texture_3d from '../driver/table/section_3d/textures/index.vue'
import Materials_3d from '../driver/table/section_3d/materials/index.vue'
import Product_3d from '../3D_Product/3D_Product.vue'
import editproduct_3d from '../3D_Product/3d_editproduct.vue'
// ------------------------------- check out ----------------------------------
import Checkout from '../components/show/checkout/checkout.vue'
import Offer from '../driver/table/Offer/Offer.vue'

var router = createRouter({
  history: createWebHistory("/driver/index/"),
  routes: [
    {
      path: '/',
      component: DriverDashboard,
      name: 'driverDashboard'
    },
    {
      path: '/profile',
      component: DriverProfile,
      name: 'driverProfile'
    },
    {
      path: '/profile/:id/edit',
      component: DriverEditProfile,
      name: 'admin_edit_profile',
    },
    {
      path: '/show/all-user',
      component: Allusers,
      name: 'all-users',
      props: true
    },
    {
      path: '/show/:id/user',
      component: UserInfo,
      name: 'user-info',
      props: true
    },
    {
      path: '/unauthenticated',
      name: 'Unauthenticated',
      component: Unauthenticated,
    },
    // ---------- table ----------
    {
      path: '/ads',
      component: Ads,
      name: 'Ads',
    },
    {
      path: '/categories',
      component: All_category,
      name: 'all_category',
    },
    {
      path: '/products-category/:id',
      component: Products_category,
      name: 'products_category',
      props: true
    },
    {
      path: '/add-products-category/:id',
      component: Add_product_category,
      name: 'add_product_category',
      props: true
    },
    {
      path: '/products',
      component: All_products,
      name: 'all_products',
    },
    {
      path: '/Offer',
      component: Offer,
      name: 'Offer',
    },
    
    {
      path: '/sub-products/:id',
      component: Sub_products,
      name: 'sub_products',
      props: true
    },

    {
      path: '/ShowOffer/:id',
      component: ShowOffer,
      name: 'ShowOffer',
      props: true
    },
    
    {
      path: '/add-sub-products/:id',
      component: Add_sub_product,
      name: 'add_sub_product',
      props: true
    },
    // --------------- show
    {
      path: '/dashboard/categories',
      component: Categories,
      name: 'Categories',
    },

    {
      path: '/dashboard/categories3d',
      component: Categories3d,
      name: 'Categories3d',
    },
    {
      path: '/show-products3d/:id',
      component: show_Products3d_category,
      name: 'show_Products3d_category',
      props: true
    },

    {
      path: '/show-products/:id',
      component: show_Products_category,
      name: 'show_Products_category',
      props: true
    },
    {
      path: '/show-sub-products/:id',
      component: Sub_product2,
      name: 'Sub_product2',
      props: true
    },
    {
      path: '/view-sub-product/:id',
      component: View_sub_product,
      name: 'view_sub_product',
      props: true
    },
    {
      path: '/edit-sub-product/:id',
      component: Edit_sub_product,
      name: 'Edit_sub_product',
      props: true
    },
    {
      path: '/checkout',
      component: Checkout,
      name: 'Checkout',
    },
    // --------------- 3D routes
    // --------------- products 3d

    {
      path: '/product-3d/:id',
      component: Product_3d,
      name: 'product_3d',
    },
    {
      path: '/editproduct_3d/:id',
      component: editproduct_3d,
      name: 'editproduct_3d',
      props: true
    },
    {
      path: '/Products3d_category/:id',
      component: Products3d_category,
      name: 'Products3d_category',
    },
    {
      path: '/Category-3d/:id',
      component: Category_3d,
      name: 'Category_3d',
    },
    {
      path: '/Category-Main-3d',
      component: category_main_3d,
      name: 'category_main_3d',
    },
    // --------------- part
    {
      path: '/parts-3d',
      component: Parts_3d,
      name: 'parts_3d',
    },
    // --------------- part
    {
      path: '/texture-3d/:id',
      component: Texture_3d,
      name: 'texture_3d',
    },
    // --------------- Materials_3d
    {
      path: '/materials-3d',
      component: Materials_3d,
      name: 'materials_3d',
    },
    // --------------- Emailpayment
    {
      path: '/email-payment',
      component: Emailpayment,
      name: 'emailpayment',
    },
    // --------------- paypalpayment
    {
      path: '/paypal-payment',
      component: Paypalpayment,
      name: 'paypalpayment',
    },

  ]
});


export default router
