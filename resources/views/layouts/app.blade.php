<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
    <head>
        <base href="../../../">
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Imperator - Aplicación de inventario</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
        <script src="{{ asset('js/jquery-3.6.0.js') }}"></script>

        @yield('scripts')

        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/layout/header/base/light.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/layout/brand/dark.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('css/layout/aside/dark.css') }}" rel="stylesheet" type="text/css"/>


        <link rel="shortcut icon" href="{{ asset('imagenes/Icon.ico') }}"/>
        @yield('styles')
    </head>

    <body  id="kt_body"  class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"  >

        <!--begin::Main-->
    <!--begin::Header Mobile-->
        <div id="kt_header_mobile" class="header-mobile align-items-center  header-mobile-fixed " >
            <!--begin::Logo-->
            <a href="/">
                <img alt="Logo" src="<?php echo asset('assets/logo-light.png'); ?>"/>
            </a>
            <!--end::Logo-->

            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                        <!--begin::Aside Mobile Toggle-->
                @auth
                <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                    <span></span>
                </button>
                @endauth
                <!--end::Aside Mobile Toggle-->
                <!--begin::Topbar Mobile Toggle-->
                <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                    <span class="svg-icon svg-icon-xl"><!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"/>
                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                </button>
                <!--end::Topbar Mobile Toggle-->
            </div>
        <!--end::Toolbar-->
        </div>
<!--end::Header Mobile-->
        <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
            <div class="d-flex flex-row flex-column-fluid page">
                <!--begin::Aside-->
                <div class="aside aside-left  aside-fixed  d-flex flex-column flex-row-auto"  id="kt_aside">
                    <div class="brand flex-column-auto " id="kt_brand">
                        <a href="/" class="brand-logo">
                            <img alt="Logo" src="<?php echo asset('assets/logo-light.png'); ?>"/>
                        </a>
                        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
                            <span class="svg-icon svg-icon svg-icon-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
                                        <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
                                    </g>
                                </svg>
                            </span>
                        </button>
                    </div>
                    
                    <!--begin::Aside Menu-->
                    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                        <!--begin::Menu Container-->
                        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
                            @auth
                            @include('layouts.components.aside')
                            @endauth
                        </div>
                    </div>
                </div>
                <!--end::Aside-->


                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    <!--begin::Header-->
                    <div id="kt_header" class="header  header-fixed " >
                        <!--begin::Container-->
                        <div class=" container-fluid  d-flex align-items-stretch justify-content-between">
                                    <!--begin::Header Menu Wrapper-->
                            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                            </div>
                            <!--end::Header Menu Wrapper-->
                        <!--begin::Topbar-->
                            <div class="topbar">
                                        <!--begin::User-->
                                <div class="topbar-item">
                                    <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                                        @guest
                                            @if (Route::has('login'))
                                                <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">
                                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Entrar') }}</a>
                                                </span>
                                            @endif
                                        @else
                                        <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hola,</span>
                                        <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ Auth::user()->name }}</span>
                                        <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                                            <span class="symbol-label font-size-h5 font-weight-bold"><?php echo substr(Auth::user()->name,0,1); ?></span>
                                        </span>
                                        @endguest
                                    </div>
                                </div>
                                <!--end::User-->
                            </div>
                            <!--end::Topbar-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Content-->
                    <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Subheader-->
                        <div class="subheader py-2 py-lg-6  subheader-solid " id="kt_subheader">
                            <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center flex-wrap mr-1">
                                    <!--begin::Page Heading-->
                                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                                        <!--begin::Page Title-->
                                        <h5 class="text-dark font-weight-bold my-1 mr-5">
                                            @yield('titulo')
                                        </h5>
                                        <!--end::Page Title-->
                                    </div>
                                    <!--end::Page Heading-->
                                </div>
                                <!--end::Info-->
                            </div>
                        </div>
                        <div class="d-flex flex-column-fluid">
                            <!--begin::Container-->
                            <div class=" container ">
@if (Session::has('success'))
    <div class="alert alert-custom alert-success alert-shadow gutter-b" role="alert">
        <div class="alert-text">
            <strong>Éxito !</strong> {{ session('success') }}
        </div>
    </div>
@endif
@if (Session::has('error'))
    <div class="alert alert-custom alert-danger alert-shadow gutter-b" role="alert">
        <div class="alert-text">
            <strong>Error !</strong> {{ session('error') }}
        </div>
    </div>
@endif
    
                                @yield('content')
        </div>
        <!--end::Container-->
    </div>
<!--end::Entry-->
                </div>
                <!--end::Content-->

                                    <!--begin::Footer-->
<div class="footer bg-white py-4 d-flex flex-lg-column " id="kt_footer">
    <!--begin::Container-->
    <div class=" container-fluid  d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-2">{{date('Y')}}&copy;</span>
            <a href="#" target="_blank" class="text-dark-75 text-hover-primary">Imperator</a>
        </div>
        <!--end::Copyright-->

        <!--begin::Nav-->
        <div class="nav nav-dark">
            <a href="https://www.instagram.com/imperator.la/" target="_blank" class="nav-link pl-0 pr-5"><i class="flaticon-instagram-logo"></i> Instagram</a>
            <a href="https://wa.me/584267835498" target="_blank" class="nav-link pl-0 pr-5"><i class="flaticon-whatsapp"></i> Whatsapp</a>
        </div>
        <!--end::Nav-->
    </div>
    <!--end::Container-->
</div>
<!--end::Footer-->
                            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
<!--end::Main-->
    @auth
    @include('layouts.components.profile')
    @endauth
        <!--begin::Global Config(global config for global JS scripts)-->
        <script>
            var KTAppSettings = {
                "breakpoints": {
                    "sm": 576,
                    "md": 768,
                    "lg": 992,
                    "xl": 1200,
                    "xxl": 1400
                },
                "colors": {
                    "theme": {
                        "base": {
                            "white": "#ffffff",
                            "primary": "#3699FF",
                            "secondary": "#E5EAEE",
                            "success": "#1BC5BD",
                            "info": "#8950FC",
                            "warning": "#FFA800",
                            "danger": "#F64E60",
                            "light": "#E4E6EF",
                            "dark": "#181C32"
                        },
                        "light": {
                            "white": "#ffffff",
                            "primary": "#E1F0FF",
                            "secondary": "#EBEDF3",
                            "success": "#C9F7F5",
                            "info": "#EEE5FF",
                            "warning": "#FFF4DE",
                            "danger": "#FFE2E5",
                            "light": "#F3F6F9",
                            "dark": "#D6D6E0"
                        },
                        "inverse": {
                            "white": "#ffffff",
                            "primary": "#ffffff",
                            "secondary": "#3F4254",
                            "success": "#ffffff",
                            "info": "#ffffff",
                            "warning": "#ffffff",
                            "danger": "#ffffff",
                            "light": "#464E5F",
                            "dark": "#ffffff"
                        }
                    },
                    "gray": {
                        "gray-100": "#F3F6F9",
                        "gray-200": "#EBEDF3",
                        "gray-300": "#E4E6EF",
                        "gray-400": "#D1D3E0",
                        "gray-500": "#B5B5C3",
                        "gray-600": "#7E8299",
                        "gray-700": "#5E6278",
                        "gray-800": "#3F4254",
                        "gray-900": "#181C32"
                    }
                },
                "font-family": "Poppins"
            };
        </script>
        <!--end::Global Config-->

        <!--begin::Global Theme Bundle(used by all pages)-->
                   <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
                   <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
                   <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
                <!--end::Global Theme Bundle-->
            </body>
    <!--end::Body-->
</html>