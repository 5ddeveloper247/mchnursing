@extends(theme('layouts.dashboard_master'))
@section('title')
    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('common.Enrollment Cancellation')}}
@endsection
@section('css') @endsection
@section('js')

@endsection

@section('mainContent')
    <x-enrollment-cancellation-page-section/>
@endsection
