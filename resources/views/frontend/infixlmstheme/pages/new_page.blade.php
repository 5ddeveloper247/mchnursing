@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ __('New Page') }}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('public/assets/owl.carousel.min.css') }}" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


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

        .mainbanner {
            height: 530px;
            background-size: cover;
            color: white;
        }

        .cont1doimgdo {
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
            font-size: 30px !important;
        }

        .slider_paragraph {
            font-size: 20px !important;
        }

        .slider_img {
            width: 744px !important;
            height: 405px;

        }

        td {
            height: 9rem;
            text-align: end;
        }

        #choose {
            background: #eee;
        }

        .custom_card_body {
            height: 22rem;
        }

        .custom_border {
            border-radius: 1rem;
        }

        .contain,
        .contain-fluid {
            position: relative;
            max-width: 120rem;
            padding: 0 1.5rem;
            margin: 0 auto;
            min-height: 0.1rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @keyframes fade {
            from {
                opacity: 0.4;
            }

            to {
                opacity: 1;
            }
        }

        body {
            background: #eeee;
        }

        #slider {
            margin: 0 auto;
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .slides {
            overflow: hidden;
            animation-name: fade;
            animation-duration: 1s;
            display: none;
        }

        img {
            width: 100%;
        }

        #dot {
            margin: 0 auto;
            text-align: center;
        }

        .dot {
            display: inline-block;
            border-radius: 50%;
            background: #d3d3d3;
            padding: 8px;
            margin: 10px 5px;
        }

        .activee {
            background: black;
        }

        @media (max-width:567px) {
            #slider {
                width: 100%;

            }
        }

        #heading {
            display: block;
            text-align: center;
            font-size: 2em;
            margin: 10px 0px;

        }

        .slider-text {
            position: absolute;
            top: 10%;
            left: 6%;
            /* transform: translate(-50%, -50%);
                  text-align: center; */
            color: white;
            font-size: 24px;
        }

        .slider_text_heading {
            font-size: 44px;
            font-weight: 900;
            line-height: 76px;
            color: #fff;
        }

        .slider-image {
            width: 100%;
          height: 530px;
            /* Adjust this value as needed */
            object-fit: cover;
        }
        @media (max-width: 767.98px){
            .slider-image{
                height: 300px;
            }.slider_text_heading{
                font-size: 32px;
            }
        }
        @media (max-width: 576px){
            .slider_text_heading{
                font-size: 25px;
            }.slider_heading_h1{
                font-size: 27px  !important; 
            }.slider_paragraph{
                font-size: 17px !important;
            }
        }
    </style>
