<base href="">
<meta charset="utf-8" />
<title>Oprnize | Dashboard</title>
<meta name="description" content="Latest updates and statistic charts">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta content="no-cache" />
<!--begin::Fonts -->
{{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">--}}

<!--end::Fonts -->
<!--end::Page Vendors Styles -->
<link href="{{asset('assets/css/pages/invoices/invoice-2' .( App::isLocale('ar')?'.rtl':'') . '.css')}}" rel="stylesheet" type="text/css" />

<!--begin::Global Theme Styles(used by all pages) -->
<link href="{{asset('assets/plugins/global/plugins.bundle' . (App::isLocale('ar')?'.rtl':'') . '.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/css/style.bundle' .( App::isLocale('ar')?'.rtl':'') . '.css')}}" rel="stylesheet" type="text/css" />

<link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" />
<link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" />
<link href="{{asset('assets/style.css')}}" rel="stylesheet" type="text/css" />
@stack('styles')
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

    @media print {
        .print-mode {
            color: #fff;
            background-color: #343a40;
            border-color: #454d55;
        }
        .btnprn,lab{
            display: none;
        }
        #voucher{
            transform: rotate(90deg);
            margin-top: 380px;
        }
        @page {
            padding: 20cm;
        }

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

    .kt-wizard-v1 .kt-wizard-v1__wrapper .kt-form {
        width: 80%;
    }

</style>
