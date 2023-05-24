@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/role_module_style.css')}}">
@endpush
@section('mainContent')
    <style>
        .erp_role_permission_area .single_permission .permission_header {
            min-height: 47px;
        }

        .module_link_option_div {
            display: flex;
        }

        .erp_role_permission_area .single_permission .permission_header div {
            display: flex;
            left: -13px;
        }
    </style>
    {!! generateBreadcrumb() !!}

    <div class="role_permission_wrap">
        <div class="permission_title">
            <h4>{{__('role.assign_permission')}} </h4>
        </div>
    </div>
    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'permission.permissions.store','method' => 'POST']) }}
    <div class="erp_role_permission_area ">
        <!-- single_permission  -->
        <input type="hidden" name="role_id" value="{{@$role->id}}">
        @foreach($sections as $section)
            <div class="row">
                <div class="col-sm-12">
                    {{$section->name}}
                </div>
                <div class="col-sm-12">
                    <div class="mesonary_role_header">
                        @php
                            if ($role->id==3){
                                  $modules =$section->frontendPermissions->where('type',1)->where('menu_status',1);
                            }else{
                             $modules =$section->permissions->where('type',1)->where('menu_status',1);
                            }
                        @endphp

                        @foreach ($modules as $key => $Module)
                            @if(!$Module->module ||  isModuleActive($Module->module))
                                @include('rolepermission::page-components.permissionModule',[ 'key' =>$key, 'Module' =>$Module ])
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-40">
        <div class="col-lg-12 text-center">
            <button class="primary-btn fix-gr-bg">
                <span class="ti-check"></span>
                {{__('common.Submit')}}
            </button>
        </div>
    </div>


    {{ Form::close() }}
@endsection
@push('scripts')
    <script src="{{asset('public/backend/js/permission.js')}}"></script>
@endpush
