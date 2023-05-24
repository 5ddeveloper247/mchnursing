@extends('backend.master')
@push('styles')
    <style>
        input {
            background: transparent;
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
    </style>
@endpush

@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area student-details">
        <div class="container-fluid p-0">
            <div class="row">
                {{-- {{ dd($student->studentsetting->l_name) }} --}}
                <div class="col-md-12">
                    <div class="main-title">
                        <h3 class="">

                            {{ __('Student') }} | {{ $student->student->name ?? null }}
                        </h3>
                    </div>

                    <div class="row pt-0">
                        <ul class="nav nav-tabs no-bottom-border mt-sm-md-20 mb-10 ml-3" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link @if (!session()->get('type')) active @endif" href="#group_email_sms"
                                    role="tab" data-toggle="tab">{{ __('User Detail') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link @if (session()->get('type') == 2) active @endif"
                                    href="#indivitual_email_sms" role="tab"
                                    data-toggle="tab">{{ __('User Application') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link @if (session()->get('type') == 3) active @endif" href="#file_list"
                                    role="tab" data-toggle="tab">{{ __('User Authentication Agreement') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#payment_detail" role="tab"
                                    data-toggle="tab">{{ __('User Payment Details') }}</a>
                            </li>

                        </ul>
                    </div>
                    <div class="white_box_30px">
                        <div class="row mt_0_sm">

                            <!-- Start Sms Details -->
                            <div class="col-lg-12">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <input type="hidden" name="selectTab" id="selectTab">
                                    <div role="tabpanel"
                                        class="tab-pane fade @if (!session()->get('type')) show active @endif"
                                        id="group_email_sms">
                                        <div class="white_box_30px pl-0 pr-0 pt-0">
                                            <form action="{{ route('student.student.detail') }}" method="POST"
                                                id="regForm">
                                                @csrf
                                                <!-- widgetsform -->
                                                <input type="hidden" name="is_user_setting" value="">
                                                <input name="user_id" type="hidden"
                                                    value="{{ $student->student->id ?? null }}">
                                                <div class="mainform row m-0 p-5">
                                                    <div class="col-md-12">

                                                        <div id="first" class="form mb-5">

                                                            <div class="ff">
                                                                <h4 class="text-center">Application for Addmission</h4>
                                                                <div class="col-md-12 program my-3">
                                                                    <h5 class="mt-5">$100 Fee Required</h5>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    First Name
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="f_name"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentsetting->f_name ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    Last Name
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="l_name"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentsetting->l_name ?? null }}">
                                                                                </span>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 my-4">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    DOB:
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="dob"
                                                                                        class="formbord"
                                                                                        value="{{ $student->student->dob ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    SS#:
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="SS"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentsetting->SS ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 my-4">
                                                                    <div class="row">
                                                                        <div class="col-md-4 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    CITY:
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="city"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentsetting->city ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    State:
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="state"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentsetting->state ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    Zip:
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="Zip"
                                                                                        class="formbord"
                                                                                        value="{{ $student->student->zip ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 my-4">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    Email
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="email"
                                                                                        class="formbord"
                                                                                        value="{{ $student->student->email ?? null }}"
                                                                                        readonly>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    Cell No
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="phone"
                                                                                        class="formbord"
                                                                                        value="{{ $student->student->phone ?? null }}"
                                                                                        readonly>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 my-4">
                                                                    <div class="row">

                                                                        <div class="col-md-12 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    Mailing address
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text"
                                                                                        name="mailing_address"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentsetting->mailing_address ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="row m-0">
                                                                    <div class="col-md-7 program">
                                                                        <h5 class="borderbotom">PROGRAM REVIEW: NCLEX
                                                                            REMEDIAL or RN COURSE
                                                                            REVIEW </h5>
                                                                    </div>
                                                                </div>

                                                                @php
                                                                    $program_review = [];
                                                                    if (!empty($student->studentsetting)) {
                                                                        $program_review = json_decode($student->studentsetting->program_review);
                                                                    }
                                                                    
                                                                @endphp

                                                                <div class="row m-0 mt-2">
                                                                    <div class="col-md-3 checkbox">
                                                                        <div class="checkboxdata mt-2">
                                                                            <input type="checkbox" name="program_review[]"
                                                                                class="increae" value="Transition"
                                                                                {{ in_array('Transition', $program_review) ? 'checked' : '' }}>
                                                                            <h5 class="mx-2 mt-3">
                                                                                Transition
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 checkbox">
                                                                        <div class="checkboxdata mt-2">
                                                                            <input type="checkbox" name="program_review[]"
                                                                                class="increae" value="Remedial"
                                                                                {{ in_array('Remedial', $program_review) ? 'checked' : '' }}>
                                                                            <h5 class="mx-2 mt-3">
                                                                                Remedial
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 checkbox">
                                                                        <div class="checkboxdata mt-2">
                                                                            <input type="checkbox" name="program_review[]"
                                                                                class="increae" value="Review"
                                                                                {{ in_array('Review', $program_review) ? 'checked' : '' }}>
                                                                            <h5 class="mx-2 mt-3">
                                                                                Review
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 checkbox">
                                                                        <div class="checkboxdata mt-2">
                                                                            <input type="checkbox" name="program_review[]"
                                                                                class="increae" value="CNA Prep"
                                                                                {{ in_array('CNA Prep', $program_review) ? 'checked' : '' }}>
                                                                            <h5 class="mx-2 mt-3">
                                                                                CNA Prep
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-8 mb-5">
                                                                        <div class="col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-md-12 text">
                                                                                    <div class="box borderbottom my-2">
                                                                                        <span>
                                                                                            <input type="text"
                                                                                                name="student_signature"
                                                                                                class="formbord"
                                                                                                value="{{ $student->studentsetting->student_signature ?? null }}">
                                                                                        </span>
                                                                                    </div>
                                                                                    <div class="col-md-8 text">
                                                                                        <div class="box">
                                                                                            <span>
                                                                                                Student Signature:
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="col-md-12 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    <input type="text"
                                                                                        name="student_signature_date"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentsetting->student_signature_date ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            <div class="box">
                                                                                <span>
                                                                                    Date
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="page">
                                                                <button class="primary-btn fix-gr-bg"
                                                                    type="submit">{{ __('common.Update') }}</button>
                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>


                                            </form>
                                        </div>

                                    </div>

                                    <div role="tabpanel"
                                        class="tab-pane fade @if (session()->get('type') == 2) show active @endif"
                                        id="indivitual_email_sms">
                                        <div class="white_box_30px pl-0 pr-0 pt-0">
                                            <form action="{{ route('student.student.application') }}" method="POST"
                                                id="regForm">
                                                @csrf
                                                <!-- widgetsform -->
                                                <input type="hidden" name="user_id"
                                                    value="{{ $student->student->id ?? null }}">
                                                <div class="mainform row m-0 p-5">
                                                    <div class="col-md-12">


                                                        <div id="second" class="form">
                                                            <div class="c">
                                                                <h5 class="text-center">CREDIT CARD AUTHORIZATION AGREEMENT
                                                                </h5>
                                                                <div class="col-md-12 program my-5">
                                                                    <h5>*Initials Required*
                                                                    </h5>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row m-0">
                                                                        <div class="col-md-4">
                                                                            <div class="mainbox borderbottom">
                                                                                <input type="text" name="term_one_text"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentapplication->term_one_text ?? null }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-8 nameda program">
                                                                            <p>
                                                                                I hereby authorize Merakii College Of Health
                                                                                to charge my Credit
                                                                                or
                                                                                Debit Card for payment of Education services
                                                                                rendered as
                                                                                described
                                                                                on Invoice No.
                                                                            </p>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row m-0">
                                                                        <div class="col-md-3">
                                                                            <div class="mainbox borderbottom">
                                                                                <input type="text"
                                                                                    name="invoice_date_one"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentapplication->term_one_text ?? null }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <div class="mainbox program">
                                                                                <h5>dated</h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="mainbox borderbottom">
                                                                                <input type="text"
                                                                                    name="invoice_date_two"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentapplication->term_one_text ?? null }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row m-0 my-4">
                                                                        <div class="col-md-4">
                                                                            <div class="mainbox borderbottom">
                                                                                <input type="text" name="term_two_text"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentapplication->term_one_text ?? null }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-8 nameda program">
                                                                            <p>
                                                                                I agree, in all cases, to pay the Credit
                                                                                Card amount below for
                                                                                the
                                                                                full payment for Education services rendered
                                                                                as described on
                                                                                Invoice
                                                                                No.
                                                                            </p>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row nameda program m-0">
                                                                        <p class="">
                                                                            I HAVE READ AND FULLY UNDERSTAND AND AGREE WITH
                                                                            ALL OF THE ABOVE
                                                                            TERMS.
                                                                        </p>
                                                                    </div>
                                                                </div>


                                                                <!-- mujtaba -->
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    Name
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="name"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentapplication->name ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    Phone
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="phone"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentapplication->phone ?? null }}">
                                                                                </span>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 my-4">
                                                                    <div class="row">
                                                                        <div class="col-md-4 text">

                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    Address
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="address"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentapplication->address ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span> Fax </span>
                                                                                <span>
                                                                                    <input type="text" name="fax"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentapplication->fax ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span> City </span>
                                                                                <span>
                                                                                    <input type="text" name="city"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentapplication->city ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-12 my-4">
                                                                    <div class="row">
                                                                        <div class="col-md-4 text">

                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    State
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="state"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentapplication->state ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    Zip
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" name="Zip"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentapplication->Zip ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    Country
                                                                                </span>

                                                                                <span>
                                                                                    <input type="text" name="country"
                                                                                        class="formbord"
                                                                                        value="{{ $student->studentapplication->country ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 my-4">
                                                                    <div class="row program">
                                                                        <div class="col-md-3 text">
                                                                            <div class="box my-2">
                                                                                <span>CREDIT CARD:</span><span>
                                                                                    <input type="radio"
                                                                                        value="CREDIT CARD"
                                                                                        name="payment_type"
                                                                                        {{ $student->studentapplication->payment_type ?? null == 'CREDIT CARD' ? 'checked' : '' }}></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 text">
                                                                            <div class="box my-2">
                                                                                <span>VISA:</span><span>
                                                                                    <input type="radio" value="VISA"
                                                                                        name="payment_type"
                                                                                        {{ $student->studentapplication->payment_type ?? null == 'VISA' ? 'checked' : '' }}></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 text">
                                                                            <div class="box my-2">
                                                                                <span>MASTERCARD:</span><span>
                                                                                    <input
                                                                                        type="radio"value="MASTERCARD"
                                                                                        name="payment_type"
                                                                                        {{ $student->studentapplication->payment_type ?? null == 'MASTERCARD' ? 'checked' : '' }}></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 text">
                                                                            <div class="box my-2">
                                                                                <span>DiSCOVER </span><span>
                                                                                    <input type="radio" value="DiSCOVER"
                                                                                        name="payment_type"
                                                                                        {{ $student->studentapplication->payment_type ?? null == 'DiSCOVER' ? 'checked' : '' }}>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 text">
                                                                            <div class="box my-2">
                                                                                <span>AMEX </span><span>
                                                                                    <input type="radio" value="AMEX"
                                                                                        name="payment_type"
                                                                                        {{ $student->studentapplication->payment_type ?? null == 'AMEX' ? 'checked' : '' }}>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 my-4">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">

                                                                            <div class="box borderbottom"
                                                                                name="payment_type">
                                                                                <span>
                                                                                    Credit Card No:
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" class="formbord"
                                                                                        name="credit_card_no"
                                                                                        value="{{ $student->studentapplication->credit_card_no ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom">
                                                                                <span>
                                                                                    EXPIRATION DATE:
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" class="formbord"
                                                                                        name="exp_date"
                                                                                        value="{{ $student->studentapplication->exp_date ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 my-4">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">

                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    PRINT NAME AS IT APPEARS ON THE CARD:
                                                                                </span>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    <input type="text" class="formbord"
                                                                                        name="card_appears_name"
                                                                                        value="{{ $student->studentapplication->card_appears_name ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 my-4">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">

                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    DIGIT # ON BACK:
                                                                                </span>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    <input type="text" class="formbord"
                                                                                        name="digit_on_back"
                                                                                        value="{{ $student->studentapplication->digit_on_back ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 my-4">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">

                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    DOLLAR AMOUNT: $
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" class="formbord"
                                                                                        name="dollar_amount"
                                                                                        value="{{ $student->studentapplication->dollar_amount ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    SIGNATURE
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" class="formbord"
                                                                                        name="stgnature"
                                                                                        value="{{ $student->studentapplication->stgnature ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 my-4">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">

                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    DATE:
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" class="formbord"
                                                                                        name="paid_bill_date"
                                                                                        value="{{ $student->studentapplication->paid_bill_date ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    Paid bill:
                                                                                </span>
                                                                                <span>
                                                                                    <input type="text" class="formbord"
                                                                                        name="paid_bill"
                                                                                        value="{{ $student->studentapplication->paid_bill ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row pb-5">
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-md-12 text">
                                                                                    <div class="box borderbottom my-2">

                                                                                        <span>
                                                                                            <input type="text"
                                                                                                class="formbord"
                                                                                                name="student_signature"
                                                                                                value="{{ $student->studentapplication->student_signature ?? null }}">
                                                                                        </span>

                                                                                    </div>
                                                                                    <div class="col-md-6 text">
                                                                                        <div class="box">
                                                                                            <span>
                                                                                                Student Signature:
                                                                                            </span>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="col-md-12 text">
                                                                            <div class="box borderbottom my-2">
                                                                                <span>
                                                                                    <input type="text" class="formbord"
                                                                                        name="student_signature_date"
                                                                                        value="{{ $student->studentapplication->student_signature_date ?? null }}">
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            <div class="box">
                                                                                <span>
                                                                                    Date
                                                                                </span>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="page">
                                                                <button class="primary-btn fix-gr-bg"
                                                                    type="submit">{{ __('common.Update') }}</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- End Individual Tab -->
                                    <div role="tabpanel"
                                        class="tab-pane fade @if (session()->get('type') == 3) show active @endif"
                                        id="file_list">
                                        <div class="white_box_30px pl-0 pr-0 pt-0">
                                            {{-- <form action="{{ route('student.student.authentication.agreement') }}"
                                                method="POST" id="regForm">
                                                @csrf
                                                <!-- widgetsform -->
                                                <input type="hidden" name="user_id"
                                                    value="{{ $student->student->id ?? null }}"> --}}
                                            <div class="mainform row m-0 p-5">
                                                <div class="col-md-12">

                                                    <div id="third" class="form pt-3">
                                                        <div class="con">
                                                            <div class="containerer program">
                                                                {{-- <div class="row">
                                                                        <div class="col-md-9 my-3">

                                                                            <div class="box">
                                                                                <b style="font-size:14px;">Complete forms
                                                                                    must be mailed
                                                                                    to:  </b><br>
                                                                                <b
                                                                                    style="color:rgb(13, 103, 168);font-size:13px;">Board <span
                                                                                        style="color:grey;font-style:italic;">of</span> Nursing </b>
                                                                                <p class="m-0"
                                                                                    style="font-size:15px;font-weight:500;color:rgb(13, 103, 168)"
                                                                                    class="">
                                                                                    4052 Bald Cypress Way Bin C‐02 </p>

                                                                                <p style="font-size:15px;font-weight:500;color:rgb(13, 103, 168)"
                                                                                    class="">
                                                                                    Tallahassee, FL 32399‐3252 </p>
                                                                                <b class="h6"
                                                                                    style="color:rgb(13, 103, 168)">Board <span
                                                                                        style="color:grey;font-style:italic;font-weight: bold;">of</span> Nursing
                                                                                    Third Party Authorization </b>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <div class="logo pt-4">
                                                                                <!-- <img src="logo.jpg"> -->
                                                                                <img src="{{ url('public/assets/logo.jpg') }}"
                                                                                    alt="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <p
                                                                            style="font-weight:bold;font-size:15px;text-align:justify;">
                                                                            Applicants who intend to have an entity other
                                                                            than themselves act as
                                                                            a
                                                                            representative in the licensure process for this
                                                                            application must
                                                                            complete this form and have their signature
                                                                            notarized. Discard this
                                                                            form
                                                                            if you are submitting this application and do
                                                                            not authorize another
                                                                            person to act on your behalf.
                                                                        </p>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="row m-0">
                                                                            <div class="col-md-1 mdka">
                                                                                <span style="font-size:12px;"><b>I,
                                                                                    </b></span>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="mainbox">
                                                                                    <div class="mini borderbottom">
                                                                                        <input type="text"
                                                                                            name="applican_name"
                                                                                            class="nameformbord"
                                                                                            value="{{ $student->studentauthorziationagreement->applican_name ?? null }}">
                                                                                    </div>
                                                                                    <p class="text-center">
                                                                                        ( applican name )
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-7 nameda1">
                                                                                <p>
                                                                                    the undersigned, do hereby authorize
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row m-0">
                                                                            <div class="col-md-4">
                                                                                <div class="mainbox">
                                                                                    <div class="mini borderbottom">
                                                                                        <input type="text"
                                                                                            name="authorized_representative"
                                                                                            class="nameformbord"
                                                                                            value="{{ $student->studentauthorziationagreement->authorized_representative ?? null }}">
                                                                                    </div>
                                                                                    <p class="text-center">
                                                                                        (authorized representative)
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-7 nameda1">
                                                                                <p>
                                                                                    whose address is
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row m-0">
                                                                            <div class="col-md-8">
                                                                                <div class="mainbox">
                                                                                    <div class="mini borderbottom">
                                                                                        <input type="text"
                                                                                            name="address"
                                                                                            class="nameformbord"
                                                                                            value="{{ $student->studentauthorziationagreement->address ?? null }}">
                                                                                    </div>
                                                                                    <p class="text-center">
                                                                                        (authorized representatives address)

                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 nameda1">
                                                                                <p>
                                                                                    , their agents, or
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 program my-4">
                                                                            <p>
                                                                                employees, to act for me and in my name with
                                                                                respect to my
                                                                                application for licensure with the Florida
                                                                                Board of Nursing,
                                                                                with
                                                                                the exception of withdrawing my application
                                                                                or requesting a
                                                                                refund.
                                                                            </p>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <p>
                                                                                Applicant Signature:
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="mainbox1 borderbottom">
                                                                                <input type="text"
                                                                                    name="applicant_signature"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentauthorziationagreement->applicant_signature ?? null }}">

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <p>
                                                                                Date:
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="mini borderbottom">
                                                                                <input type="text" name="date"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentauthorziationagreement->date ?? null }}">
                                                                            </div>
                                                                            <p class="text-center">
                                                                                (MM/DD/YYYY)
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <!-- break -->
                                                                    <div class="row my-4">
                                                                        <div class="col-md-2">
                                                                            <p>
                                                                                State of:
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="mainbox1 borderbottom">
                                                                                <input type="text" name="state"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentauthorziationagreement->state ?? null }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <p>
                                                                                County of:
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="mainbox1 borderbottom">
                                                                                <input type="text" name="country"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentauthorziationagreement->country ?? null }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mt-3">
                                                                        <div class="col-md-6">
                                                                            <p>
                                                                                Sworn to and/or subscribed before me this
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <div class="mainbox1 borderbottom">
                                                                                <input type="text" name="day"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentauthorziationagreement->day ?? null }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 mt-3">
                                                                            <p>
                                                                                day of:
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-3 mt-3">
                                                                            <div class="mainbox1 borderbottom">
                                                                                <input type="text" name="age"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentauthorziationagreement->age ?? null }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 mt-3">
                                                                            <p>
                                                                                20:
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-4 mt-3">
                                                                            <div class="mainbox1 borderbottom">
                                                                                <input type="text" name="name"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentauthorziationagreement->name ?? null }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-4">
                                                                        <div class="col-md-2">
                                                                            <p>
                                                                                By
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <div class="mainbox1 borderbottom">
                                                                                <input type="text" name="by"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentauthorziationagreement->by ?? null }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-8 mt-3">
                                                                            <p>
                                                                                whose identity is known to me by
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="mainbox1 borderbottom">
                                                                                <input type="text"
                                                                                    name="whose_identity"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentauthorziationagreement->whose_identity ?? null }}">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row mt-4 mb-5">
                                                                        <div class="col-md-5">
                                                                            <p>
                                                                                Notary Signature
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="mainbox1 borderbottom">
                                                                                <input type="text"
                                                                                    name="notary_signature"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentauthorziationagreement->notary_signature ?? null }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <p>
                                                                                Printed Name of Notary
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="mainbox1 borderbottom">
                                                                                <input type="text" name="printed_name"
                                                                                    class="nameformbord"
                                                                                    value="{{ $student->studentauthorziationagreement->printed_name ?? null }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 mt-4">
                                                                            <p
                                                                                style="text-align:center;color:rgb(49, 48, 48);font-size:17px;font-style:italic;font-weight: normal;">
                                                                                These signature fields cannot be typed. You
                                                                                must print out the
                                                                                form
                                                                                and sign it before a notary public. </p>
                                                                        </div>
                                                                        <div class="col-md-12 mt-5">
                                                                            <p>
                                                                                SEAL
                                                                            </p>
                                                                            <p style="line-height:0px;">
                                                                                (Notary Public)
                                                                            </p>
                                                                            <p class="mt-5">
                                                                                To withdraw your authorization of a third
                                                                                party representing
                                                                                you,
                                                                                submit a written request to the board office
                                                                                at the address
                                                                                above.
                                                                            </p>
                                                                        </div>
                                                                    </div> --}}
                                                                <div class="row">

                                                                    <table class="table-bordered table text-center">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="h5">Student Name</th>
                                                                                <th class="h5">Agreement File</th>
                                                                                <th class="h5">Status</th>
                                                                                @if ($student->studentauthorziationagreement->status == null || $student->studentauthorziationagreement->status == 0)
                                                                                    <th class="h5">Mark as</th>
                                                                                @endif
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    {{ $student->student->name }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($student->studentauthorziationagreement->user_agreement_form == null)
                                                                                        <p
                                                                                            style="text-align:center; color:red; font-size:17px; font-style:italic; font-weight: bold;">
                                                                                            Form Not Uploaded yet
                                                                                        </p>
                                                                                    @else
                                                                                        <a href="{{ asset($student->studentauthorziationagreement->user_agreement_form) }}"
                                                                                            class="primary-btn fix-gr-bg"
                                                                                            download="agreement_of_student_{{ $student->studentauthorziationagreement->user_id }}">Download</a>
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    @switch($student->studentauthorziationagreement->status)
                                                                                        @case(null)
                                                                                            <h4 class="text-secondary">Not
                                                                                                Available</h4>
                                                                                        @break

                                                                                        @case(0)
                                                                                            <h4 class="text-warning">Pending</h4>
                                                                                        @break

                                                                                        @case(1)
                                                                                            <h4 class="text-success">Approved</h4>
                                                                                        @break

                                                                                        @case(2)
                                                                                            <h4 class="text-danger">Disapproved
                                                                                            </h4>
                                                                                        @break

                                                                                        @default
                                                                                    @endswitch
                                                                                </td>


                                                                                @switch($student->studentauthorziationagreement->status)
                                                                                    @case(null)
                                                                                        <td>
                                                                                            <h4 class="text-secondary">Not
                                                                                                Available</h4>
                                                                                        </td>
                                                                                    @break

                                                                                    @case(0)
                                                                                        <td>
                                                                                            <button
                                                                                                class="primary-btn fix-gr-bg btn-sm"
                                                                                                onclick="changeStudentStatus({{ $student->studentauthorziationagreement->user_id }}, 1)">Approve</button>
                                                                                            <button
                                                                                                class="primary-btn fix-gr-bg btn-sm"
                                                                                                onclick="changeStudentStatus({{ $student->studentauthorziationagreement->user_id }}, 2)">Disapprove</button>
                                                                                        </td>
                                                                                    @break

                                                                                    @default
                                                                                @endswitch
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="page">

                                                                    {{-- <button class="primary-btn fix-gr-bg"
                                                                            type="submit">{{ __('common.Update') }}</button> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>


                                            {{-- </form> --}}
                                        </div>

                                    </div>


                                    <div role="tabpanel" class="tab-pane fade @" id="payment_detail">
                                        <div class="white_box_30px pl-0 pr-0 pt-0">
                                            @if (empty($student->payment_detail))
                                                <h2>Student Do'nt Make A Payment</h2>
                                            @else
                                                <!-- widgetsform -->
                                                <div class="mainform row m-0 p-5">
                                                    <div class="col-md-12">

                                                        <div id="first" class="form mb-5">

                                                            <div class="ff">
                                                                <h4 class="text-center">Payment Detail</h4>

                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">
                                                                            <strong>Payment ID:</strong>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            {{ $student->payment_detail->id }}
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">
                                                                            <strong>Currency:</strong>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            {{ $student->payment_detail->currency }}
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">
                                                                            <strong>Amount:</strong>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            {{ '$' . $student->payment_detail->amount / 100 }}
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">
                                                                            <strong>Refunded:</strong>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            {{ $student->payment_detail->amount_refunded }}
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">
                                                                            <strong>Brand:</strong>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            {{ $student->payment_detail->source->brand }}
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">
                                                                            <strong>Status:</strong>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            {{ $student->payment_detail->status }}
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-6 text">
                                                                            <strong>Date:</strong>
                                                                        </div>
                                                                        <div class="col-md-6 text">
                                                                            {{ $student->payment_detail->created_at }}
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            {{--                                                            <div class="page"> --}}
                                                            {{--                                                                <button --}}
                                                            {{--                                                                    class="primary-btn fix-gr-bg" --}}
                                                            {{--                                                                    type="submit">{{__('common.Update')}}</button> --}}
                                                            {{--                                                            </div> --}}
                                                        </div>


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
        </div>
        <div class="modal fade admin-query" id="change_status">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title"></h4>
                        <button type="button" class="close modal_close" data-dismiss="modal"><i
                                class="ti-close"></i></button>
                    </div>

                    <div class="modal-body">
                        <h3 class="text-center">Are you Sure ?</h3>
                        <form action="" id="change_status_form">
                            @csrf
                            <input type="hidden" name="student_id" id="student_id">
                            <input type="hidden" name="status" id="status">
                            <div class="d-flex justify-content-between mt-40">
                                <button type="button" class="primary-btn tr-bg modal_close"
                                    data-dismiss="modal">{{ __('common.Cancel') }}</button>

                                <button class="primary-btn semi_large2 fix-gr-bg" id="confirm_status"><i
                                        class="ti-check"></i> {{ __('Confirm') }}</button>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function changeStudentStatus(student_id, status) {
            jQuery('#change_status').modal('show', {
                backdrop: 'static'
            });
            if (status == 1) {
                $('#modal_title').html('Approve Student');
            } else {
                $('#modal_title').html('Disapprove Student');
            }
            $('#student_id').val(student_id);
            $('#status').val(status);

            $('#confirm_status').on('click', function(e) {
                e.preventDefault();
                var add_btn = $(this);
                add_btn.attr('disabled', 'true');
                add_btn.find('i').attr('class', '').addClass('fa fa-spinner fa-spin fa-lg');

                var form = $('#change_status_form');
                var data = new FormData(form[0]);
                console.log(form);
                $.ajax({
                    type: "POST",
                    url: '{{ route('changeStudentFormStatus') }}',
                    data: data,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "showDuration": 300,
                            "timeOut": 3000,
                            "hideDuration": 1000,
                            "preventDuplicates": true,
                        }
                        if (response.status == 200) {
                            form.trigger("reset");
                            add_btn.removeAttr('disabled');
                            add_btn.find('i').attr('class', '').addClass(
                                'ti-check');
                            jQuery('#change_status').modal('hide');
                            toastr[response.state](response.message);
                            window.setTimeout(function() {
                                location.reload(); // window.location.href = url;
                            }, 3000);
                        } else {
                            toastr[response.state](response.message);
                            form.trigger("reset");
                        }
                    }
                });
            });

        }
    </script>
    <script>
        var lms_option_list = $('.lms_option_list');
        var minus_option_box = $('#minus_option_box');
        var add_option_box = $('#add_option_box');
        var chapter_section = $('#chapter_section');
        var lesson_section = $('#lesson_section');
        var quiz_section = $('#quiz_section');
        $(document).ready(function() {
            let lms_option_list = $('#lms_option_list').hide();
        })
        $('#add_option_box').click(function() {
            lms_option_list.show();
            minus_option_box.show();
            add_option_box.hide();
        })
        $('#minus_option_box').click(function() {
            lms_option_list.hide();
            minus_option_box.hide();
            lesson_section.hide();
            quiz_section.hide();
            chapter_section.hide();
            add_option_box.show();
        })
        $('#show_chapter_section').click(function() {
            lms_option_list.hide();
            lesson_section.hide();
            quiz_section.hide();
            chapter_section.show();
        })
        $('#show_lesson_section').click(function() {
            lms_option_list.hide();
            lesson_section.show();
            quiz_section.hide();
            chapter_section.hide();
        })
        $('#show_quiz_section').click(function() {
            lms_option_list.hide();
            lesson_section.hide();
            quiz_section.show();
            chapter_section.hide();
        })
    </script>
@endpush
