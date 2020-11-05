<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="viewport" content="width=device-width initial-scale=1.0">
   <title>@yield('page_title')</title>
   <!-- GLOBAL MAINLY STYLES-->
   <link href="{{asset('/assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet" />
   <link href="{{asset('/assets/admin/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
   <link href="{{asset('/assets/admin/vendors/themify-icons/css/themify-icons.css')}}" rel="stylesheet" />

   <!-- PLUGINS STYLES-->
   <link href="{{asset('/assets/admin/vendors/jvectormap/jquery-jvectormap-2.0.3.css')}}" rel="stylesheet" />
   <!-- THEME STYLES-->
   <link href="{{asset('/assets/admin/css/main.min.css')}}" rel="stylesheet" />
   <script src="{{asset('/assets/admin/vendors/jquery/dist/jquery.min.js')}}" type="text/javascript"></script>
   <style type="text/css">
      .modal-dialog {
         position: relative;
         display: table;
         overflow-y: auto;
         overflow-x: auto;
         min-width: 300px;
      }

      .jcrop-keymgr {
         opacity: 0 !important;
      }

      button {
         background: none;
         border: none;
         padding: 0;
         margin: 0;
      }

      .header .dropdown-user a.dropdown-toggle img {
         height: 30px;
         object-fit: cover;
      }
   </style>

   @stack('styles')
</head>

<body class="fixed-navbar">
   <div class="page-wrapper">

      <header class="header">
         <div class="page-brand">
            <a class="link" href="{{route('setting')}}">
               <span class="brand">
                  {{$dashboard_composer->site_name}}
               </span>
               <span class="brand-mini">MEGA</span>
            </a>
         </div>
         <div class="flexbox flex-1">
            <!-- START TOP-LEFT TOOLBAR-->
            <ul class="nav navbar-toolbar">
               <li>
                  <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
               </li>

            </ul>
            <!-- END TOP-LEFT TOOLBAR-->
            <!-- START TOP-RIGHT TOOLBAR-->
            <ul class="nav navbar-toolbar">

               <li class="dropdown dropdown-user">
                  <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                     <span></span>{{ Auth::user()->name }}<i class="fa fa-angle-down m-l-5"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right">
                     <a class="dropdown-item" href="{{route('customerLogout')}}">
                        <i class="fa fa-power-off"></i>Logout
                     </a>
                  </ul>
               </li>
            </ul>
            <!-- END TOP-RIGHT TOOLBAR-->
         </div>
      </header>
      <nav class="page-sidebar" id="sidebar">
         <div id="sidebar-collapse">
            <div class="admin-block d-flex align-items-center">
               <div>
                  <img src="{{asset('/images/main/'.$dashboard_composer->logo)}}" class="rounded" width="45px" />
               </div>
               <div class="admin-info">
                  <div class="font-strong">{{ Auth::user()->name }}</div>
               </div>
            </div>
            <ul class="side-menu metismenu">

               <li class="heading">Menu</li>
               {{-- <li>
                  <a href="{{route('customerDashboard')}}"><i class="sidebar-item-icon fa fa-globe"></i>
               <span class="nav-label">Dashboard</span></a>
               </li> --}}
               <li>
                  <a href="{{route('customerProfile')}}"><i class="sidebar-item-icon fa fa-globe"></i>
                     <span class="nav-label">Profile</span></a>
               </li>
            </ul>
         </div>
      </nav>
      <div class="content-wrapper">
         @yield('content')
      </div>
   </div>
   <!-- BEGIN PAGA BACKDROPS-->
   <div class="sidenav-backdrop backdrop"></div>
   <div class="preloader-backdrop">
      <div class="page-preloader">Loading</div>
   </div>
   <!-- END PAGA BACKDROPS-->
   <!-- CORE PLUGINS-->

   <script src="{{asset('/assets/admin/vendors/popper.js/dist/umd/popper.min.js')}}" type="text/javascript"></script>
   <script src="{{asset('/assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
   <script src="{{asset('/assets/admin/vendors/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript">
   </script>
   <!-- PAGE LEVEL PLUGINS-->
   <script src="{{asset('/assets/admin/vendors/chart.js/dist/Chart.min.js')}}" type="text/javascript"></script>
   <script src="{{asset('/assets/admin/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js')}}" type="text/javascript">
   </script>
   <script src="{{asset('/assets/admin/vendors/jvectormap/jquery-jvectormap-world-mill-en.js')}}"
      type="text/javascript">
   </script>
   <script src="{{asset('/assets/admin/vendors/jvectormap/jquery-jvectormap-us-aea-en.js')}}" type="text/javascript">
   </script>
   <!-- CORE SCRIPTS-->
   <script src="{{asset('/assets/admin/js/app.min.js')}}" type="text/javascript"></script>
   <script src="{{asset('/assets/admin/vendors/metisMenu/dist/metisMenu.min.js')}}" type="text/javascript"></script>

   <!-- PAGE LEVEL SCRIPTS-->
   <script src="{{asset('/assets/admin/js/scripts/dashboard_1_demo.js')}}" type="text/javascript"></script>

   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

   @stack('scripts')
</body>

</html>