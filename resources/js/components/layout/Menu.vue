<template>
    <div class="custom-navbar1-container px-2" ref="navbar">
        <div class="custom-logo">
            <h1 class="text-white">
                <a href="/" class="text-white">Aslanova</a>
            </h1>
           
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
                <Cart />

                <div @click="toggleMenu" class="nav-item">☰</div>

                <div v-if="user" class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar"></span>
                        <span class="user-name fw-bolder">{{ user.fname }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        <router-link class="dropdown-item" to="/dashboard/profile">
                            <i class="me-50" data-feather="user"></i>
                            {{ $t('Profile') }}
                        </router-link>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item" @click="logout">
                            <i class="me-50" data-feather="power"></i>
                            {{ $t('Logout') }}
                        </div>
                    </div>
                </div>
                <div v-else>
                    <a class="nav-link" href="/login">{{ $t('Login') }}</a>
                </div>

            </div>

        </div>
        <nav :class="{ 'custom-nav-open': menuOpen }" class="custom-navbar1">
            <!-- Mobile Search -->
            <div class="mobile-search-container" v-if="menuOpen">
                <SearchComponent placeholder="Search products..." />
            </div>
            
            <ul class="custom-nav-list">
                <li v-for="(item, index) in navItems" :key="item.id" class="custom-nav-item"
                    :class="{ active: isActive(index + 1) }">
                    <router-link class="nav-link" :to="item.link" @click="setActive(index + 1)">
                        <span class="menu-title">{{ $t(item.label) }}</span>
                    </router-link>
                </li>

                <!-- <div class="custom-nav-item dropdown">
                    <a class="nav-link dropdown-item" id="dropdown-flag" href="#" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span>{{ $t("Payment") }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
                        <a v-for="(subItem, code) in dropdownItems" :key="code" class="dropdown-item" href="#">
                            <router-link class="custom-dropdown-item" :to="subItem.link">
                                {{ $t(subItem.label) }}
                            </router-link>
                        </a>
                    </div>
                </div> -->
            </ul>
        </nav>
        <div class="navbar-container d-flex content">
	<div class="search-container" style="width: 400px;">
	    <SearchComponent placeholder="Search products..." />
	</div>
      </div>
        <div class="custom-other-tools mx-4">
            <Cart />
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
     
            <div v-if="user" class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="avatar"></span>
                    <span class="user-name fw-bolder">{{ user.fname }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <router-link class="dropdown-item" to="/dashboard/profile">
                        <i class="me-50" data-feather="user"></i>{{ $t('Profile') }}
                    </router-link>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-item" @click="logout">
                        <i class="me-50" data-feather="power"></i>{{ $t('Logout') }}
                    </div>
                </div>
            </div>
            <div v-else>
                <a class="nav-link" href="/login">{{ $t('Login') }}</a>
            </div>
        </div>
    </div>
</template>

<script>
import { loadLanguageAsync } from 'laravel-vue-i18n';
import axios from 'axios';
import Cart from '../../components/cart/Cart.vue';
import SearchComponent from '../common/SearchComponent.vue';

export default {
    data() {
        return {
            activeLink: 1,
            currentLang: 'en',
            menuOpen: false,
            dropdownOpen: {},
            currentLang: 'en',
            languages: {
                en: { name: "En", icon: "fa-solid fa-globe", code: "en" },
                ar: { name: "Ar", icon: "flag-icon flag-icon-sa", code: "ar" },
                tr: { name: "Tr", icon: "flag-icon flag-icon-tr", code: "tr" },
                de: { name: "De", icon: "flag-icon flag-icon-de", code: "de" }
            },

            navItems: [
                { id: 6, label: 'home', link: '/' },
                { id: 9, label: 'categories', link: '/dashboard/categories' },
                { id: 10, label: 'CategoriesMain3d', link: '/dashboard/show_Category3d_CategoryMain' },
                { id: 11, label: 'offers', link: '/dashboard/Offer' },

            ],
            dropdownItems: [
                // { id: 9, label: 'Email payment', link: '/dashboard/email-payment' },
                // { id: 10, label: 'Paypal payment', link: '/dashboard/paypal-payment' },
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
        async getUser() {
            try {
                const response = await axios.get("/getuser");
                this.user = response.data;
                // console.log('user info : ' , this.user);
                
            } catch (error) {
                console.log('user not loged');
            }
        },

        async logout() {
            try {
                await axios.get('/logout');
                this.user = null;
                this.$router.push('/');
            } catch (error) {
                console.error("Error during logout:", error);
            }
        },

        handleClickOutside(event) {
            const navbar = this.$refs.navbar;
            if (navbar && !navbar.contains(event.target)) {
                this.menuOpen = false;
                this.dropdownOpen = {};
            }
        },
    },
    mounted() {
        this.getUser();
        loadLanguageAsync(this.currentLang);
        document.addEventListener('click', this.handleClickOutside);
    },
    beforeDestroy() {
        document.removeEventListener('click', this.handleClickOutside);
    },
    components: { Cart, SearchComponent }
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
    width: 100vw;
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
    padding: 10px 5px;
    color: white;
}

.custom-tools {
    display: none;
    color: white !important;
}

.custom-navbar1 {
    display: flex;
    width: 100%;
    justify-content: end;
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
        width: 100vw !important;
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
