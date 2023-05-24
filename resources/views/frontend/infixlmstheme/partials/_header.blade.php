<!doctype html>
<html dir="{{ isRtl() ? 'rtl' : '' }}" class="{{ isRtl() ? 'rtl' : '' }}" lang="en" itemscope
    itemtype="{{ url('/') }}">
<style>
    /* .header_area {
        padding: 17px 37px !important;
    } */
</style>

<head>
    {{--    @laravelPWA --}}
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ Settings('site_title') }}" />
    <meta property="og:description" content="{{ Settings('footer_about_description') }}" />
    <meta property="og:image" content=" @yield('og_image')" />

    <title>
        @yield('title')
    </title>
    @if (!empty(Settings('google_analytics')))
        Global site tag (gtag.js) - Google Analytics
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ Settings('google_analytics') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', '{{ Settings('google_analytics') }}');
        </script>
    @endif
    <!--Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ Settings('site_name') }}">

    <meta itemprop="image" content="{{ asset(Settings('logo')) }}">
    @if (routeIs('frontendHomePage'))
        <meta itemprop="description" content="{{ Settings('meta_description') }}">
        <meta property="og:description" content="{{ Settings('meta_description') }}">
        <meta itemprop="keywords" content="{{ Settings('meta_keywords') }}">
    @elseif(routeIs('courseDetailsView'))
        <meta itemprop="description" content="{{ $course->meta_description }}">
        <meta property="og:description" content="{{ $course->meta_description }}">
        <meta itemprop="keywords" content="{{ $course->meta_keywords }}">
    @elseif(routeIs('quizDetailsView'))
        <meta itemprop="description" content="{{ $course->meta_description }}">
        <meta property="og:description" content="{{ $course->meta_description }}">
        <meta itemprop="keywords" content="{{ $course->meta_keywords }}">
    @endif
    <meta itemprop="author" content="{{ Settings('site_name') }}">

    <!--Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ Settings('site_title') }}">

    <meta property="og:image" content="{{ asset(Settings('logo')) }}" />
    <meta property="og:image:type" content="image/png" />
    <link rel="manifest" href="site.webmanifest">
    <!--<link rel="shortcut icon" type="image/x-icon" href="{{ asset(Settings('favicon')) }}">-->
    <!-- Place favicon.ico in the root directory -->


    <x-frontend-dynamic-style-color />


    <link rel="stylesheet"
        href="{{ asset('public/frontend/infixlmstheme') }}/css/fontawesome.css{{ assetVersion() }} ">
    <link rel="stylesheet" href="{{ asset('public/backend/css/themify-icons.css') }}{{ assetVersion() }}" />
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/flaticon.css{{ assetVersion() }}">
    <link rel="stylesheet"
        href="{{ asset('public/frontend/infixlmstheme') }}/css/nice-select.css{{ assetVersion() }}">
    <link rel="stylesheet"
        href="{{ asset('public/frontend/infixlmstheme') }}/css/notification.css{{ assetVersion() }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/css/mega_menu.css') }}">

    <link href="{{ asset('public/backend/css/summernote-bs4.min.css') }}{{ assetVersion() }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/preloader.css') }}{{ assetVersion() }}" />

    {{-- @if (str_contains(request()->url(), 'tutor')) --}}
    {{-- FOR TUTOR PAYMENT --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    {{-- @endif --}}

    @if (str_contains(request()->url(), 'chat'))
        <link rel="stylesheet" href="{{ asset('public/backend/css/jquery-ui.css') }}{{ assetVersion() }}" />
        <link rel="stylesheet" href="{{ asset('public/backend/vendors/select2/select2.css') }}{{ assetVersion() }}" />
        <link rel="stylesheet" href="{{ asset('public/chat/css/style-student.css') }}{{ assetVersion() }}">
    @endif

    @if (auth()->check() && auth()->user()->role_id == 3 && !str_contains(request()->url(), 'chat'))
        <link rel="stylesheet" href="{{ asset('public/chat/css/notification.css') }}{{ assetVersion() }}">
    @endif

    @if (isModuleActive('WhatsappSupport'))
        <link rel="stylesheet" href="{{ asset('public/whatsapp-support/style.css') }}{{ assetVersion() }}">
    @endif
    <script>
        window.Laravel = {
            "baseUrl": '{{ url('/') }}' + '/',
            "current_path_without_domain": '{{ request()->path() }}',
            "csrfToken": '{{ csrf_token() }}',
        }
    </script>

    <script>
        window._locale = '{{ app()->getLocale() }}';
        window._translations = {!! json_encode(cache('translations'), JSON_INVALID_UTF8_IGNORE) !!}
    </script>

    @if (auth()->check() && auth()->user()->role_id == 3)
        <style>
            .admin-visitor-area {
                margin: 0 30px 30px 30px !important;
            }

            .dashboard_main_wrapper .main_content_iner.main_content_padding {
                padding-top: 50px !important;
            }

            .primary_input {
                height: 50px;
                border-radius: 0px;
                border: unset;
                font-family: "Jost", sans-serif;
                font-size: 14px;
                font-weight: 400;
                color: unset;
                padding: unset;
                width: 100%;

                @if ($errors->any())
                    margin-bottom: 5px;
                @else
                    margin-bottom: 30px;
                @endif

            }

            .primary_input_field {
                border: 1px solid #ECEEF4;
                font-size: 14px;
                color: #415094;
                padding-left: 20px;
                height: 46px;
                border-radius: 30px;
                width: 100%;
                padding-right: 15px;
            }

            .primary_input_label {
                font-size: 12px;
                text-transform: uppercase;
                color: #828BB2;
                display: block;
                margin-bottom: 6px;
                font-weight: 400;
            }

            .chat_badge {
                color: #ffffff;
                border-radius: 20px;
                font-size: 10px;
                position: relative;
                left: -20px;
                top: -12px;
                padding: 0px 4px !important;
                max-width: 18px;
                max-height: 18px;
                box-shadow: none;
                background: #ed353b;
            }

            .chat-icon-size {
                font-size: 1.35em;
                color: #687083;
            }

            .anchor_disabled {
                pointer-events: none !important;
                cursor: not-allowed !important;
                opacity: 0.5 !important;
            }
        </style>
    @endif


    @if (!empty(Settings('facebook_pixel')))
        Facebook Pixel Code
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', {{ Settings('facebook_pixel') }});
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id={{ Settings('facebook_pixel') }}/&ev=PageView&noscript=1" />
        </noscript>
        End Facebook Pixel Code
    @endif

    <input type="hidden" name="lat" class="lat" value="{{ Settings('lat') }}">
    <input type="hidden" name="lng" class="lng" value="{{ Settings('lng') }}">
    <input type="hidden" name="zoom" class="zoom" value="{{ Settings('zoom_level') }}">
    <input type="hidden" id="baseUrl" value="{{ url('/') }}">
    <input type="hidden" name="chat_settings" id="chat_settings" value="{{ env('BROADCAST_DRIVER') }}">
    <input type="hidden" name="slider_transition_time" id="slider_transition_time"
        value="{{ Settings('slider_transition_time') ? Settings('slider_transition_time') : 5 }}">
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme') }}/css/app.css{{ assetVersion() }}"
        media="screen,print">
    <link rel="stylesheet"
        href="{{ asset('public/frontend/infixlmstheme') }}/css/frontend_style.css{{ assetVersion() }}"
        media="screen,print">
    <script src="{{ asset('public/js/common.js') }}{{ assetVersion() }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    @yield('css')

    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/css/custom.css') }}">
</head>

<body>

    @include('secret_login')
