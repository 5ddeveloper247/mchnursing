@php
    $totalMessage = totalUnreadMessages();
@endphp
<div class="container-fluid no-gutters" id="main-nav-for-chat">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="header_iner d-flex justify-content-between align-items-center">
                @php
                    $LanguageList = getLanguageList();
                    $path = asset(Settings('logo'));
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    try {
                        $data = file_get_contents($path);
                    } catch (\Exception $e) {
                        $data = '';
                    }
                @endphp
                <input type="hidden" id="logo_img" value="{{ base64_encode($data) }}">
                <input type="hidden" id="logo_title" value="{{ Settings('company_name') }}">
                <div class="small_logo_crm d-lg-none">
                    <a href="{{ url('/') }}"> <img src="{{ asset(Settings('logo')) }}" alt=""></a>
                </div>
                <div id="sidebarCollapse" class="sidebar_icon d-lg-none">
                    <i class="ti-menu"></i>
                </div>
                <div class="collaspe_icon open_miniSide">
                    <i class="ti-menu"></i>
                </div>
                <div class="serach_field-area ml-40">
                    <div class="search_inner">
                        <form action="#">
                            <div class="search_field">
                                <input type="text" class="form-control primary-input input-left-icon"
                                    placeholder="{{ __('common.Search') }}" id="search"
                                    onkeyup="showResult(this.value)">
                            </div>
                            <button type="submit"><i class="ti-search"></i></button>
                        </form>
                    </div>
                    <div id="livesearch" style="display: none;"></div>
                </div>

                <div class="header_middle d-none d-md-block">
                    <ul class="nav navbar-nav nav-buttons flex-sm-row mr-auto">

                        <li class="nav-item">
                            <a target="_blank" class="primary-btn white mr-10"
                                href="{{ url('/') }}">{{ __('common.Website') }}</a>
                        </li>


                    </ul>
                </div>

                <div class="header_right d-flex justify-content-between align-items-center">
                    @if (Settings('language_translation') == 1)
                        <div class="select_style d-flex">
                            <select name="code" id="language_code" class="nice_Select bgLess menuLangChanger mb-0"
                                onchange="location = this.value;">
                                @foreach ($LanguageList as $key => $language)
                                    <option value="{{ route('changeLanguage', $language->code) }}"
                                        @if (Auth::user()->language_code == $language->code) selected @endif>{{ $language->native }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <ul class="header_notification_warp d-flex align-items-center">
                        {{-- Start Notification --}}
                        <li class="scroll_notification_list">
                            <a class="pulse theme_color bell_notification_clicker show_notifications" href="#">
                                <!-- bell   -->
                                <i class="fa fa-bell"></i>

                                <!--/ bell   -->
                                <span
                                    class="notificationCount notification_count">{{ Auth::user()->unreadNotifications->count() }}</span>
                                <span class="pulse-ring notification_count_pulse"></span>
                            </a>
                            <!-- Menu_NOtification_Wrap  -->
                            <div class="Menu_NOtification_Wrap notifications_wrap">
                                <div class="notification_Header">
                                    <h4>{{ __('common.Notifications') }}</h4>
                                </div>
                                <div class="Notification_body">
                                    <!-- single_notify  -->
                                    @forelse (Auth::user()->unreadNotifications as $notification)
                                        <div class="single_notify d-flex align-items-center"
                                            id="menu_notification_show_{{ $notification->id }}">
                                            <div class="notify_thumb">
                                                <i class="fa fa-bell"></i>
                                            </div>
                                            <a href="#" class="unread_notification" title="Mark As Read"
                                                data-notification_id="{{ $notification->id }}">
                                                <div class="notify_content">
                                                    <h5>{!! strip_tags(\Illuminate\Support\Str::limit(@$notification->data['title'], 30, $end = '...')) !!}</h5>
                                                    <p>{!! strip_tags(\Illuminate\Support\Str::limit(@$notification->data['body'], 70, $end = '...')) !!}</p>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <span class="text-center">{{ __('common.No Unread Notification') }}</span>
                                    @endforelse

                                </div>
                                <div class="nofity_footer">
                                    <div class="submit_button pt_20 text-center">
                                        <a href="{{ route('MyNotification') }}"
                                            class="primary-btn radius_30px text_white fix-gr-bg">{{ __('common.See More') }}</a>
                                        <a href="{{ route('NotificationMakeAllRead') }}" id="mark_all_as_read"
                                            class="primary-btn radius_30px text_white fix-gr-bg">{{ __('common.Mark As Read') }}</a>
                                    </div>
                                </div>
                            </div>
                            <!--/ Menu_NOtification_Wrap  -->
                        </li>
                        {{-- End Notification --}}
                        @if (permissionCheck('communication.PrivateMessage'))
                            <li class="scroll_notification_list">
                                <a class="pulse theme_color" href="{{ route('communication.PrivateMessage') }}">
                                    <!-- bell   -->
                                    <i class="far fa-comment"></i>
                                    <span class="notification_count">{{ $totalMessage }} </span>
                                    @if ($totalMessage > 0)
                                        <span class="pulse-ring notification_count_pulse"></span>
                                    @endif
                                </a>
                            </li>
                        @endif

                        @if (isModuleActive('Chat'))
                            <li class="scroll_notification_list">
                                @if (env('BROADCAST_DRIVER') == null)
                                    <jquery-notification-component
                                        :loaded_unreads="{{ json_encode($notifications_for_chat) }}"
                                        :user_id="{{ json_encode(auth()->id()) }}"
                                        :redirect_url="{{ json_encode(route('chat.index')) }}"
                                        :check_new_notification_url="{{ json_encode(route('chat.notification.check')) }}"
                                        :asset_type="{{ json_encode('/public') }}"
                                        :mark_all_as_read_url="{{ json_encode(route('chat.notification.allRead')) }}">
                                    </jquery-notification-component>
                                @else
                                    <notification-component
                                        :loaded_unreads="{{ json_encode($notifications_for_chat) }}"
                                        :user_id="{{ json_encode(auth()->id()) }}"
                                        :redirect_url="{{ json_encode(route('chat.index')) }}"
                                        :asset_type="{{ json_encode('/public') }}"
                                        :mark_all_as_read_url="{{ json_encode(route('chat.notification.allRead')) }}">
                                    </notification-component>
                                @endif
                            </li>
                        @endif

                    </ul>
                    <div class="profile_info">
                        <div class="profileThumb"
                            style="background-image: url('{{ getProfileImage(Auth::user()->image) }}')"></div>

                        <div class="profile_info_iner">
                            <div class="use_info d-flex align-items-center">
                                <div class="thumb"
                                    style="background-image: url('{{ getProfileImage(Auth::user()->image) }}')">

                                </div>
                                <div class="user_text">
                                    <p>{{ __('common.Welcome') }}</p>
                                    <span>{{ @Auth::user()->name }} </span>
                                </div>
                            </div>

                            <div class="profile_info_details">
                                <a href="{{ route('updatePassword') }}">
                                    <i class="ti-settings"></i> <span>{{ __('common.View Profile') }} </span>
                                </a>

                                @if (isModuleActive('UserType'))
                                    @foreach (auth()->user()->userRoles as $role)
                                        @php
                                            if ($role->id == auth()->user()->role_id) {
                                                continue;
                                            }
                                        @endphp
                                        <a href="{{ route('usertype.changePanel', $role->id) }}">
                                            <i class="ti-link"></i>
                                            <span>{{ __('common.Switch to') }} {{ $role->name }}</span>
                                        </a>
                                    @endforeach
                                @endif
                                @if (
                                    (isModuleActive('LmsSaas') && Auth::user()->is_saas_admin == 1) ||
                                        (isModuleActive('LmsSaasMD') && Auth::user()->is_saas_admin == 1))
                                    <a href="{{ route('saas_panel') }}"
                                        onclick="event.preventDefault();
                                            document.getElementById('saas_panel').submit();">
                                        <i class="ti-user"></i>
                                        <span>
                                            @if (Auth::user()->active_panel == 'saas')
                                                {{ __('common.Lms Panel') }}
                                            @else
                                                {{ __('common.Saas Panel') }}
                                            @endif
                                        </span> </a>

                                    <form id="saas_panel" action="{{ route('saas_panel') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                @endif

                                @if (isModuleActive('Affiliate') && !isAffiliateUser())
                                    <a
                                        href="{{ routeIsExist('affiliate.users.request') ? route('affiliate.users.request') : '' }}">
                                        <i class="ti-money"></i> <span>
                                            {{ __('frontend.Join Affiliate Program') }}
                                        </span>
                                    </a>
                                @endif

                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    <i class="ti-shift-left"></i> <span>{{ __('dashboard.Logout') }}</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
