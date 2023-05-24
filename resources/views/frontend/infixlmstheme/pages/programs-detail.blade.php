@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('Programs Detail')}} @endsection
@section('css')

    <script src="https://kit.fontawesome.com/b98cad50b5.js" crossorigin="anonymous"></script>
    <link rel='stylesheet'
          href='https://cdn-uicons.flaticon.com/uicons-regular-straight/css/uicons-regular-straight.css'>

    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css'>
    <link
        rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css"
    />
    <script
        src="https://kit.fontawesome.com/b98cad50b5.js"
        crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        .boxbanner h1 {
            font-size: 70px;
            font-weight: bold;
            color: white;
            padding-top: 8rem !important;
        }

        .mainbanner {
            background-image: url("{{asset('public/frontend/infixlmstheme/img/images/courses-4.jpg')}}");
            height: 530px;
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
            transition: .6s;
            background-color: #ff1949;
        }

        .bgwebs:hover {
            background-color: transparent;
            border: #ff1949 1px solid;
            color: #ff1949 !important;
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
            content: "\f007";
            font-family: "Font Awesome 5 Free";
            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-weight: 900;
        }

        .rating::before {
            content: "\f005";
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

        .courseimg {
            background-color: black;
        }

        .courseimg img:hover {
            opacity: 0.5;
    }

        .osegora {
            border-bottom: 2px dashed rgb(205, 199, 199);
        }

        .imagebdr span {
            cursor: pointer;
        }

        .image {
            background-color: black;
        }


        .image img:hover {
            opacity: 0.5;
        }

        .imagebdr i {
            color: #ff1949;
            opacity: 0;
        }

        .imagebdr span:hover + i {
            opacity: 1;
        }

        .reviewda i {
            color: #edd903;
        }

        .textdo h5::before {
            content: "\f054";
            font-family: "Font Awesome 5 Free";
            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-weight: 900;
            color: #ff1949;
            font-size: 18px;
            padding: 5px;
        }

        .textdo p {
            color: #444;
            font-size: 16px;
            font-weight: 300;
            line-height: 24px;
        }

        .data h5 {
            font-weight: 700;
        }

        .coursedata h1 {

            margin-top: -22px;
            font-weight: 800;
            font-size: 48px;
            font-family: Poppins, sans-serif;
            color: #252525;
        }

  

        .sub h4 {
            font-weight: bold;
        }

        .btr a {

            width: 213px;
            padding: 13px 0px;
            float: right;
            border-radius: 5px !important;
            border: 1PX solid red;
        }

        .btr a:hover {
            border: 1PX solid red;
            background: white;
            color: black !important;
        }

        .desc h3 {
            font-family: Poppins, sans-serif;
            color: #252525;
            font-weight: 800;
            font-size: 25px;
        }

        body {
            background-color: #f9f9fa;
        }

        .flex {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
        }


        .card {
            box-shadow: none;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            -ms-box-shadow: none;
        }

        .pl-3,
        .px-3 {
            padding-left: 1rem !important;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #d2d2dc;
            border-radius: 0;
        }

        .card .card-title {
            color: #000000;
            margin-bottom: 0.625rem;
            text-transform: capitalize;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .card .card-description {
            margin-bottom: 0.875rem;
            font-weight: 400;
            color: #76838f;
        }
/* 
        .accordion .card:first-of-type {
            border-bottom: 0;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .accordion .card {
            margin-bottom: 0.75rem;
            box-shadow: 0px 1px 15px 1px rgba(230, 234, 236, 0.35);
            border-radius: 0.25rem;
            border: none;
        }

        .accordion .card .card-header {
            background-color: transparent;
            border: none;
            padding: 2rem;
        }

        .card-header:first-child {
            border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
        }

        .accordion .card .card-header * {
            font-weight: 400;
            font-size: 1rem;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .accordion .card .card-header a {
            display: block;
            color: inherit;
            text-decoration: none;
            font-size: inherit;
            position: relative;
            -webkit-transition: color 0.5s ease;
            -moz-transition: color 0.5s ease;
            -ms-transition: color 0.5s ease;
            -o-transition: color 0.5s ease;
            transition: color 0.5s ease;
            padding-right: 1.5rem;
        }

        .accordion .card .card-header * {
            font-weight: 400;
            font-size: 1rem;
        }

        .accordion .card .card-header a[aria-expanded="false"]:before {
            content: "\f067";
        }

        .accordion .card .card-header a[aria-expanded="true"]:before {
            content: "\f068";
        }

        .accordion .card .card-header a:before {
            position: absolute;
            right: 7px;
            top: 0;
            font-size: 18px;
            display: block;
            font-family: FontAwesome;
            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-size: 0.756em;
            color: #405189;
        }
        .accordion .card .card-header a {
            display: block;
            color: inherit;
            text-decoration: none;
            font-size: inherit;
            font-size: 20px;
            font-weight: bold;
        } */

        .card {
            border: none;
        }

        .card-header a {
            font-size: 21px;
            font-weight: bold;
        }

        .mujt h5 {
            font-weight: bold;
            font-size: 17px;
        }

 
        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 0px;
        }

        .footerbox h4 {
            font-weight: 700;
            color: white;

        }

        .footerbox h5 {
            font-weight: 400;
            color: white;

        }

        .footerbox p {
            font-weight: 300 !important;
            line-height: 24px !important;
            font-size: 15px !important;
            color: white;

            /* font-weight: 700; */
        }

        .icons i {
            font-size: 12px;
            padding: 3px;
            cursor: pointer;
            color: white;

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
            color: white;

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


        .accordion .card:first-of-type {
            border-bottom: 0;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .accordion .card {
            margin-bottom: 0.75rem;
            box-shadow: 0px 1px 15px 1px rgba(230, 234, 236, 0.35);
            border-radius: 0.25rem;
            border: none;
        }

        .accordion .card .card-header {
            background-color: transparent;
            border: none;
            padding: 2rem;
        }

        .card-header:first-child {
            border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
        }

        .accordion .card .card-header * {
            font-weight: 400;
            font-size: 1rem;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .accordion .card .card-header a {
            display: block;
            color: inherit;
            text-decoration: none;
            font-size: inherit;
            position: relative;
            -webkit-transition: color 0.5s ease;
            -moz-transition: color 0.5s ease;
            -ms-transition: color 0.5s ease;
            -o-transition: color 0.5s ease;
            transition: color 0.5s ease;
            padding-right: 1.5rem;
        }

        .accordion .card .card-header * {
            font-weight: 400;
            font-size: 1rem;
        }

        .accordion .card .card-header a[aria-expanded="false"]:before {
            content: "\f067";
        }

        .accordion .card .card-header a[aria-expanded="true"]:before {
            content: "\f068";
        }

        .accordion .card .card-header a:before {
            position: absolute;
            right: 7px;
            top: 0;
            font-size: 18px;
            display: block;
            font-family: FontAwesome;
            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-size: 0.756em;
            color: #405189;
        }

        .card {
            border: none;
        }

        .card-header a {
            font-size: 21px;
            font-weight: bold;
        }

        .mujt h5 {
            font-weight: bold;
            font-size: 17px;
        }

        .accordion .card .card-header a {
            display: block;
            color: inherit;
            text-decoration: none;
            font-size: inherit;
            font-size: 20px;
            font-weight: bold;
        }


    </style>
@endsection

@section('js')

@endsection
@section('mainContent')

    {{-- <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous"
    /> --}}
    @php

        $count_enrolled = 0;
        if (isset($program_detail->currentProgramPlan[0])){
            $count_enrolled = \Modules\CourseSetting\Entities\CourseEnrolled::where('program_id',$program_detail->id)->where('plan_id',$program_detail->currentProgramPlan[0]->id)->count();
        }

    @endphp
    <div class="mainbanner">
        <div class="boxbanner containerdoosme p-5">
            <h1 class="pt-5  mt-5">Program Details</h1>
            {{--            <p class="text-white">Home / Programs / {{$program_detail->programtitle}}</p>--}}
        </div>
    </div>

    <div class="containerdoosme controlbox px-5 mt-5">
        <div class="row my-5 p-2">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="coursedata">
                                    <h1 class="fw-bold">
                                        @php
                                            // dd($program_detail);
                                        @endphp
                                        {{$program_detail->programtitle}}

                                        @if(isset($program_detail->currentProgramPlan[0]))
                                            <span
                                                class="color"
                                                style="color: #ff1949;
                      font-weight: 500;
                      font-family: Poppins,sans-serif;
                      font-size: 29px;
                      margin-left: 6px;"
                                            >   ${{$program_detail->currentProgramPlan[0]->amount}}
                                        </span>
                                            @if(!empty($program_detail->currentProgramPlan[0]->initialProgramPalnDetail[0]))
                                                <small
                                                    style="font-size: 15px;">Initial:${{$program_detail->currentProgramPlan[0]->initialProgramPalnDetail[0]->amount}}</small>
                                            @endif
                                        @endif
                                    </h1>
                                    <div class="row">
                                        <div class="col-md-3 col ">
                                            <div class="mt-4">
                                            <span class="instructor" style="color: #948989;">
                                              Sub Title :
                                            </span>
                                                <span class="mt-4"
                                                      style="padding-left:10px;font-weight:400;">{{$program_detail->subtitle}}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col reviewda">
                                            <div class="mt-4">
{{--                                              <span class="instructor" style="color: #948989;">--}}
{{--                                                Reviews:--}}
{{--                                              </span>--}}
{{--                                                <span>--}}
{{--                                                  <i class="fa-sharp fa-solid fa-star"></i>--}}
{{--                                                  <i class="fa-sharp fa-solid fa-star"></i>--}}
{{--                                                  <i class="fa-sharp fa-solid fa-star"></i>--}}
{{--                                              </span>--}}
                                            </div>
                                        </div>

                                        <div class="col-md-6 col mt-2 btr">
                                            @if (Auth::check())
                                                @if (!$isEnrolled)

                                                    @if(isset($program_detail->currentProgramPlan[0]) && $program_detail->currentProgramPlan[0]->no_of_students > $count_enrolled)
                                                        <a href="{{route('addToCart',['id'=>$program_detail->id,'plan_id'=>$program_detail->currentProgramPlan[0]->id])}}"
                                                           class="btn bgwebs rounded-0 text-white m-1"
                                                        >Add to Cart
                                                        </a>
                                                        <a href="{{route('buyNow',['id'=>$program_detail->id,'plan_id'=>$program_detail->currentProgramPlan[0]->id])}}"
                                                           class="btn bgwebs rounded-0 text-white m-1">Buy Now
                                                        </a>
                                                    @else
                                                        <a href="#"
                                                           class="btn bgwebs rounded-0 text-white m-1 disabled"
                                                        >Enrolled Complete
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="#"
                                                       class="btn bgwebs rounded-0 text-white m-1"
                                                    >Enrolled
                                                    </a>
                                                @endif
                                            @else

                                                @if(isset($program_detail->currentProgramPlan[0]) && $program_detail->currentProgramPlan[0]->no_of_students > $count_enrolled)
                                                    <a href="{{route('addToCart',['id'=>$program_detail->id,'plan_id'=>$program_detail->currentProgramPlan[0]->id])}}"
                                                       class="btn bgwebs rounded-0 text-white m-1"
                                                    >Add to Cart
                                                    </a>
                                                    <a href="{{route('buyNow',['id'=>$program_detail->id,'plan_id'=>$program_detail->currentProgramPlan[0]->id])}}"
                                                       class="btn bgwebs rounded-0 text-white m-1">Buy Now
                                                    </a>
                                                @else
                                                    <a href="#"
                                                       class="btn bgwebs rounded-0 text-white m-1"
                                                    >Enrolled Complete
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="image">
                                    <img src="{{getCourseImage($program_detail->image) }}" class="img-fluid w-100">

                                </div>
                            </div>
                            <div class="col-md-12 mt-5 osegora mb-3">
                                <div class="imagebdr mb-3">
                                    <i class="fa-solid fa-arrow-right"></i>
                                    <span onclick="fire(1)" class="h5 px-3">
                                    Description
                                  </span>

                                    <i class="fa-solid fa-arrow-right"></i>
                                    <span onclick="fire(2)" class="h5 px-3">
                                Courses
                              </span>

                                    <i class="fa-solid fa-arrow-right"></i>
                                    <span onclick="fire(3)" class="h5 px-3">
                                    Payment plan
                                  </span>
                                </div>

                                <script>
                                    function fire(id) {
                                        if (id == 1) {
                                            $(".text").addClass("d-none");
                                            $(".review").addClass("d-none");
                                            $(".desc").removeClass("d-none");
                                        } else if (id == 2) {
                                            $(".text").addClass("d-none");
                                            $(".review").removeClass("d-none");
                                            $(".desc").addClass("d-none");
                                        } else {
                                            $(".text").removeClass("d-none");
                                            $(".review").addClass("d-none");
                                            $(".desc").addClass("d-none");
                                        }
                                    }
                                </script>
                            </div>
                            <div class="row desc">
                                <div class="col-md-12 p-5">
                                    <div class="">
                                        <h3 class="mb-3">About this program</h3>
                                        <p>
                                            {!! $program_detail->discription !!}
                                        </p>
                                        <hr>
                                        <h3 class="my-3">Program requirement</h3>
                                        <p>
                                            {!! $program_detail->requirement !!}
                                        </p>
                                        <hr>

                                        <h3 class="my-3">Program outcome</h3>
                                        <p>
                                            {!! $program_detail->outcome !!}
                                        </p>
                                        <hr>

                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12  ">
                                    <div class="textdo  mx-4 bgcolor p-5">
                                        <h3 class="fw-bold">FAQs</h3>


                                        @if(count($faqs))
                                            @foreach($faqs as $faq)
                                                <div class="data">
                                                    <h5 class="fw-bold mt-4">{{@$faq->question}}</h5>
                                                    <p>
                                                        {!! @$faq->answer !!}
                                                    </p>
                                                </div>
                                            @endforeach
                                        @else
                                            No FAQs Found
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="review d-none">

                                 <div class="page-content page-containerdoosme" id="page-content">
                                        <div class="padding my-3">
                                            <div class="row containerdoosme d-flex justify-content-center">
                                                <div class="col-lg-12 grid-margin stretch-card">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="mt-4">
                                                                <div class="accordion" id="accordion" role="tablist">
                                                                    @if(isset($courses))
                                                                        @foreach($courses as $course)
                              <div class="card">
                <div class="card-header" role="tab"
                        id="heading-{{ $course->id }}">
                    <h6 class="mb-0" style="font-weight: 800;display: inline;font-size: 18px;">
                    {{@$course->title}}
                    </h6>
                <a onclick="toggleka(this,1)" id="plus" class="float-right plusbtn" style="cursor:pointer;"> +</a>
                <a onclick="toggleka(this,2)" id="minus" class="float-right minusbtn d-none"style="cursor:pointer;">
                <img src="{{asset('public/frontend/infixlmstheme/img/images/dash.png')}}" style="width: 11px;height: 22px;">       <!-- <i class="bi bi-dash"></i> -->
                <!-- <img src="{{asset('public/asset/dash.png')}}"> -->
            </a>

                </div>
                <div
                    id="collapse-{{ $course->id }}"
                    class="collapse controbtndo"
                    role="tabpanel"
                    aria-labelledby="heading-{{ $course->id }}"
                    data-parent="#accordion"
           
                >
                    {{-- mujtaba
                        --}}
                    @php
                        $userRating = userRating($course->user_id);
                    @endphp
                    <div class="card-body">
                        <div class="row mujt mx-4 pb-4">
                            <div class="col-2  ">
                                <h5>Course title</h5>
                                                                                                <p>
                                                                                                    @if($is_allow)
                                                                                                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug) }}?program_id={{$program_detail->id}}">
                                                                                                            {{@$course->title}}
                                                                                                        </a>
                                                                                                    @else
                                                                                                        <a href="javascript:void(0)">
                                                                                                            {{@$course->title}}
                                                                                                        </a>
                                                                                                    @endif
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="col-2  ">
                                                                                                <h5>
                                                                                                    {{__('frontend.Course Rating')}}</h5>
                                                                                                <p>
                                                                                                    @php

                                                                                                        $main_stars=$course->totalReview;

                                                                                                        $stars=intval($course->totalReview);

                                                                                                    @endphp
                                                                                                    @for ($i = 0; $i <  $stars; $i++)
                                                                                                        <i class="fas fa-star"></i>
                                                                                                    @endfor
                                                                                                    @if ($main_stars>$stars)
                                                                                                        <i class="fas fa-star-half"></i>
                                                                                                    @endif
                                                                                                    {{--                                                                                                    @if($main_stars==0)--}}
                                                                                                    @for ($i = 0; $i <  (5 - $stars); $i++)
                                                                                                        <i class="far fa-star"></i>
                                                                                                    @endfor
                                                                                                    {{--                                                                                                    @endif--}}
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="col-2  ">
                                                                                                <h5>
                                                                                                    Course {{__('frontend.Lectures')}}</h5>
                                                                                                <p>{{count($course->lessons)}} {{__('frontend.lessons')}}</p>
                                                                                            </div>

                                                                                            <div class="col-2 ">
                                                                                                <h5>{{__('frontend.Instructor')}}</h5>
                                                                                                <p>
                                                                                                    {{@$course->user->name}}
                                                                                                </p>
                                                                                            </div>
              {{-- ffffff --}}
                   <style>
                   .courseDescription {
                       height: 100px;
                       overflow: hidden;
                   }
                   .readmorebtn{
                        background: red;
                       border-radius: 8px;
                       color:white!important;
                       border:2px solid red!important; 
                       transition: 1s;
                       
                   }
                   .readmorebtn:hover{
                 background: rgb(255, 255, 255);
                       border-radius: 8px;
                       color:rgb(255, 0, 0)!important;
                       border:2px solid red!important;
                       
                   }
                   </style>                                                                         <div class="col-2 ">
                                                       <div class="courseDescription">                   <h5>Course
                                                                                                    Description</h5>
                                                                                                <div>
                                                                                                    {!! @$course->about !!}
                                                                                                </div>
                                                                                            </div>                      
                        <button onclick="readmore(this,1)" class="Readmore  readmorebtn mt-2">Readmore</button>
                               
                        <button onclick="readless(2)" class="added d-none readmorebtn mt-2 ">ReadLess</button>       
                        <script>
                        function readmore(id){
                         
                           $('.courseDescription').height('auto');
                           $(".Readmore").hide();
                           $('.added').removeClass('d-none');
                        }
                        function readless(id){
                         
                           $('.courseDescription').height('100px');
                           $(".Readmore").show();
                           $('.added').addClass('d-none');
                        }
                        </script>                                                             </div>

                                                                                            {{--                                                                                            <div class="col-4">--}}
                                                                                            {{--                                                                                                <h5>Course Description</h5>--}}
                                                                                            {{--                                                                                                <p>{!! @$course->about !!}</p>--}}
                                                                                            {{--                                                                                            </div>--}}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
</div>
@endforeach
@endif
@if(count($courses) == 0)
<div class="col-lg-12">
<div
    class="Nocouse_wizged text-center d-flex align-items-center justify-content-center">
<div class="thumb">
<img style="width: 50px"
src="{{ asset('public/frontend/infixlmstheme') }}/img/not-found.png"
                alt="">
    </div>
                                                                                <h1>
                                                                                    {{__('No Course Found')}}
                                                                                </h1>
                                                                            </div>
                                                                        </div>

                                                                    @endif

                                                                    @if(count($courses) != 0 && $is_allow)
                                                                        <div class="card">
                                                                            {{ $courses->links() }}
                                                                        </div>
                                                                    @else
                                                                        <div class="cardBuy text-center mb-3"
                                                                             style="z-index:9">
                                                                            <a href="{{route('buyNow',[$program_detail->id])}}"
                                                                               class="btn px-5  bgwebs rounded-0 text-white m-1 py-2"
                                                                               style="border-radius:8px!important;">Buy
                                                                                Now
                                                                            </a>
                                                                        </div>
                                                                        <div class="cardBuy"
                                                                             style="background: white;opacity: 0.6;">

                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="review d-none">
                                <h3>Out comes</h3>
                                <p>
                                    {!! $program_detail->outcome !!}
                                </p>
    </div> --}}
