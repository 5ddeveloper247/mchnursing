@php
    $route =  route('delete_program' , [ 'id' => $query['id'] ]);
@endphp
<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{trans('common.Action')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">

            <a href="{{ route('edit_program' , [ 'id' => $query['id'] ]) }}"
                data-item-id="{{$query['id']}}"
                class="dropdown-item editStudent"
                type="button">{{trans('common.Edit') }}
            </a>

            <a  href="javascript:void(0)" onclick="confirm_modal('{{$route}}')"
                class="dropdown-item deleteStudent"
                    data-id="{{$query['id']}}"
                    type="button">{{trans('common.Delete')}}
            </a>
    </div>
</div>
