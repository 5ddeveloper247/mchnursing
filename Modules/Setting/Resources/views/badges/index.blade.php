@extends('backend.master')
@php
    $table_name='badges';
@endphp
@section('table')
    {{$table_name}}
@endsection
@section('mainContent')
    @php
        if(session('type')){
            $typeTab = session('type');
        }else{
            $typeTab = 'activity';
        }
    @endphp
    {!! generateBreadcrumb() !!}
    <section class="mb-40 student-details up_st_admin_visitor badge-section">
        <div class="container-fluid p-0">
            <div class="row ">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs no-bottom-border justify-content-end mt-sm-md-20 " role="tablist">

                        @foreach($types as $key=>$type)
                            <li class="nav-item">
                                <a class="nav-link {{ $typeTab == $key?'active':'' }} show" href="#{{$key}}Badge"
                                   role="tab"
                                   onclick="changeSection('{{$key}}')"
                                   data-toggle="tab" id="{{$key}}"
                                   aria-selected="true">
                                    {{$type}}
                                </a>
                            </li>
                        @endforeach


                    </ul>
                    <div class="col-lg-12" id="lms_table">

                        <!-- Tab panes -->
                        <div class="tab-content">
                            @foreach($types as $key=>$type)
                                <div role="tabpanel" class="tab-pane {{ $typeTab == $key?'active show':'' }} fade"
                                     id="{{$key}}Badge">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @if(permissionCheck('gamification.badges.store'))
                                                <a href="#" data-type="{{$key}}"
                                                   class="primary-btn addWidget small fix-gr-bg mb-2  mt-3 add_btn_with_page_length">{{__('common.Add New')}}</a>

                                            @endif
                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table ">
                                                    <!-- table-responsive -->
                                                    <div class=" pt-3">
                                                        <table class="table Crm_table_active3">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">{{ __('common.SL') }}</th>
                                                                <th scope="col">{{ __('common.Title') }}</th>
                                                                <th scope="col">{{ __('common.Condition') }}</th>
                                                                <th scope="col">{{ __('common.Image') }}</th>
                                                                <th scope="col">{{ __('common.Status') }}</th>
                                                                <th scope="col">{{ __('common.Action') }}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php
                                                                $i =0;
                                                            @endphp
                                                            @foreach($badges->where('type',$key) as $index=>$badge)
                                                                <tr>
                                                                    <td>{{++$i}}</td>
                                                                    <td>{{$badge->title}}</td>
                                                                    <td>{{$badge->point}}</td>
                                                                    <td>
                                                                        <div>
                                                                            @if($badge->image)
                                                                                <img style="width: 70px !important;"
                                                                                     src="{{url($badge->image)}}" alt=""
                                                                                     class="img img-responsive m-2">
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    <td>

                                                                        <x-backend.status :id="$badge->id"
                                                                                          :status="$badge->status"
                                                                                          :route="'gamification.badges.status'"></x-backend.status>
                                                                    </td>


                                                                    <td>
                                                                        <div class="dropdown CRM_dropdown">
                                                                            <button
                                                                                class="btn btn-secondary dropdown-toggle"
                                                                                type="button"
                                                                                id="dropdownMenu1{{@$badge->id}}"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                {{ __('common.Select') }}
                                                                            </button>
                                                                            <div
                                                                                class="dropdown-menu dropdown-menu-right"
                                                                                aria-labelledby="dropdownMenu1{{@$badge->id}}">
                                                                                @if (permissionCheck('gamification.badges.update'))
                                                                                    <a class="dropdown-item"
                                                                                       onclick="showEditModal({{$badge}})"
                                                                                       href="#">{{__('common.Edit')}}</a>
                                                                                @endif
                                                                                @if (permissionCheck('gamification.badges.delete'))
                                                                                    <a onclick="showDeleteModal('{{route('gamification.badges.delete', $badge->id)}}');"
                                                                                       class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('setting::badges.components.widget_create')
        @include('setting::badges.components.widget_edit')
        @include('setting::badges.components.delete')
    </section>

@endsection

@include('setting::badges.components.scripts')
