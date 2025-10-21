



<template>
    <nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center navbar-light"
        data-nav="brand-center" style="background: inherit; box-shadow: inherit;">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="#"><svg
                                xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-menu ficon">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg></a></li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">
                <li class="nav-item dropdown dropdown-language">
                    <a class="nav-link dropdown-item" id="dropdown-flag" href="#" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="selected-language">{{ $t(currentLanguage.name) + " " }}
                        </span>
                        <i :class="`${currentLanguage.icon}`"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                        <a v-for="(lang, code) in languages" :key="code" @click="changeLanguage(code)"
                            class="dropdown-item" href="#">
                            <span>{{ $t(lang.name) + " " }} </span>
                            <i :class="` ${lang.icon}`"></i>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                        id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder">{{ user.fname }} {{
                            user.lname
                                }}</span><span class="user-status">{{ $t('Driver') }}</span></div><span class="avatar">
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user"><router-link
                            class="dropdown-item" to="/profile"><i class="me-50" data-feather="user"></i>{{
                                $t('Profile') }}
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/driver/driver/logout"><i class="me-50"
                                data-feather="power"></i>{{
                                    $t('Logout') }}</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="horizontal-menu-wrapper">

        <div class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-shadow menu-border container-xxl navbar-light"
            role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
            <div class="navbar-header">

            </div>
            <div class="shadow-bottom"></div>

            <!-- Horizontal menu content-->
            <div class="navbar-container">
                <!-- include ../../../includes/mixins-->
                <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                    <li class=" nav-item sidebar-group-active active open" data-menu="dropdown">
                        <router-link class="d-flex align-items-center" to="/">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg><span class="menu-title text-truncate">{{ $t("Dashboards") }}</span>
                        </router-link>
                    </li>
                    <li class="dropdown nav-item" data-menu="dropdown">
                        <a class="dropdown-toggle nav-link d-flex align-items-center" href="#"
                            data-bs-toggle="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-package">
                                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                </path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            <span>{{ $t("Table") }}</span>
                            <!-- <i data-feather="more-horizontal"></i> -->
                        </a>
                        <ul class="dropdown-menu" data-bs-popper="none">

                            <li data-menu="">
                                <router-link class="dropdown-item d-flex align-items-center" to="/categories">
                                    <i data-feather="book-open"></i><span class="menu-title text-truncate">{{
                                        $t("Category") }}</span>
                                </router-link>
                            </li>
                            <li data-menu="">
                                <router-link class="dropdown-item d-flex align-items-center" to="/products">
                                    <i data-feather="truck"></i><span class="menu-title text-truncate">{{ $t("Product")
                                        }}</span>
                                </router-link>
                            </li>
                            <li data-menu="">
                                <router-link class="dropdown-item d-flex align-items-center" to="/Offer">
                                    <i data-feather="truck"></i><span class="menu-title text-truncate">{{ $t("Offer")
                                        }}</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown nav-item" data-menu="dropdown">
                        <a class="dropdown-toggle nav-link d-flex align-items-center" href="#"
                            data-bs-toggle="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-package">
                                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                </path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            <span>{{ $t("Show") }}</span>
                            <!-- <i data-feather="more-horizontal"></i> -->
                        </a>
                        <ul class="dropdown-menu" data-bs-popper="none">
                            <li data-menu="">
                                <router-link class="dropdown-item d-flex align-items-center" to="/dashboard/categories">
                                    <i data-feather="truck"></i><span class="menu-title text-truncate">{{
                                        $t("Categories") }}</span>
                                </router-link>
                            </li>
                            <li data-menu="">

                                <router-link class="dropdown-item d-flex align-items-center" to="/dashboard/categories3d">
                                    <i data-feather="truck"></i><span class="menu-title text-truncate">{{
                                        $t("categories3d") }}</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown nav-item" data-menu="dropdown">
                        <a class="dropdown-toggle nav-link d-flex align-items-center" href="#"
                            data-bs-toggle="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-package">
                                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                </path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            <span>{{ $t("Product 3D") }}</span>
                            <!-- <i data-feather="more-horizontal"></i> -->
                        </a>
                        <ul class="dropdown-menu" data-bs-popper="none">
                            <li data-menu="">
                                <router-link class="dropdown-item d-flex align-items-center" to="/Category-Main-3d">
                                    <i data-feather="truck"></i> <span class="menu-title text-truncate">{{
                                        $t("Category Main 3d") }}</span>
                                </router-link>
                            </li>
                            <li data-menu="">
                                <router-link class="dropdown-item d-flex align-items-center" to="/parts-3d">
                                    <i data-feather="truck"></i><span class="menu-title text-truncate">{{ $t("Parts 3D")
                                        }}</span>
                                </router-link>
                            </li>
                            <li data-menu="">
                                <router-link class="dropdown-item d-flex align-items-center" to="/materials-3d">
                                    <i data-feather="truck"></i><span class="menu-title text-truncate">{{
                                        $t("Materiales3D") }}</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</template>

<script>
import axios from "axios";
import { t } from "laravel-vue-i18n";
import { loadLanguageAsync } from "laravel-vue-i18n";
import { getActiveLanguage } from "laravel-vue-i18n";

export default {
    data() {
        return {
            user: [],
            // currentLang: getActiveLanguage(),
            currentLang: 'en',
            languages: {
                en: { name: "English", icon: "fa-solid fa-globe", code: "en" },
                ar: { name: "Arabic", icon: "flag-icon flag-icon-sa", code: "ar" },
                tr: { name: "Turkey", icon: "flag-icon flag-icon-tr", code: "tr" },
            },
        };
    },
    computed: {
        currentLanguage() {
            return this.languages[this.currentLang];
        },
    },
    methods: {

        getuser() {
            axios
                .get("/get-admin")
                .then((response) => {
                    this.user = response.data.adminInfo;
                    console.log(this.user);

                    if (!this.user) {
                        window.location.href = "/driver/index";
                    }
                })
                .catch((error) => {
                    if (error.response.status === 403) {
                        this.$router.push({ name: "Unauthenticated" });
                    } else {
                        console.error(error);
                    }
                });
        },
        getUserImageSrc() {
            if (this.user.personImage) {
                return "/img/" + this.user.personImage;
            } else {
                return "/app-assets//images/portrait/small/avatar-s-11.jpg";
            }
        },
        changeLanguage(language) {
            loadLanguageAsync(language);
            axios.get(`/lang/${language}`);
            this.currentLang = language;
        },
    },
    mounted() {
        this.getuser();
        loadLanguageAsync('en');
    },
    watch: {
        "$route.path": function (newPath) {
            if (newPath === "/profile") {
                this.getuser();
            }
        },
    },
};
</script>

<style scoped>
.navbar-container {
    background-color: #fff !important;
}

.dark-layout .navbar-container {
    background-color: #283046 !important;
}
</style>
