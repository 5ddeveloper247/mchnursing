@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ __('frontendmanage.Home') }}
@endsection
@section('css')
@endsection
@section('js')
@endsection

<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/slick/slick.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/slick/slick-theme.css') }}">
<script src="https://kit.fontawesome.com/b98cad50b5.js" crossorigin="anonymous"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css'>
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css" />
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-straight/css/uicons-regular-straight.css'>
{{-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script> --}}
<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-straight/css/uicons-solid-straight.css'>
{{-- carousel --}}
{{-- <link rel="stylesheet" href="{{ asset('public/assets/owl.carousel.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/assets/owl.theme.default.min.css') }}" /> --}}

<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css" />

<link rel="stylesheet" href="{{ asset('public/assets/owl.carousel.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/assets/owl.theme.default.min.css') }}" />

{{-- <link rel="stylesheet" href="{{ asset('public/assets/style.css') }}" /> --}}

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"> --}}

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
        height: 16.875rem;
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
        height: 50rem;
        background-image: url("{{ asset('public/assets/ban.jpg') }}");
        background-repeat: no-repeat;
    }

    .owl-nav {
        display: none !important;
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
        height: 405px;
        background: red;
    }
</style>
@section('mainContent')
    {{-- MainBanner --}}
    <div class="row m-0 p-0">
        <div class="col-md-6 col-12 p-0">
            <div class="imgsiteka">
                <h1 class="px-5">
                    The University <br> for creative<br> careers
                </h1>
                <br>
                <div class="mx-2 my-3">
                    <a href="{{ route('about') }}" class="readmore mx-5">
                        Read More
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12 p-0">
            <div class="row featured-carousel owl-carousel m-0">
                <div class="col-md-12 col-12 p-0">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                            <img src="{{ asset('public/assets/c2.jpg') }}" class="d-block" style="width: 100%;">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                            <div class="cont1doimgdo pt-4">
                                <h1 class="px-5 pt-5 text-white" style="font-weight: bold;font-size:30px;">
                                    usie metdu <br> amet lrsit, <br>natu al Upsytdo remu.
                                </h1>
                                <p class="px-5 pt-3 text-white" style="font-size: 18px;">
                                    Instructor Nicol , Brown
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-12 p-0">
                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                            <img src="{{ asset('public/assets/c3.jpg') }}" class="d-block" style="width: 100%;">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                            <div class="cont1doimgdo pt-4">
                                <h1 class="px-5 pt-5 text-white" style="font-weight: bold;font-size:30px;">
                                    Upsytdo remu<br> lrsit amet, <br>natu al usie metdu.
                                </h1>
                                <p class="px-5 pt-3 text-white" style="font-size: 18px;">
                                    Nicol Brown, Instructor
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6 col-12 p-0">
                    <div class="learnmoredo px-5 pt-5">
                        <h1 class="">Learn now things.<span style="color:red;">Get new skills.</span> join us.</h1>

                        <a href="{{ route('instructors') }}"><button classs="become mx-5">Become an Instructor</button></a>
                    </div>
                </div>
                <div class="col-md-6 col-12 mt-n2 p-0">
                    <div class="learnmoredo1 imgdata px-5 pt-5">
                        <h1 class="mt-5 pt-5" style="padding-top: 3rem;">Learn now things Get new skills join us.Learn
                            now things Get new skills join.</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (!empty($blocks))
        @foreach ($blocks as $block)
            @if ($block->id == 1)
                {{-- <x-home-page-banner :homeContent="$homeContent"/> --}}
                {{-- Courses --}}
            @elseif($block->id == 3)
                @if ($homeContent->show_category_section == 1)
                    <x-home-page-category-section :homeContent="$homeContent" :categories="$categories" />
                    {{-- How to Buy --}}
                    <div class="row pt-4">
                        <div class="col-md-12 s pt-1">
                            <div class="col-md-7 m-auto mb-5 pb-5 text-center">
                                <h2 style="font-weight:bold;">How To Apply</h2>
                                <p class="websitetext">The easiest way to buy stocks is through an online
                                    stockbroker.After opening and funding your account.</p>
                            </div>

                            <div class="row m-0">
                                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
                                    <div class="iconsdo p-5 text-center">
                                        <i class="fa-solid fa-bars"></i>
                                        <h6 class="my-3">Step 1</h6>
                                        <p class="websitetext">Trusted by companies of all sizes</p>
                                    </div>
                                </div>
                                <div class="col-md-3 pb-5" data-aos="zoom-in" data-aos-delay="600">
                                    <div class="iconsdo p-5 text-center">
                                        <i class="fa-regular fa-address-card"></i>
                                        <h6 class="my-3">Step 2</h6>
                                        <p class="websitetext">Trusted by companies of all sizes</p>
                                    </div>
                                </div>
                                <div class="col-md-3 pb-5" data-aos="zoom-in" data-aos-delay="900">
                                    <div class="iconsdo p-5 text-center"><i class="fa-solid fa-book-open-reader"></i>
                                        <h6 class="my-3">Step 3</h6>
                                        <p class="websitetext">Trusted by companies of all sizes</p>
                                    </div>
                                </div>
                                <div class="col-md-3 pb-5" data-aos="zoom-in" data-aos-delay="1200">
                                    <div class="iconsdo p-5 text-center"><i class="fa-regular fa-image"></i>
                                        <h6 class="my-3">Step 4</h6>
                                        <p class="websitetext">Trusted by companies of all sizes</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Map --}}

                    <div class="row shad m-0">
                        <div class="col-md-6 p-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row m-0">
                                        <div class="col-md-6 p-0">
                                            <div class="data p-4">
                                                <i class="fa-regular fa-lightbulb" style="font-size: 35px;color:red;"></i>
                                                <h1 style="font-weight: bold;" class="mt-3"> About Us</h1>
                                                <p class="lorem mb-3">Lorem ipsum dolor sit amet consectetur,
                                                    adipisicing elit. Aperiam, veritatis cupiditate obcaecati
                                                    accusantium totam est voluptate iusto quos eligendi possimus.</p>
                                                <a href="{{ route('about') }}" class="learnmore">Learn More </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 p-0">
                                            <div class="img">
                                                <img src="{{ asset('public/assets/ban.jpg') }}" style="width: 100%;"
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6 p-0">
                            <div class="img">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d26585.518296861614!2d73.13386923173827!3d33.600379866345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1674738639942!5m2!1sen!2s"
                                    height="400" style="border:0;width:100%;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>


                    </div>
                @endif
                {{-- Learning More --}}
            @elseif($block->id == 4)
                @if ($homeContent->show_instructor_section == 1)
                    <x-home-page-instructor-section :homeContent="$homeContent" />
                @endif
                {{-- @elseif($block->id==5)
                    @if ($homeContent->show_course_section == 1)
                        <x-home-page-course-section :homeContent="$homeContent"/>
                    @endif --}}
                {{-- @elseif($block->id==6)
                    @if ($homeContent->show_best_category_section == 1)
                        <x-home-page-best-category-section :homeContent="$homeContent" :categories="$categories"/>
                    @endif --}}
                {{-- Our Courses
                  --}}
                <div class="row my-3 p-2">
                    <div class="col-md-12">
                        <div class="ourprogram pb-3 text-center">
                            <h1 style="font-weight: bold;">Our Programs</h1>
                            <p class="pb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem exerc <br>
                                voluptatibus neque et obcaecati asperiores! Praesentium magnam error veritatis
                                adipisicing elit. Dolorem exerc</p>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row px-sm-1 mb-5">
                                    @if (isset($lastest_programs))
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @foreach ($lastest_programs as $lastest_program)
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12 my-3 mx-2 px-0"
                                                data-aos-delay="{{ $counter * 500 }}" data-aos="fade-down">
                                                <div class="courseimg">
                                                    <a href="{{ route('programs.detail', [$lastest_program->id]) }}">
                                                        <img src="{{ getCourseImage($lastest_program->icon) }}"
                                                            class="img-fluid img-cover"></a>
                                                </div>
                                                <div class="coursedata label">
                                                    <h5 class="f-bolder mt-4">
                                                        <a {{ route('programs.detail', [$lastest_program->id]) }}>
                                                            {{ $lastest_program->programtitle }}</a>
                                                    </h5>
                                                    <div class="title_des pb-2" style="">
                                                        {!! $lastest_program->discription !!}
                                                    </div>
                                                    <div class="row pt-4">
                                                        <div class="col-md-5 col">
                                                            <span class="span">
                                                                {{ count(json_decode($lastest_program->allcourses)) }}
                                                                courses
                                                            </span>
                                                        </div>
                                                        <div class="col-md-4 col p-0">
                                                            <span class="rating">
                                                                {{ $lastest_program->duration }} weeks
                                                            </span>
                                                        </div>
                                                        <div class="col-md-3 col p-0">
                                                            <p class="spane color">
                                                                ${{ $lastest_program->totalcost }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $counter++;
                                            @endphp
                                        @endforeach
                                    @endif
                                    @if (count($lastest_programs) == 0)
                                        <div class="col-lg-12">
                                            <div
                                                class="Nocouse_wizged d-flex align-items-center justify-content-center text-center">
                                                <div class="thumb">
                                                    <img style="width: 50px"
                                                        src="{{ asset('public/frontend/infixlmstheme') }}/img/not-found.png"
                                                        alt="">
                                                </div>
                                                <h1>
                                                    {{ __('No Program Found') }}
                                                </h1>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                {{-- Video Section --}}

                {{-- Article  --}}
            @elseif($block->id == 8)
                @if ($homeContent->show_testimonial_section == 1)
                    {{-- <x-home-page-testimonial-section :homeContent="$homeContent"/> --}}
                @endif
                <div class="row p-2" style="background: rgb(240 246 251);">
                    <div class="col-md-12">
                        <div class="ourprogram mt-4 pb-2 text-center">
                            <h1 style="font-weight: 800; font-size: 48px;">
                                What Our Student Have To <br> Say</h1>
                            <p style="font-size:19px;">
                                The world’s largest selection of courses choose from 130,000 online video courses <br>with
                                new additions published every month
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row zakana m-0 py-4" style="background: rgb(240 246 251); justify-content: space-around; ">
                    @foreach ($lastest_course_reveiws as $course_reveiw)
                        <div class="col-md-12">
                            <div class="row m-0 p-4">
                                <div class="col-md-12 col-sm-6 bg-white" style="border-radius: 7px;">
                                    <div class="row p-5">
                                        <div class="col-md-2">
                                            <div class="image mt-2">
                                                <img src="{{ asset($course_reveiw->user->image) }}"
                                                    style="width: 77px; height: 77px; border-radius: 50%;" />
                                            </div>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="para m-3 mt-3 px-3">
                                                <p style="font-weight: bold;">{{ $course_reveiw->user->name }}</p>
                                                {{--                                            <p style="color: black;">Writer</p> --}}
                                                @php
                                                    $main_stars = $course_reveiw->star;
                                                    $stars = intval($course_reveiw->star);
                                                @endphp
                                                @for ($i = 0; $i < $stars; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                                @if ($main_stars > $stars)
                                                    <i class="fas fa-star-half"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <p>
                                                {!! $course_reveiw->comment !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{--                    <div class="col-md-12"> --}}
                    {{--                        <div class="row m-0 p-4"> --}}
                    {{--                            <div class="col-md-12 bg-white" style="border-radius: 7px;"> --}}
                    {{--                                <div class="row p-5"> --}}
                    {{--                                    <div class="col-md-2"> --}}
                    {{--                                        <div class="image mt-2"> --}}
                    {{--                                            <img src="{{ asset('public/assets/c2.jpg') }}" --}}
                    {{--                                                style="width: 77px; height: 77px; border-radius: 50%;" /> --}}
                    {{--                                        </div> --}}
                    {{--                                    </div> --}}
                    {{--                                    <div class="col-md-10"> --}}
                    {{--                                        <div class="para m-3 mt-3 px-3"> --}}
                    {{--                                            <p style="font-weight: bold;">Lorem Ipsum</p> --}}
                    {{--                                            <p style="color: black;">Writer</p> --}}
                    {{--                                            <i class="fa-sharp fa-solid fa-star"></i><i --}}
                    {{--                                                class="fa-sharp fa-solid d fa-star"></i><i --}}
                    {{--                                                class="fa-sharp fa-solid d fa-star"></i><i --}}
                    {{--                                                class="fa-sharp fa-solid d fa-star"></i><i --}}
                    {{--                                                class="fa-sharp fa-solid d fa-star"></i> --}}
                    {{--                                        </div> --}}
                    {{--                                    </div> --}}
                    {{--                                    <div class="col-md-12 mt-3"> --}}
                    {{--                                        <p> --}}
                    {{--                                            “Lorem Ipsum is simply dummy text of the printing and --}}
                    {{--                                            typesetting industry. Lorem Ipsum has been the industry's --}}
                    {{--                                            standard dummy text ever since the 1500s, when an unknown --}}
                    {{--                                            printer took a galley of type and scrambled it to make a type --}}
                    {{--                                            specimen book” --}}
                    {{--                                        </p> --}}
                    {{--                                    </div> --}}
                    {{--                                </div> --}}
                    {{--                            </div> --}}
                    {{--                        </div> --}}
                    {{--                    </div> --}}


                </div>
                {{-- @elseif($block->id==10)
                    @if ($homeContent->show_article_section == 1)
                        <x-home-page-blog-section :homeContent="$homeContent"/>
                    @endif --}}

                <div class="row p-2">
                    <div class="col-md-12">
                        <div class="ourprogram my-4 pb-3 text-center">
                            <h1 style="
                      font-weight: 800;
                      font-size: 48px;">
                                Articles & News</h1>
                            <p style="font-size:19px;">
                                The world’s largest selection of courses choose from 130,000 online video courses <br>with
                                new additions published every month
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row px-2">
                                    @if (isset($lastest_blogs))
                                        @foreach ($lastest_blogs as $lastest_blog)
                                            <div class="col-sm-6 col-md-3">
                                                <div class="courseimg">
                                                    <a href="{{ route('blogDetails', [$lastest_blog->slug]) }}"><img
                                                            src="{{ getBlogImage($lastest_blog->thumbnail) }}"
                                                            class="img-fluid"></a>
                                                </div>
                                                <div class="coursedata label">
                                                    <p class="title_des pt-3">
                                                        {{ $lastest_blog->user->name }} .
                                                        {{ showDate($lastest_blog->authored_date) }}
                                                    </p>
                                                    <h5 class="f-bolder mt-2"><a
                                                            href="{{ route('blogDetails', [$lastest_blog->slug]) }}">
                                                            {{ $lastest_blog->title }} </a></h5>

                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if (count($lastest_blogs) == 0)
                                        <div class="col-lg-12">
                                            <div
                                                class="Nocouse_wizged d-flex align-items-center justify-content-center text-center">
                                                <div class="thumb">
                                                    <img style="width: 50px"
                                                        src="{{ asset('public/frontend/infixlmstheme') }}/img/not-found.png"
                                                        alt="">
                                                </div>
                                                <h1>
                                                    {{ __('No Articles & News Found') }}
                                                </h1>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mt-4 text-center">
                                        <a href="{{ route('blogs') }}"
                                            class="viewall m-auto mb-4 px-5 py-2 text-center">View All </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>



                <div class="row mdo shad1 m-0 mt-5">
                    <div class="col-sm-6 col-md-6 p-0">
                        <div class="row">
                            <div class="col-sm-6 osdemana bozado col-md-6">


                                <div class="footerbox text-white">
                                    <h4>

                                        About us

                                    </h4>
                                    <p class="my-3" style="text-align: justify">
                                        MCOH is an inclusive and equitable enviroment that provides educational
                                        oppturities for anyone seeking update their skill being a new career path and
                                        enhance professional Skills </p>
                                    <div class="iconscont">
                                        <a class="mt-5 text-white" style="margin-top:2rem;">

                                            <i class="fi fi-rs-marker"></i>

                                        </a>

                                        <span class="locaton">
                                            50/s. florida Avenue lakeland, <span style="margin-left: 10%;">Fl 33801</span>

                                        </span><br>

                                        <i class="fi fi-br-phone-call"></i>
                                        <span class="call">
                                            863-250-8764/347-525-1736</span><br>
                                        <i class="fi fi-rs-clock-three"></i>

                                        <span class="time">
                                            Mon To Fr: 8:30Am To 7Pm</span>
                                    </div>
                                </div>


                            </div>
                            <div class="col-sm-6 col-md-6 shad1 p-0">
                                <div class="contform">
                                    <form method="POST" action="{{ route('contactMsgSubmit') }}" class="fe mx-4 my-3">
                                        <h2 class="" style="font-weight:bold;">Stay in touch!</h2>
                                        @csrf
                                        Your Name
                                        <input type="text" name="name" class="form-control mb-2" placeholder="">
                                        Email Address
                                        <input type="email" name="email" class="form-control mb-2" placeholder="">

                                        Phone #
                                        <input type="text" name="phone" class="form-control mb-2" placeholder="">

                                        Zip Code
                                        <input type="text" name="zip" class="form-control mb-2" placeholder="">

                                        <p>
                                            Select Programs
                                        </p>
                                        <select name="program" class="form-control mb-2" required>
                                            <option value="" selected>SELECT PORGRAM</option>
                                            <option value="REMEDIAL-RN(176 Hours)">REMEDIAL-RN(176 Hours)</option>
                                            <option value="Refresher-RM(Endorsement & inactive License)">
                                                Refresher-RM(Endorsement & inactive License)
                                            </option>
                                            <option value="NCLEX Refresher(Prep)">NCLEX Refresher(Prep)</option>
                                            <option value="CNA Exam Prep(Skills Testing)">CNA Exam Prep(Skills
                                                Testing)
                                            </option>
                                            <option value="Clinical-Proctor">Clinical-Proctor</option>
                                        </select>
                                        <p>
                                            High School Grad Year
                                        </p>
                                        <select name="year" class="form-control mb-2" required>
                                            <option value="" selected>Select year</option>
                                            <option value="1 year">1 year</option>
                                            <option value="2 year">2 year</option>
                                            <option value="3 year">3 year</option>
                                            <option value="4 year">4 year</option>
                                        </select>
                                        <p>
                                            Message
                                        </p>
                                        <textarea name="message" class="form-control" aria-required="true" aria-invalid="false" placeholder="Message"
                                            style="height:120px;" required></textarea>
                                        <div class="col-md-12 text-center" style="padding-left: 0%">

                                            <button type="submit" class="btn submit1 mt-2">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 p-0">
                        <div class="video1">
                            <div class="vidicons m-auto">
                                <i class="fa-solid fa-play"></i>
                            </div>
                        </div>
                    </div>
                </div>

                @include(theme('partials._custom_footer'))
            @elseif($block->id == 16)
                {{-- @if ($homeContent->show_how_to_buy == 1)
                    <x-home-page-how-to-buy :homeContent="$homeContent"/>
                @endif --}}
            @elseif($block->id == 17)
                {{-- @if ($homeContent->show_home_page_faq == 1)
                    <x-home-page-faq :homeContent="$homeContent"/>
                @endif --}}
            @endif
        @endforeach
    @endif
    <script src="https://maps.googleapis.com/maps/api/js?key={{ Settings('gmap_key') }}"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,


        });
    </script>

    {{-- <script src="{{ asset('public/assets/popper.js') }}"></script>
          <script src="{{ asset('public/assets/owl.carousel.min.js') }}"></script> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script src="{{ asset('public/assets/slick/slick.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        $('.zakana').slick({
            lazyLoad: 'ondemand',
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 2000,
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        (function($) {
            "use strict";

            var fullHeight = function() {
                $(".js-fullheight").css("height", $(window).height());
                $(window).resize(function() {
                    $(".js-fullheight").css("height", $(window).height());
                });
            };
            fullHeight();

            var carousel = function() {

                $(".owl-carousel").owlCarousel({
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    // navigation : true,

                    margin: 30,
                    animateOut: "fadeOut",
                    animateIn: "fadeIn",
                    nav: true,
                    dots: false,
                    // autoplayHoverPause: false,
                    items: 1,
                    // navText: [
                    //   "<p><small>Prev</small><span class='ion-ios-arrow-round-back'></span></p>",
                    //   "<p><small>Next</small><span class='ion-ios-arrow-round-forward'></span></p>",
                    // ],

                    // responsive: {
                    //   0: {
                    //     items: 1,
                    //   },
                    //   600: {
                    //     items: 1,
                    //   },
                    //   1000: {
                    //     items: 1,
                    //   },
                    // },
                });
            };
            carousel();
        })(jQuery);
        jQuery(document).ready(function($) {
            // $('.owl-carousel').find('.owl-nav').removeClass('disabled');
            //     $('.owl-carousel').on('changed.owl.carousel', function(event) {
            //         $(this).find('.owl-nav').removeClass('disabled');
            //     });
        });
    </script>

@endsection
