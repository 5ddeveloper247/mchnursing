@if($type=='email')
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('common.Update')}} {{__('setting.Email Template')}}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-xl-12">
                        @php
                            $codes= json_decode($template->shortcodes,true);
                        @endphp


                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""><strong>{{__('communication.Field Name')}}</strong></label>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""><strong>{{__('communication.Short Code')}}</strong></label>
                                </div>
                            </div>
                            <hr>
                            @if(is_array($codes))

                                @foreach ($codes as $key=> $code)

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="">{{$code}}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   style="text-transform: lowercase;"
                                                   for="">{{"{{".$key}}}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <hr>

                    </div>
                    <form action="{{route('updateEmailTemp')}}" method="post">
                        @csrf
                        <input type="hidden" name="id"
                               value="{{@$template->id}}">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="">{{__('setting.Subject')}}</label>
                                <input class="primary_input_field"
                                       value="{{$template->subj}}" name="subj"
                                       placeholder="-" type="text">
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label"
                                       for="">{{__('setting.Email Body')}} </label>
                                <textarea class="lms_summernote"
                                          name="email_body" id="" cols="30"
                                          rows="20">{{$template->email_body}}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center pt_15">
                            <div class="d-flex justify-content-center">
                                <button
                                    class="primary-btn semi_large  fix-gr-bg"
                                    type="submit"><i
                                        class="ti-check"></i> {{__('common.Update')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@else

    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('common.Update')}} {{__('setting.Browser Message')}}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-xl-12">
                        @php
                            $codes= json_decode($template->shortcodes,true);
                        @endphp


                        <div class="row">
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""><strong>{{__('communication.Field Name')}}</strong></label>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label"
                                           for=""><strong>{{__('communication.Short Code')}}</strong></label>
                                </div>
                            </div>
                            <hr>
                            @if(is_array($codes))

                                @foreach ($codes as $key=> $code)

                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   for="">{{$code}}</label>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label"
                                                   style="text-transform: lowercase;"
                                                   for="">{{"{{".$key}}}}</label>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <hr>

                    </div>
                    <form action="{{route('updateBrowserMessage')}}" method="post">
                        @csrf
                        <input type="hidden" name="id"
                               value="{{@$template->id}}">

                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label"
                                       for="">{{__('setting.Browser Message')}} </label>
                                <textarea class="lms_summernote"
                                          name="browser_message" id="" cols="30"
                                          rows="20">{{$template->browser_message}}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center pt_15">
                            <div class="d-flex justify-content-center">
                                <button
                                    class="primary-btn semi_large  fix-gr-bg"
                                    type="submit"><i
                                        class="ti-check"></i> {{__('common.Update')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endif
<script>
    $('.lms_summernote').summernote({
        tabsize: 2,
        height: 250,
        tooltip: true,
        callbacks: {
            onImageUpload: function (files) {
                sendFile(files, '.lms_summernote', $(this).attr('name'))
            }
        }
    });
</script>
