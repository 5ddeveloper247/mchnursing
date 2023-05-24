@include(theme('partials._header'))
@include(theme('partials._menu'))
@extends(theme('auth.layouts.app'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ __('Register') }}
@endsection
@section('content')
    <style>
        input {
            background: transparent;
        }

        body {
            /* background-image: url('body-bg.jpg'); */
            height: 100vh;
        }

        #second,
        #third {
            display: none;
        }

        .borderbottom {
            border-bottom: 1px solid black;
        }

        .formbord {
            border: none;
            width: 70%;
        }

        .formbord:focus {
            border: none;
        }

        .text span {
            font-size: 16px;
            font-weight: bold;
        }

        input:focus-visible {
            outline: none !important;


        }

        .checkbox input {
            width: 40px;
            height: 40px;
        }

        .checkboxdata {
            width: 100%;
        }

        .checkboxdata input {
            width: 20%;
            float: left;
        }

        .checkboxdata h5 {
            width: 50%;
            float: left;

        }

        .bordertop {
            border-top: 1px solid black;
        }

        .page {
            width: 100%;
            height: auto;
            display: flex;
            justify-content: center
        }

        .borderbottom {
            border-bottom: 1px solid black;
        }

        .formbord {
            border: none;
            width: 70%;
        }

        .formbord:focus {
            border: none;
        }

        .text span {
            font-size: 16px;
            font-weight: bold;
        }

        input:focus-visible {
            outline: none !important;


        }

        .checkbox input {
            width: 40px;
            height: 40px;
        }

        .checkboxdata {
            width: 100%;
        }

        .checkboxdata input {
            width: 20%;
            float: left;
        }

        .checkboxdata h5 {
            width: 50%;
            float: left;

        }

        .bordertop {
            border-top: 1px solid black;
        }


        .nameformbord {
            border: none;
            width: 100%;
        }

        .nameformbord:focus {
            border: none;
        }

        .nameda p {

            margin-top: 0;
            font-size: 16px;
            margin-bottom: 1rem;
            font-weight: bold;
            text-align: justify;
        }

        .borderbottom {
            border-bottom: 1px solid grey;
        }

        .formbord {
            border: none;
            width: 70%;
        }

        .formbord:focus {
            border: none;
        }

        .text span {
            font-weight: bold;
            font-size: 12px;
            color: grey;
        }

        input:focus-visible {
            outline: none !important;


        }

        .checkbox input {
            width: 40px;
            height: 40px;
        }

        .checkboxdata {
            width: 100%;
        }

        .checkboxdata input {
            width: 20%;
            float: left;
        }

        .checkboxdata h5 {
            width: 50%;
            float: left;
            width: 50%;
            font-size: 12px;
            color: grey;
            float: left;

        }

        .bordertop {
            border-top: 1px solid grey;
            border-top: 1px solid rgb(22, 68, 100);
        }

        .nameformbord {
            border: none;
            width: 100%;
        }

        .nameformbord:focus {
            border: none;
        }

        .nameda p {

            margin-top: 0;
            font-size: 16px;
            margin-bottom: 1rem;
            font-weight: bold;
            text-align: justify;
        }

        .nameda1 p {

            margin-top: 0;
            font-size: 17px;
            text-align: justify;
        }

        .containerer {
            width: 100%;
            /* margin:auto; */
        }

        .mdka {
            width: 0%;
            height: 100%;
            float: left;
        }

        .row p {
            font-size: 16px;
            color: rgb(49, 48, 48);
            font-weight: bold;

        }

        .program h5 {
            font-weight: bold;
            font-size: 12px;
            color: grey;
        }

        .program p {
            font-weight: bold;
            font-size: 12px;
            color: grey;
        }

        .program {
            font-weight: bold;
            font-size: 18px;
            color: grey;
        }

        .logo img {
            width: 120px;
            height: 110px;
        }

        .other_links {
            text-align: center;
            padding: 12px 0px;
        }

        .data {
            background: rgb(190, 190, 190);
        }

        .thumb img {
            width: 90% !important;
        }

        .thumb {
            text-align: center;
        }

        .login_main_info h4 {
            font-size: 25px;
            line-height: 30px;
            font-weight: 600;
            text-align: center;
            padding: 12px 0px;
        }

        .shitch_text a {
            color: blue;
        }

        .ff h4 {
            font-size: 31px;
            line-height: 30px;
            font-weight: bold;
        }

        .data h5 {
            text-align: center;
        }

        .is-invalid {
            border-bottom: 2px solid red !important;
        }

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

        @media only screen and (max-width: 768px) {
            .responsive-order {
                order: -1;
            }

            .reg1_custom_top_margin {
                margin-top: 40px;
            }

        }
    </style>
    <div class="zaamaformdata">
        {{-- <div class="logo mx-5 pt-5">
            <a href="{{ url('/') }}">
                <img style="width: 190px" src="{{ asset(Settings('logo')) }} " alt="">
            </a>
        </div> --}}
        <div class="login_wrapper_content">

            <form action="{{ route('register') }}" method="POST" id="regForm">
                @csrf
                <!-- widgetsform -->
                <input type="hidden" name="is_user_setting" value="1">
                <div class="mainform row m-0 py-5">
                    <div class="col-md-8 reg1_custom_top_margin">


                        <div class="ff">
                            <h4 class="text-center">Application for Addmission</h4>
                            <div id="first" class="form mb-5">
                                @if (count($errors))
                                    <div class="alert alert-danger alert-dismissible fade @if (count($errors)) show @endif"
                                        role="alert">
                                        <strong>Required!</strong> Please fill all fields.(Email and phone must be uqnie)
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <div class="col-md-12 program my-3">
                                    <h5 class="mt-5">$100 Fee Required</h5>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6 text mb-3">
                                            <div
                                                class="box borderbottom @if ($errors->first('f_name')) is-invalid @endif my-2">
                                                <span>
                                                    First Name:
                                                </span>
                                                <span>
                                                    <input type="text" name="f_name" class="formbord"
                                                        value="{{ request()->name ?? old('f_name') }}">
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-6 text mb-3">
                                            <div
                                                class="box borderbottom @if ($errors->first('l_name')) is-invalid @endif my-2">
                                                <span>
                                                    Last Name:
                                                </span>
                                                <span>
                                                    <input type="text" name="l_name" class="formbord"
                                                        value="{{ request()->name ?? old('l_name') }}">
                                                </span>

                                            </div>

                                        </div>
                                        <div class="col-md-6 text mb-3">
                                            <div
                                                class="box borderbottom @if ($errors->first('dob')) is-invalid @endif my-2">
                                                <span>
                                                    DOB:
                                                </span>
                                                <span>
                                                    <input type="date" name="dob" class="formbord float-right"
                                                        value="{{ old('dob') }}">
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-6 text mb-3">
                                            <div
                                                class="box borderbottom @if ($errors->first('SS')) is-invalid @endif my-2">
                                                <span>
                                                    SS#:
                                                </span>
                                                <span>
                                                    <input type="text" name="SS" class="formbord"
                                                        value="{{ old('SS') }}">
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-4 text mb-3">
                                            <div
                                                class="box borderbottom @if ($errors->first('city')) is-invalid @endif my-2">
                                                <span>
                                                    City:
                                                </span>
                                                <span>
                                                    <input type="text" name="city" class="formbord"
                                                        value="{{ old('city') }}">
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-4 text mb-3">
                                            <div
                                                class="box borderbottom @if ($errors->first('state')) is-invalid @endif my-2">
                                                <span>
                                                    State:
                                                </span>
                                                <span>
                                                    <input type="text" name="state" class="formbord"
                                                        value="{{ old('state') }}">
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-4 text mb-3">
                                            <div
                                                class="box borderbottom @if ($errors->first('Zip')) is-invalid @endif my-2">
                                                <span>
                                                    Zip:
                                                </span>
                                                <span>
                                                    <input type="text" name="Zip" class="formbord"
                                                        value="{{ old('Zip') }}">
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 text mb-3">
                                            <div
                                                class="box borderbottom @if ($errors->first('email')) is-invalid @endif my-2">
                                                <span>
                                                    Email:
                                                </span>
                                                <span>
                                                    <input type="text" name="email" class="formbord"
                                                        value="{{ request()->email ?? old('email') }}">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text mb-3">
                                            <div
                                                class="box borderbottom @if ($errors->first('phone')) is-invalid @endif my-2">
                                                <span>
                                                    Cell No:
                                                </span>
                                                <span>
                                                    <input type="text" name="phone" class="formbord"
                                                        value="{{ request()->phone ?? old('phone') }}">
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-6 text mb-3">
                                            <div
                                                class="box borderbottom @if ($errors->first('password')) is-invalid @endif my-2">
                                                <span>
                                                    Password:
                                                </span>
                                                <span>
                                                    <input type="password" name="password" class="formbord"
                                                        value="{{ old('password') }}">
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-6 text mb-3">
                                            <div
                                                class="box borderbottom d-flex @if ($errors->first('password_confirmation')) is-invalid @endif my-2">
                                                <span>
                                                    Password Confirm:
                                                </span>
                                                <span>
                                                    <input type="password" name="password_confirmation" class="formbord"
                                                        value="{{ old('password_confirmation') }}">
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-12 text mb-3">
                                            <div
                                                class="box borderbottom @if ($errors->first('mailing_address')) is-invalid @endif my-2">
                                                <span>
                                                    Mailing address:
                                                </span>
                                                <span>
                                                    <input type="text" name="mailing_address" class="formbord"
                                                        value="{{ old('mailing_address') }}">
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-7 program">
                                            <h5 class="borderbotom">PROGRAM REVIEW: NCLEX REMEDIAL or RN COURSE
                                                REVIEW: </h5>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="row m-0 mt-2">
                                                <div class="col-lg-3 col-sm-3 col-6 checkbox">
                                                    <div class="checkboxdata mt-2">
                                                        <input type="checkbox" name="program_review[]" class="increae"
                                                            value="Transition"
                                                            {{ old('program_review') == 'Transition' ? 'checked' : '' }}>
                                                        <h5 class="mx-2 mt-3">
                                                            Transition
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-3 col-6 checkbox">
                                                    <div class="checkboxdata mt-2">
                                                        <input type="checkbox" name="program_review[]" class="increae"
                                                            value="Remedial"
                                                            {{ old('program_review') == 'Remedial' ? 'checked' : '' }}>
                                                        <h5 class="mx-2 mt-3">
                                                            Remedial
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-3 col-6 checkbox">
                                                    <div class="checkboxdata mt-2">
                                                        <input type="checkbox" name="program_review[]" class="increae"
                                                            value="Review"
                                                            {{ old('program_review') == 'Review' ? 'checked' : '' }}>
                                                        <h5 class="mx-2 mt-3">
                                                            Review
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-3 col-6 checkbox">
                                                    <div class="checkboxdata mt-2">
                                                        <input type="checkbox" name="program_review[]" class="increae"
                                                            value="CNA Prep"
                                                            {{ old('program_review') == 'CNA Prep' ? 'checked' : '' }}>
                                                        <h5 class="mx-2 mt-3">
                                                            CNA Prep
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 text mb-3">
                                            <div
                                                class="box borderbottom d-flex @if ($errors->first('student_signature')) is-invalid @endif my-2">
                                                <span>
                                                    Student Signature:
                                                </span>
                                                <span>
                                                    <span>
                                                        <input type="text" name="student_signature" class="formbord"
                                                            value="{{ old('student_signature') }}">
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text mb-3">
                                            <div
                                                class="box borderbottom @if ($errors->first('student_signature_date')) is-invalid @endif my-2">
                                                <span>
                                                    Date:
                                                </span>
                                                <span>
                                                    <input type="date" name="student_signature_date"
                                                        class="formbord float-right"
                                                        value="{{ old('student_signature_date') }}">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- <div class="col-md-12 my-4">
                                    <div class="row">

                                    </div>
                                </div>

                                <div class="col-md-12 my-4">
                                    <div class="row">


                                    </div>
                                </div>
                                <div class="col-md-12 my-4">
                                    <div class="row">

                                    </div>
                                </div>

                                <div class="col-md-12 my-4">
                                    <div class="row">


                                    </div>
                                </div>
                                <div class="col-md-12 my-4">
                                    <div class="row">



                                    </div>
                                </div> --}}
                            {{--
                                <div class="row m-0">

                                </div> --}}

                            {{-- <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12 text">
                                        <div
                                            class="box borderbottom @if ($errors->first('student_signature_date')) is-invalid @endif my-2">
                                            <span>
                                                <input type="date" name="student_signature_date" class="formbord"
                                                    value="{{ old('student_signature_date') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text">
                                        <div class="box">
                                            <span>
                                                Date:
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="page">
                                <button type="submit" class="theme_btn small_btn2"> Next
                                    Page</button>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 responsive-order">
                        <div classs="data py-5" style="background: #fbfff2;">

                            @include(theme('auth.login_wrapper_right'))
                        </div>
                        <h5 class="shitch_text mt-3 text-center">
                            {{ __('common.You have already an account?') }} <a href="{{ route('login') }}">
                                {{ __('common.Login') }}</a>

                        </h5>
                    </div>
                </div>


                <div class="row">
                    @if ($custom_field->show_job_title)
                        <div class="col-12 mt_20">
                            <div class="input-group custom_group_field">
                                <input type="text" class="form-control pl-0"
                                    placeholder="{{ __('common.Enter Job Title') }} {{ $custom_field->required_job_title ? '*' : '' }}"
                                    {{ $custom_field->required_job_title ? 'required' : '' }} aria-label="email"
                                    name="job_title" value="{{ old('job_title') }}">
                            </div>
                            <span class="text-danger" role="alert">{{ $errors->first('job_title') }}</span>
                        </div>
                    @endif

                    @if ($custom_field->show_gender)
                        <div class="col-xl-12">
                            <div class="short_select mt-3">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <h5 class="mr_10 font_16 f_w_500 mb-0">{{ __('common.choose_gender') }}
                                            {{ $custom_field->required_gender ? '*' : '' }}</h5>
                                    </div>
                                    <div class="col-xl-7">
                                        <select class="small_select w-100" name="gender"
                                            {{ $custom_field->required_gender ? 'selected' : '' }}>
                                            <option value="" data-display="Choose">{{ __('common.Choose') }}
                                            </option>
                                            <option value="male">{{ __('common.Male') }}</option>
                                            <option value="female">{{ __('common.Female') }}</option>
                                            <option value="other">{{ __('common.Other') }}</option>
                                        </select>

                                    </div>
                                </div>
                                <span class="text-danger" role="alert">{{ $errors->first('gender') }}</span>

                            </div>
                        </div>
                    @endif

                    @if ($custom_field->show_student_type)
                        <div class="col-xl-12">
                            <div class="short_select mt-3">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <h5 class="mr_10 font_16 f_w_500 mb-0">{{ __('common.choose_student_type') }}
                                            {{ $custom_field->required_student_type ? '*' : '' }}</h5>
                                    </div>
                                    <div class="col-xl-7">
                                        <select class="small_select w-100" name="student_type"
                                            {{ $custom_field->required_student_type ? 'selected' : '' }}>
                                            <option value="personal">{{ __('common.Personal') }}</option>
                                            <option value="corporate">{{ __('common.Corporate') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <span class="text-danger" role="alert">{{ $errors->first('student_type') }}</span>

                            </div>
                        </div>
                    @endif


                    <div class="col-12 mt_20">
                        @if (saasEnv('NOCAPTCHA_FOR_REG') == 'true')
                            @if (saasEnv('NOCAPTCHA_IS_INVISIBLE') == 'true')
                                {!! NoCaptcha::display(['data-size' => 'invisible']) !!}
                            @else
                                {!! NoCaptcha::display() !!}
                            @endif

                            @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger"
                                    role="alert">{{ $errors->first('g-recaptcha-response') }}</span>
                            @endif
                        @endif
                    </div>

                    <div class="col-12 mt_20">
                        @if (saasEnv('NOCAPTCHA_FOR_REG') == 'true' && saasEnv('NOCAPTCHA_IS_INVISIBLE') == 'true')
                            <button type="button" class="g-recaptcha theme_btn w-100 text-center"
                                data-sitekey="{{ saasEnv('NOCAPTCHA_SITEKEY') }}" data-size="invisible"
                                data-callback="onSubmit" class="theme_btn w-100 text-center">
                                {{ __('common.Register') }}</button>
                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                            <script>
                                function onSubmit(token) {
                                    document.getElementById("regForm").submit();
                                }
                            </script>
                        @endif

                    </div>
                </div>
            </form>
        </div>
    </div>
    @include(theme('partials._custom_footer'))

    {{-- <div class="login_wrapper"> --}}
    {{-- <div class="login_wrapper_left"> --}}



    {{-- </div> --}}



    {{-- </div> --}}

    <script>
        $(function() {
            $('#checkbox').click(function() {

                if ($(this).is(':checked')) {
                    $('#submitBtn').removeClass('disable_btn');
                    $('#submitBtn').removeAttr('disabled');

                } else {
                    $('#submitBtn').addClass('disable_btn');
                    $('#submitBtn').attr('disabled', 'disabled');

                }
            });
        });
    </script>


@endsection
