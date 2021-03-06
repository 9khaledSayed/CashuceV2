<!DOCTYPE html>

<html lang="{{App::getLocale()}}" @if(App::isLocale('ar'))dir="rtl"@endif>

<!-- begin::Head -->
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <title>{{__('Cashuce')}}</title>
    <meta name="description" content="Login page example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
{{--    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">--}}
    <link href="{{asset('assets/css/pages/login/login-1.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
    <link href="{{asset('assets/style.css')}}" rel="stylesheet" type="text/css" />

    <style>
        /* -----
    SVG Icons - svgicons.sparkk.fr
    ----- */

        .svg-icon {
            width: 1em;
            height: 1em;
        }

        .svg-icon path,
        .svg-icon polygon,
        .svg-icon rect {
            fill: #4691f6;
        }

        .svg-icon circle {
            stroke: #4691f6;
            stroke-width: 1;
        }
        @font-face {
            font-family: Myriad Pro Regular;
            src: url('{{ asset('fonts/MyriadPro-Regular.otf') }}');
        }
        @font-face {
            font-family: DroidKufi Regular;
            src: url('{{ asset('fonts/Droid.Arabic.Kufi_DownloadSoftware.iR_.ttf') }}');
        }

        .form-group {
            margin-bottom: 1rem;
        }


        .required{
            color: red;
            font-size: 12px;
            font-weight: 900;
            margin: 4px;
        }



        li
        {
            list-style-type:none;
        }

        .swal-footer {
            text-align: center;
        }

        .swal-button--confirm {
            background-color: #4962B3;
            font-size: 12px;
            border: 1px solid #3e549a;
            text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.3);
        }

        .kt-login.kt-login--v1 .kt-login__wrapper .kt-login__body .kt-login__form {
            width: 100%;
            max-width: 541px;
        }

        @if(app()->getLocale() == 'ar')
        .kt-login.kt-login--v1 .kt-login__wrapper .kt-login__body .kt-login__form .kt-login__options > a:not(:last-child) {
            margin: 0 0 0 1.5rem;
        }
        @endif

        .form-control, .border11{
            border-radius: 0 0 11px 0;
        }
        @if(app()->isLocale('ar'))
            .border11{
            border-radius: 0 0 0 0;
        }
        .input-group > .form-control:not(:last-child), .input-group > .custom-select:not(:last-child) {
            border-bottom-right-radius: 11px;
        }
        @endif
    </style>
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">

<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">

            <!--begin::Aside-->
            <div class="kt-grid__item kt-grid__item--order-tablet-and-mobile-2 kt-grid kt-grid--hor kt-login__aside" style="background-image: url({{asset('assets/media/bg/bg-4.jpg')}});">
                <div class="kt-grid__item">
                    <a href="#" class="kt-login__logo">
                        <img src="{{asset('assets/media/logos/logo-4.png')}}">
                    </a>
                </div>
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver">
                    <div class="kt-grid__item kt-grid__item--middle mx-auto" >
                        <h1 class="kt-login__title">{{__('Human Resource Management System')}}</h1>
                    </div>
                </div>
                <div class="kt-grid__item">
                    <div class="kt-login__info">
                        <div class="kt-login__copyright">
                            &copy 2018 Metronic
                        </div>
                        <div class="kt-login__menu">
                            <a href="#" class="kt-link">Privacy</a>
                            <a href="#" class="kt-link">Legal</a>
                            <a href="#" class="kt-link">Contact</a>
                        </div>
                    </div>
                </div>
            </div>

            <!--begin::Aside-->

            <!--begin::Content-->
            <div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">

             @yield('content')
            </div>

            <!--end::Content-->
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#22b9ff",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Scripts(used by this page) -->
<script src="{{asset('assets/js/pages/custom/login/login-1.js')}}" type="text/javascript"></script>
<script src="{{asset('js/pages/globalScripts.js')}}" type="text/javascript"></script>

<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>
