{{-- @extends(theme('layouts.master')) --}}
{{-- @section('title') --}}
{{--    {{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{$row->title}} --}}
{{-- @endsection --}}
{{-- @section('css') --}}

{{--    @if (currentTheme() == 'infixlmstheme') --}}
{{--        <link rel="stylesheet" type="text/css" data-type="aoraeditor-style" --}}
{{--              href="{{ asset('public/frontend/infixlmstheme/css/frontend_style.css') }}"> --}}
{{--    @endif --}}

{{-- @endsection --}}

{{-- @section('mainContent') --}}

{{--    {!! $details??'' !!} --}}
{{-- @endsection --}}

{{-- @section('js') --}}

{{--    <script type="text/javascript" --}}
{{--            src="{{asset('Modules/AoraPageBuilder/Resources/assets/js/aoraeditor.js')}}"></script> --}}
{{--    <script type="text/javascript" --}}
{{--            src="{{asset('Modules/AoraPageBuilder/Resources/assets/js/aoraeditor-components.js')}}"></script> --}}


{{--    <script type="text/javascript" data-aoraeditor="script"> --}}
{{--        $(function () { --}}
{{--            KEditor.loadDynamicContent($('.dynamicData')); --}}

{{--        }); --}}
{{--    </script> --}}

{{-- @endsection --}}

@extends('aorapagebuilder::layouts.master')

@section('content')
    {!! htmlspecialchars_decode($details) !!}
    @include(theme('partials._custom_footer'))
@endsection


@section('scripts')
    <script src="{{ asset('public/frontend/infixlmstheme/js/courses.js') }}"></script>
    {{--    <script type="text/javascript" data-aoraeditor="script"> --}}
    {{--        $(function () { --}}
    {{--            aoraEditor.loadDynamicContent($('.dynamicData')); --}}

    {{--        }); --}}
    {{--    </script> --}}
@endsection
