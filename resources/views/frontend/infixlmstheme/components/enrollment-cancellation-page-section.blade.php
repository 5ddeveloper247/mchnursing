<div>
    <style>
        .theme_select:after {
            top: 25px;
        }
    </style>
    <div class="main_content_iner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="purchase_history_wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{__('common.Enrollment Cancellation')}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <form action="{{route('enrollmentCancellationSubmit')}}" method="post">
                                    <div class="single_totl_warp col-lg-12 pl-0">
                                        @csrf


                                        <div class="input-group mb-3 input-group-lg">

                                            <select class="theme_select w-50  mb_20"
                                                    name="course">
                                                <option data-display="{{__('common.Select')}}  {{__('courses.Course')}}"
                                                        value="">{{__('common.Select')}} {{__('courses.Course')}}</option>
                                                @if(isset($courses))
                                                    @foreach ($courses as $course)
                                                        <option
                                                            value="{{$course->id}}"
                                                        >{{@$course->course->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                            <div class="input-group-prepend">
                                                <button type="submit" style="margin-bottom: 30px;"
                                                        class="theme_btn btn-sm  small_btn2">{{__('common.Submit')}} </button>

                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(count($records)!=0)
        <div class="main_content_iner">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="purchase_history_wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">
                                        <h3 class="mb-0">{{__('common.Enrollment Cancellation')}} {{__('common.History')}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table custom_table3 mb-0">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{__('common.SL')}}</th>
                                                <th scope="col">{{__('courses.Course')}}</th>
                                                <th scope="col">{{__('common.Price')}}</th>
                                                <th scope="col">{{__('courses.Canceled')}} {{__('common.Date')}} </th>
                                                <th scope="col">{{__('common.Refund')}} {{__('common.Status')}} </th>
                                                <th scope="col">{{__('common.Action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($records))
                                                @foreach ($records as $key=>$record)
                                                    <tr>
                                                        <td>{{@$key+1}}</td>
                                                        <td>{{ $record->course->title }}</td>
                                                        <td>{{getPriceFormat($record->purchase_price)}}   </td>
                                                        <td>{{ showDate($record->created_at) }}</td>
                                                        <td>{{$record->refund == 1 ? trans('common.Yes') : trans('common.No')}}</td>

                                                        <td>
                                                            <a class="theme_btn_mini"
                                                               href="{{route('addToCart',[$record->course->id])}}">
                                                                {{__('common.Add To Cart')}}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        <div class="mt-4">
                                            {{ $records->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


</div>
