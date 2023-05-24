@extends('backend.master')
@php
    $table_name='front_pages'
@endphp
@section('table')
    {{$table_name}}
@stop
@section('mainContent')
    <section class="sms-breadcrumb mb-20 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{__('frontendmanage.Pages')}}</h1>
                <div class="bc-pages">
                    <a href="{{url('dashboard')}}">{{__('dashboard.Dashboard')}}</a>
                    <a href="#">{{__('frontendmanage.Frontend CMS')}}</a>
                    <a href="{{ route('frontend.page.index')}}">{{__('frontendmanage.Pages')}}</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <h4 class="pl-4 mb-3">
                <div class="row justify-content-start  pr-4">
                    @if(permissionCheck('frontend.page.create'))
                        <a href="{{ route('frontend.page.create') }}" class="primary-btn small fix-gr-bg">
                            <span class="ti-plus"></span>
                            {{__('common.Add')}} {{__('frontendmanage.Pages')}}
                        </a>
                    @endif
                </div>
            </h4>
            <div class="col-lg-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table">
                        <!-- table-responsive -->
                        <div class="">
                            <table id="lms_table" class="table Crm_table_active3">
                                <thead>

                                <tr>
                                    <th width="15%">{{__('frontendmanage.Title')}}</th>
                                    <th width="15%">{{__('frontendmanage.Slug')}}</th>
                                    {{--                                    <th width="15%">{{__('common.Type')}}</th>--}}
                                    <th width="15%">{{__('common.Status')}}</th>
                                    <th width="15%">{{__('common.Action')}}</th>
                                </tr>
                                </thead>


                                <tbody>
                                @foreach($frontPages as $value)

                                    <tr>

                                        <td> {{ Str::limit($value->title,30) }}
                                            @if($value->homepage==1)
                                               <b>
                                                   <small>
                                                       ({{__('common.Homepage')}})
                                                   </small>
                                               </b>
                                            @endif
                                        </td>
                                        <td> {{ Str::limit($value->slug,30) }}</td>
                                        <td>
                                            @if($value->is_static!='1')
                                                <x-backend.status :id="$value->id" :status="$value->status"
                                                                  :route="'frontend.page.change-status'"></x-backend.status>
                                            @endif
                                        </td>
                                        <td>


                                            <div class="dropdown CRM_dropdown">
                                                <button class="btn btn-secondary dropdown-toggle"
                                                        type="button"
                                                        id="dropdownMenu2" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    {{ __('common.Select') }}
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                     aria-labelledby="dropdownMenu2">
                                                    <a class="dropdown-item" target="_blank"
                                                       href="{{ $value->is_static!=1?url('pages/'.$value->slug):url($value->slug)}}"> {{__('common.View')}}</a>
                                                    @if(permissionCheck('frontend.page.edit'))
                                                        <a class="dropdown-item"
                                                           href="{{ route('frontend.page.edit',$value->id)}}"> {{__('common.Edit')}}</a>
                                                        @if(hasDynamicPage())
                                                            <a class="dropdown-item" target="_blank"
                                                               href="{{ route('frontend.page.show',$value->id)}}"> {{__('common.Design')}}</a>
                                                        @endif
                                                    @endif
                                                    @if(permissionCheck('frontend.page.delete'))
                                                        @if($value->is_static!=1)
                                                            <a class="dropdown-item deleteBtn" data-toggle="modal"
                                                               data-url="{{ route('frontend.page.destroy',$value->id)}}"
                                                               data-target="#deleteItem">{{__('common.Delete')}}</a>
                                                        @endif
                                                    @endif

                                                    @if(permissionCheck('frontend.page.changeHomepage'))
                                                        @if($value->homepage!=1)
                                                            <a href="{{route('frontend.page.changeHomepage',$value->id)}}"
                                                               class="dropdown-item ">{{__('frontendmanage.Make It Homepage')}}</a>
                                                        @endif
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
    </section>
    <div class="modal fade admin-query" id="deleteItem">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('common.Delete')}} {{__('frontendmanage.Page')}}</h4>
                    <button type="button" class="close"
                            data-dismiss="modal" style="color: #000">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4>{{__('footer.Are you sure')}}?</h4>
                    </div>
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg"
                                data-dismiss="modal">{{__('footer.Cancel')}}
                        </button>
                        <form action=""
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="submit" class="primary-btn fix-gr-bg"
                                   value="Delete"/>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        $(document).on("click", ".deleteBtn", function (e) {
            e.preventDefault();
            let url = $(this).data('url');
            console.log(url);
            $('#deleteItem').find('form').attr('action', url);
        });

    </script>

@endpush
