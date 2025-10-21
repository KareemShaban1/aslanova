<template>
    <Menu />
    <section>
        <router-view :key="$route.fullPath"></router-view>
    </section>

    <Footer />
</template>

<script>
import Menu from '../components/layout/Menu.vue';
import Footer from '../components/layout/FooterWeb.vue';

import axios from 'axios'


export default {
    components: { Menu, Footer },
    data() {
        return {
            user: [],
        }
    },
    methods: {
        getuser() {
            axios.get("/getuser").then((response) => {
                this.user = response.data;
            });
        },

    },
    mounted() {
        this.getuser();
    },

}
</script>

<style>
a{
    text-decoration: none;
}
.content-header {
    padding: 20px;
}

.hero {
    margin: 20px !important;
    border-radius: 20px;
}

@media (max-width:576px) {
    .hero .col-lg-7 {
        display: none;
    }

}
</style>
<style>
.cat-hover {
    cursor: pointer;
}

.card-img-top {
    width: 85% !important;
}

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

.filter-heading {
    font-weight: bold;
    margin-bottom: 10px;
}

.ecommerce-card {
    margin-bottom: 20px;
    max-width: 350px;
    flex: 1 1 350px;
}


.ecommerce-application{
    padding: 0px 20px !important;
    min-height: 85vh;
}
.content-wrapper{
    margin: 0px 67px !important;
}

.ecommerce-searchbar{
    gap: 10px;
    align-items: center !important;
}
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
    .content-wrapper{
        margin: 0px 10px !important;
    }
}

.btn-wishlist.disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
