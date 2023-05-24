@if (permissionCheck($route))
    <label class="switch_toggle" for="active_checkbox{{$query->id}}">
        <input type="checkbox" class="status_enable_disable"
               id="active_checkbox{{$query->id}}" value="{{$query->id}}"
            {{$query->status == 1 ? "checked" : ""}}><i class="slider round"></i></label>
@else
    {{$query->status == 1 ? trans('common.Active') : trans('common.Inactive')}}
@endif
