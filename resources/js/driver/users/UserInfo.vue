<template>
       <div class="d-flex justify-content-start breadcrumb-wrapper my-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ms-1">
                <li class="breadcrumb-item"><router-link to="/">{{ $t('Admin') }}</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $t('Profile') }}</li>
            </ol>
        </nav>
    </div>
    <section class="app-user-view-account">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0 ">
                <!-- User Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <img class="img-fluid rounded mt-3 mb-2" :src="getUserImageSrc()" height="110"
                                    width="110" alt="User avatar">

                                <div class="user-info text-center">
                                    <h4>{{ user.fname }} {{ user.lname }}</h4>
                                    <span class="badge bg-light-secondary">{{ $t('Customer') }}</span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fw-bolder border-bottom pb-50 my-1">{{ $t('Details') }}</h4>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('First name') }}:</span>
                                    <span>{{ user.fname }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('Last name') }}:</span>
                                    <span>{{ user.lname }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('Email') }} :</span>
                                    <span>{{ user.email }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('Status') }}:</span>
                                    <span class="badge bg-light-success">{{ $t('Active') }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('Phone number') }}:</span>
                                    <span>{{ user.phoneNumber }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('Address') }}:</span>
                                    <span>{{ user.location }}</span>
                                </li>
                                <!-- <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('Contact') }}:</span>
                                    <span>+1 (609) 933-44-22</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('Language') }}:</span>
                                    <span>{{ $t('') }}English</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('Country') }}:</span>
                                    <span>Wake Island</span>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-xl-12 col-lg-12 col-md-12 order-0 order-m-5 ">
                <!-- User Pills -->
                <!-- <ul class="nav nav-pills mb-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="app-user-view-account.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-user font-medium-3 me-50">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span class="fw-bold">Account</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-lock font-medium-3 me-50">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <span class="fw-bold">Security</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="app-user-view-billing.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-bookmark font-medium-3 me-50">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span class="fw-bold">Billing &amp; Plans</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="app-user-view-notifications.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-bell font-medium-3 me-50">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg><span class="fw-bold">Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="app-user-view-connections.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-link font-medium-3 me-50">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                            </svg><span class="fw-bold">Connections</span>
                        </a>
                    </li>
                </ul> -->
                <!--/ User Pills -->
            </div>
            <!--/ User Content -->
        </div>
    </section>
</template>

<script>
import axios from "axios";
export default {
  props: ['id'],
  data() {
    return {
      user: [],
      invoices:[]
    };
  },

  methods: {
    getUserInfo() {
            axios.get(`/api/show-user/${this.id}`).then((response) => {
            this.user = response.data.user;
            this.fetchInvoice();
        })
        .catch((error) => {
            if (error.response.status === 403) {
                this.$router.push({ name: 'Unauthenticated' });
            } else {
                console.error(error);
            }
        });
    },
    fetchInvoice() {
        axios
            .get(`${process.env.MIX_API_URL}/user-invoices/${this.id}`)
            .then((response) => {
                this.invoices = response.data.invoices;

            })
            .catch((error) => {
                console.log(error);
            });
    },
    printInvoice(invoiceId) {
            this.$router.push({ name: 'PrintAd', params: { id: invoiceId } });
    },
    handleRowClick(invoiceId) {
        this.$router.push({ name: 'PrintAd', params: { id: invoiceId } });
    },
    getUserImageSrc() {
        if (this.user.personImage) {
            return '/img/' + this.user.personImage;
        } else {
        return '/img/load.png'
        }
    },
    },
  mounted() {
    this.getUserInfo();

  },
};
</script>

<style>
</style>
