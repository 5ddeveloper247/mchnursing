<script>
    function addToSaleModal(add_to_sale_url, id) {
        jQuery('#add_to_sale').modal('show', {
            backdrop: 'static'
        });
        document.getElementById('add_to_sale_link').setAttribute('action', add_to_sale_url);
        document.getElementById('test_prep_id').setAttribute('value', id);
    }
</script>

<div class="modal fade admin-query" id="add_to_sale">
    <div class="modal-dialog modal-dialog-centered modal_1000px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ 'Add To Sale' }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="form row" id="add_to_sale_link" method="POST">
                    @csrf
                    <input type="hidden" name="test_prep_id" id="test_prep_id" value="">
                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">Start Date <strong
                                    class="text-danger">*</strong></label>
                            <input class="primary-input primary_input_field form-control" value=""
                                name="start_date" id="start_date" type="date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">End Date <strong
                                    class="text-danger">*</strong></label>
                            <input class="primary-input primary_input_field form-control" value="" name="end_date"
                                type="date" id="end_date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">Price <strong
                                    class="text-danger">($)</strong></label>
                            <input class="primary-input primary_input_field form-control" value="" name="price"
                                type="number" id="price">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">Status</label>
                            <select class="primary_select mb-25" name="status" id="status">
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-lg-12 text-center">
                        <div class="d-flex justify-content-between mt-40">
                            <button type="button" class="primary-btn tr-bg"
                                data-dismiss="modal">{{ __('common.Cancel') }}</button>
                            <button type="submit" id="add_to_sale_btn" class="primary-btn semi_large2 fix-gr-bg">
                                {{ 'Confirm' }}
                            </button>

                            <a id="deletingButton" class="primary-btn semi_large2 fix-gr-bg d-none">
                                {{ __('common.Updating') }} ....
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="sr-only"></span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
