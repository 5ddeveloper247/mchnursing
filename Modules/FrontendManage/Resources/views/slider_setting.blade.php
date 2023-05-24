@extends('backend.master')

@section('table')
    @php
        $currentTheme = currentTheme();
        if($currentTheme=='wetech'){
                $currentTheme='infixlmstheme';
            }
            $table_name='sliders';
    @endphp
    {{$table_name}}
@stop
@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12 ">


                    <div class="">
                        <div class="row">

                            <div class="col-lg-12">
                                <!-- tab-content  -->
                                <div class="tab-content " id="myTabContent">
                                    <!-- General -->
                                    <div class="tab-pane fade white_box_30px show active" id="Activation"
                                         role="tabpanel" aria-labelledby="Activation-tab">
                                        <div class="main-title mb-25">


                                            <form action="{{route('frontend.sliders.setting')}}" id="" method="POST"
                                                  enctype="multipart/form-data">

                                                @csrf
                                                <div class="single_system_wrap">


                                                    @if(hasDynamicPage())
                                                        <div class="row">

                                                            <div class="col-xl-4">
                                                                <div
                                                                    class="primary_input mb-25">
                                                                    <img
                                                                        class="  imagePreview5"
                                                                        style="max-width: 100%"
                                                                        src="{{ asset('/'.getRawHomeContents($home_content,'slider_banner','en'))}}"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-8">
                                                                <div
                                                                    class="primary_input mb-25">
                                                                    <label
                                                                        class="primary_input_label"
                                                                        for="">{{ __('frontendmanage.Homepage Banner') }}
                                                                        <small>({{__('common.Recommended Size')}}
                                                                            @if($currentTheme!="Edume")
                                                                                1920x500
                                                                            @else
                                                                                570x610
                                                                            @endif
                                                                                                                                                                                       )
                                                                        </small>
                                                                    </label>
                                                                    <div
                                                                        class="primary_file_uploader">
                                                                        <input
                                                                            class="primary-input  filePlaceholder {{ @$errors->has('slider_banner') ? ' is-invalid' : '' }}"
                                                                            type="text"
                                                                            id=""
                                                                            placeholder="Browse file"
                                                                            readonly="" {{ $errors->has('slider_banner') ? ' autofocus' : '' }}>
                                                                        <button class=""
                                                                                type="button">
                                                                            <label
                                                                                class="primary-btn small fix-gr-bg"
                                                                                for="file5">{{ __('common.Browse') }}</label>
                                                                            <input
                                                                                type="file"
                                                                                class="d-none fileUpload imgInput5"
                                                                                name="slider_banner"
                                                                                id="file5">
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-3">

                                                                <div class="mb_25">
                                                                    <label
                                                                        class="switch_toggle "
                                                                        for="show_menu_search_box">
                                                                        <input
                                                                            type="checkbox"
                                                                            class="status_enable_disable"
                                                                            name="show_menu_search_box"
                                                                            id="show_menu_search_box"
                                                                            @if (@getRawHomeContents($home_content,'show_menu_search_box','en') == 1) checked
                                                                            @endif value="1">
                                                                        <i class="slider round"></i>


                                                                    </label>
                                                                    {{__('frontendmanage.Show Menu Search Box')}}

                                                                </div>


                                                            </div>

                                                            @if($currentTheme=="infixlmstheme")
                                                                <div class="col-xl-3">

                                                                    <div class="mb_25">
                                                                        <label
                                                                            class="switch_toggle "
                                                                            for="show_banner_search_box">
                                                                            <input
                                                                                type="checkbox"
                                                                                class="status_enable_disable"
                                                                                name="show_banner_search_box"
                                                                                id="show_banner_search_box"
                                                                                @if (@getRawHomeContents($home_content,'show_banner_search_box','en') == 1) checked
                                                                                @endif value="1">
                                                                            <i class="slider round"></i>


                                                                        </label>
                                                                        {{__('frontendmanage.Show Banner Search Box')}}

                                                                    </div>
                                                                </div>
                                                            @endif


                                                        </div>

                                                        <hr>
                                                    @endif

                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <div class="row">
                                                                    <div class="col-md-12 mb-3">
                                                                        <label class="primary_input_label"
                                                                               for="">  {{__('frontendmanage.Slider')}} {{__('common.Transition time')}}</label>
                                                                    </div>
                                                                    <div class="col-md-6 mb-25">
                                                                        <input class="primary_input_field"
                                                                               placeholder="{{__('common.Transition time')}}"
                                                                               type="number"
                                                                               name="slider_transition_time"
                                                                               min="1"
                                                                               value="{{Settings('slider_transition_time')?Settings('slider_transition_time'):5}}">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="submit_btn  mt-4">
                                                    <button class="primary-btn small fix-gr-bg" type="submit"
                                                            data-toggle="tooltip" title="" id="general_info_sbmt_btn"><i
                                                            class="ti-check"></i> {{__('common.Save')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>


                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    @include('backend.partials.delete_modal')
@endsection
@push('scripts')

@endpush
