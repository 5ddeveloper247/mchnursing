<div class="modal cs_modal fade admin-query" id="submitConfirmModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Submit Test-Prep') }}</h5>
                <button type="button" class="close" data-dismiss="modal"><i
                        class="ti-close quizSubmitClose"></i></button>
            </div>


            <div class="modal-body">
                @csrf
                {{ __('frontend.Are you sure?') }}
            </div>
            <div class="modal-footer justify-content-center">
                <div class="mt-40">
                    <button type="button" class="theme_line_btn small_btn2 quizSubmitClose mr-2"
                        data-dismiss="modal">{{ __('common.Cancel') }}
                    </button>
                    <button class="theme_btn small_btn2" type="button"
                        id="QuizSubmitBtn">{{ __('common.Submit') }}</button>
                </div>
            </div>


        </div>
    </div>
</div>
