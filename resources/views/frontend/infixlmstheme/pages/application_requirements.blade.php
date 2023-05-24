@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ __('Application Requirements') }}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('public/assets/owl.carousel.min.css') }}" />


    <style>
        .footer .row p {
            font-weight: normal !important;
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

        .footercolor {
            background: #252525;
        }

        /* .mainbanner {
                    height: 530px;
                    background-size: cover;
                    color: white;
                } */

        .cont1doimgdo1 {
            /* background: url("{{ asset('public/frontend/infixlmstheme/img/images/courses-4.jpg') }}"); */
            background-size: cover;
            height: 405px;
            background: red;
        }


        /* .custom_shadow:hover {
                                                                                                                                            border: 1px solid rgb(255, 255, 255);
                                                                                                                                        } */

        .custom_shadow {
            border: 1px solid rgb(255, 255, 255);
            box-shadow: 0 3px 20px rgb(0 0 0 / 5%);
        }

        .owl-next,
        .owl-prev {
            display: none !important;
        }

        .card_img {
            width: 50px !important;
            border-radius: 50% !important;
        }

        .slider_heading_h1 {
            font-weight: bold;
            font-size: 32px !important;
            /* margin-top: 90px; */

        }

        .slider_paragraph {
            font-size: 22px !important;
            /* margin-top: 90px; */
        }

        .slider_img1 {
            width: 744px !important;
            height: 405px;
            /* border-radius: 50% !important;
                    padding-top: 1.15rem !important; */
        }

        td {
            height: 9rem;
            text-align: end;
        }

        .custom_p {
            color: #eee;
            font-size: 1.8rem;
            text-shadow: 0.5rem 0.5rem 0.5rem rgba(17, 17, 17, 0.2);
        }

        .custom_h1 {
            font-size: 4.5rem;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            text-shadow: 0.5rem 0.5rem 0.5rem rgba(17, 17, 17, 0.3);
            font-family: "source sans", Helvetica, Arial, sans-serif;
            font-weight: 700;
        }

        .content {
            max-width: 64rem;
            color: #fff;
            margin: 0 auto;
        }

        .site_btn.round {
            border-radius: 5rem;
        }

        section {
            position: relative;
            padding: 4rem 0;
        }

        .contain,
        .contain-fluid {
            position: relative;
            max-width: 120rem;
            padding: 0 1.5rem;
            margin: 0 auto;
            min-height: 0.1rem;
        }

        h1.heading {
            position: relative;
            margin-bottom: 2.5rem;
        }

        .faq_lst>.faq_blk {
            position: relative;
            background: #fff;
            padding: 2rem;
            border-radius: 1rem;
            -webkit-box-shadow: 0 0.7rem 1.5rem -0.5rem rgba(17, 17, 17, 0.08), 0 -0.5rem 1rem -0.6rem rgba(17, 17, 17, 0.03);
            box-shadow: 0 0.7rem 1.5rem -0.5rem rgba(17, 17, 17, 0.08), 0 -0.5rem 1rem -0.6rem rgba(17, 17, 17, 0.03);
            margin-bottom: 2rem;
            -webkit-transition: all ease 0.5s;
            transition: all ease 0.5s;
        }

        .faq_lst>.faq_blk.active h5:after {
            background: #6a0dad;
            -webkit-clip-path: polygon(0 40%, 0 60%, 100% 60%, 100% 40%);
            clip-path: polygon(0 40%, 0 60%, 100% 60%, 100% 40%);
        }

        .faq_lst>.faq_blk h5:after {
            content: "";
            position: absolute;
            top: 0.2rem;
            right: 0;
            width: 1.2rem;
            height: 1.2rem;
            background: #111;
            -webkit-clip-path: polygon(0 40%, 0 60%, 40% 60%, 40% 100%, 60% 100%, 60% 60%, 100% 60%, 100% 40%, 60% 40%, 60% 0, 40% 0, 40% 40%);
            clip-path: polygon(0 40%, 0 60%, 40% 60%, 40% 100%, 60% 100%, 60% 60%, 100% 60%, 100% 40%, 60% 40%, 60% 0, 40% 0, 40% 40%);
            -webkit-transition: all ease 0.5s;
            transition: all ease 0.5s;
        }

        /* .containerwidth {
                    width: 100%;
                } */

        .wrapper {
            background-color: #ffffff;
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            -webkit-box-shadow: 0 15px 25px rgba(0, 0, 50, 0.2);
            box-shadow: 0 15px 25px rgba(0, 0, 50, 0.2);
        }

        .toggle,
        .content {
            font-family: "Poppins", sans-serif;
        }

        .toggle {
            width: 100%;
            background-color: transparent;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            font-size: 16px;
            color: #111130;
            font-weight: 600;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 10px 0;
        }

        .content {
            position: relative;
            font-size: 14px;
            text-align: justify;
            line-height: 30px;
            height: 0;
            overflow: hidden;
            -webkit-transition: all 1s;
            -o-transition: all 1s;
            transition: all 1s;
        }

        #choose {
            background: #eee;
        }

        .contain,
        .contain-fluid {
            position: relative;
            max-width: 120rem;
            padding: 0 1.5rem;
            margin: 0 auto;
            min-height: 0.1rem;
        }

        #choose .flex_row {
            width: calc(100% + -5rem);
            margin: 2.5rem;
            display: flex;
        }

        #choose .flex_row>.col {
            width: 25%;
            padding: 2.5rem;

        }

        #choose .inner {
            position: relative;
            background: #fff;
            padding: 2.5rem;
            border-radius: 1rem;
            -webkit-box-shadow: 0 0.7rem 1.5rem -0.5rem rgba(17, 17, 17, 0.08), 0 -0.5rem 1rem -0.6rem rgba(17, 17, 17, 0.03);
            box-shadow: 0 0.7rem 1.5rem -0.5rem rgba(17, 17, 17, 0.08), 0 -0.5rem 1rem -0.6rem rgba(17, 17, 17, 0.03);
        }

        .flex_row>.col {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
        }

        #choose .inner>.icon {
            width: 8rem;
            min-width: 8rem;
            height: 4rem;
            margin: 0 auto 2rem;
        }

        .flex_blk {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            min-height: 100vh;
            padding: 8rem 0;
            padding-top: 17rem;
        }

        .contain,
        .contain-fluid {
            position: relative;
            max-width: 120rem;
            padding: 0 1.5rem;
            margin: 0 auto;
            min-height: 0.1rem;
        }

        .custom_h1 {
            font-size: calc(3.4rem + 1vmin) !important;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            text-shadow: 0.5rem 0.5rem 0.5rem rgba(17, 17, 17, 0.3);
            color: #fff;
        }

        .custom_P {
            color: #eee;
            font-size: 1.8rem;
            text-shadow: 0.5rem 0.5rem 0.5rem rgba(17, 17, 17, 0.2);
        }

        #banner {
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 0;
            margin-top: -8rem;
        }

        #banner .flex_blk {
            display: -webkit-box;
            display: -ms-flexbox;
            /* display: flex; */
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            min-height: 100vh;
            padding: 8rem 0;
            padding-top: 16rem;
        }

        #banner .content {
            max-width: 64rem;
            color: #fff;
            margin: 0 auto;
        }

        .owl-stage-outer {
            height: 34rem;
        }

        .cont1doimgdo{
            /* background: url("http://mchnursing.com/lms/public/frontend/infixlmstheme/img/images/courses-4.jpg"); */
            background-size: cover;
            height: 405px;
            background: red;
        }

        .custom_fs_a {
            font-size: 30px;

        }

        .custom_card_body {
            height: 22rem;
        }

        .custom_border {
            border-radius: 1rem;
        }
       
        @media (max-width: 768px) {
            .custom_h1 {
                font-size: calc(2.4rem + 1vmin) !important;
            }

            .custom_P {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .custom_h1 {
                font-size: calc(1.6rem + 1vmin) !important;
            }.slider_heading_h1{
                font-size: 27px  !important; 
            }.slider_paragraph{
                font-size: 17px !important;
            }

            .custom_P {
                font-size: 1.2rem;
            }
        }

        /* media queries for slider */
      
    </style>
@endsection
@section('mainContent')
    {{-- <div id="content-area">
        <div class="row">
            <div class="col-md-12 ui-resizable" data-type="container-content">
                <div data-type="component-text">
                    <div class="breadcrumb_area bradcam_bg_1 position-relative mainbanner">
                        <div class="breadcrumb_img w-100 h-100 position-absolute bottom-0 left-0"><img alt=""
                                class="w-100 h-100 img-cover"
                                src="http://mchnursing.com/lms/public/frontend/infixlmstheme/img/banner/bradcam_bg_1.jpg">
                                
                        </div>
                        <div class="content col-md-12 text-center">
                            <p class="custom_p">Your Dreams Realized</p>
                            <h1 class="custom_h1 text-white">Apply Now to Merakii College of Health</h1>
                        </div>
                                <div class=" col-md-12  text-center contact_btn">
                                    <a href="http://mchnursing.com/lms/login" class="theme_btn small_btn2">Apply Now</a>
                                </div>
                            
                           
                        
                    </div>
                </div>
              --}}

    <section id="banner"
        style="background-image: url('https://merakinursing.education/public/frontend/homenew/images/page-title-apply.jpg');">
        <div class="flex_blk">
            <div class="row  text-center">
                <div class="col-md-12 mb-4">
                    <p class="custom_P">Your Dreams Realized</p>
                </div>
                <div class="col-md-12 ">
                    <h1 class="custom_h1">Apply Now to Merakii <br>College of Health</h1>
                    <div class="contact_btn">
                        <a href="#" class="theme_btn small_btn2">Apply Now </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="apply">
        <div class="contain">
            <div class="row justify-content-center text-center">
                <div class="col-md-8">
                    <h1 class="heading">Apply Requirements</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis voluptate libero,
                        recusandae quam voluptates quae laudantium perferendis distinctio temporibus ipsum, id
                        ducimus dolorem vero tempore perspiciatis impedit repellat ex. Doloribus. Lorem ipsum
                        dolor sit amet consectetur adipisicing elit. Consectetur, tempore doloribus aut cumque
                        reiciendis dolore impedit quas nostrum est nesciunt repudiandae! Eius a numquam ullam
                        enim quae incidunt ut recusandae.</p>
                </div>
                <div class=" col-md-12  text-center contact_btn mt-4">
                    <a href="#" class="theme_btn small_btn2">Apply Now</a>
                </div>
            </div>
        </div>
    </section>
    <section id="choose">
        <div class="contain text-center">
            <h1 class="heading">Application Timeline</h1>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 p-3">
                    <div class="card custom_border">
                        <div class="card-body custom_card_body">


                            <div class="icon">
                                <img src="https://merakinursing.education/public/frontend/homenew/images/icon-hardware.svg"
                                    width="75px" alt="">
                            </div>
                            <div class="txt">
                                <h4>Application Period:</h4>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas blanditiis quia
                                    veritatis
                                    nihil excepturi iure.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 p-3">
                    <div class="card custom_border">
                        <div class="card-body custom_card_body">


                            <div class="icon">
                                <img src="https://merakinursing.education/public/frontend/homenew/images/icon-innovation.svg"
                                    width="75px" alt="">
                            </div>
                            <div class="txt">
                                <h4>Review and Evaluation Period:</h4>
                                <p>Accusantium veritatis delectus aliquam itaque illum odit similique numquam dolorem
                                    doloremque
                                    impedit, laudantium error!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 p-3">
                    <div class="card custom_border ">
                        <div class="card-body custom_card_body">


                            <div class="icon">
                                <img src="https://merakinursing.education/public/frontend/homenew/images/icon-reliable.svg"
                                    width="75px" alt="">
                            </div>
                            <div class="txt">
                                <h4>Notification of Decision:</h4>
                                <p>Optio reiciendis minima sunt debitis ea reprehenderit, ipsa et dolores nihil animi maxime
                                    rem
                                    labore, debitis modi.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 p-3">
                    <div class="card custom_border">
                        <div class="card-body custom_card_body ">


                            <div class="icon">
                                <img src="https://merakinursing.education/public/frontend/homenew/images/icon-secure.svg"
                                    width="75px" alt="">
                            </div>
                            <div class="txt">
                                <h4> Registration Period:</h4>
                                <p>Facere similique quisquam tempora soluta, molestias quis dolorum tempore eum quidem ipsa
                                    ratione at commodi porro.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <div class="row featured-carousel owl-carousel m-0">
        <div class="col-md-12 col-12 cont1doimgdo p-0">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                    <div class="pt-4">
                        <h1 class="slider_heading_h1 ml-5 px-5 pt-5 text-white">
                            zulqarnain-test-1
                        </h1>
                        <p class="ml-5 pt-lg-3 px-5 slider_paragraph text-white">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus magni ut animi
                            laborum quidem tempore quas sit et similique? Magni officiis dolores quam quos
                            similique atque quidem repellat recusandae mollitia!
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex justify-content-center align-items-center p-0">
                    <img src="{{ asset('public/assets/c2.jpg') }}" class="d-md-block d-none img-fluid slider_img1">
                </div>
            </div>
        </div>
        <div class="col-md-12 col-12 cont1doimgdo p-0">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                    <div class="pt-4">
                        <h1 class="slider_heading_h1 ml-5 px-5 pt-5 text-white">
                            zulqarnain-test-2
                        </h1>
                        <p class="ml-5 pt-lg-3 px-5 slider_paragraph text-white">
                            In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                            demonstrate the visual form of a document or a typeface without relying on
                            meaningful content. Lorem ipsum may be used as a placeholder before final copy is
                            available.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex justify-content-center align-items-center p-0">
                    <img src="{{ asset('public/assets/c3.jpg') }}" class="d-md-block d-none img-fluid slider_img1">
                </div>
            </div>
        </div>
        <div class="col-md-12 col-12 cont1doimgdo p-0">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                    <div class="pt-4">
                        <h1 class="slider_heading_h1 ml-5 px-5 pt-5 text-white">
                            zulqarnain-test-3
                        </h1>
                        <p class="ml-5 pt-lg-3 px-5 slider_paragraph text-white">
                            In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                            demonstrate the visual form of a document or a typeface without relying on
                            meaningful content. Lorem ipsum may be used as a placeholder before final copy is
                            available.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex justify-content-center align-items-center p-0">
                    <img src="{{ asset('public/assets/c1.jpg') }}" class="d-md-block d-none img-fluid slider_img1">
                </div>
            </div>
        </div>
    </div>
   

    <div class="row justify-content-center">
        <div class="  col-11 col-md-7  text-center text-lg-left">
            <h2 class="heading">Required Application Documents</h2>
        </div>
        <div class="col-md-7 col-11 mt-5">
            <div class="boxaccordion">
                <div class="containerwidth">
                    <div class="wrapper">
                        <button class="toggle">lpn card<i class="fas fa-plus icon"></i></button>
                        <div class="content">
                            <p>hduahdu</p>
                        </div>
                    </div>
                    <div class="wrapper">
                        <button class="toggle">Ten (10) Panel Drug Test<i class="fas fa-plus icon"></i></button>
                        <div class="content">
                            <p>The 10-panel drug test screens for the five of the most frequently misused prescription drugs
                                in the United States.</p>
                        </div>
                    </div>
                    <div class="wrapper">
                        <button class="toggle">Proof of Professional License: RN.<i class="fas fa-plus icon"></i></button>
                        <div class="content">
                            <p>Professional Trade License for Entrance in BSN program.</p>
                        </div>
                    </div>
                    <div class="wrapper mb-5">
                        <button class="toggle">Essay – Tell us about You<i class="fas fa-plus icon"></i></button>
                        <div class="content">
                            <p> Professionally - Who You are and why Nursing.</p>
                        </div>





                    </div>
                    <div class="  mb-5">
                        <h2 class="heading heading text-center text-lg-left text-sm">Most asked questions</h2>
                    </div>
                    <div class="wrapper">
                        <button class="toggle">Does FAQs Scheme Help Us to Rank our Site in Top Position?<i
                                class="fas fa-plus icon"></i></button>
                        <div class="content">
                            <p> Yes, Frequently Asked Questions scheme will make your website more popular and increase your
                                search engine ranking position.</p>
                        </div>
                    </div>
                    <div class="wrapper">
                        <button class="toggle">Does FAQs Scheme Help Us to Rank our Site in Top Position?<i
                                class="fas fa-plus icon"></i></button>
                        <div class="content">
                            <p> Yes, Frequently Asked Questions scheme will make your website more popular and increase your
                                search engine ranking position.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>



    </div>

    </div>
    <div class="mt-3">
        <div class="text-center " style="background-color: #d75151;">
            <a href="#" class="text-white custom_fs_a">Apply Now</a>
        </div>
    </div>



    @include(theme('partials._custom_footer'))
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
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
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = $('#calendar').fullCalendar({
                editable: true,
                header: {
                    right: 'prev,next',
                    // center: 'title',
                    // right: 'month,agendaWeek,agendaDay'
                },
                events: '/full-calender',
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    var title = prompt('Event Title:');

                    if (title) {
                        var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');

                        var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

                        $.ajax({
                            url: "/full-calender/action",
                            type: "POST",
                            data: {
                                title: title,
                                start: start,
                                end: end,
                                type: 'add'
                            },
                            success: function(data) {
                                calendar.fullCalendar('refetchEvents');
                                alert("Event Created Successfully");
                            }
                        })
                    }
                },
                editable: true,
                eventResize: function(event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url: "/full-calender/action",
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            id: id,
                            type: 'update'
                        },
                        success: function(response) {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Updated Successfully");
                        }
                    })
                },
                eventDrop: function(event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url: "/full-calender/action",
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            id: id,
                            type: 'update'
                        },
                        success: function(response) {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Updated Successfully");
                        }
                    })
                },

                eventClick: function(event) {
                    if (confirm("Are you sure you want to remove it?")) {
                        var id = event.id;
                        $.ajax({
                            url: "/full-calender/action",
                            type: "POST",
                            data: {
                                id: id,
                                type: "delete"
                            },
                            success: function(response) {
                                calendar.fullCalendar('refetchEvents');
                                alert("Event Deleted Successfully");
                            }
                        })
                    }
                }
            });
            $(".fc-button-group").children().removeClass('fc-state-default').addClass('theme_btn mx-1');

        });


        //<![CDATA[
        let toggles = document.getElementsByClassName("toggle");
        let contentDiv = document.getElementsByClassName("content");
        let icons = document.getElementsByClassName("icon");

        for (let i = 0; i < toggles.length; i++) {
            toggles[i].addEventListener("click", () => {
                if (parseInt(contentDiv[i].style.height) != contentDiv[i].scrollHeight) {
                    contentDiv[i].style.height = contentDiv[i].scrollHeight + "px";
                    toggles[i].style.color = "#0084e9";
                    icons[i].classList.remove("fa-plus");
                    icons[i].classList.add("fa-minus");
                } else {
                    contentDiv[i].style.height = "0px";
                    toggles[i].style.color = "#111130";
                    icons[i].classList.remove("fa-minus");
                    icons[i].classList.add("fa-plus");
                }

                for (let j = 0; j < contentDiv.length; j++) {
                    if (j !== i) {
                        contentDiv[j].style.height = 0;
                        toggles[j].style.color = "#111130";
                        icons[j].classList.remove("fa-minus");
                        icons[j].classList.add("fa-plus");
                    }
                }
            });
        }
        //]]>
    </script>
@endsection
