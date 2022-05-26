<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Unauthorized - 401</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">

    <!-- preloader css -->
    <link rel="stylesheet" href="{{asset('css/preloader.min.css')}}" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{asset('css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- <body data-layout="horizontal"> -->

    <div class="my-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5">
                        <h1 class="display-1 fw-semibold">4<span class="text-primary mx-2">0</span>1</h1>
                        @if($exception->getMessage())
                            <h4 class="text-uppercase">{{$exception->getMessage()}}</h4>
                        @else
                            <h4 class="text-uppercase">Bạn không được phép truy cập trang này. Liên hệ với admin nếu bạn cho rằng đây là một lỗi.</h4>
                        @endif
                        <div class="mt-5 text-center">
                            <a class="btn btn-success waves-effect waves-light" href="{{ url()->previous() }}">Trở lại</a>
                            <a class="btn btn-primary waves-effect waves-light" href="{{route('permissionHandle')}}">Trở về trang chủ</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10 col-xl-8">
                    <div>
                        <img src="{{asset('images/error-img.png')}}" alt="" class="img-fluid">
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end content -->

    <!-- JAVASCRIPT -->
    <script src="{{asset('libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('libs/feather-icons/feather.min.js')}}"></script>
    <!-- pace js -->
    <script src="{{asset('libs/pace-js/pace.min.js')}}"></script>

    <script src="{{asset('js/app.js')}}"></script>

</body>

</html>