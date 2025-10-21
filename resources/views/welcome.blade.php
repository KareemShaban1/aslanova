<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">

    <title>Aslanova</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors-rtl.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/apexcharts.css"> -->
    {{-- <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/toastr.min.css"> --}}
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />




    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/css-rtl/plugins/extensions/ext-component-ratings.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/jquery.rateyo.min.css">

    <!-- Font-awasome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors-rtl.min.css">
    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/swiper.min.css">
    {{-- <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/toastr.min.css"> --}}
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/dashboard-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/charts/chart-apex.css">
    {{-- <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/extensions/ext-component-toastr.css"> --}}
    <!-- END: Page CSS-->
    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/extensions/ext-component-sliders.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/app-ecommerce.css">
    <!-- END: Page CSS-->


    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS-->

    <style>
        @font-face {
            font-family: "Bahij TheSansArabic-SemiBold";
            src: url("/fonts/BahijTheSansArabic-SemiBold.ttf");
        }

        * {
            font-family: "Bahij TheSansArabic-SemiBold";
        }

        #cookieConsent {
            display: none;
            position: fixed;
            bottom: 0px;
            left: 20px;
            right: 20px;
            padding: 15px;
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            z-index: 1000;
        }

        @media (max-width: 575.98px) {
            #cookieConsent {
                bottom: 0px;
                left: 0px;
                right: 0px;
            }

            #cookieConsent h4,
            #cookieConsent button {
                font-size: 14px;
            }
        }
    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu  navbar-floating footer-static  " data-open="hover"
    data-menu="horizontal-menu" data-col="">
    <div id="app"></div>

    {{-- Cookies
    <div id="cookieConsent">
        <h4 style="margin: 0; color: #333;">
            {{ __('We use cookies to enhance your experience') }}
        </h4>
        <button id="acceptCookies"
            style="margin-top: 10px; padding: 10px 15px; background: #d9b382; color: white; border: none; border-radius: 5px; cursor: pointer;">
            {{ __('I Agree') }}
        </button>
    </div> --}}


    {{-- <a href="/logout">Logout</a> --}}


    {{-- Cookies --}}
    <style>
        /* تنسيق عام للنافذة الرئيسية ونافذة الإعدادات */
.modal {
    display: none;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

/* تنسيق العنوان */
.modal-content h2 {
    font-size: 24px;
    margin-bottom: 15px;
    color: #333;
}

/* تنسيق النصوص */
.modal-content p {
    font-size: 16px;
    line-height: 1.6;
    color: #666;
    margin-bottom: 20px;
}

/* تنسيق الأزرار */
.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-right: 10px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    opacity: 0.9;
}

.btn-danger {
    background-color: #dc3545;
    color: #fff;
}

.btn-info {
    background-color: #17a2b8;
    color: #fff;
}

/* تنسيق الجداول */
.info-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.info-table th, .info-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.info-table th {
    background-color: #f4f4f4;
    color: #333;
}

/* تنسيق النافذة الرئيسية */
#cookie-banner {
    display: flex;
}

/* تنسيق نافذة إعدادات ملفات تعريف الارتباط */
#cookie-settings {
    display: none;
}

/* تنسيق النموذج داخل نافذة الإعدادات */
#cookie-settings-form label {
    display: block;
    margin-bottom: 15px;
    font-size: 16px;
    color: #333;
}

#cookie-settings-form input[type="checkbox"] {
    margin-right: 10px;
}

/* تنسيق الأزرار داخل النموذج */
#cookie-settings-form .btn {
    margin-top: 20px;
}

/* تنسيق الجداول المخفية */
.info-table {
    display: none;
}
    </style>

<!-- النافذة الرئيسية -->
<div id="cookie-banner" class="modal" style="display: flex;">
    <div class="modal-content">
        <h2>{{__('We use cookies.')}}</h2>
        <p>
            {{__('We use cookies on our website. Some are essential, while others help us improve this site and your experience.')}}
            {{__('If you are under 16 years old and wish to give your consent for voluntary services, you must ask your legal guardian for permission.')}}
            {{__('We use cookies and other technologies on our website. Some are essential, while others help us improve this site and your experience.')}}
            {{__('Personal data (e.g., IP addresses) may be processed, for example, for personalized ads and content or ad and content measurement.')}}
            {{__('For more information on how we use your data, please refer to our privacy policy.')}}
            {{__('You can revoke or adjust your preferences at any time in the settings.')}}
        </p>
        <button class="btn" onclick="acceptAllCookies()">{{__('Accept All')}}</button>
        <button class="btn btn-danger" onclick="rejectAllCookies()">{{__('Reject')}}</button>
        <button class="btn" onclick="openSettings()">{{__('Cookie Settings')}}</button>
    </div>
