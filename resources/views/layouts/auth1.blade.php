<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="icon" href="{{ asset('assets/images/logo/favicon-icon.png') }}" type="image/x-icon">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon-icon.png') }}" type="image/x-icon">
  <title>{{ config('app.name') }}</title>
  <!-- Google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/font-awesome.css') }}">
  <!-- ico-font-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
  <!-- Themify icon-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
  <!-- Flag icon-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
  <!-- Feather icon-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
  <!-- Plugins css start-->
  <!-- Plugins css Ends-->
  <!-- Bootstrap css-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
  <!-- App css-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
  <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
  <!-- Responsive css-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
  <!---Custom Css---->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">
  @yield('style')
</head>

<body>
  <!-- login page start-->
  <section> </section>
  <div class="container-fluid p-0">
    @Yield('content')

  </div>
  <!-- latest jquery-->
  <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
  <!-- Bootstrap js-->
  <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
  <!-- feather icon js-->
  <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
  <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
  <!-- scrollbar js-->
  <!-- Sidebar jquery-->
  <script src="{{ asset('assets/js/config.js') }}"></script>
  <!-- Plugins JS start-->
  <!-- Plugins JS Ends-->
  <!-- Theme js-->
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <!-- login js-->
  <!-- Plugin used-->

  @yield('script')

</body>

</html>