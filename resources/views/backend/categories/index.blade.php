@extends('backend.master')
@php
    $table_name='categories';
@endphp
@section('table')
    {{$table_name}}
@endsection
@section('mainContent')
    @include("backend.partials.alertMessage")
    @php
        $LanguageList = getLanguageList();
    @endphp
    {!! generateBreadcrumb() !!}
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex mb-0">
                            <h3 class="mb-0"> @if(!isset($edit))
                                    {{__('courses.Add New Category') }}
                                @else
                                    {{__('courses.Update Category')}}
                                @endif</h3>
                            @if(isset($edit))
                                @if (permissionCheck('course.category.store'))
                                    <a href="{{route('course.category')}}"
                                       class="primary-btn small fix-gr-bg ml-4" style="line-height: 25px;"
                                       title="{{__('courses.Add New')}}">+</a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="white-box mb_30  student-details header-menu">

                        <div class="row pt-0">
                            @if(isModuleActive('FrontendMultiLang'))
                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                    role="tablist">
                                    @foreach ($LanguageList as $key => $language)
                                        <li class="nav-item">
                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                               href="#element{{$language->code}}"
                                               role="tab"
                                               data-toggle="tab">{{ $language->native }}  </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>


                        @if (isset($edit))
                            <form action="{{route('course.category.update')}}" method="POST"
                                  id="category-form"
                                  name="category-form" enctype="multipart/form-data">
                                <input type="hidden" name="id"
                                       value="{{$edit->id}}">
                                @else
                                    @if (permissionCheck('course.category.store'))
                                        <form action="{{route('course.category.store') }}" method="POST"
                                              id="category-form" name="category-form"
                                              enctype="multipart/form-data">
                                            @endif
                                            @endif
                                            @csrf

                                            <div class="tab-content">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="nameInput">{{ __('common.Name') }}
                                                                        <strong
                                                                            class="text-danger">*</strong></label>
                                                                    <input name="name[{{$language->code}}]"
                                                                           id="nameInput"
                                                                           class="primary_input_field name {{ @$errors->has('name') ? ' is-invalid' : '' }}"
                                                                           placeholder="{{ __('common.Name') }}"
                                                                           type="text"
                                                                           value="{{isset($edit)?$edit->getTranslation('name',$language->code):old('name.'.$language->code)}}">

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="descriptionInput">{{ __('common.Description') }}  </label>
                                                                    <input name="description[{{$language->code}}]"
                                                                           id="descriptionInput"
                                                                           class="primary_input_field description {{ @$errors->has('description') ? ' is-invalid' : '' }}"
                                                                           placeholder="{{ __('common.Description') }}"
                                                                           type="text"
                                                                           value="{{isset($edit)?$edit->getTranslation('description',$language->code):old('description'.$language->code)}}" {{$errors->has('description') ? 'autofocus' : ''}}>
                                                                    @if ($errors->has('description'))
                                                                        <span class="invalid-feedback d-block mb-10"
                                                                              role="alert">
                                                                <strong>{{ @$errors->first('description') }}</strong>
                                                            </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">

                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="parent">{{ __('common.Parent') }}</label>
                                                        <select class="primary_select mb-25" name="parent"
                                                                id="parent">
                                                            <option value="">{{__('common.None')}}</option>
                                                            @foreach($categories as $category)
                                                                @if(isset($edit) && $category->id==$edit->id)
                                                                    @php
                                                                        continue;
                                                                    @endphp
                                                                @endif
                                                                <option
                                                                    value="{{$category->id}}"
                                                                    {{isset($edit)?($edit->parent_id==$category->id?'selected':old('parent')):old('parent')}}
                                                                >{{$category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="position_order">{{ __('courses.Position Order') }}</label>
                                                        <select class="primary_select mb-25"
                                                                name="position_order"
                                                                id="position_order">
                                                            @for($i=1; $i<=$max_id; $i++)
                                                                <option
                                                                    value="{{ $i }}" {{isset($edit)?($edit->position_order==$i?'selected':old('position_order')):old('position_order')}} >
                                                                    {{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label"
                                                               for="status">{{ __('courses.Status') }}</label>
                                                        <select class="primary_select mb-25" name="status"
                                                                id="status"
                                                        >
                                                            <option
                                                                value="1" {{isset($edit)?($edit->status==1?'selected':''):''}}>{{__('common.Active') }}</option>
                                                            <option
                                                                value="0" {{isset($edit)?($edit->status==0?'selected':''):''}}>{{__('common.Inactive') }}</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12 mt-10">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label"
                                                               for="placeholderFileOneName">{{ __('frontendmanage.Icon') }}
                                                        </label>
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input filePlaceholder"
                                                                   type="text"
                                                                   value="{{isset($edit)?$edit->image:''}}"

                                                                   placeholder="{{__('student.Browse Image file')}}"
                                                                   readonly="" {{$errors->has('photo') ? 'autofocus' : ''}}>
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                       for="document_file_1">{{ __('common.Browse') }}</label>
                                                                <input type="file" class="d-none fileUpload"
                                                                       name="photo"
                                                                       id="document_file_1">
                                                            </button>
                                                        </div>
                                                        <p class="image_size">{{__('courses.Recommended size 200px x 200px')}}</p>
                                                        @if ($errors->has('photo'))
                                                            <span class="invalid-feedback d-block mb-10"
                                                                  role="alert">
                                                                <strong>{{ @$errors->first('photo') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label"
                                                               for="">{{ __('courses.Thumbnail Image') }}  </label>
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input filePlaceholder"
                                                                   type="text"
                                                                   id=" "
                                                                   value="{{isset($edit)?$edit->thumbnail:''}}"
                                                                   placeholder="Browse file"
                                                                   readonly="" {{$errors->has('thumbnail') ? 'autofocus' : ''}}>
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                       for="document_file_2">{{ __('common.Browse') }}</label>
                                                                <input type="file" class="d-none fileUpload"
                                                                       name="thumbnail"
                                                                       id="document_file_2">
                                                            </button>
                                                        </div>
                                                        <p class="image_size">{{__('courses.Recommended size 1140px x 300px')}}</p>
                                                    </div>
                                                    @if ($errors->has('thumbnail'))
                                                        <span class="invalid-feedback d-block mb-10"
                                                              role="alert">
                                                            <strong>{{ @$errors->first('thumbnail') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                @php
                                                    $tooltip = "";
                                                    if(permissionCheck('course.category.store')){
                                                          $tooltip = "";
                                                      }else{
                                                          $tooltip = trans("courses.You have no permission to add");
                                                      }
                                                @endphp
                                                <div class="col-lg-12 text-center">
                                                    <div class="d-flex justify-content-center pt_20">
                                                        <button type="submit"
                                                                class="primary-btn semi_large fix-gr-bg"
                                                                data-toggle="tooltip" title="{{@$tooltip}}"
                                                                id="save_button_parent">
                                                            <i class=" fa fa-check "></i>
                                                            @if(!isset($edit))
                                                                {{ __('common.Save') }}
                                                            @else
                                                                {{ __('common.Update') }}
                                                            @endif
                                                        </button>


                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex mb-0">
                            <h3 class="mb-0">{{__('courses.Category List')}}</h3>
                        </div>
                    </div>
                    <div class="  QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table id="lms_table" class="table table-data">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.SL') }}</th>
                                        <th scope="col">{{ __('common.Name') }}</th>
                                        <th scope="col">{{ __('common.Parent') }}</th>
                                        <th scope="col">{{ __('common.Position') }} {{ __('common.ID') }}</th>
                                        <th scope="col">{{ __('common.Description') }}</th>
                                        <th scope="col">{{ __('frontendmanage.Icon') }}</th>
                                        <th scope="col">{{ __('courses.Thumbnail Image') }}</th>
                                        <th scope="col">{{ __('common.Status') }}</th>
                                        <th scope="col">{{ __('common.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $key => $category)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td> {{checkParent($category)}} {{@$category->name }}</td>
                                            <td>{{@$category->parent->name }}</td>
                                            <td>{{@$category->position_order }}</td>
                                            <td>{{@$category->description }}</td>
                                            <td>
                                                <div>
                                                    <img style="width: 70px !important;"
                                                         src="@if(isset($category->image)){{url(@$category->image)}}@endif"
                                                         alt=""
                                                         class="img img-responsive m-2">
                                                </div>
                                            </td>

                                            <td>
                                                <img
                                                    src="@if(isset($category->thumbnail)){{url(@$category->thumbnail)}}@endif"
                                                    alt=""
                                                    class="img img-responsive m-2"
                                                    style="width: 70px !important; ">
                                            </td>
                                            <td class="nowrap">
                                                <x-backend.status :id="$category->id" :status="$category->status"
                                                                  :route="'course.category.status_update'"></x-backend.status>

                                            </td>

                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu1{{@$category->id}}"
                                                            data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu1{{@$category->id}}">
                                                        @if (permissionCheck('course.category.edit'))
                                                            <a class="dropdown-item edit_brand"
                                                               href="{{route('course.category.edit',$category->id)}}">{{__('common.Edit')}}</a>
                                                        @endif
                                                        @if (permissionCheck('course.category.delete'))
                                                            <a onclick="confirm_modal('{{route('course.category.delete', $category->id)}}');"
                                                               class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- shortby  -->
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
    </section>


    <input type="hidden" name="status_route" class="status_route" value="{{ route('course.category.status_update') }}">
    @include('backend.partials.delete_modal')
@endsection
@push('scripts')
    <script src="{{asset('public/backend/js/category.js')}}"></script>
@endpush
