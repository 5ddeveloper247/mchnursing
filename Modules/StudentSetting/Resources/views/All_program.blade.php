


@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('public/backend/css/student_list.css')}}"/>
@endpush


@section('mainContent')

    {!! generateBreadcrumb() !!}

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-8">
                    <div class="main-title">
                        <h3>{{__('Program')}}</h3>
                    </div>
                </div>
            </div>



    <form action="{{route('addprogram')}}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="row">
                <div class="col-lg-12">


                    <div class="white-box">
                        <div class="">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-title">

                                    </div>
                                </div>
                            </div>
                               <div class="row mb-40 mt-30">
                               <div class="col-xl-6">
                                      <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="">Program Title <small>Max size
                                                    (15 words)</small></label>
                                            <input class="primary_input_field" name="ProgramTitle"
                                                   placeholder="-"
                                                   id="addTitle"
                                                   maxlength="15"
                                                   type="text" {{$errors->has('title') ? 'autofocus' : ''}}
                                                   value="{{ old('ProgramTitle') }}" >
                                        </div>
                               </div>
                                <div class="col-xl-6">
                                       <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="">Program subtitle/greetings <small>Max size
                                                    (20 words)</small></label>
                                            <input class="primary_input_field" name="subtitle"
                                                   placeholder="-"
                                                   id="addTitle"
                                                   maxlength="20"
                                                   type="text" {{$errors->has('title') ? 'autofocus' : ''}}
                                                   value="{{ old('subtitle') }}">
                                        </div>
                                 </div>
                            </div>


                                <div class="row mb-40 mt-30">
                                <div class="col-xl-6">
                                    <div class="primary_input mb-35">
                                        <label class="primary_input_label" for="">Program image/thumbnail

                                        </label>
                                        <div class="primary_file_uploader">
                                            <input class="primary-input imgName" type="text" id="placeholderFileOneName" placeholder="Browse Image file" readonly="">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="document_file">Browse</label>
                                                <input type="file" class="d-none imgBrowse" name="image" id="document_file" value="">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @php
                                       $oldfaqs = (old('faqs') == null) ? [] :  old('faqs');
                                   @endphp
                                   <div class="col-xl-6">
                                       <div class="primary_input mb-25">
                                           <label class="primary_input_label"
                                                  for="faqs">Select faqs</label>
                                           <select name="faqs[]" id="faqs"
                                                   class="multypol_check_select active mb-15 e1"
                                                   multiple >

                                               @foreach($faqs as  $faq)
                                                   <option value="{{$faq->id}}"
                                                       {{(in_array((string)$faq->id, $oldfaqs) ? 'selected' : '') }}
                                                   >{{$faq->question}}</option>
                                               @endforeach

                                           </select>
                                       </div>
                                   </div>
                            </div>

                               <div class="row mb-40 mt-30 d-none">
                                <div class="col-xl-6">
                                     <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="">Program duration in weeks</label>
                                            <input class="primary_input_field" name="duration"
                                                   placeholder="-weeks"
                                                   id="addTitle"
                                                   type="number" {{$errors->has('title') ? 'autofocus' : ''}}
                                                   value="1" >
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for=""> Program total cost</label>
                                                <input class="primary_input_field" name="totalcost"
                                                       placeholder="-"
                                                       id="addTitle"
                                                       type="text" {{$errors->has('title') ? 'autofocus' : ''}}
                                                       value="0">
                                            </div>
                                          </div>
                                    </div>

                                      <div class="row mb-40 mt-30">

                                      <div class="col-xl-12">

                                     <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for=""> Program requirements</label>
                                           <textarea class="lms_summernote"
                                                      name="requirements" id="addAbout"
                                                      cols="30"
                                                      rows="10" >{{ old('requirements') }}</textarea>
                                        </div>
                                      </div>
                            </div>



                              <div class="row mb-40 mt-30">


                              <div class="col-xl-12">

                                       <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="">Program description</label>
                                            <textarea class="lms_summernote"
                                                      name="description" id="addAbout"
                                                      cols="30"
                                                      rows="10" >{{ old('description') }}</textarea>
                                        </div>
                            </div>
                            </div>
                             <div class="row mb-40 mt-30">
                         <div class="col-xl-12">
                             <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for=""> Program outcome</label>
                                            <textarea class="lms_summernote"
                                                      name="outcome" id="addAbout"
                                                      cols="30"
                                                      rows="10" >{{ old('outcome') }}</textarea>
                                        </div>
                                      </div>
                                      </div>



                             <div class="row mb-40 mt-30">
{{--                                          <div class="col-xl-6">--}}

{{--                                <div class="primary_input mb-25">--}}
{{--                                            <label class="primary_input_label"--}}
{{--                                                   for="">Number of courses </label>--}}
{{--                                            <input class="primary_input_field" name="numberofcourses"--}}
{{--                                                   placeholder="-"--}}
{{--                                                   id="addTitle"--}}
{{--                                                   type="number" {{$errors->has('title') ? 'autofocus' : ''}}--}}
{{--                                                   value="{{ old('numberofcourses') }}" >--}}
{{--                                        </div>--}}
{{--                                      </div>--}}

                                @php
                                $oldcourses = (old('allcourses') == null) ? [] :  old('allcourses');
                                @endphp
                               <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="assistant_instructors">Select Courses</label>
                                <select name="allcourses[]" id="allcourses"
                                        class="multypol_check_select active mb-15 e1"
                                        multiple >

                                @foreach($courses as  $courses1)
                                       <option value="{{$courses1->id}}"
                                           {{(in_array((string)$courses1->id, $oldcourses) ? 'selected' : '') }}
                                       >{{$courses1->slug}}</option>
                                @endforeach

                                </select>
                            </div>
                        </div>



                  </div>
                              <div class="row mb-40 mt-30">
                                          <div class="col-xl-12">

                                <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="">Payment Plan </label>
                                           <textarea class="lms_summernote"
                                                      name="Payment_plan" id="addAbout"
                                                      cols="30"
                                                      rows="10">{{ old('Payment_plan') }}</textarea>
                                        </div>
                                      </div>
                            </div>

{{--                            <div class="custom-control custom-switch">--}}
{{--                              <input type="checkbox"  {{old('status') == 1 ? "checked" : ""}} class="custom-control-input" name="status" id="customSwitch1" value="{{ old('status') }}">--}}
{{--                              <label class="custom-control-label" for="customSwitch1">Status</label>--}}
{{--                            </div>--}}

                            <div class="row mt-40">
                                <div class="col-lg-12 text-center">
                                    <button class="primary-btn semi_large2 fix-gr-bg"  id="save_button_parent"  type="submit">
                                        <span class="ti-check"></span>
                                        {{__('Submit')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </form>
        </div>
    </section>
    <script>
        $(".imgBrowse").change(function (e) {

            e.preventDefault();

            var file = $(this).closest('.primary_file_uploader').find('.imgName');

            var filename = $(this).val().split('\\').pop();

            file.val(filename);

        });
        $("#save_button_parent").click(function () {
            $(this).attr('disabled');
            $(this).find('span').attr('class','').addClass('fa fa-spinner fa-spin fa-lg');
        });
    </script>
@endsection

