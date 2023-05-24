@extends(theme('layouts.dashboard_master'))
<input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">

@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} |
    @if (routeIs('myAppointment'))
        {{ __('appointment.My Appointment') }}
    @elseif(routeIs('myClasses'))
        {{ __('courses.Live Class') }}
    @elseif(routeIs('myQuizzes'))
        {{ __('courses.My Quizzes') }}
    @else
        {{ __('courses.My Courses') }}
    @endif
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules\Appointment\Resources\assets\frontend\css\appointment.css') }}" />
    <style>
        .selected {
            cursor: pointer;
            padding: 15px;
            border: red;
            color: #fb1159;
            font-size: 25px;
        }

        #calendar_body .modal-header {
            border-radius: 16px 16px 0 0;
            padding: 20px 25px;
            background: url(public/backend/img/modal-header-bg.png) no-repeat 50%;
        }

        #calendar_body .modal-header .close {
            float: none;
            font-size: 14px;
            margin: 0;
            width: 35px;
            height: 35px;
            line-height: 35px;
            background-color: white;
            border-radius: 100%;
        }

        #calendar_body .modal-content {
            border: none;
            border-radius: 16px;
        }

        #calendar_body .modal-header h4 {
            color: #fff;
            margin-bottom: 0;
        }

        #calendar_body .modal-body {
            padding: 25px 30px;
            text-align: left;
            padding: 25px 30px;
            text-align: left;
            background-image: url(public/backend/img/popup_menu_bg.png);
            background-size: cover;
            background-position: bottom;
            border-radius: 0 0 16px 16px;
            background-repeat: no-repeat;
        }

        #calendar_body .modal-body strong {
            font-weight: 500;
            color: var(--system_secendory_color);
            margin-bottom: 5px;
        }
    </style>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.preWeekSchedule', function(e) {
                e.preventDefault();
                $('#pre_loader').removeClass('d-none');
                let next_date = '';
                let pre_date = $("#pre_date").val();
                let last_date_of_week = moment(pre_date).subtract(1, 'd').format('YYYY-MM-DD');
                let first_date_of_week = moment(pre_date).subtract(7, 'd').format('YYYY-MM-DD');
                let weeknumber = moment(first_date_of_week, "YYYY-MM-DD").week();
                changeWeek(next_date, pre_date, first_date_of_week, last_date_of_week, weeknumber);

            })
            $(document).on('click', '.nextWeekSchedule', function(e) {
                e.preventDefault();
                $('#pre_loader').removeClass('d-none');
                let next_date = $("#next_date").val();
                let pre_date = '';
                let first_date_of_week = moment(next_date).add(1, 'd').format('YYYY-MM-DD');
                let last_date_of_week = moment(next_date).add(7, 'd').format('YYYY-MM-DD');
                let weeknumber = moment(first_date_of_week, "YYYY-MM-DD").week();
                let weekNumber = weeknumber - 1;
                changeWeek(next_date, pre_date, first_date_of_week, last_date_of_week, weeknumber);
                console.log(next_date);

            })

            function changeWeek(next_date, pre_date, first_date_of_week, last_date_of_week, weeknumber) {

                var url = $("#url").val();

                let timeZone = $('#changeTimeZone').val();

                let instructor = 1;
                var formData = {
                    instructor: instructor,
                    next_date: next_date,
                    pre_date: pre_date,
                    timeZone: timeZone,
                };
                console.log(formData);
                $('#calendar_body').html('');
                $('#calender_pre_loader').removeClass('d-none');
                $.ajax({
                    type: "get",
                    data: formData,
                    dataType: "html",
                    url: url + '/appointment/timezone/change-calendar',
                    success: function(data) {
                        $('#calendarChanges').html(data);
                    },
                    error: function(data) {

                    }

                });
                $.ajax({
                    type: "get",
                    data: formData,
                    dataType: "html",
                    url: url + '/change-calendar',


                    success: function(data) {

                        $('#calendar_body').html(data);
                        $('#weeknumber').html(weeknumber);
                        $("#pre_date").val(first_date_of_week);
                        $("#next_date").val(last_date_of_week);
                        $('#calender_pre_loader').addClass('d-none');

                    },

                    error: function(data) {

                    }

                });


            }

        })
    </script>
@endsection

@section('mainContent')
    <x-appointment-my-appointment-page-section :request="$request" />
@endsection
