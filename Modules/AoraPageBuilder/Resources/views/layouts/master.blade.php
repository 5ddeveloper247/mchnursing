<!DOCTYPE html>
<html dir="{{ isRtl() ? 'rtl' : '' }}" class="{{ isRtl() ? 'rtl' : '' }}" lang="en" itemscope itemtype="{{ url('/') }}">

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

    <title>{{ Settings('site_title') }} | {{ $row->title }}</title>

    <link rel="stylesheet" href="{{ asset('public/backend/css/themify-icons.css') }}{{ assetVersion() }}" />

    <link rel="stylesheet" href="{{ asset('Modules/AoraPageBuilder/Resources/assets/css/bootstrap.min.css') }}"
        data-type="aoraeditor-style" />

    <link rel="stylesheet"
        href="{{ asset('public/frontend/infixlmstheme') }}/css/fontawesome.css{{ assetVersion() }} "
        data-type="aoraeditor-style">

    <link rel="stylesheet" href="{{ asset('Modules/AoraPageBuilder/Resources/assets/css/aoraeditor.css') }}"
        data-type="aoraeditor-style" />
    <link rel="stylesheet" href="{{ asset('Modules/AoraPageBuilder/Resources/assets/css/aoraeditor-components.css') }}"
        data-type="aoraeditor-style" />


    <link rel="stylesheet" type="text/css" data-type="aoraeditor-style"
        href="{{ asset('Modules/AoraPageBuilder/Resources/assets/css/style.css') }}">

    {{--    <link rel="stylesheet" type="text/css" data-type="aoraeditor-style" --}}
    {{--          href="{{asset('Modules/AoraPageBuilder/Resources/assets/css')}}/style1.css"> --}}

    @if (currentTheme() == 'infixlmstheme')
        <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/css/app.css') . assetVersion() }}"
            data-type="aoraeditor-style">
        <link rel="stylesheet" type="text/css" data-type="aoraeditor-style"
            href="{{ asset('public/frontend/infixlmstheme/css/frontend_style.css') . assetVersion() }}">
    @endif

    <x-frontend-dynamic-style-color></x-frontend-dynamic-style-color>

    @yield('styles')
    <style>

    </style>
    <script src="{{ asset('public/js/common.js') }}"></script>
    {{--    <script type="text/javascript" data-type="aoraeditor-script"--}}
    {{--            src="{{asset('Modules/AoraPageBuilder/Resources/assets/js/jquery-1.11.3.min.js')}}"></script> --}}

    <link rel="stylesheet" href="{{ asset('public/css/preloader.css') }}" />

    <script type="text/javascript" src="{{ asset('public/frontend/infixlmstheme/js/jquery.lazy.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('public/frontend/infixlmstheme/css/custom.css') }}">

    <style>
        .owl-carousel .owl-dots {}

        small {
            display: none !important;
        }

        .work-wrap .img {
            height: 350px;
        }

        .work-wrap .text {
            background: #ffffff;
            height: 350px;
        }

        .leftimg {
            background-image: url("images/work-4.jpg") !important;
            height: 340px;
            background-size: cover !important;
        }

        .leftimg1 {
            background-image: url("images/work-1.jpg") !important;
            height: 340px;
            background-size: cover !important;
        }

        .owl-nav {
            margin-top: -100px !important;
        }

        .owl-carousel .owl-nav .owl-next {
            left: 12%;
            margin-top: -125px;
            margin-left: 400px;
            position: relative;
            font-size: 60px !important;
            color: white !important;
        }

        .owl-carousel .owl-nav button.owl-prev {
            z-index: 12 !important;
            position: relative;
            display: block;

            font-size: 60px;
            left: 63%;
            font-size: 60px !important;
            top: -37px;
            color: white;
        }

        .owl-carousel .owl-nav .owl-prev span:before,
        .owl-carousel .owl-nav .owl-next span:before {
            font-size: 60px;
            font-weight: bold;
            color: white;
        }

        .ftco-section {
            padding: 0px;
        }

        .header_area {
            padding: 17px 37px !important;
        }

        .paragraph h1 {
            /* font-size: 55px; */

            font-size: 38px;
            font-weight: 800;
        }

        .category_area .couses_category {
            background: #fff;
            box-shadow: 0 3px 20px rgb(0 0 0 / 5%);
            border-radius: 20px;
            padding: 65px 70px 40px;
            position: relative;
            margin-top: 60px !important;
            margin-bottom: 0px !important;
        }

        .category_area {
            background: #f6e2e2;
            padding-bottom: 60px !important;

        }

        .iconsdo {

            border: 1px solid rgb(255, 255, 255);
            box-shadow: 0 3px 20px rgb(0 0 0 / 5%);
        }

        .iconsdo:hover {

            border: 1px solid rgb(255, 255, 255);
        }

        .iconsdo i {
            font-size: 30px;

            padding: 16px 20px;
            background: #fff0f0;
            border-radius: 50%;
            color: red;
        }

        .testmonial_area {
            background: #f8f8fe;
            padding-top: 140px;
            padding-bottom: 40px !important;
        }


        .submit1 {
            background: red !important;
            color: white !important;
            height: 50px;
            width: 146px;
            margin-top: 1rem;
        }

        .submit1:hover {
            background: rgb(253, 253, 253) !important;
            border: 1px solid red;
            color: red !important;
            height: 50px;
            width: 146px;


        }

        .lorem {
            font-weight: 500;
            font-size: 17px;
            color: gray;

            line-height: 30px;

        }

        .learnmore {


            font-size: 19px;
            font-weight: bold;
            border-bottom: 2px solid black;
            color: black;

        }

        body {
            font-family: sans-serif;
            font-style: normal;
            font-weight: 400;
        }

        .boxbanner h1 {
            font-size: 47px;
            font-weight: bold;

            padding-top: 8rem !important;
        }

        .boxbanner {}

        .controlbox {
            margin: auto;
            width: 1285px;
        }

        .mainbanner {
            height: 530px;
            background-image: url("{{ asset('public/frontend/infixlmstheme/img/images/courses-4.jpg') }}");
            background-size: cover;
            color: white;
        }

        .bgcolor {
            background-color: whitesmoke;
        }

        .rightbox h4 {
            font-weight: bold;
        }

        .rightbox p {
            /* font-weight: bold; */
            margin-bottom: 0px;
        }

        .bgwebs {

            background-color: #ff1949;
        }

        .bgwebs:hover {

            background-color: #100f0f;
        }

        .color {

            color: #ff1949;
        }

        .courseimg {
            position: relative;

        }

        .coursebtn {
            position: absolute;
            bottom: 25px;
            right: 0px;
            padding: 8px 29px;
        }

        .coursedata h5 {

            font-weight: 800;
            font-size: 26px;

        }

        .just {
            text-align: justify;
        }

        .p {

            color: #444;
            font-family: "Open Sans", sans-serif;
            font-size: 15px;
            font-weight: 300;
            line-height: 24px;
        }

        .span::before {
            content: "\f518";
            font-family: "Font Awesome 5 Free";
            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-weight: 900;

        }

        .rating::before {

            content: "\f017";

            font-family: "Font Awesome 5 Free";

            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-weight: 900;

        }

        .rating {
            font-size: 13px;
        }

        .span {
            font-size: 13px;
        }

        .spane {
            font-size: 17px;
            font-weight: bold;
        }

        .coureparagraph p {

            line-height: 20px;
        }

        .instabox i {

            font-size: 55px;
            cursor: pointer;

        }

        .instabox {
            /* font-size: 40px; */
            text-align: center;
        }

        /* .instabox img:hover{
        opacity: .5;
    } */
        .courseimg {
            background-color: black;
        }

        .courseimg img {
            height: 270px;
            width: 100%;
        }

        .courseimg img:hover {
            opacity: 0.5;
            /* transform: scale(1.1); */
        }

        .just {
            /*
            height: 57px;
            overflow: hidden; */
        }

        .title_des+* {
            /* height: 80px!important;
        overflow: hidden;
        font-family: "Open Sans", sans-serif;
        font-size: 14px;
        font-weight: 300;
        text-align: justify; */
        }

        .coursedata label {}

        .title_des {

            font-size: 17px;
            text-align: justify;
            height: 80px;
            overflow: hidden;
        }

        .file {

            width: 80%;
        }

        .mainbanner {
            height: 250px;
            background-image: url("images/banner.jpg");
        }

        .bgcolor {
            background-color: whitesmoke;
        }

        .rightbox h4 {
            font-weight: bold;
        }

        .rightbox p {
            /* font-weight: bold; */
            margin-bottom: 0px;
        }

        .bgwebs {
            background-color: #ff1949;
        }

        .color {
            color: #ff1949;
        }

        .courseimg {
            position: relative;
        }

        .coursebtn {
            position: absolute;
            bottom: 25px;
            right: 0px;
            padding: 8px 29px;
        }

        .coursedata h5 {
            font-weight: 800;
            font-size: 20px;
        }

        .just {
            text-align: justify;
        }

        .p {
            color: #444;
            font-family: "Open Sans", sans-serif;
            font-size: 15px;
            font-weight: 300;
            line-height: 24px;
        }

        .span::before {
            content: "\f518";
            font-family: "Font Awesome 5 Free";
            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-weight: 900;
        }

        .rating::before {
            content: "\f017";

            font-family: "Font Awesome 5 Free";

            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-weight: 900;
        }

        .rating {
            font-size: 13px;
        }

        .span {
            font-size: 13px;
        }

        .spane {
            font-size: 17px;
            font-weight: bold;
        }

        .coureparagraph p {
            line-height: 20px;
        }

        .insta img:hover {
            transition: 1s;
            opacity: 0.8;
        }

        .footerbox h4 {
            font-weight: 700;
            color: white;
            font-size: 35px;
        }

        .footerbox {

            padding: 25px;

            margin-left: 0%;

        }

        .expore h4 {
            font-weight: 700;
            color: white;
            font-size: 24px;
        }

        .footerbox1 h4 {
            font-weight: 700;
            color: white;
            font-size: 24px;
        }

        .footerbox h5 {
            font-weight: 400;
        }

        .footerbox p {
            line-height: 30px !important;
            font-size: 16px !important;
            color: white;
            cursor: pointer !important;

        }

        .footerbox p:hover {
            line-height: 30px !important;
            font-size: 16px !important;
            color: rgb(248, 0, 0);
        }

        .footerbox1 p {
            line-height: 30px !important;
            font-size: 17px !important;
            color: white;
            cursor: pointer;
            transition: 1s;
        }

        .footerbox1 p:hover {
            line-height: 30px !important;
            font-size: 17px !important;
            color: rgb(255, 0, 0);
            text-decoration: underline;
        }

        .expore p {
            line-height: 30px !important;
            font-size: 17px !important;
            color: white;
            cursor: pointer !important;
            transition: 1s;
        }

        .expore p:hover {
            line-height: 30px !important;
            font-size: 17px !important;
            color: rgb(255, 0, 0);
            text-decoration: underline;
        }

        .icons i {
            font-size: 12px;
            padding: 3px;
            cursor: pointer;
        }

        .icons i:hover {
            color: #ff1949;

            font-size: 12px;
            padding: 3px;
        }

        .fonts {
            font-size: 17px;
            font-weight: 400;
            text-align: justify;
            margin-top: 3px;
        }

        .mdo {
            height: 670px;
        }

        .vidicons {
            width: 66px;
            position: relative;
            height: 66px;
            background: white;
            text-align: center;
            border-radius: 50%;
            top: 225px;
            cursor: pointer;
            transition: .5s;
        }

        .vidicons i {
            color: red;
            padding: 28px;
            font-size: 17px;
        }

        .vidicons:hover {
            box-shadow: 0px 1px 15px 7px red;
        }

        .video1 {
            background: url("{{ asset('public/frontend/infixlmstheme/img/images/courses-1.jpg') }}");
            height: 670px;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .imgsiteka {
            height: 800px;
            background-image: url("{{ asset('public/assets/ban.jpg') }}");
            background-repeat: no-repeat;
        }

        .imgsiteka h1 {

            font-size: 80px;
            line-height: 70px;
            font-family: Poppins, sans-serif;
            color: #252525;
            font-weight: bold;
            color: white;
            padding-top: 400px;
        }

        .readmore {

            color: white;
            border: 3px solid;
            padding: 13px 35px;
            font-size: 28px;
        }

        .readmore:hover {

            color: white;
            border: 3px solid;
            padding: 13px 35px;
            font-size: 28px;
        }

        .learnmoredo h1 {
            font-size: 44px;
            /* padding: 3rem!important; */
            font-weight: bold;
        }

        .learnmoredo1 h1 {
            font-size: 20px;
            /* padding: 3rem!important; */
            font-weight: bold;
            margin-top: 12rem !important;
            color: white;
        }

        .learnmoredo button {
            margin-top: 1rem;
            font-size: 15px;
            font-weight: bold;
            padding: 12px 16px;
            border: 1px solid red;
            border-radius: 5px;
            color: rgb(255, 255, 255);
            background: red;
        }

        .learnmoredo button:hover {
            margin-top: 1rem;
            font-size: 15px;
            font-weight: bold;
            padding: 12px 16px;
            border: 1px solid red;
            border-radius: 5px;
            background: white;
            color: red;
            transition: .5s;
        }

        .testmonial_area {
            background: #f8f8fe;
            padding-top: 40px !important;
            padding-bottom: 40px !important;
        }

        .testmonial_area .single_testmonial {
            min-height: 310px !important;
        }

        .blog_area {
            padding-top: 30px !important;
            padding-bottom: 30px !important;
        }

        .osdemana {
            background: #252525;
        }

        .fontawesome {

            font-size: 16px;
        }

        .bozado {
            height: 450px;
        }

        .iconscont i {
            font-size: 17px;
            margin: 5px;
        }

        .iconscont span {
            line-height: 35px;
            font-size: 16px;

        }

        .shad {
            border: 0px solid rgb(255, 255, 255);
            box-shadow: 0 3px 20px rgb(0 0 0 / 10%);
        }

        .shad1 {
            border: 0px solid rgb(255, 255, 255);
            box-shadow: 0 3px 20px rgb(0 0 0 / 30%);
        }

        .imgdata {
            background: url("{{ asset('public/frontend/infixlmstheme/img/images/courses-4.jpg') }}");
            background-size: cover;
            height: 402px;
        }

        .cont1do img {
            height: 400px;
        }

        .ourprogram p {

            font-size: 18px;
            font-family: Jost, sans-serif;
            color: #373737;
            line-height: 26px;
        }

        .websitetext {
            font-size: 18px;
            font-family: Jost, sans-serif;
            color: #373737;
            line-height: 26px;

        }

        .owl-carousel .owl-dots {
            display: none !important;
        }

        .para p {
            line-height: 23px;
        }

        .para i {
            color: #e4e400;
        }

        .para .d {
            color: #e4e400;
            padding-left: 8px;
        }

        @media (max-width: 500px) {
            .imgsiteka {
                height: 600px;
            }

            .imgsiteka h1 {

                font-family: Poppins, sans-serif;
                font-weight: bold;
                font-size: 52px !important;
                color: white;
                padding-top: 253px !important;
                line-height: 50px;



            }

            .learnmoredo {
                height: 300px;
            }

            .cont1do img {
                height: 400px;
                width: 100%;
            }
        }

        .contform input {

            height: 30px !important;
        }

        .contform select {
            /*
          height: 30px!important; */
        }

        .contform .form-control {

            width: 96% !important;
        }

        .osdemana {

            height: 670px;
        }

        .viewall {
            background: rgb(255, 2, 2);
            border: 1px solid red;
            color: rgb(255, 255, 255);
            font-weight: bold;
            border-radius: 4px;
        }

        .viewall:hover {
            background: white;
            border: 1px solid red;
            color: red;
            font-weight: bold;
            border-radius: 4px;
        }

        .footercolor {
            background: #252525;
        }

        .cont1doimgdo {
            background: url("{{ asset('public/frontend/infixlmstheme/img/images/courses-4.jpg') }}");
            background-size: cover;
            height: 400px;
            background: red;

        }
    </style>
</head>

<body>
    @include('preloader')
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

    <script>
        window.jsLang = function(key, replace) {
            let translation = true

            let json_file = $.parseJSON(window._translations[window._locale]['json'])
            translation = json_file[key] ?
                json_file[key] :
                key


            $.each(replace, (value, key) => {
                translation = translation.replace(':' + key, value)
            })

            return translation
        }
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
        </style>
    @endif


    @if (!empty(Settings('facebook_pixel')))
        <!-- Facebook Pixel Code -->
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
        <!-- End Facebook Pixel Code -->
    @endif

    <input type="hidden" id="url" value="{{ url('/') }}">
    <input type="hidden" name="lat" class="lat" value="{{ Settings('lat') }}">
    <input type="hidden" name="lng" class="lng" value="{{ Settings('lng') }}">
    <input type="hidden" name="zoom" class="zoom" value="{{ Settings('zoom_level') }}">
    <input type="hidden" name="slider_transition_time" id="slider_transition_time"
        value="{{ Settings('slider_transition_time') ? Settings('slider_transition_time') : 5 }}">
    <input type="hidden" name="base_url" class="base_url" value="{{ url('/') }}">
    <input type="hidden" name="csrf_token" class="csrf_token" value="{{ csrf_token() }}">
    @if (auth()->check())
        <input type="hidden" name="balance" class="user_balance" value="{{ auth()->user()->balance }}">
    @endif
    <input type="hidden" name="currency_symbol" class="currency_symbol" value="{{ Settings('currency_symbol') }}">
    <input type="hidden" name="app_debug" class="app_debug" value="{{ env('APP_DEBUG') }}">
    <div data-aoraeditor="html">
        @include(theme('partials._menu'))
        <div id="content-area">
            @yield('content')
        </div>
        @include(theme('partials._footer'))

    </div>


    <script type="text/javascript" src="{{ asset('Modules/AoraPageBuilder/Resources/assets/js/bootstrap.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('Modules/AoraPageBuilder/Resources/assets/js/jquery-ui.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('Modules/AoraPageBuilder/Resources/assets/js/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Modules/AoraPageBuilder/Resources/assets/js/form-builder.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('Modules/AoraPageBuilder/Resources/assets/js/form-render.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('Modules/AoraPageBuilder/Resources/assets/js/aoraeditor.js') }}"></script>

    <script type="text/javascript"
        src="{{ asset('Modules/AoraPageBuilder/Resources/assets/js/aoraeditor-components.js') }}"></script>


    @yield('scripts')


    <script type="text/javascript" data-aoraeditor="script">
        $(function() {
            // $('.dynamicData').each(function (i, obj) {
            //     aoraEditor.loadDynamicContent($(this));
            // });


        });
        $(function() {
            if ($.isFunction($.fn.lazy)) {
                $('.lazy').lazy();
            }
        });
    </script>
</body>

</html>
