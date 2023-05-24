@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ $tutor->name }}
@endsection
@section('css')
    <link href="{{ asset('public/frontend/infixlmstheme/css/class_details.css') }}" rel="stylesheet"/>
    <style>
        /* Left Sidebar Section  style*/
        .left {
            position: fixed;
            width: 23%;
            height: 100vh;
            float: left;
        }

        /* Right Sidebar Section  style */
        .right {
            background-repeat: no-repeat;
            height: auto;
            width: 100%;
        }

        /* Main Banner Section style */
        .vansena {
            background-image: url("{{asset('/public/assets/tutor/backimg.png')}}");
            height: 630px;
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* Main banner Heading Section style  */
        .vansena h1 {
            text-align: right;
            z-index: 5;
            font-family: Poppins;
            height: auto;
            width: auto;
            color: rgb(255, 255, 255);
            text-decoration: none;
            white-space: nowrap;
            min-height: 0px;
            min-width: 0px;
            max-height: none;
            max-width: none;
            line-height: 100px;
            letter-spacing: 0px;
            font-weight: 700;
            font-size: 80px;
            transform-origin: 50% 50%;
            opacity: 1;
            transform: translate(0px, 0px);
            visibility: visible;

        }

        .vansena p {
            font-weight: 300;
            font-size: 22px;
            text-align: right;
        }

        /* What we do Section Style  */
        .whatWedo h3 {
            font-weight: bold;
            font-size: 22px;
            line-height: 42px;
            cursor: pointer;
        }

        .whatWedo {

            border-bottom: 2px dotted #e1e1e1;
        }

        .whatWedo i {
            color: red;
            margin-right: 1rem;
            font-weight: bold;
        }

        .whatWedo h3 i:hover {
            color: red;
            margin-right: 1rem;
            font-weight: bold;
            opacity: 1;
        }

        .select h1 {
            font-weight: bold;
            font-size: 45px;
        }

        .select p {
            font-size: 23px;
            font-weight: 300;
        }

        .markdone p {
            font-size: 14px;
            color: #252525;
            font-family: Poppins, sans-serif;
        }

        .markdone p i {
            font-size: 14px;
            color: red;
        }


        .controlSize {
            height: 350px;
        }

        .newknowledge {
            background-color: #ff1949;
        }

        .heading h1 {
            font-size: 45px;
            color: white;
            font-weight: bold;
        }

        .heading p {
            font-size: 18px;
            color: white;
            font-weight: bold;
            text-decoration: underline;
        }

        .lead h1 {
            font-size: 45px;
            font-weight: bold;
        }

        .lead p {
            font-size: 18px;
            font-weight: bold;
            text-decoration: underline;
        }

        .newknowledgeImg {
            background-image: url('images/banner.jpg');
            background-size: cover;
        }

        .datatext {
            width: 600px;
        }

        @media (max-width: 500px) {

            /* Left Sidebar Section  style*/
            .left {
                position: relative;
                width: 100%;
                height: 50vh;
                float: left;
            }

            /* Right Sidebar Section  style */
            .right {
                margin-left: 0%;
                background-repeat: no-repeat;
                height: auto;
                width: 100%;
                float: right;
            }

            /* Main Banner Section style */
            .vansena {
                background-image: url('images/backimg.png');
                height: 630px;
                background-repeat: no-repeat;
                background-size: cover;
            }

            /* Main banner Heading Section style  */
            .vansena h1 {
                text-align: right;
                z-index: 5;
                font-family: Poppins;
                height: auto;
                width: auto;
                color: rgb(255, 255, 255);
                text-decoration: none;
                white-space: nowrap;
                min-height: 0px;
                min-width: 0px;
                max-height: none;
                max-width: none;
                line-height: 100px;
                letter-spacing: 0px;
                font-weight: 700;
                font-size: 40px;
                transform-origin: 50% 50%;
                opacity: 1;
                transform: translate(0px, 0px);
                visibility: visible;

            }

            .vansena p {
                font-weight: 300;
                font-size: 20px;
            }

            .datatext {
                width: auto;
            }

        }
    </style>
@endsection
@section('js')
    <script>
        function shoot(id) {
            if (id == 1) {
                $('.registermain').addClass('d-none');
                $('.whatmain').removeClass('d-none');
                $('.howmain').addClass('d-none');
                $('.programmain').addClass('d-none');
                $('.coursemain').addClass('d-none');
            }
            if (id == 2) {
                $('.registermain').addClass('d-none');
                $('.whatmain').addClass('d-none');
                $('.howmain').addClass('d-none');
                $('.programmain').addClass('d-none');
                $('.coursemain').removeClass('d-none');
            } else if (id == 3) {
                $('.registermain').removeClass('d-none');
                $('.whatmain').addClass('d-none');
                $('.howmain').addClass('d-none');
                $('.programmain').addClass('d-none');
                $('.coursemain').addClass('d-none');
            } else if (id == 4) {
                $('.registermain').addClass('d-none');
                $('.whatmain').addClass('d-none');
                $('.howmain').removeClass('d-none');
                $('.programmain').addClass('d-none');
                $('.coursemain').addClass('d-none');
            } else if (id == 5) {
                $('.registermain').addClass('d-none');
                $('.whatmain').addClass('d-none');
                $('.howmain').addClass('d-none');
                $('.programmain').removeClass('d-none');
                $('.coursemain').addClass('d-none');
            }

        }
    </script>
@endsection

@section('mainContent')
    <div class="MainContainer">
        <div class="row m-0">
            <!-- left SideBar Section  -->
            <!-- <div class="left bg-dark">
                                                                                                                                                                                                                                    </div> -->
            <!-- Right Sidebar Section  -->
            <div class="col-md-12 p-0">
                <!-- Main banner Section Content  -->
                <div class="row change m-0">
                    <div class="col-md-12 vansena"></div>
                    <!-- <div class="col-md-4"></div>
                                                                                                                                                                                                                                        <div class="col-md-12 vansena" style="background-image:url('images/courses-2.jpg')">
                                                                                                                                                                                                                                          <div class="row">
                                                                                                                                                                                                                                            <div class="col-md-4"></div>
                                                                                                                                                                                                                                            <div class="col-md-8">
                                                                                                                                                                                                                                              <div class="datatext" >
                                                                                                                                                                                                                                                <h1 class="mt-5 pt-5">Vansena Keit<span>h</span></h1>
                                                                                                                                                                                                                                            <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur, ipsam incidunt quasi, officia quisquam consectetur quam eligendi, enim corrupti labore.</p>
                                                                                                                                                                                                                                              </div>
                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                          </div>
                                                                                                                                                                                                                                        </div>   -->
                </div>
                <!-- what we do section  -->
                <div class="row m-0 mt-5">
                    <div class="col-md-12">
                        <div class="row px-4">
                            <div class="col-md-4">
                                <div class="whatWedo what mx-3 my-3">
                                    <h3 class="d-inine" onclick="shoot(1)">
                                        <i class="bi bi-arrow-right"></i>About Tutor
                                    </h3>
                                </div>
                                <div class="whatWedo course mx-3 my-3">
                                    <h3 class="d-inine" onclick="shoot(2)">
                                        <i class="bi bi-arrow-right"></i>Courses
                                    </h3>
                                </div>
                                <div class="whatWedo register mx-3 my-3">
                                    <h3 class="d-inine" onclick="shoot(3)">
                                        <i class="bi bi-arrow-right"></i>Book Now
                                    </h3>
                                </div>
                                {{-- <div class="whatWedo how mx-3 my-3">
                                    <h3 class="d-inine" onclick="shoot(4)">
                                        <i class="bi bi-arrow-right"></i>How we do it
                                    </h3>
                                </div>
                                <div class="whatWedo program mx-3 my-3">
                                    <h3 class="d-inine" onclick="shoot(5)">
                                        <i class="bi bi-arrow-right"></i>Our Program
                                    </h3>
                                </div> --}}
                            </div>
                            <div class="col-md-4 select whatmain">
                                <h1>{{ $tutor->name }}</h1>
                                <div class="markdone">
                                    <p><i class="bi bi-check"></i>{{ $tutor->about }}</p>
                                    {{-- <p> Lorem ipsum dolor sit amet conse</p>
                                    <p> <i class="bi bi-check"></i>
                                        Nulla ante eros, venenatis vel suad
                                    </p>
                                    <p><i class="bi bi-check"></i>
                                        Lorem ipscras maximus turpis egit
                                    </p>
                                    <p> <i class="bi bi-check"></i>
                                        Vestibulum vitae libero neque</p> --}}
                                </div>
                            </div>
                            <div class="col-md-4 select coursemain d-none">
                                <h1>Course</h1>
                                <div class="markdone">
                                    <ul>
                                        @forelse ($courses as $course)
                                            <li>
                                                <p><i class="ti ti-check"></i> {{ $course->title }}</p>
                                            </li>
                                        @empty
                                            <li>
                                                <p>No Course of This Tutor</p>
                                            </li>
                                            <h3></h3>
                                        @endforelse
                                    </ul>
                                    {{-- <p> <i class="bi bi-check"></i>
                                        Nulla ante eros, venenatis vel suad
                                    </p>
                                    <p><i class="bi bi-check"></i> Lorem ipsum dolor sit amet conse</p>
                                    <p> <i class="bi bi-check"></i>
                                        Vestibulum vitae libero neque</p>
                                    <p><i class="bi bi-check"></i>
                                        Lorem ipscras maximus turpis egit
                                    </p> --}}
                                </div>
                            </div>
                            <div class="col-md-4 select registermain d-none">
                                <h1>Book Now</h1>
                                <p>If you want to hire the Tutor, Please Click the Below Button</p>
                                <a href="{{ route('tutorBooking', $tutor->id) }}"
                                   class="theme_btn small_btn2 mt-4">Book</a>
                                {{-- <div class="markdone">
                                    <p><i class="bi bi-check"></i> Lorem ipsum dolor sit amet conse</p>
                                    <p> <i class="bi bi-check"></i>
                                        Nulla ante eros, venenatis vel suad
                                    </p>
                                    <p><i class="bi bi-check"></i>
                                        Lorem ipscras maximus turpis egit
                                    </p>
                                    <p> <i class="bi bi-check"></i>
                                        Vestibulum vitae libero neque</p>
                                </div> --}}
                            </div>
                            {{-- <div class="col-md-4 select howmain d-none">
                                <h1>How we do it</h1>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                                <div class="markdone">
                                    <p><i class="bi bi-check"></i> Lorem ipsum dolor sit amet conse</p>
                                    <p> <i class="bi bi-check"></i>
                                        Nulla ante eros, venenatis vel suad
                                    </p>
                                    <p><i class="bi bi-check"></i>
                                        Lorem ipscras maximus turpis egit
                                    </p>
                                    <p> <i class="bi bi-check"></i>
                                        Vestibulum vitae libero neque</p>
                                </div>
                            </div>
                            <div class="col-md-4 select programmain d-none">
                                <h1>Our Program</h1>
                                <p> consectetur adipiscing elit, Lorem ipsum dolor sit amet</p>
                                <div class="markdone">
                                    <p> <i class="bi bi-check"></i>
                                        Nulla ante eros, venenatis vel suad
                                    </p>
                                    <p><i class="bi bi-check"></i> Lorem ipsum dolor sit amet conse</p>
                                    <p> <i class="bi bi-check"></i>
                                        Vestibulum vitae libero neque</p>
                                    <p><i class="bi bi-check"></i>
                                        Lorem ipscras maximus turpis egit
                                    </p>
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <img src="{{ asset($tutor->image) }}" class="img-fluid mt-4">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-0">
                    <div class="col-md-6 p-0">
                        <img src="{{asset('/public/assets/tutor/instructor.jpg')}}" class="img-fluid w-100 controlSize">
                    </div>
                    <div class="col-md-6 p-0">
                        <div class="controlSize newknowledge">
                            <div class="heading px-5 pt-5">
                                <h1 class="pt-4">New knowledge is important</h1>
                                <p class="mt-3">Read More</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 newknowledgeImg p-0">
                        <div class="controlSize">
                            <div class="lead px-5 pt-5">
                                <h1 class="pt-4">New knowledge is important</h1>
                                <p class="mt-3">Read More</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 p-0">
                        <img src="{{asset('/public/assets/tutor/book.jpg')}}" class="img-fluid controlSize w-100">
                    </div>
                </div>
            </div>
        </div>

        <div class="jumbotron m-0 row">
            <!-- content  -->
            <div class="course_review_wrapper w-75">
                <div class="details_title">
                    <h4 class="font_22 f_w_700">{{__('frontend.Student Feedback')}}</h4>
                    <p class="font_16 f_w_400">{{ $tutor->name }}</p>
                </div>
                <div class="course_feedback">
                    <div class="course_feedback_left">
                        <h2>{{$tutor->total_tutor_rating}}</h2>
                        <div class="feedmak_stars">

                            @php

                                $main_stars=$tutor->total_tutor_rating;

                                $stars=intval($tutor->total_tutor_rating);

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
                    {{--                    <div class="feedbark_progressbar">--}}
                    {{--                        <div class="single_progrssbar">--}}
                    {{--                            <div class="progress">--}}
                    {{--                                <div class="progress-bar" role="progressbar"--}}
                    {{--                                     style="width: {{getPercentageRating($tutor->total_tutor_rating,5)}}%"--}}
                    {{--                                     aria-valuenow="{{getPercentageRating($tutor->total_tutor_rating,5)}}"--}}
                    {{--                                     aria-valuemin="0" aria-valuemax="100">--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="rating_percent d-flex align-items-center">--}}
                    {{--                                <div class="feedmak_stars d-flex align-items-center">--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                </div>--}}
                    {{--                                <span>{{getPercentageRating($tutor->total_tutor_rating,5)}}%</span>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="single_progrssbar">--}}
                    {{--                            <div class="progress">--}}
                    {{--                                <div class="progress-bar" role="progressbar"--}}
                    {{--                                     style="width: {{getPercentageRating($tutor->total_tutor_rating,4)}}%"--}}
                    {{--                                     aria-valuenow="{{getPercentageRating($tutor->total_tutor_rating,4)}}"--}}
                    {{--                                     aria-valuemin="0" aria-valuemax="100">--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="rating_percent d-flex align-items-center">--}}
                    {{--                                <div class="feedmak_stars d-flex align-items-center">--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="far fa-star"></i>--}}
                    {{--                                </div>--}}
                    {{--                                <span>{{getPercentageRating($tutor->total_tutor_rating,4)}}%</span>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="single_progrssbar">--}}
                    {{--                            <div class="progress">--}}
                    {{--                                <div class="progress-bar" role="progressbar"--}}
                    {{--                                     style="width: {{getPercentageRating($tutor->total_tutor_rating,3)}}%"--}}
                    {{--                                     aria-valuenow="{{getPercentageRating($tutor->total_tutor_rating,3)}}"--}}
                    {{--                                     aria-valuemin="0" aria-valuemax="100">--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="rating_percent d-flex align-items-center">--}}
                    {{--                                <div class="feedmak_stars d-flex align-items-center">--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="far fa-star"></i>--}}
                    {{--                                    <i class="far fa-star"></i>--}}

                    {{--                                </div>--}}
                    {{--                                <span>{{getPercentageRating($tutor->total_tutor_rating,3)}}%</span>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="single_progrssbar">--}}
                    {{--                            <div class="progress">--}}
                    {{--                                <div class="progress-bar" role="progressbar"--}}
                    {{--                                     style="width: {{getPercentageRating($tutor->total_tutor_rating,2)}}%"--}}
                    {{--                                     aria-valuenow="{{getPercentageRating($tutor->total_tutor_rating,2)}}"--}}
                    {{--                                     aria-valuemin="0" aria-valuemax="100">--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="rating_percent d-flex align-items-center">--}}
                    {{--                                <div class="feedmak_stars d-flex align-items-center">--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="far fa-star"></i>--}}
                    {{--                                    <i class="far fa-star"></i>--}}
                    {{--                                    <i class="far fa-star"></i>--}}
                    {{--                                </div>--}}
                    {{--                                <span>{{getPercentageRating($tutor->total_tutor_rating,2)}}%</span>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="single_progrssbar">--}}
                    {{--                            <div class="progress">--}}
                    {{--                                <div class="progress-bar" role="progressbar"--}}
                    {{--                                     style="width: {{getPercentageRating($tutor->total_tutor_rating,1)}}%"--}}
                    {{--                                     aria-valuenow="{{getPercentageRating($tutor->total_tutor_rating,1)}}"--}}
                    {{--                                     aria-valuemin="0" aria-valuemax="100">--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="rating_percent d-flex align-items-center">--}}
                    {{--                                <div class="feedmak_stars d-flex align-items-center">--}}
                    {{--                                    <i class="fas fa-star"></i>--}}
                    {{--                                    <i class="far fa-star"></i>--}}
                    {{--                                    <i class="far fa-star"></i>--}}
                    {{--                                    <i class="far fa-star"></i>--}}
                    {{--                                    <i class="far fa-star"></i>--}}
                    {{--                                </div>--}}
                    {{--                                <span>{{getPercentageRating($tutor->total_tutor_rating,1)}}%</span>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>

                @php
                    $PickId=$tutor->id;
                    $user_tutor_hiring_count = \Modules\SystemSetting\Entities\TutorHiring::where('user_id',\Illuminate\Support\Facades\Auth::id())->where('instructor_id',$PickId)->count();
                @endphp
                <div class="course_review_header mb_20">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="review_poients">
                                @if ($user_tutor_hiring_count > 0)
                                    @if ($tutor->tutorReviews->count()<1)
                                        @if (Auth::check() && $tutor->userTutorReviews->count() == 0)
                                            <p class="theme_color font_16 mb-0">{{ __('frontend.Be the first reviewer') }}</p>
                                        @else
                                            <p class="theme_color font_16 mb-0">{{ __('frontend.No Review found') }}</p>
                                        @endif
                                    @endif
                                @else
                                    <p class="theme_color font_16 mb-0">{{ __('First you buy then review') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="rating_star text-right">


                                @if (Auth::check() && Auth::user()->role_id==3)
                                    @if ($tutor->userTutorReviews->count() == 0 && $user_tutor_hiring_count > 0)
                                        <div
                                            class="star_icon d-flex align-items-center justify-content-end">
                                            <a class="rating">
                                                <input type="radio" id="star5" name="rating"
                                                       value="5"
                                                       class="rating"/><label
                                                    class="full" for="star5" id="star5"
                                                    title="Awesome - 5 stars"
                                                    onclick="Rates(5, {{@$PickId }})"></label>

                                                <input type="radio" id="star4" name="rating"
                                                       value="4"
                                                       class="rating"/><label
                                                    class="full" for="star4"
                                                    title="Pretty good - 4 stars"
                                                    onclick="Rates(4, {{@$PickId }})"></label>

                                                <input type="radio" id="star3" name="rating"
                                                       value="3"
                                                       class="rating"/><label
                                                    class="full" for="star3"
                                                    title="Meh - 3 stars"
                                                    onclick="Rates(3, {{@$PickId }})"></label>

                                                <input type="radio" id="star2" name="rating"
                                                       value="2"
                                                       class="rating"/><label
                                                    class="full" for="star2"
                                                    title="Kinda bad - 2 stars"
                                                    onclick="Rates(2, {{@$PickId }})"></label>

                                                <input type="radio" id="star1" name="rating"
                                                       value="1"
                                                       class="rating"/><label
                                                    class="full" for="star1"
                                                    title="Bad  - 1 star"
                                                    onclick="Rates(1,{{@$PickId }})"></label>

                                            </a>
                                        </div>
                                    @endif
                                @else

                                    <p class="font_14 f_w_400 mt-0"><a href="{{url('login')}}"
                                                                       class="theme_color2">{{__('frontend.Sign In')}}</a>
                                        {{__('frontend.or')}} <a
                                            class="theme_color2"
                                            href="{{url('register')}}">{{__('frontend.Sign Up')}}</a>
                                        {{__('frontend.as student to post a review')}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="course_cutomer_reviews">
                    <div class="details_title">
                        <h4 class="font_22 f_w_700">{{__('frontend.Reviews')}}</h4>

                    </div>
                    <div class="customers_reviews" id="customers_reviews">


                    </div>
                </div>
            </div>
            <!-- content  -->
        </div>
    </div>

    <div class="modal cs_modal fade admin-query" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('frontend.Review') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><i
                            class="ti-close "></i></button>
                </div>

                <form action="{{route('submitTutorReview')}}" method="Post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="tutor_id" id="rating_tutor_id"
                               value="">
                        <input type="hidden" name="rating" id="rating_value" value="">

                        <div class="text-center">
                      <textarea class="lms_summernote" name="review" name=""
                                id=""
                                placeholder="{{__('frontend.Write your review') }}"
                                cols="30"
                                rows="10">{{old('review')}}</textarea>
                            <span class="text-danger" role="alert">{{$errors->first('review')}}</span>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="mt-40">
                            <button type="button" class="theme_line_btn mr-2"
                                    data-dismiss="modal">{{ __('common.Cancel') }}
                            </button>
                            <button class="theme_btn "
                                    type="submit">{{ __('common.Submit') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @include(theme('partials._delete_model'))

    <script>
        function Rates(val, id) {
            document.getElementById('rating_tutor_id').value = id;
            document.getElementById('rating_value').value = val;
            $("#myModal").modal();
        }
    </script>


    <script>
        function deleteCommnet(item, element) {
            let form = $('#deleteCommentForm')
            form.attr('action', item);
            form.attr('data-element', element);
        }
    </script>


    <script>
        var SITEURL = "{{ route('tutorDetails', [$tutor->id, Str::slug($tutor->name, '-')]) }}";
        var page = 1;

        load_more_review(page);


        $(window).scroll(function () { //detect page scroll
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 400) {
                page++;
                load_more_review(page);
            }


        });

        function load_more_review(page) {
            $.ajax({
                url: SITEURL + "?page=" + page,
                type: "get",
                datatype: "html",
                data: {
                    'type': 'review',
                },
                beforeSend: function () {
                    $('.ajax-loading').show();
                }
            })
                .done(function (data) {
                    if (data.length == 0) {

                        //notify user if nothing to load
                        $('.ajax-loading').html("");
                        return;
                    }
                    $('.ajax-loading').hide(); //hide loading animation once data is received
                    $("#customers_reviews").append(data); //append data into #results element


                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('No response from server');
                });

        }
    </script>
@endsection

