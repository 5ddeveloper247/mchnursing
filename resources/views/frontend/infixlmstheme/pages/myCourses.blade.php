<style>
    .section__title3 h3{
        /* font-size: 99px; */
    }
    .theme_btn6 {
    background: var(--system_primery_color);
    border-radius: 5px;
    font-family: Source Sans Pro,sans-serif;
    font-size: 15px!important;
    color: #fff;
    font-weight: 600;
    padding: 11px 8px!important;
    border: 1px solid transparent;
    text-transform: capitalize;
    display: inline-block;
    line-height: 1;
    }


h4 {
    font-size: 13px;
    line-height: 25px;
}
.couse_wizged .thumb {
    position: relative;
    overflow: hidden;
    height: 350px!important;
}
.couse_wizged .course_content {
    padding-top: 26px;
    padding-right: 0px!important;

}
@media(max-width:2000px){
    .couse_wizged .thumb {
    position: relative;
    overflow: hidden;
    height: 350px!important;
}
@media(max-width:1800px){
    .couse_wizged .thumb {
    position: relative;
    overflow: hidden;
    height: 35`0px!important;
}
}
</style>
@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} |
@if( routeIs('myClasses'))
    {{__('courses.Live Class')}}
@elseif( routeIs('myQuizzes'))
    {{__('courses.My Quizzes')}}
@else
    {{__('My Programs')}}
@endif @endsection
@section('css')

@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/my_course.js')}}"></script>
@endsection

@section('mainContent')
    <x-my-courses-page-section :request="$request"/>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script>
$(document).ready(function(){
$('.bandsha').removeClass('bandsha');
$('.theme_btn').removeClass('theme_btn');
$('.small_btn4').addClass('theme_btn6');
$('form').css({"display": "none"});
$("h4").css("fontSize", "14px!important");
});
</script>
