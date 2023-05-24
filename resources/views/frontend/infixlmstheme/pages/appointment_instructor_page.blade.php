@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('appointment.Instructors')}} @endsection
@section('css') 
<link rel="stylesheet" href="{{asset('Modules\Appointment\Resources\assets\frontend\css\appointment.css')}}"/>
<link rel="stylesheet" href="{{asset('Modules\Appointment\Resources\assets\frontend\plugins\price-range\ion.rangeslider.min.css')}}"/>
@endsection

@section('js')

<script src="{{asset('Modules\Appointment\Resources\assets\js\filter.js')}}"></script>
<script>
    $(document).ready(function(){
        
        $("#price_range").ionRangeSlider({
        
            min: 20,
            max: 1000,
        });
    })

</script>
@endsection
@section('mainContent')
   
    <x-appointment-breadcrumb :request="$request"/>

    <x-appointment-instructor-page-section :request="$request" :categories="$categories"
    :levels="$levels"/>
@endsection

