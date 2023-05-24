<script>
    (function ($) {
        "use strict";

        $('tbody').sortable({
            cursor: "move",
            update: function (event, ui) {
                let ids = $(this).sortable('toArray', {attribute: 'data-item'});
                console.log(ids);
                if (ids.length > 0) {
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        'ids': ids,
                    }
                    $.post("{{route('frontend.changeHomePageFaqPosition')}}", data, function (data) {

                    });
                }
            }
        });


        $(document).on('click', '.editfaq', function () {
            let faq = $(this).data('item');
            $('#faqId').val(faq.id);
            @foreach ($LanguageList as $key => $language)
            $('#editQuestion{{$language->code}}').val(faq.question.{{$language->code}});
            $('#editAnswer{{$language->code}}').summernote("code", faq.answer.{{$language->code}});
            @endforeach
            $('#editOrder').val(faq.order);

            $("#editfaq").modal('show');

        });


        $(document).on('click', '.deletefaq', function () {
            let id = $(this).data('id');
            $('#faqDeleteId').val(id);
            $("#deletefaq").modal('show');
        });


        $(document).on('click', '#add_faq_btn', function () {
            $('#addQuestion').val('');
            $('#addAnswer').html('');
        });
    })(jQuery);
</script>



@if ($errors->any())
    <script>
        @if(Session::has('type'))
        @if(Session::get('type')=="store")
        $('#add_faq').modal('show');
        @else
        $('#editfaq').modal('show');
        @endif
        @endif
    </script>
@endif
