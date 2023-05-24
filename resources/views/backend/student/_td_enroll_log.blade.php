@if ($query->refund != 1 && permissionCheck('course.delete'))
    @php
        $deleteUrl = route('admin.enrollDelete', $query->id);
        $refundUrl = route('admin.enrollDelete', $query->id) . '?refund';
    @endphp

    <div class="dropdown CRM_dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button"
                id="dropdownMenu2" data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
            {{trans('common.Action') }}
        </button>
        <div class="dropdown-menu dropdown-menu-right"
             aria-labelledby="dropdownMenu2">

{{--            <a onclick="confirm_refund_modal('{{$refundUrl}}')"--}}
{{--               class="dropdown-item edit_brand">--}}
{{--                {{trans('common.Refund') .' '. trans('common.Course')}}--}}
{{--            </a>--}}
            @if(!empty($query->program_id))
            <a onclick="confirm_cancel_modal('{{$deleteUrl}}')"
               class="dropdown-item edit_brand">{{trans('common.Cancel') . ' ' . trans('Program') }}</a>
            @else
                <a onclick="confirm_cancel_modal('{{$deleteUrl}}')"
                   class="dropdown-item edit_brand">{{trans('common.Cancel') . ' ' . trans('Test-Prep') }}</a>
            @endif
        </div>
    </div>

@endif