</div>
<div class="col-md-12">
    <div class="text d-none">
        <h3>Payment plan</h3>
        <p>
            {!!  $program_detail->payment_plan !!}
        </p>
        <br>
<div class="page-content page-containerdoosme" id="page-content">
    <div class="padding my-3">
        <div class="row containerdoosme d-flex justify-content-center">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-4">
                            <div class="accordion" id="accordion" role="tablist">
                                @if(isset($program_detail->programPlans) && count($program_detail->programPlans) > 0)
                                    @foreach($program_detail->programPlans as $programPlans)
        <div class="card">
            <div class="card-header" role="tab"
                    id="heading-{{ $programPlans->id }}">
                                                                                <h6 class="mb-0">                                                                                     <span style="font-size: 22px;font-weight:bold;">    {{'Plan '. @$programPlans->plan_order}}
                                                                                    @if(isset($program_detail->currentProgramPlan[0]) && $programPlans->id == $program_detail->currentProgramPlan[0]->id)
                                                                                        (Current)
                                                                                    @elseif(\Carbon\Carbon::parse($programPlans->edate)->format('Y-m-d') < \Carbon\Carbon::now()->format('Y-m-d'))
                                                                                        (Closed)
                                                                                    @else
                                                                                        (Pending)
                                                                                    @endif
                                                                                    <br/></span>
                                                                                    <span>
                                                                                        <u>Duration</u>: {{\Carbon\Carbon::parse($programPlans->sdate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($programPlans->edate)->format('d M Y') }},
                                                                                        <u>Class Start</u>: {{ \Carbon\Carbon::parse($programPlans->cdate)->format('d M Y') }}
                                                                                    </span></h6>
                                                                                    {{-- <a
                                                                                        data-toggle="collapse"
                                                                                        href="#collapse-{{ $programPlans->id }}"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="collapse-{{ $programPlans->id }}"
                                                                                        data-abc="true"
                                                                                        class="collapsed"
                                                                                    > --}}
                                                                                    <a onclick="toggleka(this,1)" id="plus" class="float-right plusbtn" style="cursor:pointer;"> +
                                                                                    {{-- </a> --}}
                                                                                    <a onclick="toggleka(this,2)" id="minus" class="float-right minusbtn d-none"style="cursor:pointer;">
                                                                                    <img src="{{asset('public/frontend/infixlmstheme/img/images/dash.png')}}" style="width: 11px;height: 22px;">       <!-- <i class="bi bi-dash"></i> -->
                                                                                    <!-- <img src="{{asset('public/asset/dash.png')}}"> -->
 

                                                                                    </a>
                                                                                </a>
                                                                                
</div>
<div
                                                                                id="collapse-{{ $programPlans->id }}"
                                                                                class="collapse controbtndo"
                                                                                role="tabpanel"
                                                                                aria-labelledby="heading-{{ $programPlans->id }}"
                                                                                data-parent="#accordion"
                                                                                style=""
                                                                            >
                                                                                <div class="card-body">
                                                                                    <div class="row mujt mx-4 pb-4">
                                                                                        <div class="col-xl-12">
                                                                                            <div
                                                                                                class="table-responsive">
                                                                                                <table
                                                                                                    class="table custom_table3">
                                                                                                    <thead>
                                                                                                    <tr>
                                                                                                        <th scope="col">{{__('common.SL')}}</th>
                                                                                                        <th scope="col">{{__('Installments')}}</th>
                                                                                                        <th scope="col">{{__('payment.Total Price')}}</th>
                                                                                                    </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                    @if(isset($programPlans->programPalnDetail) && count($programPlans->programPalnDetail) > 0)
                                                                                                        @foreach ($programPlans->programPalnDetail as $plan)

                                                                                                            <tr>
                                                                                                                <td scope="row">{{$plan->type+1}}</td>

                                                                                                                <td>
                                                                                                                    @if($plan->type == 0)
                                                                                                                        Initial
                                                                                                                    @else
                                                                                                                        Installment {{$plan->type}}
                                                                                                                    @endif
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    {{ $plan->amount }}
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endforeach
                                                                                                    @endif

                                                                                                    @if(isset($programPlans->programPalnDetail) && count($programPlans->programPalnDetail) == 0)
                                                                                                        <div
                                                                                                            class="col-12">
                                                                                                            <div
                                                                                                                class="section__title3 margin_50">
                                                                                                                <p class="text-center">{{__('No Installment Found')}}
                                                                                                                    !</p>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                    </tbody>
                                                                                                </table>

                                                                                                <div
                                                                                                    style="float: left">
                                                                                                    ({{ $programPlans->programPlanViseEnrollCount }}
                                                                                                    /{{$programPlans->no_of_students}}
                                                                                                    )
                                                                                                </div>
                                                                                                <div
                                                                                                    style="float: right">
                                                                                                    @if(\Carbon\Carbon::parse($programPlans->edate)->format('Y-m-d') > \Carbon\Carbon::now()->format('Y-m-d'))

                                                                                                        @if(Auth::check())
                                                                                                            @if($programPlans->isProgramPlanViseEnroll || Auth::User()->role_id == 1)
                                                                                                                <a href="#"
                                                                                                                   class="btn bgwebs rounded-0 text-white m-1"
                                                                                                                >Enrolled
                                                                                                                </a>
                                                                                                            @else
                                                                                                                <a href="{{route('addToCart',['id'=>$program_detail->id,'plan_id'=>$programPlans->id])}}"
                                                                                                                   class="btn bgwebs rounded-0 text-white m-1"
                                                                                                                >Add to
                                                                                                                    Cart
                                                                                                                </a>
                                                                                                                <a href="{{route('buyNow',['id'=>$program_detail->id,'plan_id'=>$programPlans->id])}}"
                                                                                                                   class="btn bgwebs rounded-0 text-white m-1">Buy
                                                                                                                    Now
                                                                                                                </a>
                                                                                                            @endif
                                                                                                        @else
                                                                                                            <a href="{{route('addToCart',['id'=>$program_detail->id,'plan_id'=>$programPlans->id])}}"
                                                                                                               class="btn bgwebs rounded-0 text-white m-1"
                                                                                                            >Add to Cart
                                                                                                            </a>
                                                                                                            <a href="{{route('buyNow',['id'=>$program_detail->id,'plan_id'=>$programPlans->id])}}"
                                                                                                               class="btn bgwebs rounded-0 text-white m-1">Buy
                                                                                                                Now
                                                                                                            </a>
                                                                                                        @endif
                                                                                                    @else
                                                                                                        <a href="#"
                                                                                                           class="btn bgwebs rounded-0 text-white m-1"
                                                                                                        >Closed
                                                                                                        </a>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                                @if(isset($program_detail->programPlans) && count($program_detail->programPlans) == 0)
                                                                    <div class="col-lg-12">
                                                                        <div
                                                                            class="Nocouse_wizged text-center d-flex align-items-center justify-content-center">
                                                                            <div class="thumb">
                                                                                <img style="width: 50px"
                                                                                     src="{{ asset('public/frontend/infixlmstheme') }}/img/not-found.png"
                                                                                     alt="">
                                                                            </div>
                                                                            <h1>
                                                                                {{__('No PLan Found')}}
                                                                            </h1>
                                                                        </div>
                                                                    </div>

                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--                                @if(empty($program_detail->currentProgramPlan[0]))--}}
                                {{--                                    <div class="col-12">--}}
                                {{--                                        <div class="section__title3 margin_50">--}}
                                {{--                                            <p class="text-center">{{__('No Plan Found')}}!</p>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                @else--}}
                                {{--                                    <div class="row">--}}
                                {{--                                        <div class="col-xl-12">--}}
                                {{--                                            <div class="table-responsive">--}}
                                {{--                                                <table class="table custom_table3">--}}
                                {{--                                                    <thead>--}}
                                {{--                                                    <tr>--}}
                                {{--                                                        <th scope="col">{{__('common.SL')}}</th>--}}
                                {{--                                                        <th scope="col">{{__('Installments')}}</th>--}}
                                {{--                                                        <th scope="col">{{__('payment.Total Price')}}</th>--}}
                                {{--                                                    </tr>--}}
                                {{--                                                    </thead>--}}
                                {{--                                                    <tbody>--}}
                                {{--                                                    @if(isset($program_detail->currentProgramPlan[0]))--}}
                                {{--                                                        @foreach ($program_detail->currentProgramPlan[0]->programPalnDetail as $plan)--}}

                                {{--                                                            <tr>--}}
                                {{--                                                                <td scope="row">{{$plan->type+1}}</td>--}}

                                {{--                                                                <td>--}}
                                {{--                                                                    @if($plan->type == 0)--}}
                                {{--                                                                        Initial--}}
                                {{--                                                                    @else--}}
                                {{--                                                                        Installment {{$plan->type}}--}}
                                {{--                                                                    @endif--}}
                                {{--                                                                </td>--}}
                                {{--                                                                <td>--}}
                                {{--                                                                    {{ $plan->amount }}--}}
                                {{--                                                                </td>--}}
                                {{--                                                            </tr>--}}
                                {{--                                                        @endforeach--}}
                                {{--                                                    @endif--}}
                                {{--                                                    </tbody>--}}
                                {{--                                                </table>--}}
                                {{--                                                --}}{{--                                            <div class="mt-4">--}}
                                {{--                                                --}}{{--                                                {{ $plans->links() }}--}}
                                {{--                                                --}}{{--                                            </div>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                @endif--}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="rightbox bgcolor px-4 py-5">
                                    <h4>This Program includes:</h4><i class="fi fi-rs-book-alt"
                                                                      style="padding-top:16px;"></i>
                                    <span
                                        style="padding-left:6px;">Courses / {{count(json_decode($program_detail->allcourses))}} </span>
                                    <br>
                                    @if(isset($program_detail->currentProgramPlan[0]))
                                        <i class="fa-regular fa-clock" style="padding-top:12px;"></i>
                                        <span
                                            style="padding-left:6px;padding-top:12px;">Duration / {{ round((strtotime($program_detail->currentProgramPlan[0]->edate) - strtotime($program_detail->currentProgramPlan[0]->sdate)) / 604800, 1) }} Weeks</span>

                                        <br>

                                        <i class="fa-regular fa-user" style="padding-top:12px;"></i>
                                        <span
                                            style="padding-left:6px;">Enrolled / {{$count_enrolled}} Students  </span>

                                        <br>

                                        <i class="fa-regular fa-user" style="padding-top:12px;"></i>
                                        <span
                                            style="padding-left:6px;">Remaining Enrolled / {{ $program_detail->currentProgramPlan[0]->no_of_students - $count_enrolled}}  </span>

                                        <br>
                                    @endif
{{--                                    <i class="fa-regular fa-thumbs-up" style="padding-top:12px;"></i>--}}
{{--                                    <span--}}
{{--                                        style="padding-left:6px;">Skill Level Intermediate / {{$program_detail->duration}}</span>--}}

{{--                                    <br>--}}

                                </div>
                            </div>
{{--                            <div class="col-md-12 my-4">--}}
{{--                                <div class="rightbox bgcolor px-4 py-5">--}}
{{--                                    <h4>Certification</h4>--}}
{{--                                    <p class="just">--}}
{{--                                        Lorem Ipsn gravida nibh vel velit auctor aliquet aenean--}}
{{--                                        sollicitudin--}}
{{--                                    </p>--}}
{{--                                    <img src="{{asset('public/frontend/infixlmstheme/img/images/certificate.jpg')}}"--}}
{{--                                         class="img-fluid">--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-md-12 my-4">
                                <div class="rightbox bgcolor px-4 py-5">
                                    <h4>You may like</h4>

                                    @forelse($recent_program as  $program)
                                        <div class="row my-3">
                                            <div class="col-md-6">
                                                <a href="{{ route('programs.detail',[$program->id])}}">
                                                    <img style=""
                                                         src="{{getCourseImage($program->icon) }}"
                                                         class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="col-md-6 coureparagraph">
                                                <p>
                                                    <a class="text-dark" href="{{ route('programs.detail',[$program->id])}}"> {{$program->subtitle}}</a>
                                                </p>
                                                <p>   {{ round((strtotime($program->currentProgramPlan[0]->edate) - strtotime($program->currentProgramPlan[0]->sdate)) / 604800, 1) }}
                                                    Weeks</p>
                                                <p class="color"> ${{$program->currentProgramPlan[0]->amount}}</p>
                                            </div>
                                        </div>

                                    @empty
                                        <div class="row my-3">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-11">
                                                <div
                                                    class="Nocouse_wizged text-center d-flex align-items-center justify-content-center">
                                                    <div class="thumb">
                                                        <img style="width: 20px"
                                                             src="{{ asset('public/frontend/infixlmstheme') }}/img/not-found.png"
                                                             alt="">
                                                    </div>
                                                    <h6>
                                                        {{__('No Program Found')}}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse

                                </div>

                            </div>
                            {{-- <div class="col-md-12 my-4">
                              <div class="rightbox bgcolor px-4 py-5">
                                <h4>Instagram</h4>
                                <div class="row mt-3">
                                  <div class="col-md-4 p-2 insta">
                                    <div class="instabox">

                                      <img src="{{asset('public/frontend/infixlmstheme/img/images/courses-1.jpg')}}" class="img-fluid">
                                    </div>
                                  </div>

                                  <div class="col-md-4 p-2 insta">
                                    <div class="instabox">

                                    <img src="{{asset('public/frontend/infixlmstheme/img/images/courses-2.jpg')}}" class="img-fluid">
                                    </div>
                                  </div>

                                  <div class="col-md-4 p-2 insta">
                                    <div class="instabox">
                                      <img src="{{asset('public/frontend/infixlmstheme/img/images/courses-3.jpg')}}" class="img-fluid">
                                    </div>
                                  </div>

                                  <div class="col-md-4 p-2 insta">
                                    <div class="instabox">
                                      <img src="{{asset('public/frontend/infixlmstheme/img/images/courses-2.jpg')}}" class="img-fluid">
                                    </div>
                                  </div>

                                  <div class="col-md-4 p-2 insta">
                                    <div class="instabox">
                                      <img src="{{asset('public/frontend/infixlmstheme/img/images/courses-4.jpg')}}" class="img-fluid">
                                    </div>
                                  </div>

                                  <div class="col-md-4 p-2 insta">
                                    <div class="instabox">
                                      <img src="{{asset('public/frontend/infixlmstheme/img/images/courses-1.jpg')}}" class="img-fluid">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> --}}
                            <div class="col-md-12 my-4 ">
                                <div class="rightbox bgcolor px-4 py-1">
                                    <h4 class="mt-2">Social Links:</h4>
                                    <div class="row my-4 ">
                                        <div class="col-md-6 -2 insta">
                                            <div class="instabox ">
                                                {{-- <img src="{{asset('public/frontend/infixlmstheme/img/images/courses-1.jpg')}}" class="img-fluid insta1"> --}}
                                               <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{URL::current()}}">
                                                   <i class="fa-brands fa-square-facebook" style="color: #395799;"></i>
                                               </a>
                                            </div>
                                        </div>


                                        <div class="col-md-6 -2 insta">
                                            <div class="instabox ">
                                                {{-- <img src="{{asset('public/frontend/infixlmstheme/img/images/courses-2.jpg')}}" class="img-fluid"> --}}
                                                <a target="_blank" href="https://twitter.com/intent/tweet?text={{$program_detail->programtitle}}&amp;url={{URL::current()}}">
                                                <i class="fa-brands fa-square-twitter" style="color: #03abf0;"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pt-3 insta">
                                            <div class="instabox">
                                                <a target="_blank" href="https://pinterest.com/pin/create/link/?url={{URL::current()}}&amp;description={{$program_detail->programtitle}}">
                                                <i class="fa-brands fa-square-pinterest" style="color: #c92128;"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pt-3 insta">
                                            <div class="instabox">
                                                {{-- <img src="{{asset('public/frontend/infixlmstheme/img/images/courses-2.jpg')}}" class="img-fluid"> --}}
                                                <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{URL::current()}}&amp;title={{$program_detail->programtitle}}&amp;summary={{$program_detail->programtitle}}">
                                                <i class="fa fa-linkedin-square" style="color: #0477b5;"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer class="footer pt-5  footercolor">
        <div class="containerdoosme">
            <div class="row text-white">
                <div class="col-md-3">

                    <div class=" expore p-5  text-white">
                        <h4>

                            Explore/About Us

                        </h4>


                        <p class="my-2">Career/Become a Teacher/ Instructor
                        </p>
                        <p class="">Blogs


                        </p>
                        <p>
                            Registration
                        </p>
                        <p class="">

                            Apple Online
                        </p>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footerbox1 p-5">
                        <h4>
                            Academics
                        </h4>


                        <p>
                            Populor Courses
                        </p>
                        <p>
                            Remedial-Rn
                        </p>

                        <p>
                            Rn-Refresher
                        </p>
                        <p>
                            Cna-Prep
                        </p>

                        <p>
                            Nciex-Prep
                        </p>

                        <p>
                            Available Courses
                        </p>

                        <p>
                            Clinic Requirments
                        </p>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footerbox1 p-5">
                        <h4>
                            Support/Services
                        </h4>

                        <p>
                            Certificate Verification
                        </p>

                        <p>
                            Blogs
                        </p>


                        <p>
                            Help & Support
                        </p>

                        <p>
                            Events
                        </p>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footerbox1 p-5">
                        <h4>
                            Contact us
                        </h4>
                        <img src="{{ asset('public/assets/map.png') }}" class="img-fluid mt-3">

                    </div>
                </div>


            </div>
        </div>
    </footer>
    <div class="col-md-12  text-center py-4 text-white footercolor">
        <span>Privacy Policy | Terms | Cookies Policy | FAQs </span>
    </div>
    <div class="" style="background: black;">
        <div class="containerdoosme">
            <div class="row">
                <div class="col-md-6 text-white">
                    <p style="font-weight: 300;" class="my-4 text-white mx-5">
                        © 2018 Qode Interactive, All Rights Reserved
                    </p>
                </div>
                <div class="col-md-2 text-white"></div>
                <div class="col-md-4 my-4 text-white icons">
          <span style="font-weight: 300;" class="my-4">
            Call +44 300 303 026 Follow us
          </span>
                    <i class="fa-brands fa-twitter"></i
                    ><i class="fa-brands fa-google-plus-g"></i
                    ><i class="fa-brands fa-linkedin"></i>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleka(add,x){
       $(add).addClass('d-none');
        if(x==1){
                $(add).parent().siblings('.controbtndo').addClass('show');
                $(add).siblings('#minus').removeClass('d-none');
                // $('.minusbtn').removeClass('d-none');
        }else{
                 $(add).parent().siblings('.controbtndo').removeClass('show');
                 $(add).siblings('#plus').removeClass('d-none');
                // $('.minusbtn').addClass('d-none');
            }
        }
    </script>
    <script
        src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"
    ></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"
    >
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    {{--
              <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
        </script>
        <script
          src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
          integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
          crossorigin="anonymous"
        ></script> --}}

    <script
        src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"
    ></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"
    ></script>
@endsection

