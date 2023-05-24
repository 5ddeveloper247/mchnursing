@extends(theme('auth.layouts.app'))
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>
    <script src="https://checkout.sandbox.dev.clover.com/sdk.js"></script>

    <?php
    
    ?>

    <input type="hidden" name="id" id="accesskey" value="{{ $pakms ?? null }}">

    <div class="login_wrapper">
        <div class="login_wrapper_left">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <img style="width: 190px" src="{{ asset(Settings('logo')) }} " alt="">
                </a>
            </div>
            <div class="login_wrapper_content">

                <!-- widgetsform -->
                <div class="mainform row m-0">
                    <div class="col-md-12">
                        <div class="input_box_tittle">
                            <h4>@lang('Payment $100')</h4>
                            @if ($errors->first('Error'))
                                <span class="text-danger" role="alert">{{ $errors->first('Error') }}</span>
                            @endif
                            <div class="container">
                                <form action="{{ route('register.payp') }}" method="post" id="payment-form">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id ?? null }}">
                                    <div class="form-row top-row">
                                        <div id="amount" class="field card-number">
                                            <input type="hidden" name="amount"
                                                value="{{ convertCurrency(Settings('currency_code') ?? 'BDT', 'USD', 100) * 100 }}"
                                                placeholder="Amount">
                                        </div>
                                    </div>

                                    <div class="form-row top-row card-number border-bottom border-dark mb-2 rounded border pt-2 pl-2"
                                        style="height: 40px;">
                                        <div id="card-number" class="field"></div>
                                        <div class="input-errors" id="card-number-errors" role="alert"></div>
                                    </div>

                                    <div class="form-row border-bottom border-dark mb-2 rounded border pt-2 pl-2"
                                        style="height: 40px;">
                                        <div id="card-date" class="field third-width"></div>
                                        <div class="input-errors" id="card-date-errors" role="alert"></div>
                                    </div>

                                    <div class="form-row border-bottom border-dark mb-2 rounded border pt-2 pl-2"
                                        style="height: 40px;">
                                        <div id="card-cvv" class="field third-width"></div>
                                        <div class="input-errors" id="card-cvv-errors" role="alert"></div>
                                    </div>

                                    <div class="form-row border-bottom border-dark mb-2 rounded border pt-2 pl-2"
                                        style="height: 40px;">
                                        <div id="card-postal-code" class="field third-width"></div>
                                        <div class="input-errors" id="card-postal-code-errors" role="alert"></div>
                                    </div>

                                    <div id="card-response" role="alert"></div>
                                    <div class="button-container d-flex justify-content-center mt-3">
                                        @if (isset($pakms->message))
                                            {{ $pakms->message }}
                                        @else
                                            <button class="btn btn-outline-secondary h6">Pay Now</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="shitch_text">
            </h5>
        </div>

        @include(theme('auth.login_wrapper_right'))
        {{--        <div class="modal fade " id="bankModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" --}}

        {{--             aria-hidden="true"> --}}

        {{--            <div class="modal-dialog modal-lg" role="document"> --}}

        {{--                <div class="modal-content"> --}}

        {{--                    <div class="modal-header"> --}}

        {{--                        <h5 class="modal-title" id="exampleModalLabel">{{ __('invoice.Bank Payment') }} </h5> --}}

        {{--                    </div> --}}



        {{--                    <div class="modal-body"> --}}





        {{--                        <input type="hidden" name="method" value="Bank Payment"> --}}

        {{--                        --}}{{--                                                    <input type="hidden" name="tracking" value="{{ $checkout->tracking }}"> --}}

        {{--                        <div class="row"> --}}

        {{--                            <div class="col-xl-6 col-md-6"> --}}

        {{--                                <label for="name" class="mb-2">@lang('setting.Bank Name') --}}

        {{--                                    <span>*</span></label> --}}

        {{--                                <input type="text" required class="primary_input4 mb_20" placeholder="Bank Name" --}}

        {{--                                       name="bank_name" value="{{ @old('bank_name') }}"> --}}

        {{--                                <span class="invalid-feedback" role="alert" id="bank_name"></span> --}}

        {{--                            </div> --}}

        {{--                            <div class="col-xl-6 col-md-6"> --}}

        {{--                                <label for="name" class="mb-2">@lang('setting.Branch Name') --}}

        {{--                                    <span>*</span></label> --}}

        {{--                                <input type="text" required name="branch_name" class="primary_input4 mb_20" --}}

        {{--                                       placeholder="Name of account owner" value="{{ @old('branch_name') }}"> --}}

        {{--                                <span class="invalid-feedback" role="alert" id="owner_name"></span> --}}

        {{--                            </div> --}}

        {{--                        </div> --}}

        {{--                        <div class="row mb-20"> --}}

        {{--                            <div class="col-xl-6 col-md-6"> --}}

        {{--                                <label for="name" class="mb-2">@lang('setting.Account Number') --}}

        {{--                                    <span>*</span></label> --}}

        {{--                                <input type="text" required class="primary_input4 mb_20" --}}

        {{--                                       placeholder="Account number" name="account_number" --}}

        {{--                                       value="{{ @old('account_number') }}"> --}}

        {{--                                <span class="invalid-feedback" role="alert" id="account_number"></span> --}}

        {{--                            </div> --}}

        {{--                            <div class="col-xl-6 col-md-6"> --}}

        {{--                                <label for="name" class="mb-2">@lang('setting.Account Holder') --}}

        {{--                                    <span>*</span></label> --}}

        {{--                                <input type="text" required name="account_holder" class="primary_input4 mb_20" --}}

        {{--                                       placeholder="Account Holder" value="{{ @old('account_holder') }}"> --}}

        {{--                                <span class="invalid-feedback" role="alert" id="account_holder"></span> --}}

        {{--                            </div> --}}

        {{--                            <input type="hidden" name="deposit_amount" value="100"> --}}





        {{--                        </div> --}}



        {{--                        <div class="row  mb-20"> --}}




        {{--                            <div class="col-xl-6 col-md-12"> --}}

        {{--                                <label for="name" class="mb-2">@lang('setting.Account Type') --}}

        {{--                                    <span>*</span></label> --}}

        {{--                                <select class="theme_select wide update-select-arrow" name="type" required --}}

        {{--                                        id="type" style="margin-top: -10px;"> --}}

        {{--                                    <option --}}

        {{--                                        data-display="{{ __('common.Select') }}  {{ __('setting.Account Type') }}" --}}

        {{--                                        value="">{{ __('common.Select') }} {{ __('setting.Account Type') }} --}}

        {{--                                    </option> --}}

        {{--                                    <option value="Current Account" --}}

        {{--                                        {{ (getPaymentEnv('ACCOUNT_TYPE') ? getPaymentEnv('ACCOUNT_TYPE') : '') == 'Current Account' ? 'selected' : '' }}> --}}

        {{--                                        {{ __('invoice.Current Account') }} --}}

        {{--                                    </option> --}}



        {{--                                    <option value="Savings Account" --}}

        {{--                                        {{ (getPaymentEnv('ACCOUNT_TYPE') ? getPaymentEnv('ACCOUNT_TYPE') : '') == 'Savings Account' ? 'selected' : '' }}> --}}

        {{--                                        {{ __('invoice.Savings Account') }} --}}

        {{--                                    </option> --}}

        {{--                                    <option value="Salary Account" --}}

        {{--                                        {{ (getPaymentEnv('ACCOUNT_TYPE') ? getPaymentEnv('ACCOUNT_TYPE') : '') == 'Salary Account' ? 'selected' : '' }}> --}}

        {{--                                        {{ __('invoice.Salary Account') }} --}}

        {{--                                    </option> --}}

        {{--                                    <option value="Fixed Deposit" --}}

        {{--                                        {{ (getPaymentEnv('ACCOUNT_TYPE') ? getPaymentEnv('ACCOUNT_TYPE') : '') == 'Fixed Deposit' ? 'selected' : '' }}> --}}



        {{--                                        {{ __('invoice.Fixed Deposit') }} --}}

        {{--                                    </option> --}}



        {{--                                </select> --}}

        {{--                            </div> --}}

        {{--                            <div class="col-xl-6 col-md-12"> --}}

        {{--                                <label for="name" class="mb-2">{{ __('invoice.Cheque Slip') }} --}}

        {{--                                    <span>*</span></label> --}}

        {{--                                <input type="file" required name="image" class="primary_input4 mb_20"> --}}

        {{--                                <span class="invalid-feedback" role="alert" id="amount_validation"></span> --}}

        {{--                            </div> --}}

        {{--                        </div> --}}



        {{--                        <fieldset class="mt-3"> --}}

        {{--                            <legend>{{ __('invoice.Bank Account Info') }} --}}

        {{--                            </legend> --}}

        {{--                            <table class="table table-bordered"> --}}



        {{--                                <tr> --}}

        {{--                                    <td>@lang('setting.Bank Name')</td> --}}

        {{--                                    <td>{{ getPaymentEnv('BANK_NAME') }}</td> --}}

        {{--                                </tr> --}}

        {{--                                <tr> --}}

        {{--                                    <td>@lang('setting.Branch Name')</td> --}}

        {{--                                    <td>{{ getPaymentEnv('BRANCH_NAME') }}</td> --}}

        {{--                                </tr> --}}

        {{--                                <tr> --}}

        {{--                                    <td>@lang('setting.Account Type')</td> --}}

        {{--                                    <td>{{ getPaymentEnv('ACCOUNT_TYPE') }}</td> --}}

        {{--                                </tr> --}}

        {{--                                <tr> --}}

        {{--                                    <td>@lang('setting.Account Number')</td> --}}

        {{--                                    <td>{{ getPaymentEnv('ACCOUNT_NUMBER') }}</td> --}}

        {{--                                </tr> --}}



        {{--                                <tr> --}}

        {{--                                    <td>@lang('setting.Account Holder')</td> --}}

        {{--                                    <td>{{ getPaymentEnv('ACCOUNT_HOLDER') }}</td> --}}

        {{--                                </tr> --}}

        {{--                            </table> --}}

        {{--                        </fieldset> --}}

        {{--                    </div> --}}

        {{--                    <div class="modal-footer d-flex justify-content-between"> --}}

        {{--                        <button type="button" class=" theme_line_btn " --}}

        {{--                                data-dismiss="modal">@lang('common.Cancel')</button> --}}

        {{--                        <button class="  theme_btn" type="submit">@lang('payment.Payment')</button> --}}

        {{--                    </div> --}}



        {{--                </div> --}}

        {{--            </div> --}}

        {{--        </div> --}}

    </div>


    <script>
        const accesskey = document.getElementById('accesskey').value;

        const clover = new Clover(accesskey);
        const elements = clover.elements();

        let styles = "";
        const form = document.getElementById('payment-form');
        const cardNumber = elements.create('CARD_NUMBER', styles);
        const cardDate = elements.create('CARD_DATE', styles);
        const cardCvv = elements.create('CARD_CVV', styles);
        const cardPostalCode = elements.create('CARD_POSTAL_CODE', styles);

        cardNumber.mount('#card-number');
        cardDate.mount('#card-date');
        cardCvv.mount('#card-cvv');
        cardPostalCode.mount('#card-postal-code');

        const cardResponse = document.getElementById('card-response');
        const displayCardNumberError = document.getElementById('card-number-errors');
        const displayCardDateError = document.getElementById('card-date-errors');
        const displayCardCvvError = document.getElementById('card-cvv-errors');
        const displayCardPostalCodeError = document.getElementById('card-postal-code-errors');

        // Handle real-time validation errors from the card element
        cardNumber.addEventListener('change', function(event) {
            console.log(`cardNumber changed ${JSON.stringify(event)}`);
        });

        cardNumber.addEventListener('blur', function(event) {
            console.log(`cardNumber blur ${JSON.stringify(event)}`);
        });

        cardDate.addEventListener('change', function(event) {
            console.log(`cardDate changed ${JSON.stringify(event)}`);
        });

        cardDate.addEventListener('blur', function(event) {
            console.log(`cardDate blur ${JSON.stringify(event)}`);
        });

        cardCvv.addEventListener('change', function(event) {
            console.log(`cardCvv changed ${JSON.stringify(event)}`);
        });

        cardCvv.addEventListener('blur', function(event) {
            console.log(`cardCvv blur ${JSON.stringify(event)}`);
        });

        cardPostalCode.addEventListener('change', function(event) {
            console.log(`cardPostalCode changed ${JSON.stringify(event)}`);
        });

        cardPostalCode.addEventListener('blur', function(event) {
            console.log(`cardPostalCode blur ${JSON.stringify(event)}`);
        });


        // Listen for form submission
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            // Use the iframe's tokenization method with the user-entered card details
            clover.createToken()
                .then(function(result) {
                    if (result.errors) {
                        Object.values(result.errors).forEach(function(value) {
                            //displayError.textContent = value;
                            alert(value);
                        });
                    } else {
                        cloverTokenHandler(result.token);
                    }
                });
        });


        function cloverTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'cloverToken');
            hiddenInput.setAttribute('value', token);
            form.appendChild(hiddenInput);
            console.log(hiddenInput);
            form.submit();
        }
    </script>
@endsection