</div>

<!-- نافذة إعدادات ملفات تعريف الارتباط -->
<div id="cookie-settings" class="modal">
    <div class="modal-content">
        <h2>{{__('Cookie Settings')}}</h2>
        <div class="cookie-settings-container">
            <p>
                {{__('We use cookies on our website. Some are essential, while others help us improve this site and your experience.')}}
                {{__('If you are under 16 years old and wish to give your consent for voluntary services, you must ask your legal guardian for permission.')}}
                {{__('We use cookies and other technologies on our website. Some are essential, while others help us improve this site and your experience.')}}
                {{__('Personal data (e.g., IP addresses) may be processed, for example, for personalized ads and content or ad and content measurement.')}}
                {{__('For more information on how we use your data, please refer to our privacy policy.')}}
                {{__('You can revoke or adjust your preferences at any time in the settings.')}}
            </p>
            <form id="cookie-settings-form">
                <label>
                    <input type="checkbox" name="essential" checked disabled>
                    {{__('Essential Cookies (Always Enabled)')}}
                </label>
                <label>
                    <input type="checkbox" name="statistics">
                    {{__('Statistics Cookies (For Analyzing Website Performance)')}}
                    <button type="button" class="btn btn-info" onclick="toggleTable('statistics-table')">{{__('Details')}}</button>
                    <table id="statistics-table" class="info-table" style="display: none;">
                        <thead>
                            <tr>
                                <th>{{__('Property')}}</th>
                                <th>{{__('Description')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{__('Google Analytics')}}</td>
                                <td>{{__('Google\'s cookie for website analysis. Generates statistical data about how visitors use the site.')}}</td>
                            </tr>
                            <tr>
                                <td>{{__('Provider Name')}}</td>
                                <td>{{__('Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Ireland')}}</td>
                            </tr>
                            <tr>
                                <td>{{__('Privacy Policy')}}</td>
                                <td><a href="https://policies.google.com/privacy?hl=de" target="_blank">{{__('https://policies.google.com/privacy?hl=de')}}</a></td>
                            </tr>
                            <tr>
                                <td>{{__('Cookie Name')}}</td>
                                <td>_ga, _ga_CPTEKQPWP8</td>
                            </tr>
                            <tr>
                                <td>{{__('Cookie Duration')}}</td>
                                <td>{{__('2 years / Data retention in Google for 2 months')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </label>
                <label>
                    <input type="checkbox" name="marketing">
                    {{__('Marketing Cookies (For Displaying Relevant Ads)')}}
                    <button type="button" class="btn btn-info" onclick="toggleTable('marketing-table')">{{__('Details')}}</button>
                    <table id="marketing-table" class="info-table" style="display: none;">
                        <thead>
                            <tr>
                                <th>{{__('Cookie Name')}}</th>
                                <th>{{__('Provider')}}</th>
                                <th>{{__('Purpose')}}</th>
                                <th>{{__('Privacy Policy')}}</th>
                                <th>{{__('Host')}}</th>
                                <th>{{__('Cookie Duration')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{__('Borlabs Cookie')}}</td>
                                <td>{{__('Owner of this website, Legal Notice')}}</td>
                                <td>{{__('This website uses the Borlabs cookie, which sets a technically necessary cookie (borlabs cookie) to store your cookie consent. Borlabs Cookie does not process any personal data.')}}</td>
                                <td>{{__('Not available')}}</td>
                                <td>{{__('Not available')}}</td>
                                <td>{{__('6 months')}}</td>
                            </tr>
                            <tr>
                                <td>{{__('Google reCAPTCHA')}}</td>
                                <td>{{__('Google LLC')}}</td>
                                <td>{{__('Used by Google\'s spam protection service.')}}</td>
                                <td><a href="https://policies.google.com/privacy?hl=de" target="_blank">{{__('Privacy Policy')}}</a></td>
                                <td>.google.com</td>
                                <td>{{__('6 months')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </label>
                <button type="button" class="btn" onclick="saveSettings()">{{__('Save')}}</button>
                <button type="button" class="btn btn-danger" onclick="closeSettings()">{{__('Cancel')}}</button>
            </form>
        </div>
    </div>
</div>

<script>
    function acceptAllCookies() {
        const settings = {
            essential: true,
            statistics: true,
            marketing: true
        };
        localStorage.setItem('cookieSettings', JSON.stringify(settings));
        closeAllModals();
    }

    function rejectAllCookies() {
        const settings = {
            essential: true,
            statistics: false,
            marketing: false
        };
        localStorage.setItem('cookieSettings', JSON.stringify(settings));
        closeAllModals();
    }

    function openSettings() {
        document.getElementById('cookie-banner').style.display = 'none';
        document.getElementById('cookie-settings').style.display = 'flex';
    }

    function closeSettings() {
        document.getElementById('cookie-settings').style.display = 'none';
    }

    function saveSettings() {
        const form = document.getElementById('cookie-settings-form');
        const formData = new FormData(form);
        const settings = {
            essential: true,
            statistics: formData.has('statistics'),
            marketing: formData.has('marketing')
        };
        localStorage.setItem('cookieSettings', JSON.stringify(settings));
        closeAllModals();
    }

    function closeAllModals() {
        document.getElementById('cookie-banner').style.display = 'none';
        document.getElementById('cookie-settings').style.display = 'none';
    }

    function toggleTable(tableId) {
        // إخفاء جميع الجداول المفتوحة
        const allTables = document.querySelectorAll('.info-table');
        allTables.forEach(table => {
            if (table.id !== tableId) {
                table.style.display = 'none';
            }
        });

        // التبديل بين إظهار أو إخفاء الجدول الحالي
        const table = document.getElementById(tableId);
        table.style.display = table.style.display === 'none' ? 'block' : 'none';
    }

    document.addEventListener("DOMContentLoaded", function () {
const savedSettings = JSON.parse(localStorage.getItem("cookieSettings"));

if (savedSettings && savedSettings.essential) {
    document.getElementById("cookie-banner").style.display = "none";
}
});

</script>


    {{-- <script>
        document.getElementById('acceptCookies').addEventListener('click', function() {
            // إرسال طلب إلى السيرفر لحفظ موافقة المستخدم
            fetch('{{ route('cookie.accept') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                    document.getElementById('cookieConsent').style.display = 'none';
                })
                .catch(error => console.error('Error:', error));
        });
    </script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            async function checkConsentStatus() {
                try {
                    const response = await fetch('{{ route('cookie.check') }}');
                    const data = await response.json();
                    if (data.status !== 'accepted') {
                        document.getElementById('cookieConsent').style.display =
                        'block'; // Show the cookie consent div if not accepted
                    } else {
                        document.getElementById('cookieConsent').style.display =
                        'none'; // Hide the cookie consent div if accepted
                    }
                } catch (error) {
                    console.error('Error checking consent status:', error);
                }
            }

            document.getElementById('acceptCookies').addEventListener('click', async function() {
                try {
                    const response = await fetch('{{ route('cookie.accept') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({}),
                    });
                    const data = await response.json();
                    if (data.status === 'accepted') {
                        document.getElementById('cookieConsent').style.display =
                        'block'; // Hide the consent div if accepted
                    } else {
                        console.error('Failed to accept cookies');
                    }
                } catch (error) {
                    console.error('Error accepting cookies:', error);
                }
            });

            checkConsentStatus(); // Check the consent status when the page loads
        });
    </script> --}}



    <script src="{{ mix('js/app.js') }}"></script>

    <!-- BEGIN: Vendor JS-->
    <script src="../../../app-assets/vendors/js/extensions/swiper.min.js"></script>

    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <!-- <script src="../../../app-assets/vendors/js/charts/apexcharts.min.js"></script> -->
    {{-- <script src="../../../app-assets/vendors/js/extensions/toastr.min.js"></script> --}}
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/extensions/jquery.rateyo.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/js/scripts/extensions/ext-component-ratings.js"></script>
    <!-- END: Page JS-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy6F5P5x5jFw5QG7Zm3mJdMGa0O2JhD1w2Po4Wdd" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: "top-start",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500
            });

            // إزالة مفتاح success من الجلسة بعد العرض
            @php
                session()->forget('success');
            @endphp
        </script>
    @endif




    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> --}}
</body>
<!-- END: Body-->

</html>
