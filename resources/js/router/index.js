import { createRouter, createWebHistory } from "vue-router";
import CustomerProfile from "../customer/profile/Customer_profile.vue";
import EditProfile from "../customer/profile/Edit_profile.vue";
import Mainpage from "../customer/pages/Mainpage.vue";
import Categories from "../components/show/category/Categories.vue";
import show_Products_category from "../components/show/product/show_products_category.vue";
import Sub_product2 from "../components/show/sub_products/Sub_product2.vue";
import View_sub_product from "../components/show/sub_products/View_sub_product.vue";
import HomeCarousel from "../customer/layout/HomeCarousel.vue";
import Product_3d from "../3D_Product/3D_Product.vue";
import Categories3d from "../components/show/3d/category/Categories.vue";
import show_Category3d_CategoryMain from "../components/show/3d/categoryMain/categoryMain.vue";
import Offer from "../components/show/Offer/Offer.vue";
import show_Products3d_category from "../components/show/3d/product/show_products3d_category.vue";
import Orders from "../components/show/orders/Orders.vue";
import Cart from "../components/cart/Cart.vue";
import Home from "../components/pages/Home.vue";
import About from "../components/pages/About.vue";
import Services from "../components/pages/Services.vue";
import Contact from "../components/pages/Contact.vue";
import ShowOffer from "../components/show/Offer/ShowOffer.vue";
import CartView from "../components/cart/CartView.vue";
import CartViewOrder from "../components/cart/CartViewOrder.vue";
import AGB from "../components/pages/footer/Agb.vue";
import Datenschutzerklarung from "../components/pages/footer/Datenschutzerklarung.vue";
import Impressum from "../components/pages/footer/Impressum.vue";
import Kunden_info from "../components/pages/footer/Kunden_info.vue";
// ----------------------- Payments --------------------
import Emailpayment from "../components/pages/payment/Emailpayment.vue";
import Paypalpayment from "../components/pages/payment/Paypalpayment.vue";
const routes = [
    {
        path: "/",
        component: Home,
        name: "Home",
    },
    {
        path: "/dashboard/about",
        component: About,
        name: "About",
    },
    {
        path: "/dashboard/cart",
        name: "CartView",
        component: CartView,
    },
    {
        path: "/dashboard/order",
        name: "CartViewOrder",
        component: CartViewOrder,
    },

    {
        path: "/dashboard/services",
        component: Services,
        name: "Services",
    },

    {
        path: "/dashboard/Contact",
        component: Contact,
        name: "Contact",
    },

    {
        path: "/dashboard/Offer",
        component: Offer,
        name: "Offer",
    },
    {
        path: "/dashboard/profile",
        component: CustomerProfile,
        name: "profile",
    },
    {
        path: "/dashboard/profile/:id/edit",
        component: EditProfile,
        name: "edit_profile",
    },

    // --------------- show
    {
        path: "/dashboard/categories",
        component: Categories,
        name: "Categories",
    },
    {
        path: "/dashboard/show-products/:id",
        component: show_Products_category,
        name: "show_Products_category",
        props: true,
    },
    {
        path: "/dashboard/ShowOffer/:id",
        component: ShowOffer,
        name: "ShowOffer",
        props: true,
    },
    {
        path: "/dashboard/show-sub-products/:id",
        component: Sub_product2,
        name: "Sub_product2",
        props: true,
    },
    {
        path: "/dashboard/view-sub-product/:id",
        component: View_sub_product,
        name: "view_sub_product",
        props: true,
    },

    // ---------------- Orders and Cart -----------------
    {
        path: "/dashboard/orders",
        component: Orders,
        name: "orders",
    },
    {
        path: "/dashboard/cart",
        component: Cart,
        name: "cart",
    },

    //3d
    {
        path: "/dashboard/product-3d/:id",
        component: Product_3d,
        name: "product_3d",
    },
    {
        path: "/dashboard/show_Category3d_CategoryMain",
        component: show_Category3d_CategoryMain,
        name: "show_Category3d_CategoryMain",
    },
    {
        path: "/dashboard/categories3d/:id",
        component: Categories3d,
        name: "Categories3d",
    },
    {
        path: "/dashboard/show-products3d/:id",
        component: show_Products3d_category,
        name: "show_Products3d_category",
        props: true,
    },

    // ----- Footer

    {
        path: "/dashboard/agb",
        component: AGB,
        name: "agb",
    },
    {
        path: "/dashboard/datenschutzerklarung",
        component: Datenschutzerklarung,
        name: "datenschutzerklarung",
    },
    {
        path: "/dashboard/impressum",
        component: Impressum,
        name: "impressum",
    },
    {
        path: "/dashboard/kunden_info",
        component: Kunden_info,
        name: "kunden_info",
    },
    // --------------- Emailpayment
    {
        path: "/dashboard/email-payment",
        component: Emailpayment,
        name: "emailpayment",
    },
    // --------------- paypalpayment
    {
        path: "/dashboard/paypal-payment",
        component: Paypalpayment,
        name: "paypalpayment",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return { top: 0 };
    },
});

export default router;
