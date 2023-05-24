@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ __('frontend.Instructor') }}
@endsection
@section('css')
@endsection
@section('js')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/slick/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/slick/slick.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-straight/css/uicons-regular-straight.css" />
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css" />
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css" />
    <script src="https://kit.fontawesome.com/b98cad50b5.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{--    <script --}}
    {{--        src="https://code.jquery.com/jquery-3.6.3.js" --}}
    {{--        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" --}}
    {{--        crossorigin="anonymous" --}}
    {{--    ></script> --}}

    <style>
        .pullkado {
            position: absolute;
            top: 0px;
            right: 0px;
            left: 0px;
            z-index: 99999999;
        }

        .becomedobs h2 {
            text-decoration: underline;
            font-weight: bold;

        }

        .form-select {

            border: 1px solid gray;
            border-radius: 10px;
            height: 50px;

        }

        .form-control {
            border: 1px solid gray;
            border-radius: 10px !important;
            height: 50px;

        }

        label {

            font-weight: bold;
            margin-bottom: 7px;
            font-size: 14px;

        }

        .popup a {
            text-decoration: none;
            color: black;
            float: right;
            font-size: 20px;
        }

        .model-close {
            position: relative;
            top: -30px;
            right: 8px;
        }

        .mainbanner {
            height: 600px;
            background-image: url("{{ asset('public/frontend/infixlmstheme/img/images/courses-2.jpg') }}");
            background-size: cover;
        }

        .boxbanner h1 {
            font-size: 70px;
            font-weight: bold;
            color: white;
            margin-top: 4rem;

            padding-top: 10rem !important;
        }

        .leftimg {
            height: 400px;
            background-image: url("{{ asset('public/assets/leftimg.jpg') }}");
        }

        .readmore {
            padding: 12px 18px;
            background-color: transparent;
            border: white solid 2px;
            color: white;

        }

        .dataheading h1 {
            margin-top: -14px;
            /* padding:rem; */
        }

        /* .dataheading1{
                                                                                                                                                                                                      padding-left:4rem;
                                                                                                                                                                                                    } */
        .dataheading1 h1 {
            font-weight: 800;
            font-size: 45px;
        }

        .dataheading h1 {
            font-weight: 800;
            font-size: 45px;
        }

        .readmore1 {
            padding: 12px 32px;
            background-color: red;

            border: white solid 2px;
            border-radius: 7px;
            color: white;

        }

        .readmore1:hover {
            padding: 12px 32px;
            background-color: rgb(255, 255, 255);
            border: rgb(255, 0, 0) solid 1px;
            border-radius: 7px;
            color: rgb(254, 0, 0);

        }

        .becomeInsructor {
            background: red;
            color: white;
        }

        .leftimg1 img {
            height: 350px;
            width: 350px;
            border-radius: 50%;
            margin-left: 15%;
        }


        .flip-card {
            background-color: transparent;
            width: 100%;
            height: 350px;
            perspective: 1000px;
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }


        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 100%;
            height: 250px;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }


        .contka img {
            height: 350px !important;
            width: 250px !important;
            transition: 1s;
        }

        .contka img:hover {

            -ms-transform: scale(1.05);
            /* IE 9 */
            -webkit-transform: scale(1.05);
            /* Safari 3-8 */
            transform: scale(1.05);

        }

        .a {

            font-size: 23px !important;
            font-weight: 800 !important;
        }

        .footerbox h4 {
            font-weight: 700;
            color: white;
            font-size: 35px;
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
            font-size: 17px !important;
            color: white;
            cursor: pointer !important;

        }

        .footerbox p:hover {
            line-height: 30px !important;
            font-size: 17px !important;
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

        .footercolor {
            background: #252525;
        }

        .slick-arrow {
            background: black !important;
            display: block;
            border-radius: 50%;

        }

        .slick-arrow:hover {
            background: black !important;
            display: block;
            border-radius: 50%;

        }

        .containerdoda {
            width: 90%;
            margin: auto;
        }

        .becomedobs h2 {
            text-decoration: underline;
            font-weight: bold;

        }

        .form-select {

            border: 1px solid gray;
            border-radius: 10px;
            height: 50px;

        }

        .form-control {
            border: 1px solid gray;
            border-radius: 10px !important;
            height: 50px;

        }

        label {

            font-weight: bold;
            margin-bottom: 7px;
            font-size: 14px;

        }

        .popup a {
            text-decoration: none;
            color: black;
        }

        .model-close {
            position: relative;
            top: -30px;
            right: 8px;
        }

        .is-invalid {
            border-bottom: 2px solid red !important;
        }

        .contain {
            padding-left: 3rem !important;
        }

        @media (max-width: 500px) {
            .contain {
                padding-left: 0rem !important;
            }
        }

        @media (max-width: 600px) {
            .leftimg1 img {
                height: 250px;
                margin-top: 2rem;
                width: 250px;
                border-radius: 50%;
                padding-left: 0%;
            }

            .boxbanner h1 {
                font-size: 40px;
                font-weight: bold;
                color: white;
                margin-top: 4rem;
                padding-top: 10rem !important;
            }

            .dataheading h1 {
                font-weight: 800;
                font-size: 30px;
                margin-top: 3rem;
            }

            .leftimg1 img {
                height: 290px;
                width: 280px;
                border-radius: 50%;
                margin-left: 4%;
            }
        }
    </style>
@endsection
@section('mainContent')
    <div class="mainbanner">
        <div class="boxbanner contain px-5 py-5">
            <h1 class="mt-5 pt-5">Instructors</h1>
            <button class="readmore hit mx-1 mt-3" style="font-weight: bold;">Become an Instructor</button>
            <!-- <button class="readmore popup hit mx-1 mt-3" style="font-weight: bold;">Become an Instructor</button> -->
        </div>

    </div>

    <!-- Main heading Section  -->
    <div class="col-md-12 pb-3 shadow">
        <div class="contain">
            <div class="row m-0 my-5 p-4">
                <div class="col-md-6 leftimg" data-aos="fade-right"></div>

                <div class="col-md-6 ltimg" data-aos="fade-left" data-aos-delay="500">
                    <div class="dataheading">
                        <h1>
                            Lorem ipsum dolor sit amet consecter
                        </h1>
                        <p style="font-size:18px;text-align:justify;">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, consequuntur, voluptatem
                            sequi optio iste molestias nihil sed dicta dignissimos fugiat neque rem
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, consequuntur, voluptatem
                            sequi optio iste molestias nihil sed dicta dignissimos fugiat neque rem
                            Lorem ipsum dolor sit amet consectetur dignissimos fugiat neque rem
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, consequuntur, voluptatem
                            sequi optio iste molestias nihil sed dicta dignissimos fugiat neque rem
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, consequuntur, voluptatem
                            sequi optio iste molestias nihil sed dicta dignissimos fugiat neque rem
                            Lorem ipsum dolor.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- profile slidder -->
    <div class="row m-0 mt-4 pt-5">
        <div class="col-md-12">
            <h1 class="text-center py-3">Merakii Tutors use Saunders and ATI for Tutoring</h1>
        </div>
        <div class="col-md-11 m-auto my-5">
            <div class="row lazy m-0">
                @forelse ($instructors as $instructor)
                    {{-- @dd(route(route('tutorDetails', [$instructor->id, Str::slug($instructor->name, '-')]))) --}}
                    <div class="col-md-12 pb-5">
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front contka">
                                    <a href="{{ route('instructors') }}">
                                        <img src="{{ getInstructorImage($instructor->image) }}" alt="Avatar"
                                            class="img-fluid">
                                    </a>
                                </div>
                                <div class="flip-card-back contka">
                                    <a
                                        href="{{ route('tutorDetails', [$instructor->id, Str::slug($instructor->name, '-')]) }}">
                                        <img src="{{ getInstructorImage($instructor->image) }}" alt="Avatar"
                                            class="img-fluid">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('tutorDetails', [$instructor->id, Str::slug($instructor->name, '-')]) }}">
                            <h1 class="a mt-3">{{ $instructor->name }}</h1>
                        </a>
                        <div class="course_feedback_left">
                            <h2>{{$instructor->total_tutor_rating}}</h2>
                            <div class="feedmak_stars">

                                @php

                                    $main_stars=$instructor->total_tutor_rating;

                                    $stars=intval($instructor->total_tutor_rating);

                                @endphp
                                @for ($i = 0; $i <  $stars; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                @if ($main_stars>$stars)
                                    <i class="fas fa-star-half"></i>
                                @endif
                                @if($main_stars==0)
                                    @for ($i = 0; $i <  5; $i++)
                                        <i class="far fa-star"></i>
                                    @endfor
                                @endif
                            </div>
                            <span>{{__('frontend.Course Rating')}}</span>
                        </div>
                        <div class="row">
                            <div class="col-6">Total Hours:</div>
                            <div class="col-6">{{ $instructor->total_hours }} Hrs.</div>
                            <div class="col-6">Tutor:</div>
                            <div class="col-6">{{ $instructor->tutor_type == 1 ? 'Nursing' : 'Gen-Ed' }}</div>
                            <div class="col-6">Price:</div>
                            <div class="col-6">${{ $instructor->tutor_price }}/hr.</div>
                        </div>
                        {{-- <div class="rating_star">
                            <div class="stars">
                                @php
                                    $total = $instructor->totalRating();
                                    $totalReviews = $total['total'];
                                    $rating = $total['rating'];
                                    $main_stars = $rating;
                                    $stars = intval($main_stars);

                                @endphp
                                @for ($i = 0; $i < $stars; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                @if ($main_stars > $stars)
                                    <i class="fas fa-star-half"></i>
                                @endif
                                @if ($main_stars == 0)
                                    @for ($i = 0; $i < 5; $i++)
                                        <i class="far fa-star"></i>
                                    @endfor
                                @endif

                            </div>


                            <p>{{ $rating }}/5 ({{ $totalReviews }} rating)</p>
                        </div> --}}

                    </div>
                @empty
                    <p>No Tutor Found</p>
                @endforelse
            </div>
            <div class="my-2">
                {{$instructors->links()}}
            </div>
        </div>
    </div>
    {{-- <div class="row m-0 mt-4 pt-5">
        <div class="col-md-11 m-auto my-5">
            <div class="row lazy m-0">


                <div class="col-md-12 pb-5">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front contka">
                                <img src="{{ asset('public/assets/leftimg.jpg') }}" alt="Avatar" class="img-fluid">
                            </div>
                            <div class="flip-card-back contka">
                                <img src="{{ asset('public/assets/contact.jpg') }}" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <h1 class="a mt-3">John Doe</h1>
                    <p class="title">CEO & Founder, Example</p>

                </div>


                <div class="col-md-12">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front contka">
                                <img src="{{ asset('public/assets/courses-2.jpg') }}" alt="Avatar" class="img-fluid">
                            </div>

                        </div>
                    </div>
                    <h1 class="a mt-3">Tom Agee</h1>
                    <p class="title">CEO & Founder, Example</p>

                </div>


                <div class="col-md-12">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front contka">
                                <img src="{{ asset('public/assets/courses-4.jpg') }}" alt="Avatar" class="img-fluid">
                            </div>

                        </div>
                    </div>
                    <h1 class="a mt-3">Linda Mailis</h1>
                    <p class="title">CEO & Founder, Example</p>

                </div>


                <div class="col-md-12">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front contka">
                                <img src="{{ asset('public/assets/leftimg.jpg') }}" alt="Avatar" class="img-fluid">
                            </div>

                        </div>
                    </div>
                    <h1 class="a mt-3">Anna Hota</h1>
                    <p class="title">CEO & Founder, Example</p>

                </div>

                <div class="col-md-12 pb-5">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front contka">
                                <img src="{{ asset('public/assets/leftimg.jpg') }}" alt="Avatar" class="img-fluid">
                            </div>

                        </div>
                    </div>
                    <h1 class="a mt-3">John Doe</h1>
                    <p class="title">CEO & Founder, Example</p>

                </div>


                <div class="col-md-12">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front contka">
                                <img src="{{ asset('public/assets/courses-2.jpg') }}" alt="Avatar" class="img-fluid">
                            </div>

                        </div>
                    </div>
                    <h1 class="a mt-3">Tom Agee</h1>
                    <p class="title">CEO & Founder, Example</p>

                </div>


                <div class="col-md-12">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front contka">
                                <img src="{{ asset('public/assets/courses-4.jpg') }}" alt="Avatar" class="img-fluid">
                            </div>

                        </div>
                    </div>
                    <h1 class="a mt-3">Linda Mailis</h1>
                    <p class="title">CEO & Founder, Example</p>

                </div>


                <div class="col-md-12">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front contka">
                                <img src="{{ asset('public/assets/leftimg.jpg') }}" alt="Avatar" class="img-fluid">
                            </div>

                        </div>
                    </div>
                    <h1 class="a mt-3">Anna Hota</h1>
                    <p class="title">CEO & Founder, Example</p>

                </div>

            </div>
        </div>
    </div> --}}
    <!-- becomeInsructor section  -->
    <div class="becomeInsructor py-4">
        <div class="containerdoda">
            <div class="row m-0 my-5">
                <div class="col-md-6 ltimg" data-aos="fade-right">
                    <div class="dataheading1 pt-5">
                        <h1 class="text-white">
                            Lorem ipsum dolor <br>sit amet consecter
                            Lorem ipsum dolor sit amet consecter
                        </h1>

                        <button class="readmore hit mt-3">Become An Instructor</button>

                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <div class="row m-0">

                        <div class="col-md-4 bg-sucss">
                            <div class="leftimg1 mt-1">
                                <img src="{{ asset('public/assets/contact.jpg') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include(theme('partials._custom_footer'))


    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

        });
    </script>

    {{--    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script> --}}
    <script src="{{ asset('public/assets/slick/slick.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        $('.lazy').slick({
            lazyLoad: 'ondemand',
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
            autoplay: false,
            autoplaySpeed: 2000,
            // nextArrow: '<button class="any-class-name-you-want-next">Next</button>',
            // prevArrow: '<button class="any-class-name-you-want-previous">Previous</button>'
        });

        // $('.shooteka').click(function(){

        // });


        // $(".hit").click(function(){
        //   $('.popup').removeClass('d-none');
        //
        //   });
        //   $(".close").click(function(){
        //
        //   $('.popup').addClass('d-none');
        //
        //   })
    </script>
    <!-- mujtaba -->

    {{--    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script> --}}


    <div class="maincontainer pullkado bg-white">
        <div class="row popup @if (!count($errors)) d-none @endif m-0 px-5">
            <div class="col-md-12 becomedobs my-4 py-5 shadow">
                <a class="model-close float-end h4">X</a>
                <!-- Become an Instructor section  -->
                <div class="alert alert-danger alert-dismissible fade @if (count($errors)) show @endif"
                    role="alert">
                    <strong>Required!</strong> Please fill all fields.(Email and phone must be unique)
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input name="type" value="Instructor" type="hidden">
                    <div class="container">
                        <h2 class="hit mb-4 text-center">
                            Become an Instructor
                        </h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="data">
                                            <label>
                                                What position are you applying?*
                                            </label>
                                            <select name="instructor_position_id"
                                                class="form-select form-control @if ($errors->first('instructor_position_id')) is-invalid @endif"
                                                aria-label="Default select example">
                                                <option value="" selected>--SELECT--</option>
                                                @foreach ($postions as $postion)
                                                    <option value="{{ $postion->id }}"
                                                        {{ (string) $postion->id == old('instructor_position_id') ? 'selected' : '' }}>
                                                        {{ $postion->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="data">
                                            <label>How did you hear about us ?*
                                            </label>
                                            <select name="instructor_hear_id"
                                                class="form-select form-control @if ($errors->first('instructor_hear_id')) is-invalid @endif"
                                                aria-label="Default select example">
                                                <option value="" selected>--SELECT--</option>
                                                @foreach ($hears as $hear)
                                                    <option value="{{ $hear->id }}"
                                                        {{ (string) $hear->id == old('instructor_hear_id') ? 'selected' : '' }}>
                                                        {{ $hear->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="data">
                                            <label>Start Date
                                            </label>
                                            <input name="start_date"
                                                class="input--style-1 js-datepicker form-control @if ($errors->first('start_date')) is-invalid @endif"
                                                type="date" placeholder="BIRTHDATE" name="birthday"
                                                value="{{ old('start_date') }}">


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- personal information section  -->
                        <h2 class="my-5 text-center">
                            Personal Information
                        </h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="data">
                                            <label>
                                                First Name*
                                            </label>
                                            <input class="form-control @if ($errors->first('first_name')) is-invalid @endif"
                                                type="text" placeholder="" name="first_name"
                                                value="{{ old('first_name') }}">

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="data">
                                            <label>Middle Name
                                            </label>
                                            <input class="form-control @if ($errors->first('middle_name')) is-invalid @endif"
                                                type="text" placeholder="" name="middle_name"
                                                value="{{ old('middle_name') }}">

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="data">
                                            <label>Last Name*
                                            </label>
                                            <input class="form-control @if ($errors->first('last_name')) is-invalid @endif"
                                                type="text" placeholder="" name="last_name"
                                                value="{{ old('last_name') }}">

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="data">
                                            <label>Gender*
                                            </label>
                                            <select name="gender"
                                                class="form-select form-control @if ($errors->first('gender')) is-invalid @endif"
                                                aria-label="Default select example">
                                                <option value="" selected>--SELECT--</option>
                                                <option value="Male" {{ 'Male' == old('gender') ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="Female" {{ 'Female' == old('gender') ? 'selected' : '' }}>
                                                    Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="data">
                                            <label>
                                                Date of Birth*
                                            </label>
                                            <input class="form-control @if ($errors->first('date_of_birth')) is-invalid @endif"
                                                type="date" placeholder="" name="date_of_birth"
                                                value="{{ old('date_of_birth') }}">

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="data">
                                            <label>Email*
                                            </label>
                                            <input
                                                class="form-control @if ($errors->first('email')) is-invalid @endif"
                                                type="text" placeholder="" name="email"
                                                value="{{ old('email') }}">

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="data">
                                            <label>Phone(Home)
                                            </label>
                                            <input
                                                class="form-control @if ($errors->first('phone')) is-invalid @endif"
                                                type="text" placeholder="" name="phone"
                                                value="{{ old('phone') }}">

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="data">
                                            <label>Cell*
                                            </label>
                                            <input
                                                class="form-control @if ($errors->first('cell')) is-invalid @endif"
                                                type="text" placeholder="" name="cell"
                                                value="{{ old('cell') }}">

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="data">
                                            <label>
                                                Work
                                            </label>
                                            <textarea name="work" class="form-control @if ($errors->first('work')) is-invalid @endif"
                                                style="height:150px">{{ old('work') }}</textarea>

                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="data">
                                            <label>
                                                Address*
                                            </label>
                                            <textarea name="address" class="form-control @if ($errors->first('address')) is-invalid @endif"
                                                style="height:150px">{{ old('address') }}</textarea>


                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <div class="container">
                            <h2 class="my-5 text-center">
                                School Information
                            </h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="data">
                                                <label>
                                                    High School/GED*
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('high_school')) is-invalid @endif"
                                                    type="text" placeholder="" name="high_school"
                                                    value="{{ old('high_school') }}">

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="data">
                                                <label>
                                                    Years Attended*
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('school_years_attended')) is-invalid @endif"
                                                    type="date" placeholder="" name="school_years_attended"
                                                    value="{{ old('school_years_attended') }}">

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="data">
                                                <label>
                                                    Graduates*
                                                </label>
                                                <select name="school_year_graduate"
                                                    class="form-select form-control @if ($errors->first('school_year_graduate')) is-invalid @endif"
                                                    aria-label="Default select example">
                                                    <option value="" selected>--SELECT--</option>
                                                    <option value="yes"
                                                        {{ 'yes' == old('school_year_graduate') ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="no"
                                                        {{ 'no' == old('school_year_graduate') ? 'selected' : '' }}>No
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="data">
                                                <label>
                                                    Degree/Major*
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('school_degree')) is-invalid @endif"
                                                    type="text" placeholder="" name="school_degree"
                                                    value="{{ old('school_degree') }}">

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="data">
                                                <label>
                                                    College*
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('college')) is-invalid @endif"
                                                    type="text" placeholder="" name="college"
                                                    value="{{ old('college') }}">

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="data">
                                                <label>
                                                    Years Attended*
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('college_email')) is-invalid @endif"
                                                    type="date" placeholder="" name="college_email"
                                                    value="{{ old('college_email') }}">

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="data">
                                                <label>
                                                    Graduates*
                                                </label>
                                                <select name="college_graduate"
                                                    class="form-select form-control @if ($errors->first('college_graduate')) is-invalid @endif"
                                                    aria-label="Default select example" value="{{ old('f_name') }}">
                                                    <option value="" selected>--SELECT--</option>
                                                    <option value="yes"
                                                        {{ 'yes' == old('college_graduate') ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="no"
                                                        {{ 'no' == old('college_graduate') ? 'selected' : '' }}>No
                                                    </option>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="data">
                                                <label>
                                                    Trade or Correspondence School*
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('trade_school')) is-invalid @endif"
                                                    type="text" placeholder="" name="trade_school"
                                                    value="{{ old('trade_school') }}">

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="data">
                                                <label>
                                                    Degree/Major*
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('trade_degree')) is-invalid @endif"
                                                    type="text" placeholder="" name="trade_degree"
                                                    value="{{ old('trade_degree') }}">

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="data">
                                                <label>
                                                    Years Attended*
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('trade_years_attended')) is-invalid @endif"
                                                    type="date" placeholder="" name="trade_years_attended"
                                                    value="{{ old('trade_years_attended') }}">

                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="data">
                                                <label>
                                                    Graduates*
                                                </label>
                                                <select name="trade_year_graduate"
                                                    class="form-select form-control @if ($errors->first('trade_year_graduate')) is-invalid @endif"
                                                    aria-label="Default select example">
                                                    <option value="" selected>--SELECT--</option>
                                                    <option value="yes"
                                                        {{ 'yes' == old('trade_year_graduate') ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="no"
                                                        {{ 'no' == old('trade_year_graduate') ? 'selected' : '' }}>No
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Teaching Experience section  -->
                        <div class="container">
                            <h2 class="my-5 text-center">
                                Teaching Experience

                            </h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="data">
                                                <label>
                                                    Current Position
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('current_position')) is-invalid @endif"
                                                    type="text" placeholder="" name="current_position"
                                                    value="{{ old('current_position') }}">

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="data">
                                                <label>
                                                    Phone No
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('Teach_phone')) is-invalid @endif"
                                                    type="number" placeholder="" name="Teach_phone"
                                                    value="{{ old('Teach_phone') }}">

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="data">
                                                <label>
                                                    Employeer Name
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('employee_name')) is-invalid @endif"
                                                    type="text" placeholder="" name="employee_name"
                                                    value="{{ old('employee_name') }}">

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <div class="data">
                                                <label>
                                                    Dates Employer
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('date_employer')) is-invalid @endif"
                                                    type="date" placeholder="" name="date_employer"
                                                    value="{{ old('date_employer') }}">

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="data">
                                                <label>
                                                    Supervisor Name
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('supervisor_name')) is-invalid @endif"
                                                    type="text" placeholder="" name="supervisor_name"
                                                    value="{{ old('supervisor_name') }}">

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="data">
                                                <label>

                                                    Upload Resume*
                                                </label>
                                                <input
                                                    class="form-control @if ($errors->first('upload_resume')) is-invalid @endif"
                                                    type="file" placeholder="" name="upload_resume"
                                                    accept=".doc,.docx,.pdf" style="line-height: 39px;">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="data">
                                                <label>
                                                    Cover*
                                                </label>
                                                <textarea name="cover" class="form-control @if ($errors->first('cover')) is-invalid @endif"
                                                    style="height:150px;">{{ old('cover') }}</textarea>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="data">
                                                <label>
                                                    Address
                                                </label>
                                                <textarea name="employer_address" class="form-control @if ($errors->first('employer_address')) is-invalid @endif"
                                                    style="height:150px;">{{ old('employer_address') }}</textarea>

                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success m-5">Submit</button>

                                    </div>
                                </div>
                            </div>
                </form>

            </div>
        </div>
    </div>

    <!-- <button class="btn-success py-4">Become an Instructor</button> -->
    <script>
        $(".hit").click(function() {
            $('.popup').removeClass('d-none');

        });
        $(".model-close").click(function() {

            $('.popup').addClass('d-none');

        })
    </script>
    <!-- Optional JavaScript; select of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>



    <script>
        $(".hit").click(function() {
            $('.popup').removeClass('d-none');

        });
        $(".model-close").click(function() {

            $('.popup').addClass('d-none');

        })
    </script>
    <!-- Optional JavaScript; select of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
@endsection
