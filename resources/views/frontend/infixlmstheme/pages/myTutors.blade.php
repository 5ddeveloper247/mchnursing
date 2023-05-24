@extends(theme('layouts.dashboard_master'))
@section('title')
    {{ Settings('site_title') ? Settings('site_title') : 'Infix LMS' }} | {{ __('My Tutors') }}
@endsection
@section('css')
@endsection
@section('js')
@endsection

@section('mainContent')

    <div>
        <div class="main_content_iner main_content_padding">
            <div class="dashboard_lg_card">
                <div class="container-fluid no-gutters">
                    <div class="my_courses_wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 margin-50">
                                    <h3>

                                        {{ __('Tutors') }}

                                    </h3>
                                </div>
                            </div>


                        </div>

                        <div class="row">

                            @if (isset($tutors))
                                @foreach ($tutors as $tutor)
                                    <div class="col-xl-4 col-md-6">

                                        <div class="couse_wizged">
                                            <div class="thumb">
                                                <div class="thumb_inner lazy"
                                                    data-src="{{ getCourseImage($tutor->instructor->image) }}">

                                                </div>

                                            </div>
                                            <div class="course_content px-0">
                                                <div class="d-flex justify-content-between">
                                                    <a
                                                        href="{{ route('tutorDetails', [$tutor->instructor->id, \Illuminate\Support\Str::slug($tutor->instructor->name, '-')]) }}">
                                                        <h4 class="noBrake" title=" {{ $tutor->instructor->name }}">
                                                            {{ $tutor->instructor->name }}
                                                        </h4>
                                                    </a>

                                                    <div class="d-flex align-items-center gap_15">
                                                        <div class="progress_percent flex-fill text-right">
                                                            @php
                                                                if (\Carbon\Carbon::parse($tutor->assign_date)->format('d-m-Y') == \Carbon\Carbon::now()->format('d-m-Y')) {
                                                                    if (\Carbon\Carbon::parse($tutor->assign_start_time)->format('H:i:s') <= \Carbon\Carbon::now()->format('H:i:s') && \Carbon\Carbon::now()->format('H:i:s') <= \Carbon\Carbon::parse($tutor->assign_end_time)->format('H:i:s')) {
                                                                        $currentstat = 'started';
                                                                    } elseif (\Carbon\Carbon::parse($tutor->assign_start_time)->format('H:i:s') > \Carbon\Carbon::now()->format('H:i:s')) {
                                                                        $currentstat = 'waiting';
                                                                    } else {
                                                                        $currentstat = 'closed';
                                                                    }
                                                                } else {
                                                                    $currentstat = 'closed';
                                                                }
                                                                 if (\Carbon\Carbon::parse($tutor->assign_date)->format('d-m-Y') > \Carbon\Carbon::now()->format('d-m-Y')) {
                                                                       $currentstat = 'waiting';
                                                                 }
                                                            @endphp
                                                            @if ($currentstat == 'started')
                                                                <a href="{{ $tutor->meeting_join_url }}"
                                                                    class="link_value theme_btn small_btn4">Join</a>
                                                            @elseif($currentstat == 'waiting')
                                                                <a href="#"
                                                                    class="link_value theme_btn bg-info small_btn4">Waiting</a>
                                                            @else
                                                                <a href="#"
                                                                    class="link_value bg-warning theme_btn small_btn4 border-warning text-black-50">Closed</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="course_less_students mt-3">
                                                    <ul>
                                                        <li>
                                                            <div class="d-inline">Date:</div>
                                                            <div class="d-inline float-right">
                                                                {{ \Carbon\Carbon::parse($tutor->assign_date)->format('d M Y') }}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="d-inline">Start Time:</div>
                                                            <div class="d-inline float-right">
                                                                {{ $tutor->assign_start_time }}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="d-inline">End Time:</div>
                                                            <div class="d-inline float-right">
                                                                {{ $tutor->assign_end_time }}
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="d-inline">End Time:</div>
                                                            <div class="d-inline float-right">
                                                                {{ $tutor->course->title ?? 'Delete Course' }}
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    {{-- {{ \Carbon\Carbon::parse($tutor->assign_date)->format('d M Y') . ' ' . $tutor->assign_start_time . ' ' . $tutor->assign_end_time }} --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif


                        </div>
                        <div class="mt-4 my-4">
                            {{ $tutors->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
