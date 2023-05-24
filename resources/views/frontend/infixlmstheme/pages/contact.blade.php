@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontend.Contact Us')}} @endsection
@section('css') @endsection

@section('mainContent')
    <script
        src="https://kit.fontawesome.com/b98cad50b5.js"
        crossorigin="anonymous"
    ></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css"
    />
    <link
        rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css"
    />
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    />
    <link
        rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/uicons-regular-straight/css/uicons-regular-straight.css"
    />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link
        rel="stylesheet"
        href="https://cdn-uicons.flaticon.com/uicons-solid-straight/css/uicons-solid-straight.css"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css"
    />
    <title>Lms</title>
    </head>
    <style>
        .mainbanner {
            height: 530px;
            background-image: url("{{asset('public/assets/contact.jpg')}}");
            background-size: cover;
        }

        .boxbanner h1 {
            font-size: 70px;
            font-weight: bold;
            color: white;
            margin-top: 4rem;
            padding-top: 10rem !important;
        }

        .data h1 {
            font-size: 42px;
            font-family: Poppins, sans-serif;
            color: #252525;
            font-weight: 800;
        }

        .data p {
            font-size: 20px;
            font-weight: 400;
        }

        .separator {
            border-bottom: 4px solid red;
            max-width: 50px;
            margin-top: 15px;
        }

        .iconsdo i {
            color: red;
            font-size: 17px;
            padding-right: 5px;
            line-height: -16px;
            cursor: pointer;
        }

        .ankar a {
            text-decoration: none;
            color: #252525;
            line-height: 36px;
        }

        .custombtn {
            padding: 15px 50px;
            background-color: red;
            color: white;
            border: none;
            font-weight: bold;
        }

        .custombtn:hover {
            padding: 15px 50px;
            background-color: rgb(0, 0, 0);
            color: white;
            border: none;
            font-weight: bold;
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

        .mintban {
            background-image: url("{{ asset('public/assets/bgpicture.jpg') }}");
            height: auto;
            background-size: cover;
        }

        .flowdiv {
            width: 85%;
            padding: 8rem 8rem;
            margin: auto;
        }

        element.style {
            border-color: #ffffff;
            background-color: #ffffff;
            background-image: url(https://academist.qodeinteractive.com/wp-content/uploads/2018/07/Form-background-img.jpg);
        }


        user agent stylesheet
        .formdokana input[type="text" i] {
            padding: 1px 2px;
        }

        .formdokana .wpcf7-form-control-wrap {
            position: relative;
        }

        a, abbr, acronym, address, applet, b, big, blockquote, body, caption, center, cite, code, dd, del, dfn, div, dl, dt, em, fieldset, font, form, h1, h2, h3, h4, h5, h6, html, i, iframe, ins, kbd, label, legend, li, object, ol, p, pre, q, s, samp, small, span, strike, strong, sub, sup, table, tbody, td, tfoot, th, thead, tr, tt, u, ul, var {
            background: 0 0;
            border: 0;
            margin: 0;
            outline: 0;
            padding: 0;
            vertical-align: baseline;
        }

        .btn-submit {
            padding: 14px 31px;
            background: red;
            border: 0;
            color: white;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .btn-submit:hover {
            padding: 14px 31px;
            background: rgb(0, 0, 0);
            border: 0;
            color: white;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .formdokana .changeborder .wpcf7-form-control.wpcf7-text, .wpcf7-form-control.wpcf7-textarea, input[type=email], input[type=password], input[type=text] {
            background-color: transparent;
            /* border: 1px solid #e1e1e1; */
            border-radius: 0;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            color: #252525;
            font-family: inherit;
            font-size: 15px;
            font-weight: inherit;
            line-height: calc(50px - (12px * 2) - 2px);
            margin: 0 0 16px;
            outline: 0;
            padding: 12px 16px;
            position: relative;
            width: 100%;
            -webkit-appearance: none;
            -webkit-transition: border-color .2s ease-in-out;
            -o-transition: border-color .2s ease-in-out;
            transition: border-color .2s ease-in-out;
        }

        .formdokana .change .wpcf7-form-control.wpcf7-text, .wpcf7-form-control.wpcf7-textarea, input[type=email], input[type=password], input[type=text] {
            background-color: transparent;
            /* border: 1px solid #e1e1e1; */
            border-radius: 0;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            color: #252525;
            font-family: inherit;
            font-size: 15px;
            font-weight: inherit;
            line-height: calc(50px - (12px * 2) - 2px);
            margin: 0 0 16px;
            outline: 0;
            padding: 12px 16px;
            position: relative;
            width: 100%;
            -webkit-appearance: none;
            -webkit-transition: border-color .2s ease-in-out;
            -o-transition: border-color .2s ease-in-out;
            transition: border-color .2s ease-in-out;
        }

        .formdokana .eltdf-contact-form-7-widget .wpcf7-form-control.wpcf7-date, .eltdf-contact-form-7-widget .wpcf7-form-control.wpcf7-number, .eltdf-contact-form-7-widget .wpcf7-form-control.wpcf7-quiz, .eltdf-contact-form-7-widget .wpcf7-form-control.wpcf7-select, .eltdf-contact-form-7-widget .wpcf7-form-control.wpcf7-text, .eltdf-contact-form-7-widget .wpcf7-form-control.wpcf7-textarea {
            border: 0;
            border-bottom: 1px solid #e1e1e1;
            margin: 7px 0 20px;
            padding: 7px 10px;
            font-size: 15px;
        }

        .formdokana input[type=text] {
            background-color: transparent;
            border: 1px solid #e1e1e1;
            border-radius: 0;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            color: #252525;
            font-family: inherit;
            font-size: 15px;
            font-weight: inherit;
            line-height: calc(50px - (12px * 2) - 2px);
            margin: 0 0 16px;
            outline: 0;
            padding: 12px 16px;
            position: relative;
            width: 100%;
            -webkit-appearance: none;
            -webkit-transition: border-color .2s ease-in-out;
            -o-transition: border-color .2s ease-in-out;
            transition: border-color .2s ease-in-out;
        }

        .formdokana input[type=text] {
            background-color: transparent;
            /* border: 1px solid #e1e1e1; */
            border-radius: 0;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            color: #252525;
            font-family: inherit;
            font-size: 15px;
            font-weight: inherit;
            line-height: calc(50px - (12px * 2) - 2px);
            margin: 0 0 16px;
            outline: 0;
            /* padding: 12px 16px; */
            position: relative;
            width: 100%;
            -webkit-appearance: none;
            -webkit-transition: border-color .2s ease-in-out;
            -o-transition: border-color .2s ease-in-out;
            transition: border-color .2s ease-in-out;
        }

        .dataflow {
            height: 400px;
            background-color: red;
            position: relative;
            padding: 8rem 8rem;
        }

        .dataflow h1 {
            font-size: 45px;
            width: 70%;
            margin: auto;
            line-height: 1.2em;
            font-family: Poppins, sans-serif;
            color: #ffffff;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .dataflow h1 {
                font-size: 25px;
                padding: 10px;
                line-height: 1.2em;
                font-family: Poppins, sans-serif;
                color: #ffffff;
                font-weight: bold;
            }

            .dataflow {
                height: 250px;
                background-color: red;
                position: relative;
            }

            .flowdiv {
                width: 85%;
                padding: 0rem 0rem;
                margin: auto;
            }

            .dataflow img {
                display: none;
            }

            .mintban {
                background-image: url("{{ asset('public/assets/bgpicture.jpg') }}");
                height: auto;
                background-size: cover;
                padding: 4rem 0rem;
                margin-bottom: 4rem;
            }

        }
    </style>
    <div class="mainbanner">
        <div class="boxbanner containerdoosme py-5 p-5">
            <h1 class="pt-5 text-white mt-5">Contact Us</h1>
        </div>
    </div>
    <div class="containerdoosme">
        <div class="row my-5 p-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row px-4">
                            <div class="col-sm-12 col-md-12">
                                <div class="map m-1">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14944372.906747056!2d34.40694603561576!3d23.87086960764348!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15e7b33fe7952a41%3A0x5960504bc21ab69b!2sSaudi%20Arabia!5e0!3m2!1sen!2s!4v1675226140271!5m2!1sen!2s"
                                        width="100%"
                                        height="450"
                                        style="border: 0;"
                                        allowfullscreen=""
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                    ></iframe>
                                </div>
                            </div>
                            {{-- <div class="col-sm-6 col-md-4">
                              <div class="map m-1">
                                <iframe
                                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14944372.906747056!2d34.40694603561576!3d23.87086960764348!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15e7b33fe7952a41%3A0x5960504bc21ab69b!2sSaudi%20Arabia!5e0!3m2!1sen!2s!4v1675226140271!5m2!1sen!2s"
                                  width="100%"
                                  height="450"
                                  style="border: 0;"
                                  allowfullscreen=""
                                  loading="lazy"
                                  referrerpolicy="no-referrer-when-downgrade"
                                ></iframe>
                              </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                              <div class="map m-1">
                                <iframe
                                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14944372.906747056!2d34.40694603561576!3d23.87086960764348!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15e7b33fe7952a41%3A0x5960504bc21ab69b!2sSaudi%20Arabia!5e0!3m2!1sen!2s!4v1675226140271!5m2!1sen!2s"
                                  width="100%"
                                  height="450"
                                  style="border: 0;"
                                  allowfullscreen=""
                                  loading="lazy"
                                  referrerpolicy="no-referrer-when-downgrade"
                                ></iframe>
                              </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="containerdoosme">
        <div class="row my-5">
            <div class="col-md-12 mx-1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row  px-5">
                            <div class="col-sm-6 ankar col-md-6" data-aos="fade-up" data-aos-delay="300">
                                <div class="data ">
                                    <h1>
                                        Get in touch
                                    </h1>
                                    <div class="separator my-3"></div>
                                    <p class="pb-5 pt-3">
                                        MCOH is an inclusive and equitable enviroment that provides educational
                                        oppturities for anyone seeking update their skill being a new career path and
                                        enhance professional Skills
                                    </p>

                                    <a class="iconsdo">
                                        <i class="fi fi-rs-marker"></i>
                                        <span class="locaton"> 50/s. florida Avenue lakeland, Fl 33801</span>
                                    </a><br/>

                                    <a class="iconsdo">
                                        <i class="fi fi-br-phone-call"></i>
                                        <span class="locaton"> 863-250-8764/347-525-1736</span>
                                    </a><br/>

                                    <a class="iconsdo">
                                        <i class="fi fi-rs-clock-three"></i>
                                        <span class="locaton">  Mon To Fr: 8:30Am To 7Pm</span>
                                    </a>
                                    <br/>

                                    {{-- <a class="iconsdo">
                                     <i class="fi fi-br-phone-call"></i>
                                     <span class="call"> 863-250-8764/347-525-1736</span>
                                    </a>
                                    <br />

                                    <a class="iconsdo">
                                     <i class="fi fi-rs-clock-three"></i>
                                     <span class="time"> Mondey To Friday: 8:30Am To 7Pm</span>
                                    </a> --}}
                                    <br/>


                                </div>

                            </div>

                            <div class="col-sm-6 col-md-6 col-12" data-aos="fade-up" data-aos-delay="600">
                                <form method="POST" action="{{ route('contactMsgSubmit') }}">
                                    @csrf
                                    <div class="row formdokana">
                                        <div class="col-sm-6 col-md-6 col-12">
                                            <input type="text" name="name" placeholder="Your Name" class="form-control"
                                                   required>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-12">

                                            <input type="text" name="email" placeholder="Email Address"
                                                   class="form-control" required>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-12">
                                            <input type="text" name="phone" placeholder="Phone#" class="form-control"
                                                   required>
                                        </div>
                                        <div class="col-sm-6  col-md-6 col-12">

                                            <input type="text" name="zip" placeholder="Zip Code" class="form-control"
                                                   required>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-12">
                                            <select name="program" class="form-control" required>
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
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-12">

                                            <select name="year" class="form-control mb-2" required>
                                                <option value="" selected>Select year</option>
                                                <option value="1 year">1 year</option>
                                                <option value="2 year">2 year</option>
                                                <option value="3 year">3 year</option>
                                                <option value="4 year">4 year</option>

                                            </select></div>

                                        <div class="col-sm-6 col-md-12 col-12 mt-1">

                                            <!-- <textarea class="form-control" placeholder="Message" style="height:200px;">

                                            </textarea> -->
                                            <textarea name="message"
                                                      class="wpcf7-form-control wpcf7-textarea form-control wpcf7-validates-as-required"
                                                      aria-required="true" aria-invalid="false" placeholder="Message"
                                                      style="height:100px;" required></textarea>

                                            <button type="submit" class="custombtn mt-2">Send</button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- apply now Section  --}}
    <div class="contain mintban">
        <div class="row m-0 ">
            <div class="col-md-12 mb-5">
                <div class="row ">
                    <div class="col-md-12  flowdiv ">
                        <div class="row m-0 " style="">
                            <div class="col-sm-12 col-12 ankar col-md-6 p-0 " data-aos="fade-right">
                                <div class="dataflow text-white p-2">
                                    <h1 class="mt-5 pt-4">Ut enim ad minim veniam, quis nos trud exercita ion</h1>
                                    <img src="{{ asset("public/assets/left-arrow-64.png") }}" height="50" class="lia"
                                         style="position:absolute;right: -12px;top: 174px;">
                                </div>
                            </div>


                            <!-- <div class="col-sm-6 ankar col-md-6 p-0" >
                              <div class="dataflow  " style="height:400px;background-color: rgb(255, 255, 255);">
                            <h1>full course</h1>
                          </div>
                              </div> -->
                            <div class="col-sm-12 col-12 ankar col-md-6 p-0" data-aos="fade-left">
                                <div class="eltdf-eh-item     eltdf-background-arrow-left changeborder"
                                     style="background: white;">
                                    <!-- <div class="eltdf-eh-item     eltdf-background-arrow-left" style="/* visibility: hidden; */border-color: #ffffff;/* display: none; */background-color: #ffffff;background-image: url(https://academist.qodeinteractive.com/wp-content/uploads/2018/07/Form-background-img.jpg)" data-item-class="eltdf-eh-custom-5500" data-769-1024="15% 10% 6% 10%" data-681-768="10% 15% 5% 15%" data-680="0% 20px 0% 20px"> -->
                                    <div class="eltdf-eh-item-inner" style="height: 400px;">
                                        <div class="eltdf-eh-item-content eltdf-eh-custom-5500 py-4"
                                             style="padding: 5px 12% 0 12%">
                                            <div class="wpb_text_column wpb_content_element ">
                                                <div class="wpb_wrapper mt-3">
                                                    <h3 style="font-weight: bold;">Apply now</h3>
                                                </div>
                                            </div>
                                            <div class="vc_empty_space" style="height: 25px"><span
                                                    class="vc_empty_space_inner"></span></div>
                                            <div role="form" class="wpcf7" id="wpcf7-f910-p311-o2" lang="en-US"
                                                 dir="ltr">
                                                <div class="screen-reader-response"><p role="status" aria-live="polite"
                                                                                       aria-atomic="true"></p>
                                                    <ul></ul>
                                                </div>
                                                <form action="{{ route('register') }}" method="GET"
                                                      class="wpcf7-form init demo"
                                                  >

                                                    <div class="eltdf-contact-form-7-widget">
                                                        <span class="wpcf7-form-control-wrap"
                                                              data-name="your-name"><input type="text" name="name"
                                                                                           value="" size="40"
                                                                                           class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                                                                            required
                                                                                           placeholder="Name"></span><br>
                                                        <span class="wpcf7-form-control-wrap"
                                                              data-name="your-email"><input type="email"
                                                                                            name="email" value=""
                                                                                            size="40"
                                                                                            class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email"
                                                                                            required
                                                                                            placeholder="Email"></span><br>
                                                        <span class="wpcf7-form-control-wrap"
                                                              data-name="your-tel"><input type="tel" name="phone"
                                                                                          value="" size="40"
                                                                                          class="wpcf7-form-control wpcf7-text wpcf7-tel wpcf7-validates-as-required wpcf7-validates-as-tel"
                                                                                          required
                                                                                          placeholder="Phone number"></span><br>
                                                        <input type="submit" value="Get it now"
                                                               class="wpcf7-form-control has-spinner wpcf7-submit btn-submit mt-4"><span
                                                            class="wpcf7-spinner "></span>
                                                    </div>
                                                    <div class="wpcf7-response-output" aria-hidden="true"></div>
                                                </form>
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
    {{-- footer Section  --}}
    @include(theme('partials._custom_footer'))
@endsection
@section('js')

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

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{Settings('gmap_key') }}"></script>
    <script src="{{ asset('public/frontend/infixlmstheme') }}/js/map.js"></script>
    <script src="{{asset('public/frontend/infixlmstheme/js/contact.js')}}"></script>
@endsection
