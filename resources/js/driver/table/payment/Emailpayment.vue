<template>
    <nav aria-label="breadcrumb" class="mb-2">
      <ol class="breadcrumb breadcrumb-pipes">
        <li class="breadcrumb-item">
          <router-link to="/">{{ $t('Home') }}</router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ $t('Email Payments') }}</li>
      </ol>
    </nav>
  
    <div class="row" id="table-hover-row">
      <div class="col-12">
        <div class="card">
             <!-- نموذج البحث -->
        <div class="card-header">
          <form @submit.prevent="goToInvoice">
            <div class="input-group mb-3">
              <input 
                type="text" 
                class="form-control" 
                placeholder="Enter Invoice ID" 
                v-model="invoiceId" 
                required />
              <button class="btn btn-primary" type="submit">{{ $t('Go to Invoice') }}</button>
            </div>
          </form>
        </div>

          <!-- -------- Modal لتعديل الحالة -------- -->
          <div class="modal fade text-start" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="statusModalLabel">{{ $t('Update Status') }}</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="updateStatus">
                  <div class="modal-body">
                    <!-- اختيار الحالة -->
                    <div class="mb-1">
                      <label class="form-label" for="statusSelect">{{ $t('Status') }}</label>
                      <select class="form-select" id="statusSelect" v-model="selectedStatus" required>
                        <option value="all">{{ $t('All') }}</option>
                        <option value="pending">{{ $t('Pending') }}</option>
                        <option value="processing">{{ $t('Processing') }}</option>
                        <option value="on_the_way">{{ $t('On The Way') }}</option>
                        <option value="delivered">{{ $t('Delivered') }}</option>
                        <option value="cancelled">{{ $t('Cancelled') }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $t('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ $t('Update') }}</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- -------- نهاية Modal -------- -->
  
          <div class="card-header d-flex justify-content-between align-items-center">
            <div>
              <h4 class="card-title">{{ $t('Email Payments') }}</h4>
              <h4 class="card-title">{{ $t('Count') }} : {{ filteredPayments.length }}</h4>
            </div>
            <!-- حقل البحث وفلترة الحالة -->
            <div class="row">
              <div class="input-group mb-3 col-md-4">
                <input type="text" class="form-control" :placeholder="$t('Search by Payment ID or Product Name')"
                  v-model="searchQuery" @input="filterPayments" />
                <button class="btn btn-outline-secondary" type="button" @click="filterPayments">
                  <i class="fas fa-search"></i>
                </button>
              </div>
              <div class="input-group mb-3 col-md-4">
                <select class="form-select" v-model="selectedStatus" @change="filterPayments">
                  <option value="all">{{ $t('All') }}</option>
                  <option value="pending">{{ $t('Pending') }}</option>
                  <option value="processing">{{ $t('Processing') }}</option>
                  <option value="on_the_way">{{ $t('On The Way') }}</option>
                  <option value="delivered">{{ $t('Delivered') }}</option>
                  <option value="cancelled">{{ $t('Cancelled') }}</option>
                </select>
              </div>
            </div>
          </div>
  
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
              <thead>
                <tr>
                  <th>{{ $t('Status') }}</th>
                  <th>{{ $t('Payment ID') }}</th>
                  <th>{{ $t('Full Name') }}</th>
                  <th>{{ $t('Email') }}</th>
                  <th>{{ $t('Product Name') }}</th>
                  <th>{{ $t('Quantity') }}</th>
                  <th>{{ $t('Amount') }}</th>
                  <th>{{ $t('VAT') }}</th>
                  <th>{{ $t('Currency') }}</th>
                  <th>{{ $t('Country') }}</th>
                  <th>{{ $t('Street') }}</th>
                  <th>{{ $t('Address') }}</th>
                  <th>{{ $t('Zip Code') }}</th>
                  <th>{{ $t('Location') }}</th>
                  <th>{{ $t('Phone') }}</th>
                  <th>{{ $t('Payment Status') }}</th>
                  <th>{{ $t('Created At') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(payment, index) in filteredPayments" :key="index" @click="openStatusModal(payment)">
                  <td>
                    <!-- حالة pending -->
                    <span v-if="payment.status === 'pending'" class="badge rounded-pill text-secondary border-primary">
                      {{ $t('Pending') }}
                    </span>
  
                    <!-- حالة processing أو on_the_way -->
                    <span v-else-if="['processing', 'on_the_way'].includes(payment.status)"
                      class="badge rounded-pill text-warning border-warning">
                      {{ payment.status === 'processing' ? $t('Processing') : $t('On The Way') }}
                    </span>
  
                    <!-- حالة delivered -->
                    <span v-else-if="payment.status === 'delivered'" class="badge rounded-pill text-success border-success">
                      {{ $t('Delivered') }}
                    </span>
  
                    <!-- حالة cancelled -->
                    <span v-else-if="payment.status === 'cancelled'" class="badge rounded-pill text-danger border-danger">
                      {{ $t('Cancelled') }}
                    </span>
  
                    <!-- حالة افتراضية (إذا كانت الحالة غير معروفة) -->
                    <span v-else class="badge rounded-pill text-secondary border-secondary">
                      {{ payment.status }}
                    </span>
                  </td>
                  <td>{{ payment.payment_id }}</td>
                  <td>{{ payment.payer_name }}</td>
                  <td>{{ payment.payer_email }}</td>
                  <td>{{ payment.product_name }}</td>
                  <td>{{ payment.quantity }}</td>
                  <td>{{ payment.amount }}</td>
                  <td>{{ payment.vat }}</td>
                  <td>{{ payment.currency }}</td>
                  <td>{{ payment.country }}</td>
                  <td>{{ payment.street }}</td>
                  <td>{{ payment.address }}</td>
                  <td>{{ payment.zipcode }}</td>
                  <td>{{ payment.location }}</td>
                  <td>{{ payment.phone }}</td>
                  <td>{{ payment.payment_status }}</td>
                  <td>{{ payment.created_at }}</td>
                </tr>
                <tr v-if="filteredPayments.length === 0">
                  <td colspan="17" class="text-center">{{ $t('No payments found') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { Modal } from 'bootstrap'; // استيراد Modal من Bootstrap
  import Swal from 'sweetalert2'; // استيراد SweetAlert2
  
  export default {
    data() {
      return {
        payments: [], // جميع الطلبات
        filteredPayments: [], // الطلبات المصفاة
        searchQuery: "", // نص البحث
        selectedStatus: "all", // الحالة المحددة (الافتراضي: جميع الحالات)
        selectedPaymentId: null, // ID الطلب المحدد
        statusModal: null, // Modal لتعديل الحالة
        invoiceId: "",
      };
    },
    methods: {
        // دالة التوجيه إلى صفحة الفاتورة
    goToInvoice() {
      if (this.invoiceId) {
        // قم بفتح الرابط في نافذة جديدة
        window.open(`/payment/success/${this.invoiceId}`, '_blank');
      } else {
        this.showErrorMessage("Please enter a valid invoice ID.");
      }
    },

      // جلب جميع الطلبات
      get_all() {
        axios
          .get("/api/email-payment")
          .then((response) => {
            this.payments = response.data.data;
            this.filteredPayments = this.payments; // تعيين الطلبات المصفاة كجميع الطلبات في البداية
          })
          .catch((error) => {
            console.error("Error fetching payments:", error);
          });
      },
  
      // تصفية الطلبات بناءً على نص البحث والحالة المحددة
      filterPayments() {
        let filtered = this.payments;
  
        // فلترة بناءً على نص البحث
        if (this.searchQuery) {
          const query = this.searchQuery.toLowerCase();
          filtered = filtered.filter(
            (payment) =>
              payment.payment_id.toString().toLowerCase().includes(query) ||
              payment.product_name.toLowerCase().includes(query)
          );
        }
  
        // فلترة بناءً على الحالة المحددة
        if (this.selectedStatus !== "all") {
          filtered = filtered.filter((payment) => payment.status === this.selectedStatus);
        }
  
        this.filteredPayments = filtered;
      },
  
      // فتح Modal لتعديل الحالة
      openStatusModal(payment) {
        this.selectedPaymentId = payment.id; // تعيين ID الطلب المحدد
        this.selectedStatus = payment.status; // تعيين الحالة الحالية
        this.statusModal.show(); // عرض Modal
      },
  
      // تحديث الحالة
      updateStatus() {
        axios
          .post(`/api/email/status/${this.selectedPaymentId}`, { status: this.selectedStatus }, {
            headers: {
              'Content-Type': 'application/json', // إضافة headers إذا لزم الأمر
              // 'Authorization': `Bearer ${token}` // إذا كان API يتطلب token
            }
          })
          .then((response) => {
            if (response.data.success) {
              this.showSuccessMessage("Status updated successfully!");
            } else {
              this.showErrorMessage(response.data.message || "Failed to update status.");
            }
            this.get_all(); // إعادة جلب البيانات لتحديث الجدول
          })
          .catch((error) => {
            if (error.response) {
              // إذا كان هناك استجابة من الخادم مع خطأ
              this.showErrorMessage(error.response.data.message || "Failed to update status.");
            } else if (error.request) {
              // إذا لم يتم إرسال الطلب إلى الخادم
              this.showErrorMessage("Network error. Please check your connection.");
            } else {
              // إذا كان هناك خطأ في إعداد الطلب
              this.showErrorMessage("An unexpected error occurred.");
            }
          })
          .finally(() => {
            this.statusModal.hide(); // إخفاء Modal بعد الانتهاء
          });
      },
  
      // عرض رسالة نجاح
      showSuccessMessage(text) {
        Swal.fire({
          position: "top-start",
          icon: "success",
          title: text,
          showConfirmButton: false,
          timer: 1500,
          customClass: {
            confirmButton: "btn btn-primary",
          },
          buttonsStyling: false,
        });
      },
  
      // عرض رسالة فشل
      showErrorMessage(message) {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: message,
        });
      },
    },
    mounted() {
      this.get_all();
      this.statusModal = new Modal(document.getElementById('statusModal')); // تهيئة Modal
    },
  };
  </script>
  
  <style scoped>
  /* تنسيقات إضافية */
  tr {
    cursor: pointer;
  }
  
  td {
    width: auto !important;
    /* text no wrap */
    white-space: nowrap;
  }
  </style>