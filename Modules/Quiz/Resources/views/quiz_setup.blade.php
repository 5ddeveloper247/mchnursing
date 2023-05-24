@extends('backend.master')
@section('mainContent')
    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-title">
                                <h3 class="mb-30">
                                    {{__('quiz.Quiz Setup')}}
                                </h3>
                            </div>

                            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'quizSetup.store','method' => 'POST', 'enctype' => 'multipart/form-data']) }}

                            <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-4 mt-40">
                                            <ul class="permission_list">
                                                <li>
                                                    <label class="primary_checkbox d-flex mr-12 ">
                                                        <input name="set_per_question_time"
                                                               @if (@$quiz_setup->set_per_question_time==1) checked
                                                               @endif value="1" onChange="setQuestionTime()"
                                                               id="set_question_time" type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p for="#set_question_time">{{trans('quiz.Per Question time count')}}</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-4">
                                            @if ($quiz_setup->set_per_question_time==1)
                                                <div class="form-group" id="per_question_time">
                                                    <label
                                                        for="set_time_per_question">{{trans('quiz.Per Question Time Count (Minute)')}}</label>
                                                    <input type="text" class="primary_input_field name"
                                                           name="set_time_per_question"
                                                           value="{{@$quiz_setup->time_per_question}}"
                                                           id="set_time_per_question"
                                                           aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group" id="total_question_time" style="display: none">
                                                    <label
                                                        for="set_time_total_question">{{trans('quiz.Total Quiz time count (Minute)')}}</label>
                                                    <input type="text" class="primary_input_field name"
                                                           name="set_time_total_question"
                                                           value="{{@$quiz_setup->time_total_question}}"
                                                           id="set_time_total_question"
                                                           aria-describedby="helpId" placeholder="">
                                                </div>
                                            @else
                                                <div class="form-group" id="per_question_time" style="display: none">
                                                    <label
                                                        for="set_time_per_question">{{trans('quiz.Per Question Time Count (Minute)')}}</label>
                                                    <input type="text" class="primary_input_field name"
                                                           name="set_time_per_question"
                                                           value="{{@$quiz_setup->time_per_question}}"
                                                           id="set_time_per_question"
                                                           aria-describedby="helpId" placeholder="">
                                                </div>
                                                <div class="form-group" id="total_question_time">
                                                    <label
                                                        for="set_time_total_question">{{trans('quiz.Total Quiz time count (Minute)')}}</label>
                                                    <input type="text" class="primary_input_field name"
                                                           name="set_time_total_question"
                                                           value="{{@$quiz_setup->time_total_question}}"
                                                           id="set_time_total_question"
                                                           aria-describedby="helpId" placeholder="">
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-lg-4 mt-40">
                                            <ul class="permission_list">
                                                <li>
                                                    <label class="primary_checkbox d-flex mr-12 ">
                                                        <input name="question_review"
                                                               @if (@$quiz_setup->question_review==1) checked
                                                               @endif value="1" id="questionReview"
                                                               onChange="changeQuestionReview()" type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p for="#set_question_time">{{trans('quiz.Question Review')}} </p>
                                                </li>
                                                <small id="helpId" class="form-text text-muted">{{trans('quiz.Note')}}
                                                    : {{trans('quiz.If you enable this option, show result: after each submit will disabled')}}</small>
                                            </ul>
                                        </div>
                                        @php
                                            if($quiz_setup->question_review!=1){
                                                    $show_result_each='';
                                            }else{
                                                $show_result_each='style=display:none';
                                            }
                                        @endphp
                                        <div class="col-lg-4 mt-40" {{@$show_result_each}} id="showResultDiv">
                                            <ul class="permission_list">
                                                <li>
                                                    <label class="primary_checkbox d-flex mr-12 ">
                                                        <input name="show_result_each_submit"
                                                               @if (@$quiz_setup->show_result_each_submit==1) checked
                                                               @endif value="1" type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p for="#set_question_time">{{trans('quiz.Show Results After Each Submit')}} </p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-4 mt-40">
                                            <ul class="permission_list">
                                                <li>
                                                    <label class="primary_checkbox d-flex mr-12 ">
                                                        <input name="random_question"
                                                               @if (@$quiz_setup->random_question==1) checked
                                                               @endif value="1" type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p for="#set_question_time">{{trans('quiz.Random Question')}} </p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-4 mt-40">
                                            <ul class="permission_list">
                                                <li>
                                                    <label class="primary_checkbox d-flex mr-12 ">
                                                        <input name="multiple_attend"
                                                               @if (@$quiz_setup->multiple_attend==1) checked
                                                               @endif value="1" type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p for="#set_question_time">{{trans('quiz.Multiple Attend')}} </p>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-lg-4 mt-40">
                                            <ul class="permission_list">
                                                <li>
                                                    <label class="primary_checkbox d-flex mr-12 ">
                                                        <input name="show_ans_with_explanation"
                                                               @if (@$quiz_setup->show_ans_with_explanation==1) checked
                                                               @endif value="1" type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p for="#show_ans_with_explanation">{{trans('quiz.Same Page Show Question & Explanation')}} </p>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-lg-4 mt-40">
                                            <ul class="permission_list">
                                                <li>
                                                    <label class="primary_checkbox d-flex mr-12 ">
                                                        <input name="show_ans_sheet"
                                                               @if (@$quiz_setup->show_ans_sheet==1) checked
                                                               @endif value="1" type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <p for="#show_ans_sheet">{{trans('quiz.See Answer Sheet')}} </p>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-3 mt-40">
                                                    <ul class="permission_list">
                                                        <li>
                                                            <label class="primary_checkbox d-flex mr-12 text-nowrap ">
                                                                <input
                                                                    name="losing_focus_acceptance_number_check"
                                                                    class="losing_focus_acceptance_number_check"
                                                                    @if (@$quiz_setup->losing_focus_acceptance_number>0) checked
                                                                    @endif
                                                                    value="1"
                                                                    type="checkbox"
                                                                >

                                                                <span class="checkmark"></span>

                                                                <span
                                                                    class="pl-3"> {{trans('quiz.Losing focus acceptance')}}</span>
                                                            </label>

                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-8 losing_total_count_div">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <label class="primary_input_label"
                                                                   for="groupInput">{{__('quiz.Losing type')}} *</label>
                                                            <select
                                                                class="primary_select "
                                                                onChange="setLosingQuestionTime()"
                                                                name="losing_type" id="losingType">
                                                                <option
                                                                    value="0"
                                                                    @if (@$quiz_setup->losing_type!=1) selected
                                                                    @endif>{{__('quiz.Per Question Time')}}
                                                                </option>
                                                                <option
                                                                    @if (@$quiz_setup->losing_type==1) selected
                                                                    @endif
                                                                    value="1">{{__('quiz.Total Question Time')}}
                                                                </option>

                                                            </select>

                                                        </div>

                                                        <div class="col-lg-6">
                                                            <label
                                                                for="#">

                                                        <span id="losingPerQusCount"
                                                              style="display: {{$quiz_setup->losing_type!=1?'block':'none'}}">
                                                               {{trans('quiz.Per Question time count')}}
                                                        </span>
                                                                <span id="losingTotalQusCount"
                                                                      style="display: {{$quiz_setup->losing_type==1?'block':'none'}}">
                                                               {{trans('quiz.Total Quiz time count')}}
                                                        </span>

                                                            </label>
                                                            <input class="primary_input_field name"
                                                                   name="losing_focus_acceptance_number"
                                                                   value="{{$quiz_setup->losing_focus_acceptance_number??0}}"
                                                                   type="number">
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip">
                                                <span class="ti-check"></span>
                                                {{__('quiz.Save Setup')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <div id="edit_form">

    </div>
    <div id="view_details">

    </div>

    {{-- @include('coupons::create') --}}
    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script src="{{asset('public/backend/js/manage_quiz.js').assetVersion()}}"></script>
@endpush
