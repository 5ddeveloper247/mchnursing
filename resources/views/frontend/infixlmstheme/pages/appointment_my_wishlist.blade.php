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
@endsection


@section('mainContent')

    <x-appointment-my-wishlist-page-section :request="$request" />
@endsection
