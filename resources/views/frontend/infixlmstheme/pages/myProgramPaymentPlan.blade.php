@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('My Program Payment Plan')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <div class="main_content_iner main_content_padding">
        <div class="dashboard_lg_card">
            <div class="container-fluid no-gutters">
                <div class="row">
                    <div class="col-12">
                        <div class="p-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">

                                        <h3 class="mb-0">{{ $program->programtitle . __(' Payment Plan') }}</h3>
                                        <h4></h4>
                                    </div>
                                </div>
                            </div>
                            @if(count($plans)==0)
                                <div class="col-12">
                                    <div class="section__title3 margin_50">
                                        <p class="text-center">{{__('No Plan Found')}}!</p>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table custom_table3">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{__('common.SL')}}</th>
                                                    <th scope="col">{{__('Installments')}}</th>
                                                    <th scope="col">{{__('payment.Total Price')}}</th>
                                                    <th scope="col">{{__('Start Date')}}</th>
                                                    <th scope="col">{{__('End date')}}</th>
                                                    <th scope="col">{{__('payment.Invoice')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(isset($plans))
                                                    @foreach ($plans as $plan)

                                                        <tr>
                                                            <td scope="row">{{$plan->type+1}}</td>

                                                            <td>
                                                                @if($plan->type == 0)
                                                                    Initial
                                                                @else
                                                                    Installment {{$plan->type}}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $plan->amount }}
                                                            </td>

                                                            <td>
                                                                {{ $plan->sdate }}

                                                            </td>
                                                            <td>

                                                                {{ $plan->edate }}

                                                            </td>
                                                            <td>

                                                                @if($plan->pay_status == 'paid')
                                                                <a href="javascript:void(0)"
                                                                   class="link_value theme_btn small_btn4">Paid</a>
                                                                @else
                                                                    @if($plan->sdate <= \Carbon\Carbon::now()->format('Y-m-d'))
                                                                        <a href="{{ route('my.payment.plan.installment',[$plan->id,'plan_id'=>$request->plan_id]) }}"
                                                                           class="link_value theme_btn small_btn4" >Pay Now</a>
                                                                    @else
                                                                        <a href="javascript:void(0)"
                                                                           class="link_value theme_btn small_btn4 disabled" >Pay Now</a>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
{{--                                            <div class="mt-4">--}}
{{--                                                {{ $plans->links() }}--}}
{{--                                            </div>--}}
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
