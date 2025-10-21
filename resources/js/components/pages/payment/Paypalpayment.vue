<template>
    <div class="container my-3">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb breadcrumb-pipes">
                <li class="breadcrumb-item"><router-link to="/">{{ $t('Home') }}</router-link></li>
                <!-- <li class="breadcrumb-item"><a href="#">Library</a></li> -->
                <li class="breadcrumb-item active" aria-current="page">{{ $t('Payments') }}</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title text-white">{{ $t('Payments') }}</h4>
                    </div>

                    <!-- عرض الرسالة إذا لم توجد بيانات -->
                    <div v-if="payments.length === 0" class="text-center p-4">
                        <p class="text-muted">{{ $t('No Payments Found') }}</p>
                    </div>

                    <!-- عرض البيانات في شكل cards -->
                    <div v-else class="row p-3">
                        <div v-for="(payment, index) in payments" :key="index" class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm border">
                                <div class="card-body">
                                    <!-- عنوان البطاقة -->
                                    <h5 class="card-title text-primary">
                                        <i class="fas fa-receipt me-2"></i> {{ $t('Payment ID') }}: {{ payment.payment_id }}
                                    </h5>

                                    <!-- معلومات الدفع -->
                                    <div class="mb-3">
                                        <p class="card-text">
                                            <i class="fas fa-user me-2 text-secondary"></i> <strong>{{ $t('Full Name') }}:</strong>
                                            {{ payment.payer_name }}
                                        </p>
                                        <p class="card-text">
                                            <i class="fas fa-envelope me-2 text-secondary"></i> <strong>{{ $t('Email') }}:</strong>
                                            {{ payment.payer_email }}
                                        </p>
                                        <p class="card-text">
                                            <i class="fas fa-box me-2 text-secondary"></i> <strong>{{ $t('Product Name') }}:</strong> {{
                                                payment.product_name }} (x{{ payment.quantity }})
                                        </p>
                                        <p class="card-text">
                                            <i class="fas fa-money-bill-wave me-2 text-secondary"></i>
                                            <strong>{{ $t('Amount') }}:</strong> {{ payment.amount }} {{ payment.currency }}
                                        </p>
                                        <p class="card-text">
                                            <i class="fas fa-percent me-2 text-secondary"></i> <strong>{{ $t('VAT') }}:</strong> {{
                                                payment.vat }}
                                        </p>
                                    </div>

                                    <!-- معلومات العنوان -->
                                    <div class="mb-3">
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            <i class="fas fa-map-marker-alt me-2"></i> {{ $t('Address Details') }}
                                        </h6>
                                        <p class="card-text">
                                            <strong>{{ $t('Country') }}:</strong> {{ payment.country }}
                                        </p>
                                        <p class="card-text">
                                            <strong>{{ $t('Street') }}:</strong> {{ payment.street }}
                                        </p>
                                        <p class="card-text">
                                            <strong>{{ $t('Address') }}:</strong> {{ payment.address }}
                                        </p>
                                        <p class="card-text">
                                            <strong>{{ $t('Zip Code') }}:</strong> {{ payment.zipcode }}
                                        </p>
                                        <p class="card-text">
                                            <strong>{{ $t('Location') }}:</strong> {{ payment.location }}
                                        </p>
                                    </div>

                                    <!-- معلومات إضافية -->
                                    <div class="mb-3">
                                        <p class="card-text">
                                            <i class="fas fa-phone me-2 text-secondary"></i> <strong>{{ $t('Phone') }}:</strong> {{
                                                payment.phone }}
                                        </p>
                                        <p class="card-text">
                                            <i class="fas fa-info-circle me-2" :class="{
                                                'text-secondary border-primary': payment.status === 'pending',
                                                'text-warning border-warning': ['processing', 'on_the_way', 'cancelled'].includes(payment.status),
                                                'text-success border-success': payment.status === 'delivered'
                                            }" style="border: 2px solid; border-radius: 50%; padding: 5px;"></i>
                                            <strong>Status:</strong> {{ payment.status }}
                                        </p>
                                        <p class="card-text">
                                            <i class="fas fa-credit-card me-2 text-secondary"></i> <strong>
                                                {{ $t('Payment Status') }}:</strong> {{ payment.payment_status }}
                                        </p>
                                        <p class="card-text">
                                            <i class="fas fa-calendar-alt me-2 text-secondary"></i> <strong>
                                                {{ $t('Created At') }}:</strong> {{ payment.created_at }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            axios.get(`/api/user-payments/${userId}`).
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