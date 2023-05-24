<div>
    <style>
        .list-group-item2 {
            padding: 10px;
            margin: 5px;
            border: 2px solid #ccc;
        }
    </style>

    <div class="question_list d-none">

        @foreach($quiz->assign as $key=>$assign)
            @php
                $qus= $assign->questionBank;
            @endphp
            <div class="card" id="question{{$qus->id}}">
                <div class="card-header">
                    <b>{{__('quiz.Question')}} {{++$key}}</b>
                </div>
                <div class="card-body">
                    <p class="card-text">{!! $qus->question !!}</p>
                    <a href="#" class="btn theme_btn_mini hide_show_btn"
                       data-id="{{$qus->id}}" data-type="check">{{__('quiz.Check')}}</a>
                    <a href="#" class="btn theme_btn_mini hide_show_btn"
                       data-id="{{$qus->id}}" data-type="hide">{{__('quiz.Hide Answer')}}</a>

                    <div class="answer{{$qus->id}} d-none list mt-4">
                        <ul class="">
                            @foreach($qus->questionMuInSerial as $option)
                                <li class="list-group-item2 list-option" id="list_option{{$option->id}}">
                                    <label
                                        class="primary_checkbox2 d-flex ">
                                        <input id="option{{$option->id}}"
                                               disabled
                                               type="checkbox">
                                        <span
                                            class="checkmark mr_10"></span>
                                        <span
                                            class="label_name">{{$option->title}}

                                                                           <span
                                                                               class="mr_10  ti-close text-danger d-none"></span>
                                                                           <span
                                                                               class="mr_10  ti-check text-success d-none"></span>
                                                                        </span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card-footer answer{{$qus->id}} d-none ">
                    <b>
                        {{__('quiz.Explanation')}}
                    </b>
                </div>
                <div class="card-body answer{{$qus->id}} d-none">
                    <p class="card-text">
                        {!! $qus->explanation !!}
                    </p>

                </div>
            </div>
        @endforeach

    </div>
    <input type="hidden" id="quiz_test_id" value="0">
    <script>
        $(document).on('click', '.submit_q_btn', function (e) {
            e.preventDefault();
            $('#quiz_test_id').val($(this).data('quiz_test_id'))
            $('.question_list').removeClass('d-none');
            UpdateResult();
        });
        $(document).on('click', '.hide_show_btn', function (e) {
            e.preventDefault();
            var type = $(this).data('type');
            var id = $(this).data('id');
            if (type == 'check') {
                $('.answer' + id).removeClass('d-none');
            } else {
                $('.answer' + id).addClass('d-none')
            }
        });


        $.ajaxSetup({
            headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
        });

        function UpdateResult() {
            let list_option =$('.list-option');
            list_option.removeClass('border-success');
            list_option.removeClass('border-danger');
            list_option.find('label').removeClass('error_ans');
            list_option.find('.text-danger').addClass('d-none');
            list_option.find('.text-success').addClass('d-none');
            $('input:checkbox').removeAttr('checked');

            let quiz_test_id = $('#quiz_test_id').val();
            if (quiz_test_id != 0) {
                jQuery.ajax({
                    url: '{{url('quizResultPreviewApi')}}/' + quiz_test_id,
                    type: 'GET',
                    success: function (data) {

                        $.each(data, function (index, value) {
                            $.each(value.option, function (index2, value2) {
                                let list_option = $('#list_option' + value2.id)
                                let option = $('#option' + value2.id);
                                if (value2.wrong) {
                                    list_option.addClass('border-danger');
                                    list_option.removeClass('border-success');
                                    list_option.find('label').addClass('error_ans');
                                    list_option.find('.text-danger').removeClass('d-none');
                                    list_option.find('.text-success').addClass('d-none');
                                    option.prop('checked', true);
                                }
                                if (value2.right) {
                                    list_option.find('label').removeClass('error_ans');
                                    list_option.addClass('border-success');
                                    list_option.removeClass('border-danger');
                                    list_option.find('.text-danger').addClass('d-none');
                                    list_option.find('.text-success').removeClass('d-none');
                                    option.prop('checked', true);
                                }
                                if(!value.isSubmit) {
                                    list_option.find('label').removeClass('error_ans');
                                    list_option.removeClass('border-success');
                                    list_option.removeClass('border-danger');
                                    list_option.find('.text-success').addClass('d-none');
                                    list_option.find('.text-danger').addClass('d-none');
                                    option.prop('checked', false);
                                }
                            });
                        });
                    }
                });
            }
        }


    </script>

</div>
