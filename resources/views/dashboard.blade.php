{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}


<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('Customer')}}</title>


    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">


  <!-- BEGIN: Vendor CSS-->
  <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors-rtl.min.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/apexcharts.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/toastr.min.css">
  <!-- END: Vendor CSS-->

  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/bootstrap-extended.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/colors.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/components.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/themes/dark-layout.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/themes/bordered-layout.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/themes/semi-dark-layout.css">

  <!-- BEGIN: Page CSS-->
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/pages/dashboard-ecommerce.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/plugins/charts/chart-apex.css">
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/plugins/extensions/ext-component-toastr.css">
  <!-- END: Page CSS-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/custom-rtl.css">
  <link rel="stylesheet" type="text/css" href="../../../assets/css/style-rtl.css">
  <!-- END: Custom CSS-->

  <style>
    @font-face {
font-family: "Bahij TheSansArabic-SemiBold";
src: url("/fonts/BahijTheSansArabic-SemiBold.ttf");
}
* {
font-family: "Bahij TheSansArabic-SemiBold";
}
</style>
</head>
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
    <div id="customer"></div>
    {{-- <a href="/logout">Logout</a> --}}

    <script src="{{ mix('js/customer.js') }}"></script>


    {{-- --------------------------- template JS --}}


            <!-- BEGIN: Vendor JS-->
            <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
            <!-- BEGIN Vendor JS-->

            <!-- BEGIN: Page Vendor JS-->
            <script src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
            <script src="../../../app-assets/vendors/js/charts/apexcharts.min.js"></script>
            <script src="../../../app-assets/vendors/js/extensions/toastr.min.js"></script>
            <!-- END: Page Vendor JS-->

            <!-- BEGIN: Theme JS-->
            <script src="../../../app-assets/js/core/app-menu.js"></script>
            <script src="../../../app-assets/js/core/app.js"></script>
            <!-- END: Theme JS-->

            <!-- BEGIN: Page JS-->
            <script src="../../../app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>
            <!-- END: Page JS-->

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


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
</body>
</html>