@endsection
@section('mainContent')
    <div id="content-area">
        <div class="row">
            <div class="col-md-12 ui-resizable" data-type="container-content">
                <div data-type="component-text">
                    <div class="breadcrumb_area bradcam_bg_1 position-relative mainbanner">
                        <div class="breadcrumb_img w-100 h-100 position-absolute bottom-0 left-0"><img alt=""
                                class="w-100 h-100 img-cover"
                                src="http://mchnursing.com/lms/public/frontend/infixlmstheme/img/banner/bradcam_bg_1.jpg">
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-9 offset-lg-1">
                                    <div class="breadcam_wrap learnmoredo">&nbsp;
                                        <h3>New Page Heading</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section id="choose">
                    <div class="contain py-2 text-center">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 p-2">
                                <div class="card custom_border " data-aos="fade-up" data-aos-delay="500">
                                    <div class="card-body custom_card_body">
                                        <h1 class="py-1">Heading text 1</h1>
                                        <h3>Heading text 1</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas blanditiis quia
                                            veritatis
                                            nihil excepturi iure.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 p-2">
                                <div class="card custom_border" data-aos="fade-up" data-aos-delay="700">
                                    <div class="card-body custom_card_body">
                                        <h1 class="py-1">Heading text 1</h1>
                                        <h3>Heading text 1</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas blanditiis quia
                                            veritatis
                                            nihil excepturi iure.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 p-2">
                                <div class="card custom_border" data-aos="fade-up" data-aos-delay="900">
                                    <div class="card-body custom_card_body">
                                        <h1 class="py-1">Heading text 1</h1>
                                        <h3>Heading text 1</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas blanditiis quia
                                            veritatis
                                            nihil excepturi iure..</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 p-2">
                                <div class="card custom_border" data-aos="fade-up" data-aos-delay="1100">
                                    <div class="card-body custom_card_body">
                                        <h1 class="py-1">Heading text 1</h1>
                                        <h3>Heading text 1</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas blanditiis quia
                                            veritatis
                                            nihil excepturi iure.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <div class="row mt-4 p-5">
                    <div class="col-md-12 ui-resizable  text-center" data-type="container-content">
                        <h1 data-type="component-text" class="font-weight-bold py-3">Our Calender</h1>

                        {{-- <div class="m-2" id="calendar"></div> --}}
                        <div class="m-2">
                            <div class="table-responsive">
                                <table class="table-bordered table">
                                    <h2 class="text-left">@php
                                        echo date('F Y');
                                    @endphp</h2>
                                    <thead>
                                        <tr>
                                            <th>Mon</th>
                                            <th>Tues</th>
                                            <th>Thu</th>
                                            <th>Wed</th>
                                            <th>Fri</th>
                                            <th>Sat</th>
                                            <th>Sun</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>9</td>
                                            <td>10</td>
                                            <td>11</td>
                                            <td>12</td>
                                            <td>13</td>
                                            <td>14</td>
                                        </tr>
                                        <tr>
                                            <td>15</td>
                                            <td>16</td>
                                            <td>17</td>
                                            <td>18</td>
                                            <td>19</td>
                                            <td>20</td>
                                            <td>21</td>
                                        </tr>
                                        <tr>
                                            <td>22</td>
                                            <td>23</td>
                                            <td>24</td>
                                            <td>25</td>
                                            <td>26</td>
                                            <td>27</td>
                                            <td>28</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="slider_section">
        <span id="heading">Slider</span>
        <div id="slider">
            <div class="slides">
                <img src="http://mchnursing.com/lms/public/frontend/infixlmstheme/img/banner/bradcam_bg_9.jpg"
                    width="100%" class="slider-image" />
                <div class="slider-text">
                    <h1 class="text-white slider_text_heading ">Study with us</h1>
                </div>
            </div>
            <div class="slides">
                <img src="http://mchnursing.com/lms/public/frontend/infixlmstheme/img/banner/bradcam_bg_10.jpg"
                    width="100%" class="slider-image" />
                <div class="slider-text">
                    <h1 class="text-white slider_text_heading "> creative Thinking</h1>
                </div>
            </div>
            <div class="slides">
                <img src="http://mchnursing.com/lms/public/frontend/infixlmstheme/img/banner/bradcam_bg_6.jpg"
                    width="100%" class="slider-image" />
                <div class="slider-text">
                    <h1 class="text-white slider_text_heading ">learning Process</h1>
                </div>
            </div>
            <div id="dot" class="d-none"><span class="dot"></span><span class="dot"></span><span
                    class="dot"></span></div>
        </div>
    </section>
    <section class="carousel_section mt-5 mb-5">
        <div class="row featured-carousel owl-carousel m-0">
            <div class="col-md-12 col-12 cont1doimgdo p-0">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                        <div class="pt-4">
                            <h1 class="slider_heading_h1 ml-5 px-5 pt-5 text-white">
                             First Slider
                            </h1>
                            <p class="ml-5 pt-lg-3 px-5 slider_paragraph text-white">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus magni ut animi
                                laborum quidem tempore quas sit et similique? Magni officiis dolores quam quos
                                similique atque quidem repellat recusandae mollitia!
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex justify-content-center align-items-center p-0 ">
                        <img src="{{ asset('public/assets/c2.jpg') }}" class="d-md-block d-none img-fluid slider_img">
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-12 cont1doimgdo p-0">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                        <div class="pt-4">
                            <h1 class="slider_heading_h1 ml-5 px-5 pt-5 text-white">
                                Second Slider
                            </h1>
                            <p class="ml-5 pt-lg-3 px-5 slider_paragraph text-white">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ducimus quis vel rem
                                reiciendis deleniti totam, consequuntur recusandae perspiciatis ex optio blanditiis
                                molestiae distinctio alias repudiandae sit! Corrupti, doloremque numquam. Earum?
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex justify-content-center align-items-center p-0  ">
                        <img src="{{ asset('public/assets/c3.jpg') }}" class="d-md-block d-none img-fluid slider_img">
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-12 cont1doimgdo p-0">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                        <div class="pt-4">
                            <h1 class="slider_heading_h1 ml-5 px-5 pt-5 text-white">
                                Third Slider
                            </h1>
                            <p class="ml-5 pt-lg-3 px-5 slider_paragraph text-white">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ducimus quis vel rem
                                reiciendis deleniti totam, consequuntur recusandae perspiciatis ex optio blanditiis
                                molestiae distinctio alias repudiandae sit! Corrupti, doloremque numquam. Earum?
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-flex justify-content-center align-items-center p-0 ">
                        <img src="{{ asset('public/assets/c1.jpg') }}" class="d-md-block d-none img-fluid slider_img">
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include(theme('partials._custom_footer'))
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

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
    </script>
    <script>
        AOS.init();

        // You can also pass an optional settings object
        // below listed default settings
        AOS.init({
            duration: 1000,
            // Global settings:
            // disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
            // startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
            // initClassName: 'aos-init', // class applied after initialization
            // animatedClassName: 'aos-animate', // class applied on animation
            // useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
            // disableMutationObserver: false, // disables automatic mutations' detections (advanced)
            // debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
            // throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)


            // // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
            // offset: 120, // offset (in px) from the original trigger point
            // delay: 0, // values from 0 to 3000, with step 50ms
            // // values from 0 to 3000, with step 50ms
            // easing: 'ease', // default easing for AOS animations
            // once: false, // whether animation should happen only once - while scrolling down
            // mirror: false, // whether elements should animate out while scrolling past them
            // anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

        });
    </script>
    <script>
        var index = 0;
        var slides = document.querySelectorAll(".slides");
        var dot = document.querySelectorAll(".dot");

        function changeSlide() {

            if (index < 0) {
                index = slides.length - 1;
            }

            if (index > slides.length - 1) {
                index = 0;
            }

            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
                dot[i].classList.remove("activee");
            }

            slides[index].style.display = "block";
            dot[index].classList.add("activee");

            index++;

            setTimeout(changeSlide, 5000);

        }

        changeSlide();
    </script>
@endsection
