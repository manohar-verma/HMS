<!DOCTYPE html>
<html dir="ltr" lang="en">
<?php
  use App\library\get_site_details; 
 
  $get_site_details = new get_site_details;
  $siteInfo = $get_site_details->get_site_data();
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="">
    <meta name="description"
        content="">
    <meta name="robots" content="noindex,nofollow">
    <title>{{$siteInfo->site_name}}</title>
    <link rel="canonical" href="" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{SITE_URL}}/assets/admin/images/favicon.png">
    <link href="{{SITE_URL}}/assets/admin/images/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- this pagjs -->
    <link rel="stylesheet" href="{{SITE_URL}}/assets/admin/css/apexcharts/dist/apexcharts.css">
    <link href="{{SITE_URL}}/assets/admin/css/jvectormap/jquery-jvectormap.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{SITE_URL}}/assets/admin/css/style.min.css" rel="stylesheet">
    <link href="{{SITE_URL}}/assets/admin/css/toastr/dist/build/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/admin/prism/prism.css">
    <link href="{{SITE_URL}}/assets/admin/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{SITE_URL}}/assets/admin/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- -------------------------------------------------------------- -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- -------------------------------------------------------------- -->
    <div class="preloader">
        <svg class="tea lds-ripple" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="#2962FF" stroke-width="2"></path>
          <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="#2962FF" stroke-width="2"></path>
          <path id="teabag" fill="#2962FF" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"></path>
          <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#2962FF"></path>
          <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="#2962FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- -------------------------------------------------------------- -->
    <div id="main-wrapper">
        <!-- -------------------------------------------------------------- -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- -------------------------------------------------------------- -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ri-close-line fs-6 ri-menu-2-line"></i>
                    </a>
                    <!-- -------------------------------------------------------------- -->
                    <!-- Logo -->
                    <!-- -------------------------------------------------------------- -->
                    <a class="navbar-brand" href="{{ADMIN_URL}}/dashboard">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{url('/')}}/assets/admin/images/logo.png" alt="Dashboard" width="34%"/>
                            
                        </b>
            
                    </a>
                    <!-- -------------------------------------------------------------- -->
                    <!-- End Logo -->
                    <!-- -------------------------------------------------------------- -->
                    <!-- -------------------------------------------------------------- -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- -------------------------------------------------------------- -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                           data-feather="more-horizontal" class="feather-sm"></i></a>
                </div>
                <!-- -------------------------------------------------------------- -->
                <!-- End Logo -->
                <!-- -------------------------------------------------------------- -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- -------------------------------------------------------------- -->
                    <!-- toggle and nav items -->
                    <!-- -------------------------------------------------------------- -->
                    <ul class="navbar-nav me-auto">
                        <!-- This is  -->
                        <li class="nav-item"> <a
                                class="nav-link sidebartoggler d-none d-md-block waves-effect waves-dark"
                                href="javascript:void(0)"><i data-feather="menu" class="feather-sm"></i></a> </li>
                    </ul>
                    <!-- -------------------------------------------------------------- -->
                    <!-- Right side toggle and nav items -->
                    <!-- -------------------------------------------------------------- -->
                    <ul class="navbar-nav justify-content-end">
                        <!-- -------------------------------------------------------------- -->
                        <!-- Search -->
                        <!-- -------------------------------------------------------------- -->
                        
                       
                        <!-- -------------------------------------------------------------- -->
                        <!-- Profile -->
                        <!-- -------------------------------------------------------------- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="{{SITE_URL}}/assets/admin/images/users/1.jpg" alt="user" width="30"
                                    class="profile-pic rounded-circle" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-end user-dd animated flipInY">
                                <a class="dropdown-item"  href="{{SITE_URL}}/admin/change-password">
                                <i data-feather="key"
                                        class="feather-sm text-success me-1 ms-1"></i>Change Password
                                </a>
                                <a class="dropdown-item" href="{{ADMIN_URL}}/logout"><i data-feather="log-out"
                                        class="feather-sm text-danger me-1 ms-1"></i> Logout</a>
                                <div class="dropdown-divider"></div>
                                
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- -------------------------------------------------------------- -->
        <!-- End Topbar header -->
        @include('admin.include.leftside')

        <div class="page-wrapper">
