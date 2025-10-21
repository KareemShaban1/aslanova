<template>
    <div class="content-overlay"></div>
    <div></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Dashboard Analytics Start -->
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h2 class="fw-bolder mb-0">{{ categories.length }}</h2>
                                <p class="card-text">{{ $t("Categories") }}</p>
                            </div>
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-cpu font-medium-5">
                                        <rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
                                        <rect x="9" y="9" width="6" height="6"></rect>
                                        <line x1="9" y1="1" x2="9" y2="4"></line>
                                        <line x1="15" y1="1" x2="15" y2="4"></line>
                                        <line x1="9" y1="20" x2="9" y2="23"></line>
                                        <line x1="15" y1="20" x2="15" y2="23"></line>
                                        <line x1="20" y1="9" x2="23" y2="9"></line>
                                        <line x1="20" y1="14" x2="23" y2="14"></line>
                                        <line x1="1" y1="9" x2="4" y2="9"></line>
                                        <line x1="1" y1="14" x2="4" y2="14"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h2 class="fw-bolder mb-0">{{ products.length }}</h2>
                                <p class="card-text">{{ $t("Products") }}</p>
                            </div>
                            <div class="avatar bg-light-success p-50 m-0">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-server font-medium-5">
                                        <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect>
                                        <rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect>
                                        <line x1="6" y1="6" x2="6.01" y2="6"></line>
                                        <line x1="6" y1="18" x2="6.01" y2="18"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h2 class="fw-bolder mb-0">{{ users.length }}</h2>
                                <p class="card-text">{{ $t("Users") }}</p>
                            </div>
                            <div class="avatar bg-light-danger p-50 m-0">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-activity font-medium-5">
                                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h2 class="fw-bolder mb-0">{{ orders.length }}</h2>
                                <p class="card-text">{{ $t("Orders") }}</p>
                            </div>
                            <div class="avatar bg-light-warning p-50 m-0">
                                <div class="avatar-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-alert-octagon font-medium-5">
                                        <polygon
                                            points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                        </polygon>
                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard Analytics end -->

        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            user: [],
            categories: [],
            products: [],
            orders: [],
            users: [],
            totalUsersCount: 0,
        }
    },
    methods: {
        getuser() {
            axios.get("/get-admin").then((response) => {
                this.user = response.data.adminInfo;
            });
        },

        // userStatistics() {
        //     axios.get("/user-statistics").then((response) => {
        //         this.totalUsersCount = response.data.totalUsersCount;
        //     });
        // },
        editProfile(id) {
            this.$router.push(`/profile/${id}/edit`);
        },
        hasAdminRole(role) {
            return this.adminRoles.includes(role);
        },

        get_categories() {
            axios.get('/api/categories').
                then(response => {
                    this.categories = response.data.categories;
                    // console.log("category: ", this.categories.length);
                })
        },
        get_products() {
            axios.get('/api/products').
                then(response => {
                    this.products = response.data.products;
                    // console.log("category: ", this.products.length);
                })
        },
        get_users() {
            axios.get('/api/get-all-user').
                then(response => {
                    this.users = response.data.users;
                    // console.log("users: ", this.users.length);
                })
        },
        get_orders() {
            axios.get('/api/products')
                .then(response => {
                    if (response.data && response.data.orders) {
                        this.orders = response.data.orders;
                        console.log("orders: ", this.orders.length);
                    } else {
                        this.orders = [];
                        // console.log("orders: 0");
                    }
                })
                .catch(error => {
                    console.error("Error fetching orders:", error);
                    this.orders = [];
                    // console.log("orders: 0");
                });
        }
    },
    mounted() {
        this.getuser();
        this.get_categories();
        this.get_products();
        this.get_orders();
        this.get_users();
        // this.userStatistics();
    },
}
</script>

<style></style>
