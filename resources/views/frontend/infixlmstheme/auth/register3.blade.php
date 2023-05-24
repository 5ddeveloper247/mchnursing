@extends(theme('auth.layouts.app'))
@section('content')
    <style>
        input {
            background: transparent;
        }

        body {
            /* background-image: url('body-bg.jpg'); */
            height: 100vh;
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
            width: 200px;
            height: 30px;
            float: right;

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
            width: 200px;
            height: 30px;
            float: right;

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

        .page {
            width: 200px;
            height: 30px;
            float: right;

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

        ::placeholder {
            font-weight: bold;
            font-size: 12px;
            color: grey;
        }
    </style>
    <div class="zaamaformdata">
        <div class="logo mx-5 pt-5">
            <a href="{{ url('/') }}">
                <img style="width: 190px" src="{{ asset(Settings('logo')) }} " alt="">
            </a>
        </div>

        <div class="login_wrapper_content">
            <form action="{{ route('register.3') }}" method="POST" id="regForm">
                @csrf
                <!-- widgetsform -->
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="mainform row m-0 p-5">
                    <div class="col-md-8">
                        <div id="third" class="form pt-3">
                            <div class="con">
                                <div class="containerer program">
                                    <div class="row">
                                        <div id="first" class="col-md-12 form mb-5">
                                            <div class="alert alert-warning shadow" role="alert">
                                                <strong>Note !</strong> Please Download the Authorization Form by clicking
                                                the Download Button.
                                            </div>
                                            {{-- <div class="alert alert-danger alert-dismissible fade @if (count($errors)) show @endif"
                                                role="alert">
                                                <strong>Required!</strong> Please fill all fields.
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div> --}}
                                        </div>
                                        {{-- <div class="d-flex justify-content-center mt-3 gap-2">
                                            <a href="{{ route('register.2') }}"
                                                class="h6 btn btn-outline-secondary float-end">
                                                Back
                                                Page</a>

                                            <a href="{{ asset('public/student_affidavit/agreement_form/Agreement_file.pdf') }}"
                                                download="Agreement_file.pdf" id="redirect_to"
                                                class="h6 btn btn-outline-secondary float-end">Download Form</a>
                                        </div> --}}

                                        {{-- <div class="col-md-9 d-none my-3">
                                            <div class="box">
                                                <b style="font-size:14px;">Complete forms must be mailed
                                                    to:  </b><br>
                                                <b style="color:rgb(13, 103, 168);font-size:13px;">Board <span
                                                        style="color:grey;font-style:italic;">of</span> Nursing </b>
                                                <p class="m-0"
                                                    style="font-size:15px;font-weight:500;color:rgb(13, 103, 168)"
                                                    class="">4052 Bald Cypress Way Bin C‐02 </p>

                                                <p style="font-size:15px;font-weight:500;color:rgb(13, 103, 168)"
                                                    class="">Tallahassee, FL 32399‐3252 </p>
                                                <b class="h6" style="color:rgb(13, 103, 168)">Board <span
                                                        style="color:grey;font-style:italic;font-weight: bold;">of</span> Nursing
                                                    Third Party Authorization </b>
                                            </div>
                                        </div>

                                        <div class="col-md-3 d-none">
                                            <div class="logo pt-4">
                                                <!-- <img src="logo.jpg"> -->
                                                <img src="{{ url('public/assets/logo.jpg') }}" alt="">
                                            </div>
                                        </div> --}}
                                        {{-- </div> --}}

                                        {{-- <div class="col-md-12 d-none p-0">
                                        <p style="font-weight:bold;font-size:15px;text-align:justify;">
                                            Applicants who intend to have an entity other than themselves act as
                                            a
                                            representative in the licensure process for this application must
                                            complete this form and have their signature notarized. Discard this
                                            form
                                            if you are submitting this application and do not authorize another
                                            person to act on your behalf.
                                        </p>
                                    </div>

                                    <div class="col-md-12 d-none mt-4 p-0">
                                        <div class="row m-0">
                                            <div class="col-md-3 p-0">
                                                <div class="mainbox">
                                                    <div
                                                        class="mini borderbottom @if ($errors->first('applican_name')) is-invalid @endif">
                                                        <span>I</span>
                                                        <input type="text" disabled name="applican_name" class="formbord"
                                                            value="{{ old('applican_name') ? old('applican_name') : $user->name }}">
                                                    </div>
                                                    <p class="text-center">
                                                        ( applican name )
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-md-4 nameda1">
                                                <p>
                                                    the undersigned, do hereby authorize
                                                </p>
                                            </div>

                                            <div class="col-md-5 p-0">
                                                <div class="mainbox">
                                                    <div
                                                        class="mini borderbottom @if ($errors->first('authorized_representative')) is-invalid @endif">
                                                        <input type="text" disabled name="authorized_representative"
                                                            class="nameformbord"
                                                            value="{{ old('authorized_representative') }}">
                                                    </div>
                                                    <p class="text-center">
                                                        (authorized representative)
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12 d-none mt-4 p-0">
                                        <div class="row m-0">
                                            <div class="col-md-2 nameda1 p-0">
                                                <p>
                                                    whose address is
                                                </p>
                                            </div>
                                            <div class="col-md-6 p-0">
                                                <div class="mainbox">
                                                    <div
                                                        class="mini borderbottom @if ($errors->first('address')) is-invalid @endif">
                                                        <input type="text" disabled name="address" class="nameformbord"
                                                            value="{{ old('address') ? old('address') : $userSetting->mailing_address }}"
                                                            placeholder="whose address is:">
                                                    </div>
                                                    <p class="text-center">
                                                        (authorized representatives address)

                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 nameda1">
                                                <p>
                                                    , their agents, or employees,to act for me
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 program d-none my-4 p-0">
                                        <p>
                                            and in my name with respect to my
                                            application for licensure with the Florida Board of Nursing,
                                            with
                                            the exception of withdrawing my application or requesting a
                                            refund.
                                        </p>
                                    </div>

                                    <div class="row d-none">
                                        <div class="col-md-7">
                                            <p>
                                                Applicant Signature:
                                            </p>
                                            <div
                                                class="mainbox1 borderbottom @if ($errors->first('applicant_signature')) is-invalid @endif">
                                                <input type="text" disabled name="applicant_signature"
                                                    class="nameformbord"
                                                    value="{{ old('applicant_signature') ? old('applicant_signature') : $userSetting->student_signature }}">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div
                                                class="mini borderbottom @if ($errors->first('date')) is-invalid @endif">
                                                <p> Date:</p>
                                                <input type="date" disabled name="date" class="nameformbord"
                                                    value="{{ old('date') ? old('date') : $userSetting->student_signature_date }}">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- break -->
                                    <div class="row d-none my-4">
                                        <div class="col-md-6">
                                            <p>
                                                State of:
                                            </p>
                                            <div
                                                class="mainbox1 borderbottom @if ($errors->first('state')) is-invalid @endif">
                                                <input type="text" disabled name="state" class="nameformbord"
                                                    value="{{ old('state') ? old('state') : $payment_detials->state }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <p>
                                                County of:
                                            </p>
                                            <div
                                                class="mainbox1 borderbottom @if ($errors->first('country')) is-invalid @endif">
                                                <input type="text" disabled name="country" class="nameformbord"
                                                    value="{{ old('country') ? old('country') : $payment_detials->country }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-none mt-3">

                                        <div class="col-md-6 mt-3">
                                            <p>Sworn to and/or subscribed before me this:</p>
                                            <div
                                                class="mainbox1 borderbottom @if ($errors->first('day')) is-invalid @endif">

                                                <input type="text" disabled name="day" class="nameformbord"
                                                    value="{{ old('day') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-3">

                                            <p>Day of:</p>
                                            <div
                                                class="mainbox1 borderbottom @if ($errors->first('age')) is-invalid @endif">
                                                <input type="text" disabled name="age" class="nameformbord"
                                                    value="{{ old('age') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <div
                                                class="mainbox1 d-flex borderbottom @if ($errors->first('name')) is-invalid @endif mt-4">
                                                <p>20</p>
                                                <input type="text" disabled name="name" class="nameformbord"
                                                    value="{{ old('name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <p>By:</p>
                                            <div
                                                class="mainbox1 borderbottom @if ($errors->first('by')) is-invalid @endif">
                                                <input type="text" disabled name="by" class="nameformbord"
                                                    value="{{ old('by') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <p>Whose identity is known to me by:</p>
                                            <div
                                                class="mainbox1 borderbottom @if ($errors->first('whose_identity')) is-invalid @endif">
                                                <input type="text" disabled name="whose_identity" class="nameformbord"
                                                    value="{{ old('whose_identity') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <p>Notary Signature:</p>
                                            <div
                                                class="mainbox1 borderbottom @if ($errors->first('notary_signature')) is-invalid @endif">
                                                <input type="text" disabled name="notary_signature"
                                                    class="nameformbord" value="{{ old('notary_signature') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <p>Printed Name of Notary:</p>
                                            <div
                                                class="mainbox1 borderbottom @if ($errors->first('printed_name')) is-invalid @endif">
                                                <input type="text" disabled name="printed_name" class="nameformbord"
                                                    value="{{ old('printed_name') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <p
                                                style="color:rgb(49, 48, 48);font-size:17px;font-style:italic;font-weight: normal;">
                                                These signature fields cannot be typed. You must print out the
                                                form
                                                and sign it before a notary public. </p>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <p>
                                                SEAL
                                            </p>
                                            <p style="line-height:0px;">
                                                (Notary Public)
                                            </p>
                                            <p class="mt-5">
                                                To withdraw your authorization of a third party representing
                                                you,
                                                submit a written request to the board office at the address
                                                above.
                                            </p>
                                        </div>
                                    </div> --}}
                                        <div class="col-md-12 d-flex justify-content-center mt-3 gap-2">
                                            <a href="{{ route('register.2') }}"
                                                class="h6 btn btn-outline-secondary float-end">
                                                Back Page</a>

                                            <a href="{{ asset('public/student_affidavit/agreement_form/Agreement_file.pdf') }}"
                                                download="Agreement_file.pdf" id="redirect_to"
                                                class="h6 btn btn-outline-secondary float-end">Download Form</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="data py-5" style="background: #fbfff2;">

                            @include(theme('auth.login_wrapper_right'))
                        </div>

                        <div class="col-12 mt_20">
                            <div class="remember_forgot_passs d-flex align-items-center">
                                <label class="primary_checkbox d-flex" for="checkbox">
                                    <input checked="" type="checkbox" id="checkbox" required>
                                    <span class="checkmark mr_15"></span>
                                    <p>{{ __('frontend.By signing up, you agree to') }} <a target="_blank"
                                            href="{{ url('privacy') }}">{{ __('frontend.Terms of Service') }}</a>
                                        {{ __('frontend.and') }}
                                        <a target="_blank" href="{{ url('privacy') }}">{{ __('frontend.Privacy Policy') }}
                                            .</a>
                                    </p>
                                </label>
                            </div>
                        </div>
                    </div>
                    @php
                        
                    @endphp
                </div>

                <div class="row">

                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#redirect_to").click(function() {
                // var url = "{{ route('register.pay') }}";
                window.setTimeout(function() {
                    $('#regForm').submit();
                    // window.location.href = url;
                }, 2500);
            });
        });

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
