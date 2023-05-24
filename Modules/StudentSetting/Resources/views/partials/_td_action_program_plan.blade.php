@php
    $route = route('plan.delete_plan', ['id' => $query['id']]);
@endphp
<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        {{ trans('common.Action') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        <a href="javascript:void(0)" onclick="editPlan(' {{ $query['id'] }} ','{{ $query['parent_id'] }} ')"
            class="dropdown-item editPlan" type="button">Edit</a>

        <a href="javascript:void(0)" onclick="confirm_plan_modal('{{ $route }}')"
            class="dropdown-item deleteStudent" type="button">{{ trans('common.Delete') }}
        </a>
    </div>
</div>
