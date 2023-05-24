<div class="aoraeditor-skip aoraeditor-footer">
    <x-popup-content />
    {{-- <footer class="{{Settings('footer_show')==0?'d-none d-sm-none d-md-block d-lg-block d-xl-block':''}}"> --}}
    {{-- @if (@$homeContent->show_subscribe_section == 1)
            <x-footer-news-letter/>
        @endif --}}
    {{-- <div class="copyright_area"> --}}
    <div class="container">
        <div class="row">
            {{--                @if (!isset($sectionWidgets) || (count($sectionWidgets['one']) == 0 && count($sectionWidgets['two']) == 0 && count($sectionWidgets['three']) == 0)) --}}

            {{-- <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="footer_widget">
                            <div class="footer_logo">
                                <a href="#">
                                    <img src="{{getCourseImage(Settings('logo2'))}}" alt=""
                                         style="width: 108px">
                                </a>
                            </div>
                            <p>{{ function_exists('footerSettings')?footerSettings('footer_about_description'):''  }}</p>
                            <div class="copyright_text">
                                <p>{!! function_exists('footerSettings')?footerSettings('footer_copy_right'):''  !!}</p>
                            </div>

                            <style>


                            </style>
                            <div class="">
                                <ul class="pt-3 ">
                                    <ul class="social-network social-circle col-lg-12 ">
                                        <x-footer-social-links/>
                                    </ul>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8 col-lg-8 col-md-6">

                        <x-footer-section-widgets/>

                    </div> --}}

        </div>
    </div>
</div>

<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat Plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>



<div class="shoping_wrapper">
    <div class="dark_overlay"></div>
    <div class="shoping_cart">
        <div class="shoping_cart_inner">
            <div class="cart_header d-flex justify-content-between">
                <h4>{{ __('frontend.Shopping Cart') }}</h4>
                <div class="chart_close">
                    <i class="ti-close"></i>
                </div>
            </div>
            <div id="cartView">
                <div class="single_cart">
                    Loading...
                </div>
            </div>


        </div>
        <div class="view_checkout_btn d-flex justify-content-end gap_10 flex-wrap" style="display: none!important;">
            <a href="{{ url('my-cart') }}"
                class="theme_btn small_btn3 flex-fill text-center">{{ __('frontend.View cart') }}</a>
            <a href="{{ route('myCart', ['checkout' => true]) }}"
                class="theme_btn small_btn3 flex-fill text-center">{{ __('frontend.Checkout') }}</a>
        </div>
    </div>
</div>
<!-- shoping_cart::end  -->



<!-- UP_ICON  -->
<div id="back-top" style="display: none;">
    <a title="Go to Top" href="#">
        <i class="fa fa-angle-up"></i>
    </a>
</div>

<input type="hidden" name="item_list" class="item_list" value="{{ url('getItemList') }}">
<input type="hidden" name="enroll_cart" class="enroll_cart" value="{{ url('enrollOrCart') }}">
<input type="hidden" name="csrf_token" class="csrf_token" value="{{ csrf_token() }}">
<!--/ UP_ICON -->



<x-footer-cookie />

<div class="modal fade leaderboard-boarder" id="myLeaderBoard" tabindex="-1" role="dialog"
    aria-labelledby="myLeaderBoard" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="">{{ __('common.Leaderboard') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="reward-leader">
                    <ul class="nav nav-tabs border-bottom-0 m-0" id="myTab" role="tablist">
                        @if (Settings('gamification_leaderboard_show_point_status'))
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nav-point" id="point-tab" data-toggle="tab" data-target="#point"
                                    data-type="point" type="button" role="tab" aria-controls="point"
                                    aria-selected="true">{{ __('setting.Points') }}
                                </button>
                            </li>
                        @endif
                        @if (Settings('gamification_leaderboard_show_level_status'))
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nav-point" id="level-tab" data-toggle="tab" data-target="#level"
                                    data-type="level" type="button" role="tab" aria-controls="level"
                                    aria-selected="true">{{ __('setting.Levels') }}
                                </button>
                            </li>
                        @endif
                        @if (Settings('gamification_leaderboard_show_badges_status'))
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nav-point" id="badge-tab" data-toggle="tab" data-target="#badge"
                                    data-type="badge" type="button" role="tab" aria-controls="badge"
                                    aria-selected="true">{{ __('setting.Badges') }}
                                </button>
                            </li>
                        @endif
                        @if (Settings('gamification_leaderboard_show_courses_status'))
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nav-point" id="courses-tab" data-toggle="tab"
                                    data-target="#courses" data-type="courses" type="button" role="tab"
                                    aria-controls="courses" aria-selected="true">{{ __('courses.Courses') }}
                                </button>
                            </li>
                        @endif
                        @if (Settings('gamification_leaderboard_show_certificate_status'))
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nav-point" id="certificate-tab" data-toggle="tab"
                                    data-target="#certificate" data-type="certificate" type="button" role="tab"
                                    aria-controls="certificate" aria-selected="true">{{ __('setting.certificates') }}
                                </button>
                            </li>
                        @endif
                    </ul>
                    <div id="leaderboardBody" class="leaderboardBody"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('public/frontend/infixlmstheme/js/app.js') }}"></script>

<script src="{{ asset('public/backend/js/summernote-bs4.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ Settings('gmap_key') }}"></script>
<script src="{{ asset('public/frontend/infixlmstheme/js/map.js') }}"></script>
<script src="{{ asset('public/frontend/infixlmstheme/js/contact.js') }}"></script>

{!! Toastr::message() !!}

@if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
            toastr.error('{{ $error }}', 'Error', {
                closeButton: true,
                progressBar: true,
            });
        @endforeach
    </script>
