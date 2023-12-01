<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('assets/css/images/logo/favicon-icon.png') }}" type="image/x-icon">
  <link rel="shortcut icon" href="{{ asset('assets/css/images/logo/favicon-icon.png') }}" type="image/x-icon">
  @yield('page_title')

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
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollable.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
  <!-- Plugins css Ends-->
  <!-- Bootstrap css-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
  <!-- App css-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
  <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}">
  <!-- Responsive css-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
  <!---Custom Css---->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">

  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">

  @yield('style')


</head>

<body>

  <div class="loader-wrapper">
    <div class="loader">
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-bar"></div>
      <div class="loader-ball"></div>
    </div>
  </div>
  <!-- tap on top starts-->

  <div class="tap-top"><i data-feather="chevrons-up"></i></div>
  <!-- tap on tap ends-->
  <!-- page-wrapper Start-->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <div class="page-header">
      <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">
          <div class="logo-wrapper"><a href="{{url('/dashboard')}}"><img class="img-fluid" src="{{ asset('assets/css/images/logo/logo.png') }}" alt=""></a></div>
          <div class="toggle-sidebar">
            <div class="status_toggle sidebar-toggle d-flex">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                  <g>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M21.0003 6.6738C21.0003 8.7024 19.3551 10.3476 17.3265 10.3476C15.2979 10.3476 13.6536 8.7024 13.6536 6.6738C13.6536 4.6452 15.2979 3 17.3265 3C19.3551 3 21.0003 4.6452 21.0003 6.6738Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.3467 6.6738C10.3467 8.7024 8.7024 10.3476 6.6729 10.3476C4.6452 10.3476 3 8.7024 3 6.6738C3 4.6452 4.6452 3 6.6729 3C8.7024 3 10.3467 4.6452 10.3467 6.6738Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M21.0003 17.2619C21.0003 19.2905 19.3551 20.9348 17.3265 20.9348C15.2979 20.9348 13.6536 19.2905 13.6536 17.2619C13.6536 15.2333 15.2979 13.5881 17.3265 13.5881C19.3551 13.5881 21.0003 15.2333 21.0003 17.2619Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.3467 17.2619C10.3467 19.2905 8.7024 20.9348 6.6729 20.9348C4.6452 20.9348 3 19.2905 3 17.2619C3 15.2333 4.6452 13.5881 6.6729 13.5881C8.7024 13.5881 10.3467 15.2333 10.3467 17.2619Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  </g>
                </g>
              </svg>
            </div>
          </div>
        </div>
        <div class="left-side-header col ps-0 d-none d-md-block">

        </div>
        <div class="nav-right col-10 col-sm-6 pull-right right-header p-0">
          <ul class="nav-menus">
            <li data-toggle="tooltip" data-placement="top" title="Screen Mode">
              <div class="mode animated backOutRight">
                <svg class="lighticon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g>
                    <g>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M18.1377 13.7902C19.2217 14.8742 16.3477 21.0542 10.6517 21.0542C6.39771 21.0542 2.94971 17.6062 2.94971 13.3532C2.94971 8.05317 8.17871 4.66317 9.67771 6.16217C10.5407 7.02517 9.56871 11.0862 11.1167 12.6352C12.6647 14.1842 17.0537 12.7062 18.1377 13.7902Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </g>
                  </g>
                </svg>
                <svg class="darkicon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12C7 9.23858 9.23858 7 12 7C14.7614 7 17 9.23858 17 12Z">
                  </path>
                  <path d="M18.3117 5.68834L18.4286 5.57143M5.57144 18.4286L5.68832 18.3117M12 3.07394V3M12 21V20.9261M3.07394 12H3M21 12H20.9261M5.68831 5.68834L5.5714 5.57143M18.4286 18.4286L18.3117 18.3117" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
              </div>
            </li>

            <li class="maximize"><a class="text-dark" data-toggle="tooltip" data-placement="top" title="Full Screen" href="#!" onclick="javascript:toggleFullScreen()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize">
                  <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                </svg></a></li>
            <span class="topbar-divider d-none d-sm-block"></span>
            <li class="profile-nav onhover-dropdown pe-0 py-0 me-0">
              <div class=" media d-flex align-items-center">
                <div class="media-body me-3 text-end lh-1 text-dark align-items-center d-none d-lg-block"><span class="mb-0 font-small text-gray-900 text-capitalize">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</span><br><span class="text-secondary font-size-90 d-block mt-1">{{Auth::user()->designation->designation}}</span></div>
                <img class="avatar rounded-circle" alt="Image placeholder" src="{{asset('image/').'/'.Auth::user()->image_path}}">
              </div>

              <ul class="profile-dropdown onhover-show-div">
                <li><a href="{{url('change-password')}}"><i data-feather="settings"></i><span>Settings</span></a>
                </li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i data-feather="log-out"> </i><span>Log out</span></a></li>
                <form id="logout-form" action="{{ route('logout') }}" style="display:none;" method="POST"> @csrf</form>
              </ul>
            </li>
          </ul>
        </div>

      </div>
    </div>
    <!-- Page Header Ends-->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
      <!-- Page Sidebar Start-->
      <div class="sidebar-wrapper">
        <div>
          <div class="logo-wrapper"><a href="{{url('/dashboard')}}"><img class="img-fluid for-light" src="{{ asset('assets/css/images/logo/small-logo.png') }}" alt=""><img class="img-fluid for-dark" src="../assets/css/images/logo/sword-logo.png" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
          </div>
          <div class="logo-icon-wrapper"><a href="{{url('/dashboard')}}"><img class="img-fluid" src="{{ asset('assets/css/images/logo-icon.png') }}" alt=""></a></div>
          <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
              @include('layouts.menu')

            </div>

          </nav>
        </div>
      </div>
      <!-- Page Sidebar Ends-->
      @yield('content')
      <!-- footer start-->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 footer-copyright text-center">
              <p class="mb-0">Copyright<script>
                  document.write(new Date().getFullYear())
                </script> © Sword India Private Limited {{ config('app.version') }}</p>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- latest jquery-->
  <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.ui.min.js') }}"></script>
  <!-- Bootstrap js-->
  <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
  <!-- feather icon js-->
  <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
  <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
  <!-- scrollbar js-->
  <script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
  <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
  <script src="{{ asset('assets/js/scrollable/perfect-scrollbar.min.js')}}"></script>
  <script src="{{ asset('assets/js/scrollable/scrollable-custom.js')}}"></script>
  <!-- Sidebar jquery-->
  <script src="{{ asset('assets/js/config.js') }}"></script>
  <!-- Plugins JS start-->
  <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
  <!-- Plugins JS Ends-->
  <!-- Theme js-->
  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script src="{{ asset('assets/js/autocomplete.js') }}"></script>

  <script src="{{ asset('assets/js/theme-customizer/customizer.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
  <script src="https://cdn.tiny.cloud/1/wn1eiidnybp21nuxg1o5akeguxiukdrz328dh0so963dsf3g/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

  <!--select2--->

  <!-- login js-->
  <!--Custom Js -->
  <script src="{{ asset('js/custom.js') }}"></script>

  <!-- Plugin used-->

  <script>
    ///-----------------auto dismiss alert-------------------------////
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
      });
    }, 5000);
  </script>

  <script>
    $('#sidebar-menu ul li ul.sidebar-submenu li a').click(function(e) {
      if ($(this).attr('class') != 'active') {
        $('#sidebar-menu ul li a').removeClass('active');
        $(this).addClass('active');
      }
    });

    $('a').filter(function() {
      return this.href === document.location.href;
    }).addClass('active')

    $("ul.sidebar-submenu > li > a").each(function() {
      var currentURL = decodeURIComponent(document.location.href);
      var thisURL = $(this).attr("href");
      if (currentURL.indexOf(thisURL) != -1) {
        $(this).parents("ul.sidebar-submenu").css('display', 'block');
      }
    });

    $('#sidebar-menu > ul > li > a').each(function() {
      var currURL = decodeURIComponent(document.location.href);
      var myHref = $(this).attr('href');
      if (currURL.match(myHref)) {
        $(this).addClass('active');
        $(this).parent().find("ul.sidebar-submenu").css('display', 'block');
      }
    });

    $("ul.nav-sub-childmenu > li > a").each(function() {
      var currentURL = decodeURIComponent(document.location.href);
      var thisURL = $(this).attr("href");
      if (currentURL.indexOf(thisURL) != -1) {
        $(this).parents("ul.nav-sub-childmenu").css('display', 'block');
        $(this).parents("ul.sidebar-submenu").css('display', 'block');
      }
    });
  </script>

  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
    })()
  </script>

  @yield('script')
</body>

</html>