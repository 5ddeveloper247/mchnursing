@extends('backend.master')
@push('styles')
    <style>


        .becomedobs h2 {
            text-decoration: underline;
            font-weight: bold;

        }

        .form-select {

            border: 1px solid gray;
            border-radius: 10px;
            height: 50px;

        }

        .form-control {
            border: 1px solid gray;
            border-radius: 10px !important;
            height: 50px;

        }

        label {

            font-weight: bold;
            margin-bottom: 7px;
            font-size: 14px;

        }

        .popup a {
            text-decoration: none;
            color: black;
        }




        .boxbanner h1 {
            font-size: 70px;
            font-weight: bold;
            color: white;
            margin-top: 4rem;

            padding-top: 10rem !important;
        }



        .dataheading h1 {
            margin-top: -14px;
            /* padding:rem; */
        }


        .dataheading1 h1 {
            font-weight: 800;
            font-size: 45px;
        }

        .dataheading h1 {
            font-weight: 800;
            font-size: 45px;
        }



        .leftimg1 img {
            height: 350px;
            width: 350px;
            border-radius: 50%;
            margin-left: 15%;
        }





        .contka img {
            height: 350px !important;
            width: 250px !important;
            transition: 1s;
        }

        .contka img:hover {

            -ms-transform: scale(1.05); /* IE 9 */
            -webkit-transform: scale(1.05); /* Safari 3-8 */
            transform: scale(1.05);

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





        @media (max-width: 600px) {
            .leftimg1 img {
                height: 250px;
                margin-top: 2rem;
                width: 250px;
                border-radius: 50%;
                padding-left: 0%;
            }

            .boxbanner h1 {
                font-size: 40px;
                font-weight: bold;
                color: white;
                margin-top: 4rem;
                padding-top: 10rem !important;
            }
        }



        .becomedobs h2 {
            text-decoration: underline;
            font-weight: bold;

        }

        .form-select {

            border: 1px solid gray;
            border-radius: 10px;
            height: 50px;

        }

        .form-control {
            border: 1px solid gray;
            border-radius: 10px !important;
            height: 50px;

        }

        label {

            font-weight: bold;
            margin-bottom: 7px;
            font-size: 14px;

        }

        .popup a {
            text-decoration: none;
            color: black;
        }


        .is-invalid{
            border-bottom: 2px solid red !important;
        }

    </style>
@endpush

@section('mainContent')
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class=" col-md-12  ">
                    <div class="main-title">
                        <h3 class="">

                            {{ __('Instructor') }} | {{ $instructors_personal_info->first_name  ?? null }} {{ $instructors_personal_info->last_name  ?? null }}
                        </h3>
                    </div>

                    {{--                    <div class="row pt-0">--}}
                    {{--                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3" role="tablist">--}}

                    {{--                            <li class="nav-item">--}}
                    {{--                                <a class="nav-link @if(!session()->get('type')) active @endif"--}}
                    {{--                                   href="#group_email_sms" role="tab" data-toggle="tab">{{ __('User Detail') }}</a>--}}
                    {{--                            </li>--}}

                    {{--                            <li class="nav-item">--}}
                    {{--                                <a class="nav-link @if(session()->get('type') == 2) active @endif"--}}
                    {{--                                   href="#indivitual_email_sms" role="tab"--}}
                    {{--                                   data-toggle="tab">{{ __('User Application') }}</a>--}}
                    {{--                            </li>--}}

                    {{--                            <li class="nav-item">--}}
                    {{--                                <a class="nav-link  @if(session()->get('type') == 3) active @endif" href="#file_list"--}}
                    {{--                                   role="tab" data-toggle="tab">{{ __('User Authentication Agreement') }}</a>--}}
                    {{--                            </li>--}}

                    {{--                            <li class="nav-item">--}}
                    {{--                                <a class="nav-link" href="#payment_detail"--}}
                    {{--                                   role="tab" data-toggle="tab">{{ __('User Payment Details') }}</a>--}}
                    {{--                            </li>--}}

                    {{--                        </ul>--}}
                    {{--                    </div>--}}
                    <div class="white_box_30px">
                        <div class="row  mt_0_sm">

                            <!-- Start Sms Details -->
                            <div class="col-lg-12">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <input type="hidden" name="selectTab" id="selectTab">
                                    <div role="tabpanel"
                                         class="tab-pane fade  show active"
                                         id="group_email_sms">
                                        <div class="col-md-12 becomedobs">
                                            <!-- Become an Instructor section  -->


                                            <form action="{{ route('instructor.update.view') }}" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <input name="type" value="Instructor" type="hidden">
                                                <input name="user_id" value="{{ $id }}" type="hidden">
                                                <div class="container ">
                                                    <h2 class="text-center my-4 hit">
                                                        Become an Instructor
                                                    </h2>
                                                    <div class="row">
                                                        <div class="col-md-12 ">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="data">
                                                                        <label>
                                                                            What position are you applying?*
                                                                        </label>
                                                                        <select name="instructor_position_id"
                                                                                class="form-select form-control "
                                                                                aria-label="Default select example">
                                                                            <option value="" selected>
                                                                                --SELECT--
                                                                            </option>
                                                                            @foreach($postions as $postion)
                                                                                <option
                                                                                    value="{{ $postion->id }}" {{($postion->id == $become_instructors_form_data->instructor_position_id ? 'selected' : '') }}>{{ $postion->name }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="data">
                                                                        <label>How did you hear about us ?*
                                                                        </label>
                                                                        <select name="instructor_hear_id"
                                                                                class="form-select form-control "
                                                                                aria-label="Default select example">
                                                                            <option value="" selected>
                                                                                --SELECT--
                                                                            </option>
                                                                            @foreach($hears as $hear)
                                                                                <option
                                                                                    value="{{ $hear->id }}" {{($hear->id == $become_instructors_form_data->instructor_hear_id ? 'selected' : '') }}>{{ $hear->name }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="data">
                                                                        <label>Start Date
                                                                        </label>
                                                                        <input name="start_date"
                                                                               class="input--style-1 js-datepicker form-control "
                                                                               type="date"
                                                                               placeholder="BIRTHDATE"

                                                                               value="{{ $become_instructors_form_data->start_date }}">


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- personal information section  -->
                                                    <h2 class="text-center my-5 ">
                                                        Personal Information
                                                    </h2>
                                                    <div class="row">
                                                        <div class="col-md-12 ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="data">
                                                                        <label>
                                                                            First Name*
                                                                        </label>
                                                                        <input
                                                                            class=" form-control "
                                                                            type="text" placeholder=""
                                                                            name="first_name"
                                                                            value="{{ $instructors_personal_info->first_name }}">

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="data">
                                                                        <label>Middle Name
                                                                        </label>
                                                                        <input
                                                                            class=" form-control "
                                                                            type="text" placeholder=""
                                                                            name="middle_name"
                                                                            value="{{ $instructors_personal_info->middle_name }}">

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="data">
                                                                        <label>Last Name*
                                                                        </label>
                                                                        <input
                                                                            class=" form-control "
                                                                            type="text" placeholder=""
                                                                            name="last_name"
                                                                            value="{{ $instructors_personal_info->last_name }}">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="data">
                                                                        <label>Gender*
                                                                        </label>
                                                                        <select name="gender"
                                                                                class="form-select form-control "
                                                                                aria-label="Default select example">
                                                                            <option value="" selected>
                                                                                --SELECT--
                                                                            </option>
                                                                            <option
                                                                                value="Male" {{('Male' ==  $instructors_personal_info->gender ? 'selected' : '') }}>
                                                                                Male
                                                                            </option>
                                                                            <option
                                                                                value="Female" {{('Female' ==  $instructors_personal_info->gender ? 'selected' : '') }}>
                                                                                Female
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row my-4">
                                                        <div class="col-md-12 ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="data">
                                                                        <label>
                                                                            Date of Birth*
                                                                        </label>
                                                                        <input
                                                                            class=" form-control "
                                                                            type="date" placeholder=""
                                                                            name="date_of_birth"
                                                                            value="{{ $instructors_personal_info->date_of_birth }}">

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="data">
                                                                        <label>Email*
                                                                        </label>
                                                                        <input
                                                                            class=" form-control "
                                                                            type="text" placeholder=""
                                                                            name="email"
                                                                            value="{{ $instructors_personal_info->email }}">

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="data">
                                                                        <label>Phone(Home)
                                                                        </label>
                                                                        <input
                                                                            class=" form-control "
                                                                            type="text" placeholder=""
                                                                            name="phone"
                                                                            value="{{ $instructors_personal_info->phone }}">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="data">
                                                                        <label>Cell*
                                                                        </label>
                                                                        <input
                                                                            class=" form-control "
                                                                            type="text" placeholder=""
                                                                            name="cell" value="{{ $instructors_personal_info->cell }}">

                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row my-4">
                                                        <div class="col-md-12 ">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="data">
                                                                        <label>
                                                                            Work
                                                                        </label>
                                                                        <textarea name="work"
                                                                                  class="form-control "
                                                                                  style="height:150px">{{ $instructors_personal_info->work }}</textarea>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <div class="data">
                                                                        <label>
                                                                            Address*
                                                                        </label>
                                                                        <textarea name="address"
                                                                                  class="form-control "
                                                                                  style="height:150px">{{ $instructors_personal_info->address }}</textarea>


                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>


                                                    <div class="container ">
                                                        <h2 class="text-center my-5 ">
                                                            School Information
                                                        </h2>
                                                        <div class="row">
                                                            <div class="col-md-12 ">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="data">
                                                                            <label>
                                                                                High School/GED*
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="text" placeholder=""
                                                                                name="high_school"
                                                                                value="{{ $instructors_school_info->high_school }}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="data">
                                                                            <label>
                                                                                Years Attended*
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="date" placeholder=""
                                                                                name="school_years_attended"
                                                                                value="{{ $instructors_school_info->school_years_attended }}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="data">
                                                                            <label>
                                                                                Graduates*
                                                                            </label>
                                                                            <select name="school_year_graduate"
                                                                                    class="form-select form-control "
                                                                                    aria-label="Default select example">
                                                                                <option value="" selected>
                                                                                    --SELECT--
                                                                                </option>
                                                                                <option
                                                                                    value="yes" {{('yes' ==  $instructors_school_info->school_year_graduate  ? 'selected' : '') }}>
                                                                                    Yes
                                                                                </option>
                                                                                <option
                                                                                    value="no" {{('no' ==  $instructors_school_info->school_year_graduate  ? 'selected' : '') }}>
                                                                                    No
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="data">
                                                                            <label>
                                                                                Degree/Major*
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="text" placeholder=""
                                                                                name="school_degree"
                                                                                value="{{ $instructors_school_info->school_degree }}">

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row my-4">
                                                            <div class="col-md-12 ">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="data">
                                                                            <label>
                                                                                College*
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="text" placeholder=""
                                                                                name="college"
                                                                                value="{{ $instructors_school_info->college }}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="data">
                                                                            <label>
                                                                                Years Attended*
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="date" placeholder=""
                                                                                name="college_email"
                                                                                value="{{ $instructors_school_info->email }}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="data">
                                                                            <label>
                                                                                Graduates*
                                                                            </label>
                                                                            <select name="college_graduate"
                                                                                    class="form-select form-control "
                                                                                    aria-label="Default select example"
                                                                                    >
                                                                                <option value="" selected>
                                                                                    --SELECT--
                                                                                </option>
                                                                                <option
                                                                                    value="yes" {{('yes' ==  $instructors_school_info->college_graduate  ? 'selected' : '') }}>
                                                                                    Yes
                                                                                </option>
                                                                                <option
                                                                                    value="no" {{('no' ==  $instructors_school_info->college_graduate  ? 'selected' : '') }}>
                                                                                    No
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 ">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="data">
                                                                            <label>
                                                                                Trade or Correspondence School*
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="text" placeholder=""
                                                                                name="trade_school"
                                                                                value="{{ $instructors_school_info->trade_school }}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="data">
                                                                            <label>
                                                                                Degree/Major*
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="text" placeholder=""
                                                                                name="trade_degree"
                                                                                value="{{ $instructors_school_info->trade_degree }}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="data">
                                                                            <label>
                                                                                Years Attended*
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="date" placeholder=""
                                                                                name="trade_years_attended"
                                                                                value="{{ $instructors_school_info->trade_years_attended }}">

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="data">
                                                                            <label>
                                                                                Graduates*
                                                                            </label>
                                                                            <select name="trade_year_graduate"
                                                                                    class="form-select form-control "
                                                                                    aria-label="Default select example">
                                                                                <option value="" selected>
                                                                                    --SELECT--
                                                                                </option>
                                                                                <option
                                                                                    value="yes" {{('yes' ==  $instructors_school_info->trade_year_graduate   ? 'selected' : '') }}>
                                                                                    Yes
                                                                                </option>
                                                                                <option
                                                                                    value="no" {{('no' ==  $instructors_school_info->trade_year_graduate   ? 'selected' : '') }}>
                                                                                    No
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Teaching Experience section  -->
                                                    <div class="container ">
                                                        <h2 class="text-center my-5 ">
                                                            Teaching Experience

                                                        </h2>
                                                        <div class="row">
                                                            <div class="col-md-12 ">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="data">
                                                                            <label>
                                                                                Current Position
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="text" placeholder=""
                                                                                name="current_position"
                                                                                value="{{ $instructors_teaching_experience->current_position }}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="data">
                                                                            <label>
                                                                                Phone No
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="number" placeholder=""
                                                                                name="Teach_phone"
                                                                                value="{{ $instructors_teaching_experience->phone }}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="data">
                                                                            <label>
                                                                                Employeer Name
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="text" placeholder=""
                                                                                name="employee_name"
                                                                                value="{{ $instructors_teaching_experience->employee_name }}">

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-md-12 ">
                                                                <div class="row mt-4">
                                                                    <div class="col-md-4">
                                                                        <div class="data">
                                                                            <label>
                                                                                Dates Employer
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="date" placeholder=""
                                                                                name="date_employer"
                                                                                value="{{ $instructors_teaching_experience->date_employer }}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="data">
                                                                            <label>
                                                                                Supervisor Name
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="text" placeholder=""
                                                                                name="supervisor_name"
                                                                                value="{{ $instructors_teaching_experience->supervisor_name }}">

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="data">
                                                                            <label>

                                                                                Upload Resume*
                                                                            </label>
                                                                            <input
                                                                                class=" form-control "
                                                                                type="file" placeholder=""
                                                                                name="upload_resume"
                                                                                accept=".doc,.docx,.pdf"
                                                                                style="line-height: 39px;">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 ">
                                                                <div class="row mt-4">
                                                                    <div class="col-md-6">
                                                                        <div class="data">
                                                                            <label>
                                                                                Cover*
                                                                            </label>
                                                                            <textarea name="cover"
                                                                                      class="form-control "
                                                                                      style="height:150px;">{{ $instructors_teaching_experience->cover }}</textarea>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="data">
                                                                            <label>
                                                                                Address
                                                                            </label>
                                                                            <textarea name="employer_address"
                                                                                      class="form-control "
                                                                                      style="height:150px;">{{ $instructors_teaching_experience->address }}</textarea>

                                                                        </div>
                                                                    </div>

                                                                    <button id="save_button"
                                                                        class="primary-btn fix-gr-bg m-4"
                                                                        type="submit"><span class="ti-check"></span> {{__('common.Update')}}</button>

                                                                </div>
                                                            </div>
                                                        </div>
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
        </div>
    </section>

@endsection
@push('scripts')
<script>
    $("#save_button").click(function () {
        $(this).attr('disabled');
        $(this).find('span').first().remove();
        $(this).find('span').attr('class','').addClass('fa fa-spinner fa-spin fa-lg');
    });
</script>


@endpush
