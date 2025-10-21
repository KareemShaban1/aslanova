<template>
    <!-- <h1>wewew</h1> -->
    <!-- <router-link to="/profile">profile</router-link> <br>
    <a href="/driver/driver/logout">logout</a> -->

    <DriverMenu />
    <div class="app-content content ">
        <router-view :key="$route.fullPath"></router-view>

    </div>
</template>

<script>
import DriverMenu from './layouts/Menu.vue'
export default {
    components: { DriverMenu }
}
</script>

<style>
a {
    text-decoration: none;
}
.app-content{
    padding-top: 5% !important;
}
.cat-hover {
    cursor: pointer;
}

.card-img-top {
    width: 85% !important;
}

/* تحسين مظهر أزرار الترقيم */
.pagination .page-item .page-link {
    color: #007bff;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    cursor: default;
}

/* تحسين مظهر الفلاتر */
.filter-heading {
    font-weight: bold;
    margin-bottom: 10px;
}

/* تحسين مظهر بطاقة المنتجات */
.ecommerce-card {
    margin-bottom: 20px;
    max-width: 350px;
    flex: 1 1 350px;
    /* يسمح للبطاقة بالنمو والإنكماش ولكن لا يقل عرضها عن 350px */
}

/* تحسين استجابة التصميم للبطاقات */
@media (max-width: 1200px) {
    .ecommerce-card {
        flex: 1 1 300px;
        min-width: 300px;
    }
}

@media (max-width: 768px) {
    .ecommerce-card {
        flex: 1 1 100%;
        min-width: 100%;
    }
}

/* تحسين مظهر الزر غير النشط */
.btn-wishlist.disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>