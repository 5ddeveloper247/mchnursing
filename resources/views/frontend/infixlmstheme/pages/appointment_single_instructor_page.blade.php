@extends(theme('layouts.master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ $instructor->name }}
@endsection
@section('css')

    <link rel="stylesheet"
        href="{{ asset('Modules\Appointment\Resources\assets\frontend\plugins\price-range\ion.rangeslider.min.css') }}" />

    <style>
        .rating {
            border: none;
            float: left;
        }

        .rating>input {
            display: none;
        }

        .rating>label:before {
            margin: 0 3px;
            font-size: 20px;
            font-family: 'FONT AWESOME 5 FREE';
            display: inline-block;
            content: "\f005";
            font-weight: 800;
        }

        .rating>.half:before {
            content: "\f005";
            position: absolute;
        }

        .rating>label {
            color: #ddd;
            float: right;
        }

        /***** CSS Magic to Highlight Stars on Hover *****/
        .rating>input:checked~label,
        /* show gold star when clicked */
        .rating:not(:checked)>label:hover,
        /* hover current star */
        .rating:not(:checked)>label:hover~label {
            color: #FFC107;
        }

        /* hover previous stars in list */
        .rating>input:checked+label:hover,
        /* hover current star when changing rating */
        .rating>input:checked~label:hover,
        .rating>label:hover~input:checked~label,
        /* lighten current selection */
        .rating>input:checked~label:hover~label {
            color: #FFC107;
        }

        .pt-25 {
            padding-top: 25px;
        }

        .star i.unchecked {
            color: #ddd !important;
        }

        .star i.half-checked {}
        .nav-tabs .nav-link.active {
            background:#fff;
        }
        #resume .nav-link {
            background: transparent !important;
        }
        @media only screen and (min-width: 1200px) and  (max-width: 1439px){
            .tutor_listing_details_content_info_card_subheader .nav-item {
                margin: 0px 0px !important;
            }
        }


    </style>
    <link rel="stylesheet" href="{{ asset('Modules\Appointment\Resources\assets\frontend\css\appointment.css') }}" />
@endsection
@section('mainContent')
<input type="hidden" id="url" value="{{ url('/') }}">
    <x-appointment-single-instructor :slug="$slug"/>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>
    <script>
        $(document).ready(function() {

            let timeZone = moment.tz.guess();
            $(document).on('change', '#changeTimeZone', function() {
                changeTimeZone();
            })
            $('#changeTimeZone').val(timeZone).niceSelect('update');

            changeTimeZone();

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

            })

            function changeWeek(next_date, pre_date, first_date_of_week, last_date_of_week, weeknumber) {

                var url = $("#url").val();

                let timeZone = $('#changeTimeZone').val();

                let instructor = "{{ $instructor->slug }}";
                var formData = {
                    instructor: instructor,
                    next_date: next_date,
                    pre_date: pre_date,
                    timeZone: timeZone,
                };
                console.log(formData);
                $('#calender_body').html('');
                $('#calender_pre_loader').removeClass('d-none');
                $.ajax({
                    type: "get",
                    data: formData,
                    dataType: "html",
                    url: url + '/appointment/timezone/user',


                    success: function(data) {

                        $('#calender_body').html(data);
                        $('#weeknumber').html(weeknumber);
                        $("#pre_date").val(first_date_of_week);
                        $("#next_date").val(last_date_of_week);
                        $('#calender_pre_loader').addClass('d-none');

                    },

                    error: function(data) {

                    }

                });

                // change calender date period weekly

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

            }


            function changeTimeZone() {
                let timeZone = $('#changeTimeZone').val();
                let url = $("#url").val();
                let instructor = "{{ $instructor->slug }}";
                formData = {
                    instructor: instructor,
                    timeZone: timeZone,
                }
                $.ajax({
                    type: 'get',
                    data: formData,
                    dataType: 'html',
                    url: url + '/appointment/timezone/user',
                    success: function(data) {
                        $('#calender_body').html('');
                        $('#calender_body').html(data);
                    },
                    error: function(data) {

                    }
                })
            }
            $(document).on('click', '.scheduleBook', function() {
                $(this).addClass('selected');
            })
            
        })
    </script>
@endsection
