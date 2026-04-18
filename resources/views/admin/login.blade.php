<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - SIRI Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

   <!-- inject:css-->
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/bootstrap/bootstrap.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/daterangepicker.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/fontawesome.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/footable.standalone.min.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/fullcalendar@5.2.0.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/jquery-jvectormap-2.0.5.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/jquery.mCustomScrollbar.min.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/leaflet.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/line-awesome.min.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/magnific-popup.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/MarkerCluster.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/MarkerCluster.Default.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/select2.min.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/slick.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/star-rating-svg.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/trumbowyg.min.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/wickedpicker.min.css') }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/style.css') }}">
   <!-- endinject -->

   <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin-assets/img/favicon.png') }}">
   <!-- Fonts -->
   <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">

   <style>
      .btn-primary {
         background: linear-gradient(135deg, #EC4899, #A855F7) !important;
         border-color: #EC4899 !important;
      }
      .btn-primary:hover {
         background: linear-gradient(135deg, #DB2777, #9333EA) !important;
      }
      .form-control:focus {
         border-color: #EC4899;
         box-shadow: 0 0 0 0.2rem rgba(236, 72, 153, 0.25);
      }
      .color-primary { color: #EC4899 !important; }
   </style>
</head>

<body>
   <main class="main-content">

      <div class="admin">
         <div class="container-fluid">
            <div class="row justify-content-center">
               <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-8">
                  <div class="edit-profile">
                     <div class="edit-profile__logos">
                        <a href="{{ route('admin.login') }}">
                           <img class="dark" src="{{ asset('admin-assets/img/logo-dark.png') }}" alt="">
                           <img class="light" src="{{ asset('admin-assets/img/logo-white.png') }}" alt="">
                        </a>
                     </div>
                     <div class="card border-0">
                        <div class="card-header">
                           <div class="edit-profile__title">
                              <h6>Sign in SIRI Admin</h6>
                           </div>
                        </div>
                        <div class="card-body">
                           <div class="edit-profile__body">

                              @if($errors->any())
                                 <div class="alert alert-danger alert-dismissible fade show mb-20" role="alert">
                                    <ul class="mb-0" style="padding-left: 1.2rem;">
                                       @foreach($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                       @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                 </div>
                              @endif

                              <form action="{{ route('admin.authenticate') }}" method="POST">
                                 @csrf
                                 <div class="form-group mb-25">
                                    <label for="username">Email Address</label>
                                    <input type="email" class="form-control" id="username" name="email"
                                       placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                                 </div>
                                 <div class="form-group mb-15">
                                    <label for="password-field">password</label>
                                    <div class="position-relative">
                                       <input id="password-field" type="password" class="form-control" name="password" placeholder="Password" required>
                                       <div class="uil uil-eye-slash text-lighten fs-15 field-icon toggle-password2">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="admin-condition">
                                    <div class="checkbox-theme-default custom-checkbox ">
                                       <input class="checkbox" type="checkbox" id="check-1" name="remember">
                                       <label for="check-1">
                                          <span class="checkbox-text">Keep me logged in</span>
                                       </label>
                                    </div>
                                 </div>
                                 <div class="admin__button-group button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                    <button type="submit" class="btn btn-primary btn-default w-100 btn-squared text-capitalize lh-normal px-50 signIn-createBtn ">
                                       sign in
                                    </button>
                                 </div>
                              </form>

                           </div>
                        </div><!-- End: .card-body -->
                     </div><!-- End: .card -->
                  </div><!-- End: .edit-profile -->
               </div><!-- End: .col-xl-5 -->
            </div>
         </div>
      </div><!-- End: .admin-element  -->

   </main>
   <div id="overlayer">
      <div class="loader-overlay">
         <div class="dm-spin-dots spin-lg">
            <span class="spin-dot badge-dot dot-primary"></span>
            <span class="spin-dot badge-dot dot-primary"></span>
            <span class="spin-dot badge-dot dot-primary"></span>
            <span class="spin-dot badge-dot dot-primary"></span>
         </div>
      </div>
   </div>
   <div class="enable-dark-mode dark-trigger">
      <ul>
         <li>
            <a href="#">
               <i class="uil uil-moon"></i>
            </a>
         </li>
      </ul>
   </div>
   <!-- inject:js-->
   <script src="{{ asset('admin-assets/vendor_assets/js/jquery/jquery-3.5.1.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/jquery/jquery-ui.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/bootstrap/popper.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/bootstrap/bootstrap.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/moment/moment.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/accordion.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/apexcharts.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/autoComplete.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/Chart.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/daterangepicker.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/drawer.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/dynamicBadge.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/dynamicCheckbox.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/footable.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/google-chart.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/jquery-jvectormap-2.0.5.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/jquery-jvectormap-world-mill-en.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/jquery.countdown.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/jquery.filterizr.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/jquery.magnific-popup.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/jquery.peity.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/jquery.star-rating-svg.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/leaflet.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/leaflet.markercluster.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/loader.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/message.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/moment.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/muuri.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/notification.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/popover.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/select2.full.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/slick.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/trumbowyg.min.js') }}"></script>
   <script src="{{ asset('admin-assets/vendor_assets/js/wickedpicker.min.js') }}"></script>
   <script src="{{ asset('admin-assets/theme_assets/js/apexmain.js') }}"></script>
   <script src="{{ asset('admin-assets/theme_assets/js/charts.js') }}"></script>
   <script src="{{ asset('admin-assets/theme_assets/js/drag-drop.js') }}"></script>
   <script src="{{ asset('admin-assets/theme_assets/js/footable.js') }}"></script>
   <script src="{{ asset('admin-assets/theme_assets/js/full-calendar.js') }}"></script>
   <script src="{{ asset('admin-assets/theme_assets/js/googlemap-init.js') }}"></script>
   <script src="{{ asset('admin-assets/theme_assets/js/icon-loader.js') }}"></script>
   <script src="{{ asset('admin-assets/theme_assets/js/jvectormap-init.js') }}"></script>
   <script src="{{ asset('admin-assets/theme_assets/js/leaflet-init.js') }}"></script>
   <script src="{{ asset('admin-assets/theme_assets/js/main.js') }}"></script>
   <!-- endinject-->
</body>

</html>
