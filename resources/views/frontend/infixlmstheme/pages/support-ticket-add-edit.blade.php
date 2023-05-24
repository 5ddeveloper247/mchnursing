@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('ticket.support_ticket')}} @endsection
@section('css')
    <link rel="stylesheet" href="{{asset('public/frontend/infixlmstheme/css/support.css')}}">
@endsection
@section('js')
    <script src="{{asset('public/frontend/infixlmstheme/js/support.js')}}"></script>
@endsection

@section('mainContent')
    @php
        if(routeIs('student.support-ticket.create')){
        $new =true;
    }else{
        $new=false;
    }
    @endphp
    <div class="main_content_iner support_main">
        <div class="support_main_card_title">
            <h5>
                @if($new)
                    {{__('ticket.open_a_ticket')}}
                @else
                    {{__('ticket.update_ticket')}}
                @endif
            </h5>
        </div>
        <div class="support_main_create">
            <form
                action="{{$new?route('student.support-ticket.store'):route('student.support-ticket.update',$ticket->id)}}"
                method="post" enctype="multipart/form-data">
                @csrf
                <div class='row'>
                    <div class="col-md-6">
                        <div class="support_main_card_content_item">
                            <label for="#" class='primary_label2'>{{__('ticket.subject')}} <span>*</span></label>
                            <input type="text" value="{{$ticket->subject}}" class="primary_input4" name="subject"
                                   placeholder='Subject' required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="support_main_card_content_item">
                            <label for="#" class='primary_label2'>{{__('common.Category')}} <span>*</span></label>
                            <select name="category_id" id="" class="theme_select w-100">
                                <option value="">{{__('common.Select')}}</option>
                                @foreach($CategoryList as $category)
                                    <option
                                        {{$ticket->category_id==$category->id?'selected':''}} value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="support_main_card_content_item">
                            <label for="#" class='primary_label2'>{{__('common.Priority')}} <span>*</span></label>
                            <select name="priority_id" id="" class="theme_select w-100">
                                <option value="">{{__('common.Select')}}</option>
                                @foreach($PriorityList as $priority)
                                    <option
                                        {{$ticket->priority_id==$priority->id?'selected':''}} value="{{$priority->id}}">{{$priority->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="support_main_card_content_item">
                            <label for="#" class='primary_label2'>{{ __('common.Description') }} <span>*</span></label>
                            <textarea name="description" id="" cols="30" rows="10" placeholder='Write here...'
                                      class='primary_input4 editor  '>{!! $ticket->description !!}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($ticket->attachFiles as $key => $file)
                        <div class="col-10 pb-3">
                            <a class="attach_file_name"
                               href="{{ URL::to('/') }}/{{ $file->url }}"
                               download="">{{  $key+1 }} .
                                {{ strlen($file->name) > 20 ? substr($file->name, 0,20) . '...' . $file->type : $file->name}}</a>
                            <span class="float-right attach_delete_btn"><a
                                    class="text-white attach_file_delete"
                                    data-id="{{$file->id}}"
                                    href=""><i class="ti-trash"></i></a></span>
                        </div>

                    @endforeach
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="all_attach">
                            <div class="row attach-item support_main_file">
                                <div class="col-11">
                                    <div class="support_main_card_content_item">
                                        <label for="#" class='primary_label2'>{{ __('ticket.attach_file') }}</label>
                                        <div class="position-relative primary_file_uploader">
                                            <input type="text" class="primary_input4 filePlaceholder"
                                                   placeholder='{{ __('ticket.attach_file') }}' readonly>
                                            <button type='button' class='theme_btn' id='file-upload'>
                                                <label for="ticket_file">{{__('common.Browse')}}</label>
                                                <input type="file" name="ticket_file[]" class='d-none fileUpload'
                                                       id="ticket_file">
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 text-right">
                                    <button type="button" class="theme_btn action" id=''><i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-right mobile-center mt-md-4">
                        <button type="submit" class="theme_btn"><i
                                class="ti ti-check"></i>
                            @if($new)
                                {{__('ticket.create_ticket')}}
                            @else
                                {{__('ticket.update_ticket')}}

                            @endif
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
