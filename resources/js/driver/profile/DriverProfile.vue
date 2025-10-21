<template>
    <div class="d-flex justify-content-start breadcrumb-wrapper my-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb ms-1">
                <li class="breadcrumb-item"><a href="/driver/index">{{ $t('Admin') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $t('Profile') }}</li>
            </ol>
        </nav>
    </div>
    <section class="app-user-view-account">
        <div class="row d-flex justify-content-center">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <img class="img-fluid rounded mt-3 mb-2" :src="getUserImageSrc()" height="110"
                                    width="110" alt="User avatar">

                                <div class="user-info text-center">
                                    <h4>{{ user.fname }} {{ user.lname }}</h4>
                                    <span class="badge bg-light-secondary">{{ $t('Admin') }}</span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fw-bolder border-bottom pb-50 m-2">{{ $t('Details') }}</h4>
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
                                </li> -->
                                <!-- <li class="mb-75">
                                    <span class="fw-bolder me-25">{{ $t('Language') }}:</span>
                                    <span>{{ $t('English') }}</span>
                                </li> -->
                            </ul>
                            <div class="d-flex justify-content-center pt-2">
                                <button class="btn btn-primary me-1 waves-effect waves-float waves-light"
                                    @click="editProfile(user.id)">
                                    {{ $t('Edit') }}
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Edit User Modal -->
    <!-- <EditCustomer :user="user"/> -->
    <!--/ Edit User Modal -->
    <!-- upgrade your plan Modal -->
    <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-upgrade-plan">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5 pb-2">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">Upgrade Plan</h1>
                        <p>Choose the best plan for user.</p>
                    </div>
                    <form id="upgradePlanForm" class="row pt-50" onsubmit="return false">
                        <div class="col-sm-8">
                            <label class="form-label" for="choosePlan">Choose Plan</label>
                            <select id="choosePlan" name="choosePlan" class="form-select" aria-label="Choose Plan">
                                <option selected="">Choose Plan</option>
                                <option value="standard">Standard - $99/month</option>
                                <option value="exclusive">Exclusive - $249/month</option>
                                <option value="Enterprise">Enterprise - $499/month</option>
                            </select>
                        </div>
                        <div class="col-sm-4 text-sm-end">
                            <button type="submit"
                                class="btn btn-primary mt-2 waves-effect waves-float waves-light">Upgrade</button>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="modal-body px-5 pb-3">
                    <h6>User current plan is standard plan</h6>
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex justify-content-center me-1 mb-1">
                            <sup class="h5 pricing-currency pt-1 text-primary">$</sup>
                            <h1 class="fw-bolder display-4 mb-0 text-primary me-25">99</h1>
                            <sub class="pricing-duration font-small-4 mt-auto mb-2">/month</sub>
                        </div>
                        <button class="btn btn-outline-danger cancel-subscription mb-1 waves-effect">Cancel
                            Subscription</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ upgrade your plan Modal -->
</template>

<script>
export default {

    data() {
        return {
            user: [],
        }
    },
    methods: {
        getuser() {
            axios.get("/get-admin").then((response) => {
                this.user = response.data.adminInfo;

            });
        },
        editProfile(id) {
            this.$router.push(`/profile/${id}/edit`);
        },
        
        getUserImageSrc() {
        if (this.user.personImage) {
            return '/img/' + this.user.personImage;
        } else {
          return '/img/load.png'
        }
    }
    },
    mounted() {
        this.getuser();
    },
}
</script>

<style></style>
