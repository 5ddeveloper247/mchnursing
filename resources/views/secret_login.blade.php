@if(\Illuminate\Support\Facades\Session::has("impersonated"))
    <div class="secret_login text-center p-3 d-flex align-items-center justify-content-center">
        <span class="mr-1">{{__('common.Login as')}}</span>
        <b>{{\Illuminate\Support\Facades\Auth::user()->email}}</b>
        <a class="primary-btn fix-gr-bg ml-3 theme_btn_mini  " href="{{route('secretLoginExit')}}">
            {{__('common.Exit Now')}}
        </a>
    </div>
@endif