@endif

@if (isModuleActive('Appointment'))
    {{-- <script
            src="{{asset('Modules\Appointment\Resources\assets\frontend\5\bootstrap.min.js')}}{{assetVersion()}}"></script>
        <script
            src="{{asset('Modules\Appointment\Resources\assets\frontend\plugins\jquery-ui\jquery-ui.min.js')}}{{assetVersion()}}"></script>
        <script
            src="{{asset('Modules\Appointment\Resources\assets\frontend\plugins\jquery-ui\jquery.ui.touch-punch.min.js')}}{{assetVersion()}}">
        </script>
        <script
            src="{{asset('Modules\Appointment\Resources\assets\frontend\plugins\price-range\ion.rangeslider.min.js')}}{{assetVersion()}}">
        </script>
        <script src="{{asset('Modules\Appointment\Resources\assets\frontend\js\main.js')}}{{assetVersion()}}"></script> --}}
@endif

@yield('js')

<script>
    setTimeout(function() {
        $('.preloader').fadeOut('hide', function() {
            // $(this).remove();

        });
    }, 0);
</script>
<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "103165209134409");
    chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v16.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script>
    $('#cartView').on('click', '.remove_cart', function() {
        let id = $(this).data('id');
        let total = $('.notify_count').html();

        $(this).closest(".single_cart").hide();
        let url = "{{ url('/home/removeItemAjax') }}" + '/' + id;

        $.ajax({
            type: 'GET',
            url: url,
            success: function(data) {

                $('.notify_count').html(total - 1);
            }
        });
    });

    $(function() {
        $('.lazy').Lazy();
    });
</script>
@auth
    @if (Settings('device_limit_time') != 0)
        @if (\Illuminate\Support\Facades\Auth::user()->role_id == 3)
            <script>
                function update() {
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/') }}" + "/update-activity",
                        success: function(data) {


                        }
                    });
                }

                var intervel = "{{ Settings('device_limit_time') }}"
                var time = (intervel * 60) - 20;

                setInterval(function() {
                    update();
                }, time * 1000);
            </script>
        @endif
    @endif
@endauth
<script>
    $(document).on('click', '.show_notify', function(e) {
        e.preventDefault();

        console.log('notify');
    });
    if ($('#main-nav-for-chat').length) {} else {
        $('#main-content').append('<div id="main-nav-for-chat" style="visibility: hidden;"></div>');
    }

    if ($('#admin-visitor-area').length) {} else {
        $('#main-content').append('<div id="admin-visitor-area" style="visibility: hidden;"></div>');
    }
</script>


@if (str_contains(request()->url(), 'chat'))
    <script src="{{ asset('public/backend/js/jquery-ui.js') }}{{ assetVersion() }}"></script>
    <script src="{{ asset('public/frontend/infixlmstheme/js/select2.min.js') }}{{ assetVersion() }}"></script>
    <script src="{{ asset('public/js/app.js') }}{{ assetVersion() }}"></script>
    <script src="{{ asset('public/chat/js/custom.js') }}{{ assetVersion() }}"></script>
@endif

@if (auth()->check() && auth()->user()->role_id == 3 && !str_contains(request()->url(), 'chat'))
    <script src="{{ asset('public/js/app.js') }}{{ assetVersion() }}"></script>
@endif


@if (isModuleActive('WhatsappSupport'))
    <script src="{{ asset('public/whatsapp-support/scripts.js') }}{{ assetVersion() }}"></script>

    @include('whatsappsupport::partials._popup')
@endif

<script src="{{ asset('public/frontend/infixlmstheme/js/custom.js') }}{{ assetVersion() }}"></script>
@if (Settings('gamification_status') && Settings('gamification_leaderboard_status'))
    <script>
        $(document).on("click", ".point_btn", function() {
            let modal = $('#myLeaderBoard')
            modal.modal('show');
            let type = modal.find('.nav-link.active').data('type');
            if (type == undefined) {
                let link = modal.find('.nav-link:first');
                link.addClass('active')
                type = link.data('type');

            }
            loadData(type);
        });
        $(document).on("click", ".how_to_point", function() {
            let modal = $('#myLeaderBoard')
            modal.modal('show');
            let link = modal.find('.nav-link:first');
            link.addClass('active')
            loadData('how_to_point')
        });

        $(document).on("click", ".nav-point", function() {
            let type = $(this).data('type');
            loadData(type);
        });

        function loadData(type, id = 0) {
            let body = $('#leaderboardBody');
            let url = '{{ url('/') }}';
            let formData = {
                type: type,
                id: id,
            };
            body.html(
                '<div class="d-flex align-items-center justify-content-center py-3"><i class="fas fa-spinner  fa-spin"></i></div>'
            )


            $.ajax({
                type: "get",
                data: formData,
                dataType: "html",
                url: url + '/my-leaderboard',
                success: function(data) {
                    body.html(data);
                },
                error: function(data) {
                    body.html("");
                }

            });
        }
    </script>
@endif
<!-- wathsapp -->
<style>
    .float-a{
        position:fixed !important;
        width:58px !important;
        height:58px !important;
        bottom:170px !important;
        right:26px !important;
        background-color:#25d366 !important;
        color:#FFF !important;
        border-radius:50px !important;
        text-align:center !important;
        font-size:30px !important;
        box-shadow: 2px 2px 3px #999 !important;
        z-index:100 !important;
    }

    .my-float{
        margin-top:16px;
    }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<a href="https://api.whatsapp.com/send?phone=3475251736" class="float-a" target="_blank">
    <i class="fa fa-whatsapp my-float"></i>
</a>
<!-- wathsapp -->

</body>

</html>
</div>
