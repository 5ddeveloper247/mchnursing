<div>
    @if(permissionCheck($route) || empty($route))
        <label class="switch_toggle" for="active_checkbox{{$id }}">
            <input type="checkbox"
                   class="status_enable_disable"
                   id="active_checkbox{{$id }}"
                   @if ($status == 1) checked
                   @endif value="{{$id }}">
            <i class="slider round"></i>
        </label>
    @else
        {{$status==1?trans('common.Active'):trans('common.Inactive')}}
    @endif
</div>
