<template>
    <div class="custom-navbar1-container px-2" ref="navbar">
        <div class="custom-logo">
            <h1 class="text-white">
                <a href="/driver/index/" class="text-white">Aslanova</a>
            </h1>
            <div class="navbar-container d-flex content">
            </div>
            <div class="custom-tools">
                <div class="nav-item dropdown dropdown-language">
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
                </div>
                <!-- <Cart /> -->

                <div @click="toggleMenu" class="nav-item">☰</div>

                <div class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar"></span>
                        <!-- <span class="user-name fw-bolder">{{ user.fname }} {{
                            user.lname
                        }}</span> -->
                        
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        <router-link class="dropdown-item" to="/profile">
                            <i class="me-50" data-feather="user"></i>{{ $t('Profile') }}
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <!-- <div class="dropdown-item" @click="logout">
                            <i class="me-50" data-feather="power"></i>{{ $t('Logout') }}
                        </div> -->

                        <a class="dropdown-item" href="/driver/driver/logout"><i class="me-50"
                                data-feather="power"></i>{{
                                    $t('Logout') }}
                        </a>
                    </div>
                </div>

            </div>

        </div>
        <nav :class="{ 'custom-nav-open': menuOpen }" class="custom-navbar1">
            <ul class="custom-nav-list">
                <li v-for="(item, index) in navItems" :key="item.id" class="custom-nav-item"
                    :class="{ active: isActive(index + 1) }">
                    <router-link class="nav-link" :to="item.link" @click="setActive(index + 1)">
                        <span class="menu-title">{{ $t(item.label) }}</span>
                    </router-link>
                </li>

                <div class="custom-nav-item dropdown">
                    <a class="nav-link dropdown-item" id="dropdown-flag" href="#" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span>{{ $t("Products3D") }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                        <a v-for="(subItem, code) in dropdownItems" :key="code" class="dropdown-item" href="#">
                            <router-link class="custom-dropdown-item" :to="subItem.link">
                                {{ $t(subItem.label) }}
                            </router-link>
                        </a>
                    </div>
                </div>
                <div class="custom-nav-item dropdown">
                    <a class="nav-link dropdown-item" id="dropdown-flag" href="#" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span>{{ $t("Payment") }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                        <a v-for="(subItem, code) in dropdownItemPayment" :key="code" class="dropdown-item" href="#">
                            <router-link class="custom-dropdown-item" :to="subItem.link">
                                {{ $t(subItem.label) }}
                            </router-link>
                        </a>
                    </div>
                </div>
            </ul>
        </nav>
        <div class="custom-other-tools">
            <!-- <Cart /> -->
            <div class="nav-item dropdown dropdown-language">
                <a class="nav-link dropdown-item" id="dropdown-flag" href="#" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="selected-language">{{ $t(currentLanguage.name) + " " }}
                    </span>
                    <i :class="`${currentLanguage.icon}`"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                    <a v-for="(lang, code) in languages" :key="code" @click="changeLanguage(code)" class="dropdown-item"
                        href="#">
                        <span>{{ $t(lang.name) + " " }} </span>
                        <i :class="` ${lang.icon}`"></i>
                    </a>
                </div>
            </div>

            <div class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="avatar"></span>
                    <!-- <span class="user-name fw-bolder">{{ user.fname }} {{
                        user.lname
                    }}</span>  -->
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <router-link class="dropdown-item" to="/profile">
                        <i class="me-50" data-feather="user"></i>{{ $t('Profile') }}
                    </router-link>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/driver/driver/logout"><i class="me-50"
                        data-feather="power"></i>
                        {{$t('Logout') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { loadLanguageAsync } from 'laravel-vue-i18n';
import axios from 'axios';
// import Cart from '../../components/cart/Cart.vue';

export default {
    data() {
        return {
            activeLink: 1,
            currentLang: 'en',
            menuOpen: false,
            dropdownOpen: {},
            languages: {
                en: { name: "English", icon: "fa-solid fa-globe", code: "en" },
                ar: { name: "Arabic", icon: "flag-icon flag-icon-sa", code: "ar" },
                tr: { name: "Turkey", icon: "flag-icon flag-icon-tr", code: "tr" },
                de: { name: "German", icon: "flag-icon flag-icon-de", code: "de" }
            },

            navItems: [
                { id: 6, label: 'Dashboards', link: '/' },
                { id: 9, label: 'categories', link: '/categories' },
                // { id: 10, label: 'Products', link: '/products' },
                { id: 11, label: 'offers', link: '/Offer' },
                { id: 12, label: 'Ads', link: '/ads' },

            ],
            dropdownItems: [
                { id: 6, label: 'CategoryMain3D', link: '/Category-Main-3d' },
                { id: 7, label: 'Parts3D', link: '/parts-3d' },
                { id: 8, label: 'Materiales3D', link: '/materials-3d' },
            ],
            dropdownItemPayment: [
                { id: 9, label: 'Email payment', link: '/email-payment' },
                { id: 10, label: 'Paypal payment', link: '/paypal-payment' },
            ],
            user: null,
        };
    },
    computed: {
        currentLanguage() {
            return this.languages[this.currentLang];
        },
    },
    methods: {
        toggleMenu() {
            console.log(this.menuOpen);

            this.menuOpen = !this.menuOpen;
            console.log(this.menuOpen);

        },
        changeLanguage(language) {
            loadLanguageAsync(language);
            axios.get(`/lang/${language}`);
            this.currentLang = language;
        },
        toggleDropdown(index) {
            this.dropdownOpen[index] = !this.dropdownOpen[index]; // تحديث القيمة مباشرة
        },
        isActive(index) {
            return this.activeLink === index;
        },
        setActive(index) {
            this.activeLink = index;
            this.menuOpen = false;
            this.dropdownOpen = {}; // إغلاق جميع القوائم المنسدلة
        },
        getuser() {
            axios.get("/get-admin").then((response) => {
                this.user = response.data.adminInfo;
                console.log("user menu : ", this.user);
            });
        },

        logout() {
            try {
                axios.get('/driver/driver/logout');
                this.user = null;
                this.$router.push('/driver/login');
            } catch (error) {
                console.error("Error during logout:", error);
            }
        },

        handleClickOutside(event) {
            const navbar = this.$refs.navbar;
            if (navbar && !navbar.contains(event.target)) {
                // console.log("lssdl,lasvl,las");

                this.menuOpen = false;
                this.dropdownOpen = {};
            }
        },
    },
    mounted() {
        this.getuser();
        loadLanguageAsync(this.currentLang);
        document.addEventListener('click', this.handleClickOutside);
    },
    beforeDestroy() {
        document.removeEventListener('click', this.handleClickOutside);
    },
    // components: { Cart }
};
</script>

<style scoped>
.dropdown-menu-end {
    color: white !important;
}

.selected-language {
    color: white !important;
}

.dropdown-language {
    color: var(--mainColor) !important;
}

.dropdown-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.custom-navbar1-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    background-color: var(--mainColor);
    color: white !important;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0px 5px 15px gray;
}

.custom-logo {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    color: white;
    width: fit-content;
}

.custom-tools {
    display: none;
    color: white !important;
}

.custom-navbar1 {
    display: flex;
    width: 100%;
    justify-content: center;
    align-items: center;
}

nav {
    transition: all 1s ease;
}

.custom-other-tools {
    width: 150px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.custom-nav-open {
    display: flex;
}

.custom-nav-list {
    list-style-type: none;
    padding: 0;
    margin: 0;
    display: flex;
}

.custom-nav-item {
    position: relative;
}

.nav-link {
    display: block;
    padding: 10px;
    color: white !important;
    text-decoration: none;
    transition: background 0.3s;
}

.custom-nav-link:hover {
    color: white;
}

.custom-dropdown {
    cursor: pointer;
}

.custom-dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background-color: white;
    border: 1px solid #ccc;
    z-index: 1;
    min-width: 200px;
    list-style: none;
    padding: 0;
}

.custom-dropdown-menu .custom-dropdown-item {
    padding: 10px 20px;
    color: var(--mainColor);
    text-decoration: none;
}

.custom-dropdown-menu .custom-dropdown-item:hover {
    color: var(--mainColor);
}

@media (max-width: 1000px) {
    .custom-other-tools {
        display: none;
    }

    .custom-logo {
        width: 100%;
    }

    .custom-navbar1-container {
        flex-direction: column;
        padding: 0px !important;
    }

    .custom-navbar1 {
        flex-direction: column !important;
        padding: 0px;
    }

    .custom-nav-list {
        flex-direction: column;
        width: 100%;
    }

    .custom-tools {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        color: white !important;
    }

    .custom-nav-item {
        display: none;
    }

    .custom-nav-open .custom-nav-item {
        display: block;
        width: 100%;
    }
}
</style>
