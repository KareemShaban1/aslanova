<template>
    <div class="container my-3">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb breadcrumb-pipes">
                <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
                <!-- <li class="breadcrumb-item"><a href="#">Library</a></li> -->
                <li class="breadcrumb-item active" aria-current="page">Email Payment</li>
            </ol>
        </nav>
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Email Payments</h4>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>payment id</th>
                                    <th>full name</th>
                                    <th>email</th>
                                    <th>product name</th>
                                    <th>quantity</th>
                                    <th>amount</th>
                                    <th>vat</th>
                                    <th>currency</th>

                                    <th>country</th>
                                    <th>street</th>
                                    <th>address</th>
                                    <th>zip code</th>
                                    <th>location</th>
                                    <th>phone</th>

                                    <th>payment status</th>
                                    <th>Created at</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="payments.length > 0" v-for="(payment, index) in payments" :key="index">
                                    <td>
                                        {{ payment.payment_id }}
                                    </td>
                                    <td>
                                        {{ payment.payer_name }}
                                    </td>
                                    <td>
                                        {{ payment.payer_email }}
                                    </td>
                                    <td>
                                        {{ payment.product_name }}
                                    </td>
                                    <td>
                                        {{ payment.quantity }}
                                    </td>
                                    <td>
                                        {{ payment.total }}
                                    </td>
                                    <td>
                                        {{ payment.vat }}
                                    </td>
                                    <td>
                                        {{ payment.currency }}
                                    </td>
                                    <td>
                                        {{ payment.country }}
                                    </td>
                                    <td>
                                        {{ payment.street }}
                                    </td>
                                    <td>
                                        {{ payment.address }}
                                    </td>
                                    <td>
                                        {{ payment.zipcode }}
                                    </td>
                                    <td>
                                        {{ payment.location }}
                                    </td>
                                    <td>
                                        {{ payment.phone }}
                                    </td>
                                    <td>
                                        {{ payment.payment_status }}
                                    </td>
                                    <td>
                                        {{ payment.created_at }}
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td colspan="9" class="text-center">No payments found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            payments: [],
            user: [],
        }
    },
    methods: {
        get_all() {
            const userId = this.user.id;
            axios.get(`/api/user-emails/${userId}`).
                then(response => {
                    this.payments = response.data.data;
                    console.log("payments: ", this.payments);
                })
        },

        // get user
        async getUser() {
            try {
                const response = await axios.get("/getuser");
                this.user = response.data;
                this.get_all();
                // console.log('user info : ' , this.user);

            } catch (error) {
                window.location.href = "/login";
            }
        },
    },
    mounted() {
        this.getUser();
    }
}
</script>