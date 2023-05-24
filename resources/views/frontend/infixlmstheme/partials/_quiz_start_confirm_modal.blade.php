<div class="modal cs_modal fade admin-query" id="StartConfirmModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Start Test-Prep') }}</h5>
                <button type="button" class="close" data-dismiss="modal"><i class="ti-close"></i></button>
            </div>


            <div class="modal-body">
                @csrf
                {{ __('Are you ready for Test-Prep?') }}
            </div>
            <div class="modal-footer justify-content-center">
                <div class="mt-40">
                    <button type="button" class="theme_line_btn small_btn2 mr-2"
                        data-dismiss="modal">{{ __('common.No') }}
                    </button>
                    <button class="theme_btn small_btn2" type="button"
                        id="QuizStartBtn">{{ __('common.Yes') }}</button>
                </div>
            </div>


        </div>
    </div>
</div>
