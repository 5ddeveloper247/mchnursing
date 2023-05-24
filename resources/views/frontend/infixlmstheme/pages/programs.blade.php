@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ __('Programs') }}
@endsection
@section('css')
    <script src="https://kit.fontawesome.com/b98cad50b5.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: sans-serif;
            font-style: normal;
            font-weight: 400;
        }

        .boxbanner h1 {
            font-size: 70px;
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
            height: 340px;
            width: 100%;
        }

        .courseimg img:hover {
            opacity: 0.5;
            /* transform: scale(1.1); */
        }

        @media(max-width:2000px) {
            .courseimg img {
                height: 340px;
                width: 100%;
            }

            @media(min-width:2700px) {
                .courseimg img {
                    height: 380px;
                    width: 100%;
                }

            }

            .just {
                /*
                        height: 57px;
                        overflow: hidden; */
            }

            .title_des+p {
                height: 80px;
                overflow: hidden;
                font-family: "Open Sans", sans-serif;
                font-size: 14px;
                font-weight: 300;
                text-align: justify;
            }

            .coursedata label {}

            .title_des {
                font-size: 22px;
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
    </style>
@endsection

@section('js')
@endsection
@section('mainContent')
    <div class="mainbanner">
        <div class="boxbanner containerdoosme p-5">
            <h1 class="mt-5 pt-5 text-white">Programs</h1>
        </div>
    </div>
    <div class="containerdoosme controlbox1 p-5">
        <div class="row my-5 p-2">
            <div class="col-md-12">
                <div class="row">


                    <div class="col-md-9">
                        <div class="row">
                            @if (isset($programs))
                                @foreach ($programs as $program)
                                    <div class="col-sm-6 col-md-4 mb-5">
                                        <div class="courseimg">
                                            <a href="{{ route('programs.detail', [$program->id]) }}"><img
                                                    src="{{ getCourseImage($program->icon) }}" class="img-fluid"></a>

                                        </div>
                                        <div class="coursedata label">
                                            @php
                                            @endphp
                                            <h5 class="f-bolder mt-4"><a
                                                    href="{{ route('programs.detail', [$program->id]) }}">
                                                    {{ $program->programtitle }}</a>
                                            </h5>
                                            <p class="title_des pb-2">{{ $program->subtitle }}</p> {!! $program->discription !!}

                                            <div class="row pt-4">
                                                <div class="col-md-5 col">
                                                    <span class="span">
                                                        {{ count(json_decode($program->allcourses)) }} courses
                                                    </span>
                                                </div>
                                                <div class="col-md-4 col p-0">
                                                    <span class="rating">
                                                        {{ round((strtotime($program->currentProgramPlan[0]->edate) - strtotime($program->currentProgramPlan[0]->sdate)) / 604800, 1) }}
                                                        Weeks
                                                    </span>
                                                </div>
                                                <div class="col-md-3 col p-0">
                                                    <p class="spane color">
                                                        ${{ $program->currentProgramPlan[0]->amount }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if (count($programs) == 0)
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
                        <div class="row">
                            @if (count($programs) != 0)
                                {{ $programs->links() }}
                            @endif
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="rightbox bgcolor px-4 py-5">
                                    <h4>Program Feartures</h4>
                                    <p>Courses / {{ \Modules\CourseSetting\Entities\Course::where('status', 1)->count() }}
                                    </p>
                                    <p>Classes /
                                        {{ \Modules\VirtualClass\Entities\VirtualClass::where('status', 1)->count() }}</p>
                                </div>
                            </div>
                            {{--                            <div class="col-md-12 my-4"> --}}
                            {{--                                <div class="rightbox bgcolor px-4 py-5"> --}}
                            {{--                                    <h4>Certification</h4> --}}
                            {{--                                    <p class="just"> --}}
                            {{--                                        Lorem Ipsn gravida nibh vel velit auctor aliquet aenean sollicitudin --}}
                            {{--                                    </p> --}}
                            {{--                                    <img src="{{asset('public/frontend/infixlmstheme/img/images/certificate.jpg')}}" --}}
                            {{--                                         class="img-fluid"> --}}
                            {{--                                </div> --}}
                            {{--                            </div> --}}
                            <div class="col-md-12 my-4">
                                <div class="rightbox bgcolor px-4 py-5">
                                    <h4>You may like</h4>

                                    @forelse($recent_program as  $program)
                                        <div class="row my-3">
                                            <div class="col-md-6">
                                                <a href="{{ route('programs.detail', [$program->id]) }}">
                                                    <img style="" src="{{ getCourseImage($program->icon) }}"
                                                        class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="col-md-6 coureparagraph">
                                                <p>
                                                    <a class="text-dark"
                                                        href="{{ route('programs.detail', [$program->id]) }}">
                                                        {{ $program->subtitle }}</a>
                                                </p>
                                                <p> {{ round((strtotime($program->currentProgramPlan[0]->edate) - strtotime($program->currentProgramPlan[0]->sdate)) / 604800, 1) }}
                                                    Weeks</p>
                                                <p class="color"> ${{ $program->currentProgramPlan[0]->amount }}</p>
                                            </div>
                                        </div>

                                    @empty
                                        <div class="row my-3">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-11">
                                                <div
                                                    class="Nocouse_wizged d-flex align-items-center justify-content-center text-center">
                                                    <div class="thumb">
                                                        <img style="width: 20px"
                                                            src="{{ asset('public/frontend/infixlmstheme') }}/img/not-found.png"
                                                            alt="">
                                                    </div>
                                                    <h6>
                                                        {{ __('No Program Found') }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse

                                </div>

                            </div>
                            {{--                            <div class="col-md-12 my-4 "> --}}
                            {{--                                <div class="rightbox bgcolor px-4 py-1"> --}}
                            {{--                                    <h4 class="mt-2">Social Links:</h4> --}}
                            {{--                                    <div class="row my-4 "> --}}
                            {{--                                        <div class="col-md-6 -2 insta"> --}}
                            {{--                                            <div class="instabox "> --}}
                            {{--                                                --}}{{-- <img src="{{asset('public/frontend/infixlmstheme/img/images/courses-1.jpg')}}" class="img-fluid insta1"> --}}
                            {{--                                                <i class="fa-brands fa-square-facebook" style="color:#0374ed;"></i> --}}
                            {{--                                            </div> --}}
                            {{--                                        </div> --}}


                            {{--                                        <div class="col-md-6 -2 insta"> --}}
                            {{--                                            <div class="instabox "> --}}
                            {{--                                                --}}{{-- <img src="{{asset('public/frontend/infixlmstheme/img/images/courses-2.jpg')}}" class="img-fluid"> --}}
                            {{--                                                <i class="fa-brands fa-square-whatsapp" style="color:#33e555;"></i> --}}
                            {{--                                            </div> --}}
                            {{--                                        </div> --}}
                            {{--                                        <div class="col-md-6 pt-3 insta"> --}}
                            {{--                                            <div class="instabox"> --}}

                            {{--                                                <i class="fa-brands fa-square-youtube" style="color:#f40009"></i> --}}
                            {{--                                            </div> --}}
                            {{--                                        </div> --}}
                            {{--                                        <div class="col-md-6 pt-3 insta"> --}}
                            {{--                                            <div class="instabox"> --}}
                            {{--                                                --}}{{-- <img src="{{asset('public/frontend/infixlmstheme/img/images/courses-2.jpg')}}" class="img-fluid"> --}}
                            {{--                                                <i class="fa-brands fa-square-instagram"></i> --}}
                            {{--                                            </div> --}}
                            {{--                                        </div> --}}
                            {{--                                    </div> --}}
                            {{--                                </div> --}}
                            {{--                            </div> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include(theme('partials._custom_footer'))
    <script>
        a = 1;

        function togglefn() {
            if (a == 1) {

                current = document.querySelector(".title_des");
                next = current.nextElementSibling;
                next.style.height = "auto";
                a = 2;
            } else {
                a = 1;
                current = document.querySelector(".title_des");
                next = current.nextElementSibling;
                next.style.height = "80px";
            }
        }
    </script>
@endsection
