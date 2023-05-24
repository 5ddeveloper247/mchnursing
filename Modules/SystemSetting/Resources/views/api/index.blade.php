@extends('backend.master')

@section('mainContent')

    {!! generateBreadcrumb() !!}


    <section class="mb-20 student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">

                    <div class="payment_getway_tab ">
                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3" role="tablist">
                            <li class="nav-item m-1">
                                <a class="nav-link active"
                                   href="#lmsKey"
                                   role="tab" data-toggle="tab">{{__('setting.LMS Key')}}</a>
                            </li>
                            <li class="nav-item m-1">
                                <a class="nav-link "
                                   href="#googleMap"
                                   role="tab" data-toggle="tab">{{__('setting.Google')}} {{__('setting.Map')}}</a>
                            </li>

                            <li class="nav-item m-1">
                                <a class="nav-link"
                                   href="#fixer"
                                   role="tab" data-toggle="tab">{{__('setting.Fixer')}}</a>
                            </li>

                            <li class="nav-item m-1">
                                <a class="nav-link"
                                   href="#fcm"
                                   role="tab" data-toggle="tab">{{__('setting.FCM')}}</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab panes -->
                    <div class="tab-content">


                        <div role="tabpanel" class="tab-pane fade active show "
                             id="lmsKey">
                            @if (permissionCheck('save.api.setting'))
                                <form class="form-horizontal" action="{{route('api-key.setting')}}"
                                      method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="white-box">
                                        <div class="col-md-12 ">
                                            <div class="row mb-30">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-lg-10 ">

                                                            <div class="primary_input mb-15">
                                                                <label class="primary_input_label"
                                                                       for="">{{__('setting.App Key')}}</label>
                                                                <input class="primary_input_field "
                                                                       type="text" name="api_key" id="inputKey"
                                                                       autocomplete="off"
                                                                       value="{{Settings('api_key')}}">
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-2 mb-30">
                                                            <button type="button" id="generateNewKey"
                                                                    class="primary-btn small fix-gr-bg mt-40">
                                                                <span class="ti-plus pr-2"></span>
                                                                {{__('setting.Generate')}}
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-40">
                                                <div class="col-lg-12 text-center">
                                                    <button type="button" id="confirmBtn" class="primary-btn fix-gr-bg">
                                                        <span class="ti-check"></span>
                                                        {{__('common.Update')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>

                        <div role="tabpanel" class="tab-pane fade "
                             id="googleMap">
                            @if (permissionCheck('save.api.setting'))
                                <form class="form-horizontal" action="{{route('save.api.setting')}}"
                                      method="POST" enctype="multipart/form-data">
                                    @endif
                                    @csrf
                                    <div class="white-box">
                                        <div class="col-md-12 ">
                                            <div class="row mb-30">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-30">
                                                            <div class="input-effect">
                                                                <input class="primary-input form-control "
                                                                       type="text" name="gmap_key"
                                                                       autocomplete="off"
                                                                       value="{{Settings('gmap_key')}}">
                                                                <label>{{__('setting.Google Map API Key')}}
                                                                    <span></span> </label>
                                                                <span class="focus-border"></span>
                                                                <span
                                                                    class="text-danger">{{$errors->first('gmap_key')}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 mb-30">
                                                            <div class="input-effect">
                                                                <input class="primary-input form-control"
                                                                       type="number" name="zoom_level"
                                                                       id="zoom_level" autocomplete="off"
                                                                       value="{{Settings('zoom_level')}}">
                                                                <label>{{__('setting.Zoom Level')}}
                                                                    <span></span> </label>
                                                                <span class="focus-border"></span>
                                                                <span
                                                                    class="text-danger">{{$errors->first('zoom_level')}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 mb-30">
                                                            <div class="input-effect">
                                                                <input class="primary-input form-control "
                                                                       type="text" name="lat"
                                                                       autocomplete="off"
                                                                       value="{{Settings('lat')}}">
                                                                <label>{{__('setting.Latitude')}}
                                                                    <span></span> </label>
                                                                <span class="focus-border"></span>
                                                                <span
                                                                    class="text-danger">{{$errors->first('lat')}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 mb-30">
                                                            <div class="input-effect">
                                                                <input class="primary-input form-control"
                                                                       type="text" name="lng"
                                                                       id="lng" autocomplete="off"
                                                                       value="{{Settings('lng')}}">
                                                                <label>{{__('setting.Longitude')}}
                                                                    <span></span> </label>
                                                                <span class="focus-border"></span>
                                                                <span
                                                                    class="text-danger">{{$errors->first('lng')}}</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <code><a target="_blank" title="Google map api key"
                                                                     href="https://developers.google.com/maps/documentation/javascript/get-api-key">{{__('setting.Click Here to Get Google Map Api Key')}}</a></code>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-40">
                                                <div class="col-lg-12 text-center">
                                                    <button class="primary-btn fix-gr-bg">
                                                        <span class="ti-check"></span>
                                                        {{__('common.Update')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fade"
                             id="fixer">
                            @if (permissionCheck('paymentmethodsetting.payment_method_setting_update'))
                                <form class="form-horizontal" action="{{route('save.api.setting')}}"
                                      method="POST" enctype="multipart/form-data">
                                    @endif
                                    @csrf
                                    <div class="white-box">
                                        <div class="col-md-12 ">
                                            <div class="row mb-30">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-10">
                                                            <div class="input-effect">
                                                                <input class="primary-input form-control"
                                                                       type="text" name="fixer_key"
                                                                       autocomplete="off"
                                                                       value="{{Settings('fixer_key')}}">
                                                                <label>{{__('setting.Fixer Key')}}
                                                                    <span></span> </label>
                                                                <span class="focus-border"></span>
                                                                <span class="modal_input_validation red_alert"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <code><a target="_blank"
                                                                     title="Foreign exchange rates and currency conversion"
                                                                     href="https://fixer.io/">{{__('setting.Click Here to Get Fixer Api Key')}}</a></code>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-40">
                                                <div class="col-lg-12 text-center">
                                                    <button class="primary-btn fix-gr-bg">
                                                        <span class="ti-check"></span>
                                                        {{__('common.Update')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>

                        <div role="tabpanel" class="tab-pane fade"
                             id="fcm">
                            @if (permissionCheck('paymentmethodsetting.payment_method_setting_update'))
                                <form class="form-horizontal" action="{{route('save.api.setting')}}"
                                      method="POST" enctype="multipart/form-data">
                                    @endif
                                    @csrf
                                    <div class="white-box">
                                        <div class="col-md-12 ">
                                            <div class="row mb-30">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-10">
                                                            <div class="input-effect">
                                                                <input class="primary-input form-control"
                                                                       type="text" name="fcm_key"
                                                                       autocomplete="off" va
                                                                       value="{{Settings('fcm_key')}}">
                                                                <label>{{__('setting.FCM Secret key')}}
                                                                    <span></span> </label>
                                                                <span class="focus-border"></span>
                                                                <span class="modal_input_validation red_alert"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <code><a target="_blank"
                                                                     title=""
                                                                     href="https://console.firebase.google.com/">{{__('setting.Click Here to Get Firebase Cloud Messaging(FCM) Api Secret Key')}}</a></code>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-40">
                                                <div class="col-lg-12 text-center">
                                                    <button class="primary-btn fix-gr-bg">
                                                        <span class="ti-check"></span>
                                                        {{__('common.Update')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade admin-query" id="AppKeyModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('common.Confirmation')</h4>
                    <button type="button" class="close" data-dismiss="modal"><i class="ti-close"></i></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <strong>{{__('common.Update')}} {{__('setting.API Key')}}</strong>
                        <h4>@lang('setting.are_you_sure_to_change_api_key')</h4>
                    </div>

                    <div class="mt-40 justify-content-between">
                        <form id="activate_form" action="{{route('api-key.setting')}}" method="POST">
                            @csrf
                            <input type="hidden" id="appKeyUpdateInput" name="api_key" value="">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label"
                                               for="title">{{__('common.Enter Password')}} <span
                                                class="text-danger">*</span></label>
                                        <input required type="password" id="password"
                                               class="primary_input_field" name="password" autocomplete="off"
                                               value="" placeholder="{{__('common.Enter Password')}} ">

                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="primary_input">
                                    <button type="submit" class="primary-btn fix-gr-bg"
                                            id="save_button_parent">{{ __('common.Confirm') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).on("click", "#confirmBtn", function (e) {
            e.preventDefault();
            let key = $('#inputKey').val();
            $('#appKeyUpdateInput').val(key);
            $('#AppKeyModal').modal('show');
        });


        $("#generateNewKey").click(function () {
            let key = $('#inputKey');
            let possible = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

            let generate_key = '';
            for (let i = 0; i < 64; i++) {
                generate_key += possible.charAt(Math.floor(Math.random() * possible.length));
            }

            key.val(generate_key)
        });


    </script>
@endpush

