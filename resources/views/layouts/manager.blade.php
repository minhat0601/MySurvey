<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>@yield('title') - Trung tâm quản lý khảo sát khách hàng</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template"
            name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('/images/favicon.ico')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- preloader css -->
        <link rel="stylesheet" href="{{asset('/css/preloader.min.css')}}"type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{asset('/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('/css/icons.min.css')}}" rel="stylesheet" type="text/css"
            />
        <!-- App Css-->
        <link href="{{asset('/css/app.min.css')}}" id="app-style" rel="stylesheet"
            type="text/css" />

        <!-- Custom Css -->
        <link href="{{asset('/css/custom.css')}}" rel="stylesheet" type="text/css" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

    </head>

    <body>

        <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="{{route('permissionHandle')}}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{asset('/images/logo-sm.svg')}}" alt=""
                                        height="24">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{asset('/images/logo-sm.svg')}}" alt=""
                                        height="24"> <span class="logo-txt">FPT</span>
                                </span>
                            </a>

                            <a href="{{route('permissionHandle')}}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{asset('/images/logo-sm.svg')}}" alt=""
                                        height="24">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{asset('/images/logo-sm.svg')}}" alt=""
                                        height="24"> <span class="logo-txt">FPT</span>
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3
                            font-size-16 header-item" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                        <!-- App Search-->
                        <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                <input type="text" class="form-control"
                                    placeholder="Search...">
                                <button class="btn btn-primary" type="button"><i
                                        class="bx bx-search-alt align-middle"></i></button>
                            </div>
                        </form>
                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item"
                                id="page-header-search-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i data-feather="search" class="icon-lg"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg
                                dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Search ..."
                                                aria-label="Search Result">
                                            <button class="btn btn-primary"
                                                type="submit"><i class="mdi
                                                    mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>



                        <div class="dropdown d-none d-sm-inline-block">
                            <button type="button" class="btn header-item"
                                id="mode-setting-btn">
                                <i data-feather="moon" class="icon-lg
                                    layout-mode-dark"></i>
                                <i data-feather="sun" class="icon-lg
                                    layout-mode-light"></i>
                            </button>
                        </div>


                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item
                                bg-soft-light border-start border-end"
                                id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <img class="rounded-circle header-profile-user"
                                    src="{{asset('/images/users/avatar-1.jpg')}}"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1
                                    fw-medium">{{Auth::user()['fullname']}}</span>
                                <i class="mdi mdi-chevron-down d-none
                                    d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="#"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Quản lý tài khoản</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('auth.logout')}}"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Đăng xuất</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" data-key="t-menu">Menu</li>
                            <li>
                                <a href="{{route('permissionHandle')}}">
                                    <i class="fas fa-home"></i>
                                    <span data-key="t-dashboard">Trang chủ</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i class="fas fa-clipboard-list"></i>
                                    <span data-key="t-apps">Khảo sát</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="{{route('manager.survey.create')}}">
                                            <span data-key="t-calendar" >Tạo khảo sát</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{route('manager.survey.mySurvey')}}">
                                            <span data-key="t-chat">Khảo sát đã tạo</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{route('manager.customer.myCustomer')}}">
                                    <i class="fas fa-user-friends"></i>
                                    <span data-key="t-authentication">Khách hàng</span>
                                </a>
                            </li>

                        </ul>

                        <div class="card sidebar-alert border-0 text-center mx-4
                            mb-0 mt-5">
                            <div class="card-body">
                                <img src="{{asset('/images/giftbox.png')}}" alt="">
                                <div class="mt-4">
                                    <h5 class="alertcard-title font-size-16">Unlimited
                                        Access</h5>
                                    <p class="font-size-13">Upgrade your plan
                                        from a Free trial, to select ‘Business
                                        Plan’.</p>
                                    <a href="#!" class="btn btn-primary mt-2">Upgrade
                                        Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content" id="miniaresult">
                <!--- Content --->
                @yield('content')
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script>
                            ©
                            Minia.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by <a href="#!"
                                    class="text-decoration-underline">Themesbrand</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->


        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center bg-dark
                    p-3">

                    <h5 class="m-0 me-2 text-white">Theme Customizer</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle
                        ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="m-0" />

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{asset('/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{asset('libs/feather-icons/feather.min.js')}}"></script>
        <!-- pace js -->
        <script src="{{asset('/libs/pace-js/pace.min.js')}}"></script>

        <script src="https://maps.google.com/maps/api/js?key=AIzaSyCtSAR45TFgZjOs4nBFFZnII-6mMHLfSYI"></script>

        <script src="{{asset('/js/app.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/notiflix@3.2.5/dist/notiflix-aio-3.2.5.min.js"></script>

        @yield('scripts')

    </body>

</html>