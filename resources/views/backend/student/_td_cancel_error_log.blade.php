{{-- @if ($query->refund != 1 && permissionCheck('course.delete')) --}}
@php
    $deleteUrl = route('admin.enrollDelete', $query->id) . '?cancel';
@endphp

<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        {{ trans('common.Action') }}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">

        <a onclick="confirm_delete_modal('{{ $deleteUrl }}')" class="dropdown-item edit_brand">
            {{ trans('common.Delete') }}
        </a>

    </div>
</div>
{{-- @endif --}}
