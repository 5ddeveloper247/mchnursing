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

        .formbord {
            border: none;
            width: auto;
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
            border-bottom: 1px solid gray;
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

        .nameda p {
            margin-top: 0;
            font-size: 16px;
            /* margin-bottom: 1rem; */
            font-weight: bold;
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

        .footer .row p {
            font-weight: normal !important;
        }

        .program h5 {
            font-weight: bold;
            font-size: 12px;
            color: grey;
        }

        .program span {
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

        .footer .row p {
            font-weight: normal !important;
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
            font-weight: normal !important;
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
            font-weight: normal !important;
        }

        .expore p:hover {
            line-height: 30px !important;
            font-size: 17px !important;
            color: rgb(255, 0, 0);
            text-decoration: underline;
        }

        .custom_d_flex {
            display: flex !important;
            flex-direction: row;
            padding-right: 0px;
        }

        .custom_col_01 {
            padding-right: 0px;
            width: 45%;
        }

        .custom_col_02 {
            /* padding-right: 0px; */
            width: 55%;
        }

        .custom_col_03 {
            /* padding-right: 0px; */
            width: fit-content;
            white-space: nowrap;
        }

        .custom_col_04 {
            /* padding-right: 0px; */
            width: 25%;
        }

        .custom_col_05 {
            display: flex;
            height: fit-content;
        }

        .custom_col_06 {
            padding-bottom: 0px;
            height: fit-content;
        }

        .custom_col_07 {
            display: flex;
            width: 100%;
        }

        @media only screen and (max-width: 320px) {
            .custom_d_flex {
                display: flex !important;
                flex-direction: column;
            }

            .custom_col_01 {
                padding-right: 0px;
                width: 100%;
            }

            .custom_col_02 {
                width: 100%;
                margin-top: 0.45rem;
            }

            .custom_col_03 {
                /* width: 100%; */
                width: fit-content;
                white-space: normal;
                margin-bottom: -1.7rem;
            }

            .custom_col_04 {
                width: 100%;
            }

            .custom_col_05 {
                margin-top: 0.9rem;
                width: 100%;
                align-items: flex-end;
            }

            .custom_col_06 {
                padding-bottom: 0px;
                height: fit-content;
                width: fit-content;
            }

            .responsive-order {
                order: -1 !important;
            }

            .reg1_custom_top_margin {
                margin-top: 40px;
            }
        }

        .custom_nowrap {
            white-space: nowrap;
        }
    </style>

    <div class="zaamaformdata">
        {{-- <div class="logo mx-5 pt-5">
            <a href="{{ url('/') }}">
                <img style="width: 190px" src="{{ asset(Settings('logo')) }} " alt="">
            </a>
        </div> --}}
        <div class="login_wrapper_content">
            <form action="{{ route('register.2p') }}" method="POST" id="regForm">
                @csrf
                <!-- widgetsform -->
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="mainform row m-0 mt-5">
                    <div class="col-md-8">
                        <div id="second" class="form">
                            <h5 class="text-center">CREDIT CARD AUTHORIZATION AGREEMENT </h5>
                            <div id="first" class="form mb-5">
                                @if (count($errors))
                                    <div class="alert alert-danger alert-dismissible fade @if (count($errors)) show @endif"
                                        role="alert">
                                        <strong>Required!</strong> Please fill all fields.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12 program my-3">
                                <h5>*Initials Required*</h5>
                            </div>
                            <div class="col-md-12 p-0">
                                <div class="row m-0">
                                    <div class="col-md-12 program mb-4">
                                        <div class="borderbottom @if ($errors->first('term_one_text')) is-invalid @endif">
                                            <span>I</span>
                                            <span>
                                                <input type="text" name="term_one_text" class="formbord"
                                                    value="{{ old('term_one_text') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 program mb-3">
                                        <span>hereby authorize Merakii College Of Health to charge my Credit or Debit
                                            Card for payment of Education services rendered as described on</span>
                                    </div>
                                    <div class="col-md-6 program mb-4" style="display: flex; align-items: baseline;">
                                        <div class="borderbottom @if ($errors->first('invoice_date_one')) is-invalid @endif"
                                            style="width:100%;">
                                            <span class="custom_nowrap">Invoice No.</span>
                                            <span>
                                                <input type="text" name="invoice_date_one" class="formbord"
                                                    value="{{ old('invoice_date_two') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 program mb-4" style="display: flex; align-items: baseline;">
                                        <div class="borderbottom @if ($errors->first('invoice_date_two')) is-invalid @endif"
                                            style="width:100%;">
                                            <span class="custom_nowrap">Dated</span>
                                            <span>
                                                <input type="date" name="invoice_date_two" class="formbord"
                                                    value="{{ old('invoice_date_two') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <div class="borderbottom @if ($errors->first('term_two_text')) is-invalid @endif"
                                            style="width: 100%;">
                                            <span class="custom_nowrap">I</span>
                                            <span>
                                                <input type="text" name="term_two_text" class="formbord"
                                                    value="{{ old('term_two_text') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 program mb-3">
                                        <span>agree, in all cases, to pay the Credit Card amount below for the full
                                            payment for Education services rendered as described on </span>
                                    </div>
                                    <div class="col-md-12 program mb-4" style="display: flex; align-items: baseline;">
                                        <div class="borderbottom @if ($errors->first('invoice_date_one')) is-invalid @endif"
                                            style="width: 100%;">
                                            <span class="custom_nowrap" style="">Invoice No.</span>
                                            <span>
                                                <input type="text" name="invoice_date_one" class="formbord"
                                                    value="{{ old('invoice_date_two') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 program mb-3">
                                        <span>I HAVE READ AND FULLY UNDERSTAND AND AGREE WITH ALL OF THE ABOVE
                                            TERMS.</span>
                                    </div>
                                    <div class="col-md-6 text my-2">
                                        <div class="borderbottom @if ($errors->first('name')) is-invalid @endif">
                                            <span>Name:</span>
                                            <span>
                                                <input type="text" name="name" class="formbord"
                                                    value="{{ old('name') ? old('name') : $user->name }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text my-2">
                                        <div class="borderbottom @if ($errors->first('phone')) is-invalid @endif">
                                            <span>Phone</span>
                                            <span>
                                                <input type="text" name="phone" class="formbord"
                                                    value="{{ old('phone') ? old('phone') : $user->phone }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text my-2">
                                        <div class="borderbottom @if ($errors->first('address')) is-invalid @endif">
                                            <span>Address:</span>
                                            <span>
                                                <input type="text" name="address" class="formbord"
                                                    value="{{ old('address') ? old('address') : $userSetting->mailing_address }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text my-2">
                                        <div class="borderbottom @if ($errors->first('fax')) is-invalid @endif">
                                            <span>Fax:</span>
                                            <span>
                                                <input type="text" name="fax" class="formbord"
                                                    value="{{ old('fax') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text my-2">
                                        <div class="borderbottom @if ($errors->first('city')) is-invalid @endif">
                                            <span>City:</span>
                                            <span>
                                                <input type="text" name="city" class="formbord"
                                                    value="{{ old('city') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text my-2">
                                        <div class="borderbottom @if ($errors->first('state')) is-invalid @endif">
                                            <span>State:</span>
                                            <span>
                                                <input type="text" name="state" class="formbord"
                                                    value="{{ old('state') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text my-2">
                                        <div class="borderbottom @if ($errors->first('Zip')) is-invalid @endif">
                                            <span>Zip:</span>
                                            <span>
                                                <input type="text" name="Zip" class="formbord"
                                                    value="{{ old('Zip') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text my-2">
                                        <div class="borderbottom @if ($errors->first('country')) is-invalid @endif">
                                            <span>Country:</span>
                                            <span>
                                                <input type="text" name="country" class="formbord"
                                                    value="{{ old('country') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my-4">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="text my-2">
                                                    <span>
                                                        <input type="radio" value="CREDIT CARD" name="payment_type"
                                                            {{ old('payment_type') == 'CREDIT CARD' ? 'checked' : '' }}>
                                                    </span>
                                                    <span>CREDIT CARD</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="text my-2">
                                                    <span>
                                                        <input type="radio" value="VISA" name="payment_type"
                                                            {{ old('payment_type') == 'CREDIT CARD' ? 'checked' : '' }}>
                                                    </span>
                                                    <span>VISA</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="text my-2">
                                                    <span>
                                                        <input type="radio" value="MASTERCARD" name="payment_type"
                                                            {{ old('payment_type') == 'MASTERCARD' ? 'checked' : '' }}>
                                                    </span>
                                                    <span>MASTERCARD</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="text my-2">
                                                    <span>
                                                        <input type="radio" value="DiSCOVER" name="payment_type"
                                                            {{ old('payment_type') == 'DiSCOVER' ? 'checked' : '' }}>
                                                    </span>
                                                    <span>DiSCOVER</span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="text my-2">
                                                    <span>
                                                        <input type="radio" value="AMEX" name="payment_type"
                                                            {{ old('payment_type') == 'AMEX' ? 'checked' : '' }}>
                                                    </span>
                                                    <span>AMEX </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text my-2">
                                        <div class="borderbottom @if ($errors->first('credit_card_no')) is-invalid @endif"
                                            name="payment_type">
                                            <span>Credit Card No:</span>
                                            <span>
                                                <input type="text" class="formbord" name="credit_card_no"
                                                    value="{{ old('credit_card_no') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text my-2">
                                        <div class="borderbottom @if ($errors->first('exp_date')) is-invalid @endif">
                                            <span>Expire Date:</span>
                                            <span>
                                                <input type="text" class="formbord" name="exp_date"
                                                    value="{{ old('exp_date') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text my-2">
                                        <div class="borderbottom @if ($errors->first('card_appears_name')) is-invalid @endif">
                                            <span>PRINT NAME AS IT APPEARS ON THE CARD:</span>
                                            <span>
                                                <input type="text" class="formbord" name="card_appears_name"
                                                    value="{{ old('card_appears_name') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text my-2">
                                        <div class="borderbottom @if ($errors->first('digit_on_back')) is-invalid @endif">
                                            <span>Digit # On Back:</span>
                                            <span>
                                                <input type="text" class="formbord" name="digit_on_back"
                                                    value="{{ old('digit_on_back') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text my-2">
                                        <div class="borderbottom @if ($errors->first('dollar_amount')) is-invalid @endif">
                                            <span>Amount (USD):</span>
                                            <span>
                                                <input type="text" class="formbord" name="dollar_amount"
                                                    value="{{ old('dollar_amount') }}" placeholder=" ">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text my-2">
                                        <div class="borderbottom @if ($errors->first('stgnature')) is-invalid @endif">
                                            <span>Signature:</span>
                                            <span>
                                                <input type="text" class="formbord" name="stgnature"
                                                    value="{{ old('stgnature') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text my-2">
                                        <div class="borderbottom @if ($errors->first('paid_bill_date')) is-invalid @endif">
                                            <span>Date:</span>
                                            <span>
                                                <input type="date" class="formbord" name="paid_bill_date"
                                                    value="{{ old('paid_bill_date') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text my-2">
                                        <div class="borderbottom @if ($errors->first('paid_bill')) is-invalid @endif">
                                            <span>Paid bill:</span>
                                            <span>
                                                <input type="text" class="formbord" name="paid_bill"
                                                    value="{{ old('paid_bill') }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text my-2">
                                        <div class="borderbottom @if ($errors->first('student_signature_date')) is-invalid @endif">
                                            <span>Date:</span>
                                            <span>
                                                <input type="date" class="formbord" name="student_signature_date"
                                                    value="{{ old('student_signature_date') ? old('student_signature_date') : $userSetting->student_signature_date }}">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text my-2">
                                        <div class="borderbottom @if ($errors->first('student_signature')) is-invalid @endif">
                                            <span>Student Signature:</span>
                                            <span>
                                                <input type="text" class="formbord" name="student_signature"
                                                    value="{{ old('student_signature') ? old('student_signature') : $userSetting->student_signature }}">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pb-5">
                                    <div class="page gap_15 mt_40">
                                        <a href="{{ route('register') }}" class="theme_btn small_btn2">Back Page</a>
                                        <button type="submit" class="theme_btn small_btn2">Next Page</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 responsive-order">
                        <div classs="data py-5" style="background: #fbfff2;">
                            @include(theme('auth.login_wrapper_right'))
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include(theme('partials._custom_footer'))

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
