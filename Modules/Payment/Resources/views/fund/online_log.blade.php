@extends('backend.master')
@section('table')
    @php
        $table_name='checkouts';
    @endphp
    {{$table_name}}
@stop

@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-between">
                <div class="col-lg-12">
                    <div class="white_box mb_30">
                        <div class="white_box_tittle list_header">
                            <h4>{{__('courses.Advanced Filter')}} </h4>
                        </div>
                        <form action="{{route('filterSearch')}}" method="POST">
                            @csrf
                            <div class="row">

                                <div class="col-lg-4 mt-30">
                                    <select class="primary_select" name="methods">
                                        <option data-display="{{__('common.Select')}} {{__('payment.Method')}}"
                                                value="">{{__('common.Select')}} {{__('payment.Method')}}</option>
                                        <option value="all" selected>{{__('payment.All')}}</option>
                                        @foreach($gateways as $gateway)
                                            @if($gateway->method!='Bank Payment')
                                                <option value="{{$gateway->method}}"
                                                        @if(isset($_POST['methods']) && $_POST['methods']==$gateway->method)selected @endif>
                                                    {{$gateway->method}}
                                                </option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-xl-4 col-md-4 col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label"
                                               for="startDate">{{__('common.Start Date')}}</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="Date"
                                                               class="primary_input_field primary-input date form-control"
                                                               id="startDate" type="text" name="start_date"
                                                               value="@if(isset($_POST['start_date'])){{$_POST['start_date']}} @else{{date('m/d/Y')}}@endif"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label"
                                               for="admissionDate">{{__('common.End Date')}}</label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input placeholder="Date"
                                                               class="primary_input_field primary-input date form-control"
                                                               id="admissionDate" type="text" name="end_date"
                                                               value="@if(isset($_POST['end_date'])){{$_POST['end_date']}} @else{{date('m/d/Y')}}@endif"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                                <button class="" type="button">
                                                    <i class="ti-calendar" id="admission-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 mt-20">
                                    <div class="search_course_btn text-right">
                                        <button type="submit"
                                                class="primary-btn radius_30px mr-10 fix-gr-bg">{{__('courses.Filter')}} </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mt-40 mb-25">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-0">{{__('payment.Received Online')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
            <div class="QA_section QA_section_heading_custom check_box_table mt-30">
                <div class="QA_table table-responsive ">

                    <table id="lms_table" class="table Crm_table_active3">
                        <thead>
                        <tr>
                            <th scope="col">{{__('payment.Transaction')}}</th>
                            <th scope="col">{{__('common.User')}}</th>
                            <th scope="col">{{__('payment.Request Date')}}</th>
                            <th scope="col">{{__('payment.Total')}} {{__('payment.Amount')}}</th>
{{--                            <th scope="col">{{__('common.Paid')}} {{__('payment.Amount')}}</th>--}}
{{--                            <th scope="col">  {{__('tax.TAX')}}</th>--}}
                            <th scope="col">{{__('payment.Payment')}} {{__('payment.Method')}}</th>
                            {{--                            <th scope="col">{{__('common.Status')}}</th>--}}
                            <th scope="col">{{__('Action')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($onlineLogs as $log)
                            <tr>
                                <th scope="row">
                                    {{@$log->tracking}}
                                </th>
                                <td>{{@$log->user->name}}</td>
                                <td>{{@$log->dateFormat}}</td>
                                <td> {{getPriceFormat($log->price,false)}}</td>
{{--                                <td>{{getPriceFormat($log->purchase_price,false)}}</td>--}}
{{--                                <td>{{getPriceFormat($log->tax,false)}}</td>--}}
                                <td> {{@$log->payment_method }}</td>
                                <th>
                                    <a href="{{route('invoice',$log->id)}}" class="primary-btn fix-gr-bg radius_30px text-white"
                                    >
                                        View
                                    </a>
                                </th>
                            </tr>

                        @endforeach
                        @if(count($onlineLogs)!=0)
                            <tr>
                                <td>{{__('common.Total')}}</td>
                                <td></td>
                                <td></td>
                                <td> {{getPriceFormat($onlineLogs->sum('price'),false)}}</td>
{{--                                <td> {{getPriceFormat($onlineLogs->sum('purchase_price'),false)}}</td>--}}
{{--                                <td> {{getPriceFormat($onlineLogs->sum('tax'),false   )}}</td>--}}
                                <td></td>

                            </tr>
                        @endif
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </section>

@endsection

