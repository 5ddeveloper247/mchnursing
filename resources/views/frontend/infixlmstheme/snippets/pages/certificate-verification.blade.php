<div
    class="full-page"
    data-type="component-text"
    data-preview="{{!function_exists('themeAsset')?'':themeAsset('img/snippets/preview/certificate_verification/search.jpg')}}"
    data-aoraeditor-title="Certificate Verification Form" data-aoraeditor-categories="Certificate Verification Page">

    <div class="contact_section ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="contact_address certificate-verify">
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="row justify-content-between">
                                    <div class="col-lg-12 p-5">
                                        <div class="contact_title">
                                            <h4 class="mb-0">{{__('certificate.Verify Certificate')}}</h4>
                                            <div class="subcribe-form theme_mailChimp mt-40">
                                                <form action="#"
                                                      method="GET" class="subscription relative">
                                                    <input name="certificate_number" class="primary_input4"
                                                           placeholder="{{__('certificate.Enter Certificate Number')}}"
                                                           onfocus="this.placeholder = ''"
                                                           onblur="this.placeholder = '{{__('certificate.Enter Certificate Number')}}'"
                                                           required="" type="text"
                                                           value="{{old('certificate_number')}}">

                                                    <button id="getCertificate"
                                                            type="button">{{__('chat.search')}}</button>

                                                </form>
                                            </div>
                                        </div>

                                        <div class="address_lines py-3">
                                            <img class="d-none" style="width: 100%; height:auto" src=""
                                                 id="certificateImg"
                                                 alt="">
                                            <h2 class="text-center" id="certificateMsg"></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
