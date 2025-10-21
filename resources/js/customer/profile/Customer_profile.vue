<template>
      <div class="d-flex justify-content-start breadcrumb-wrapper my-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ms-1">
                <li class="breadcrumb-item"><router-link to="/">{{ $t('home') }}</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $t('Profile') }}</li>
            </ol>
        </nav>
    </div>
    <section class="app-user-view-account">
        <div class="row d-flex justify-content-center">
              <div class="col-xl-6 col-lg-5 col-md-6 order-1 order-md-0">
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
                        <h4 class="fw-bolder border-bottom pb-50 mb-1">{{ $t('Details') }}</h4>
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
                                <!-- <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('Status') }}:</span>
                                    <span class="badge bg-light-success">{{ $t('Active') }}</span>
                                </li> -->
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
                                </li> -->
                                <!-- <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('Language') }}:</span>
                                    <span>{{ $t('English') }}</span>
                                </li> -->
                                <!-- <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('Country') }}:</span>
                                    <span>Wake Island</span>
                                </li> -->
                            </ul>
                            <div class="d-flex justify-content-start pt-2">
                                <button class="btn btn-primary me-1 waves-effect waves-float waves-light"
                                    @click="editProfile(user.id)">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    {{ $t('Edit') }}
                                </button>
                                <button class="btn btn-primary me-1 waves-effect waves-float waves-light"
                                    @click="show_orders(user.id)">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    {{ $t('Orders') }}
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
           
            <!-- User Sidebar -->
          
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
               
            </div>
            <!--/ User Content -->
        </div>
    </section>
    <!-- Edit User Modal -->
    <!-- <EditCustomer :user="user"/> -->
    <!--/ Edit User Modal -->
</template>

<script>
export default {
    data() {
        return {
            user: [],
        }
    },
    mounted() {
        this.getuser();
    },
    methods: {
        getuser() {
            axios.get("/getuser").then((response) => {
                this.user = response.data;
                this.fetchInvoice();
            });
        },
        editProfile(id) {
            this.$router.push(`/dashboard/profile/${id}/edit`);
        },
        show_orders(id) {
            this.$router.push(`/dashboard/paypal-payment`);
        },
        // fetchInvoice() {
        //     axios
        //         .get(`${process.env.MIX_API_URL}/user-invoices/${this.user.id}`)
        //         .then((response) => {
        //             this.invoices = response.data.invoices;

        //         })
        //         .catch((error) => {
        //             console.log(error);
        //         });
        // },
        // printInvoice(invoiceId) {
        //     this.$router.push({ name: 'Print', params: { id: invoiceId } });
        // },
        getUserImageSrc() {
        if (this.user.personImage) {
            return '/img/' + this.user.personImage;
        } else {
          return '/img/load.png'
        }
    }
    },
}
</script>

<style scoped>
.breadcrumb-wrapper {
    /* هامش داخلي للحافة */
    background-color: #f8f9fa; /* لون الخلفية */
    border-radius: 5px; /* زوايا مستديرة */
}

/* تنسيق البيانات الشخصية */
.user-avatar-section {
    text-align: center; /* محاذاة النص في الوسط */
}

.user-info h4 {
    margin-bottom: 5px; /* هامش أسفل العنصر */
}

.user-info .badge {
    margin-left: 5px; /* هامش على اليسار */
}

/* تنسيق قائمة المعلومات */
.info-container ul {
    list-style: none; /* إزالة نقاط القائمة */
    padding-left: 0; /* إزالة التباعد الأفقي */
}

.info-container li {
    margin-bottom: 10px; /* هامش أسفل العنصر */
}

/* تنسيق زر التحرير */
.btn-primary {
    background-color: #27139c; /* لون الخلفية */
    border-color: #6507b1; /* لون الحدود */
}

.btn-primary:hover {
    background-color: #0056b3; /* تغيير لون الخلفية عند التحويم */
    border-color: #0056b3; /* تغيير لون الحدود عند التحويم */
}

</style>>

