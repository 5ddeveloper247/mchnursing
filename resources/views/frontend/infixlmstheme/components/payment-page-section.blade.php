
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
<script src="https://checkout.sandbox.dev.clover.com/sdk.js"></script>

</head>

<?php

    $pakms=Config::get('apiaccess');



?>

<div>

<input type="hidden" name="id" id="accesskey" value="{{  $pakms ?? null }}">

    <div class="checkout_wrapper payment_area" id="mainFormData">



        <div class="billing_details_wrapper">

            <div class="biling_address gray-bg">

                <div class="biling-header d-flex justify-content-between align-items-center">

                    <h4>{{ __('frontendmanage.Billing Address') }}</h4>



                         @if(isModuleActive('Invoice') && ($type == 'invoice' || $type == 'certificate' ))

                            <a class="billingUpdate">{{ __('common.Edit') }}</a>

                            <a class="billingUpdateShow d-none">{{ __('common.Show') }}</a>

                        @else

                            <a href="{{ route('CheckOut') }}?type=edit">{{ __('common.Edit') }}</a>

                        @endif

                </div>

                <div class="biling_body_content" id="deafult">

                    <p>{{ @$checkout->billing->first_name }} {{ @$checkout->billing->last_name }}</p>

                    <p>{{ @$checkout->billing->address }}</p>

                    <p>{{ @$checkout->billing->stateDetails->name }},{{ @$checkout->billing->cityDetails->name }} -

                        {{ @$checkout->billing->zip_code }} </p>

                    <p> {{ @$checkout->billing->countryDetails->name }} </p>

                </div>



            </div>

            @if(isModuleActive('Invoice'))

                @includeIf('invoice::billing')

            @endif

            <div class="select_payment_method">

                <div class="input_box_tittle">

                    <h4>@lang('Clover Payment ')</h4>

                    <div class="container">
                        <form action="{{ route('paymentSubmit') }}" method="post" id="payment-form">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Illuminate\Support\Facades\Auth::user()->id ?? null}}">
                            <input type="hidden" name="tracking_id"value="{{ $checkout->tracking }}">
                            <input type="hidden" name="id" value="{{ $checkout->id }}">
                            <div class="form-row top-row">
                                <div id="amount" class="field card-number">
                                    <input type="hidden" name="amount" value="{{ convertCurrency(Settings('currency_code') ?? 'BDT', 'USD', $checkout->purchase_price)*100 }}" placeholder="Amount">
                                </div>
                            </div>

                            <div class="form-row top-row card-number border border-bottom border-dark pt-2 pl-2 rounded mb-2" style="height: 40px;">
                                <div id="card-number" class="field "></div>
                                <div class="input-errors" id="card-number-errors" role="alert"></div>
                            </div>

                            <div class="form-row border border-bottom border-dark pt-2 pl-2 rounded mb-2" style="height: 40px;" >
                                <div id="card-date" class="field third-width"></div>
                                <div class="input-errors" id="card-date-errors" role="alert"></div>
                            </div>

                            <div class="form-row border border-bottom border-dark pt-2 pl-2 rounded mb-2" style="height: 40px;">
                                <div id="card-cvv" class="field third-width"></div>
                                <div class="input-errors" id="card-cvv-errors" role="alert"></div>
                            </div>

                            <div class="form-row border border-bottom border-dark pt-2 pl-2 rounded mb-2" style="height: 40px;">
                                <div id="card-postal-code" class="field third-width"></div>
                                <div class="input-errors" id="card-postal-code-errors" role="alert"></div>
                            </div>

                            <div id="card-response" role="alert"></div>

                            <div class="button-container float-right mr-4 mt-3 ">
                                @if(isset($pakms->message))
                                    {{ $pakms->message }}
                                @else
                                    <button class="btn btn-secondary h6" style="background: var(--system_primery_color);border:var(--system_primery_color); ">Pay Now</button>
                                @endif
                            </div>

                        </form>
{{--<form action="{{ route('paymentSubmit') }}" method="post" id="payment-form">--}}
{{--    @csrf--}}
{{--  <div class="form-row top-row">--}}
{{--    <div id="amount" class="field card-number">--}}
{{--      <input type="hidden" name="amount" value="{{ convertCurrency(Settings('currency_code') ?? 'BDT', 'USD', $checkout->purchase_price)*100 }}"placeholder="Amount">--}}
{{--    </div>--}}
{{--  </div>--}}
{{--  <input type="hidden" name="tracking_id"value="{{ $checkout->tracking }}">--}}
{{--  <input type="hidden" name="id" value="{{ $checkout->id }}">--}}
{{--  <div class="form-row top-row">--}}
{{--    <div id="card-number" class="field card-number"></div>--}}
{{--    <div class="input-errors" id="card-number-errors" role="alert"></div>--}}
{{--  </div>--}}

{{--  <div class="form-row">--}}
{{--    <div id="card-date" class="field third-width"></div>--}}
{{--    <div class="input-errors" id="card-date-errors" role="alert"></div>--}}
{{--  </div>--}}

{{--  <div class="form-row">--}}
{{--    <div id="card-cvv" class="field third-width"></div>--}}
{{--    <div class="input-errors" id="card-cvv-errors" role="alert"></div>--}}
{{--  </div>--}}

{{--  <div class="form-row">--}}
{{--    <div id="card-postal-code" class="field third-width"></div>--}}
{{--    <div class="input-errors" id="card-postal-code-errors" role="alert"></div>--}}
{{--  </div>--}}

{{--  <div id="card-response" role="alert"></div>--}}

{{--	<div class="button-container">--}}
{{--    <button>Submit Payment</button>--}}
{{--  </div>--}}

{{--</form>--}}
</div>

                </div>



                <div class="privaci_polecy_area section-padding checkout_area ">

                    <div class="">

                        <div class="row">

                            <div class="col-12">

                                <div class="payment_method_wrapper">



                                    @if (isset($methods))

                                        @php

                                            $withMoule = $methods;



                                            $methods = $methods->where('method', '!=', 'Bank Payment')->where('method', '!=', 'Offline Payment');

                                            $payment_type = $checkout->invoice ? $checkout->invoice->payment_type : null;

                                            if (isModuleActive('Invoice') && $payment_type == 2) {

                                                $methods = $withMoule->where('method', 'Bank Payment');

                                            }



                                        @endphp





                                    @endif



                                </div>

                            </div>

                        </div>

                    </div>

                </div>





            </div>

        </div>



        <div class="order_wrapper">

            <h3 class="font_22 f_w_700 mb_30">{{ __('frontend.Your order') }}</h3>

            <div class="ordered_products">

                @php $totalSum=0; @endphp



                @if (isset($carts))



                    @foreach ($carts as $cart)
                        @if(!empty($cart->course_id))
                            @php

                                if ($cart->course_id) {

                                    if ($cart->course_id != 0) {

                                        if ($cart->course->discount_price > 0) {

                                            $price = $cart->course->discount_price;

                                        } else {

                                            $price = $cart->price;

                                        }

                                    } else {

                                        $price = $cart->bundle->price;

                                    }

                                } elseif (isModuleActive('Appointment')) {

                                    $price = $cart->instructor->hour_rate;

                                } else {

                                    $price = 0;

                                }

                                if($type=="certificate") {

                                    $price = $cart->price;

                                }

                                $totalSum = $totalSum + @$price;



                            @endphp
                            <div class="single_ordered_product">

                                <div class="product_name d-flex align-items-center">

                                    <div class="thumb">

                                        <img src="{{ getCourseImage(@$cart->course->thumbnail) }}" class="h-100" alt="">

                                    </div>

                                    <span>{{ @$cart->course->title }} {{ $type == 'certificate' ? '['.__('certificate.Certificate').']' :'' }}</span>

                                </div>

                                <span class="order_prise f_w_500 font_16">

                                {{ getPriceFormat($price) }}

                            </span>

                            </div>
                        @else
                            @php

                                if ($cart->program_id) {

                                    if ($cart->program_id != 0) {

                                        if ($cart->program->discount_price > 0) {

                                            $price = $cart->program->discount_price;

                                        } else {

                                            $price = $cart->price;

                                        }

                                    } else {

                                        $price = $cart->bundle->price;

                                    }

                                } elseif (isModuleActive('Appointment')) {

                                    $price = $cart->instructor->hour_rate;

                                } else {

                                    $price = 0;

                                }

                                if($type=="certificate") {

                                    $price = $cart->price;

                                }

                                $totalSum = $totalSum + @$price;



                            @endphp
                            <div class="single_ordered_product">

                                <div class="product_name d-flex align-items-center">

                                    <div class="thumb">

                                        <img src="{{ getCourseImage(@$cart->program->icon) }}" class="h-100" alt="">

                                    </div>

                                    <span>{{ @$cart->program->programtitle }} {{ $type == 'certificate' ? '['.__('certificate.Certificate').']' :'' }}</span>

                                </div>

                                <span class="order_prise f_w_500 font_16">

                                {{ getPriceFormat($price) }}

                            </span>

                            </div>
                        @endif

                    @endforeach

                @endif

            </div>

            <div class="ordered_products_lists">

                <div class="single_lists">

                    <span class=" total_text">{{ __('frontend.Subtotal') }}</span>

                    <span>{{ getPriceFormat($checkout->price) }}</span>

                </div>

                @if ($checkout->purchase_price > 0)

                    <div class="single_lists">



                        <span class="total_text">{{ __('payment.Discount Amount') }}</span>

                        <span>{{ $checkout->discount == '' ? '0' : getPriceFormat($checkout->discount) }}</span>

                    </div>

                    @if (hasTax())

                        <div class="single_lists">

                            <span class="total_text">{{ __('tax.TAX') }} </span>



                            <span class="totalTax">{{ getPriceFormat($checkout->tax) }}</span>

                        </div>

                    @endif

                    <div class="single_lists">

                        <span class="total_text">{{ __('frontend.Payable Amount') }} </span>

                        <span class="totalBalance">{{ getPriceFormat($checkout->purchase_price) }}</span>

                    </div>

                @endif

            </div>



        </div>

    </div>

</div>

@if (isModuleActive('Invoice') && $payment_type == 2)

    <div class="modal fade " id="bankModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"

        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">{{ __('invoice.Bank Payment') }} </h5>

                </div>

                <form name="bank_payment" enctype="multipart/form-data" action="{{ route('invoice.offline-payment.store') }} "

                    class="single_account-form" method="POST">

                    <div class="modal-body">

                        @csrf



                        <input type="hidden" name="method" value="Bank Payment">

                        <input type="hidden" name="tracking" value="{{ $checkout->tracking }}">

                        <div class="row">

                            <div class="col-xl-6 col-md-6">

                                <label for="name" class="mb-2">@lang('setting.Bank Name')

                                    <span>*</span></label>

                                <input type="text" required class="primary_input4 mb_20" placeholder="Bank Name"

                                    name="bank_name" value="{{ @old('bank_name') }}">

                                <span class="invalid-feedback" role="alert" id="bank_name"></span>

                            </div>

                            <div class="col-xl-6 col-md-6">

                                <label for="name" class="mb-2">@lang('setting.Branch Name')

                                    <span>*</span></label>

                                <input type="text" required name="branch_name" class="primary_input4 mb_20"

                                    placeholder="Name of account owner" value="{{ @old('branch_name') }}">

                                <span class="invalid-feedback" role="alert" id="owner_name"></span>

                            </div>

                        </div>

                        <div class="row mb-20">



                            <div class="col-xl-6 col-md-6">

                                <label for="name" class="mb-2">@lang('setting.Account Number')

                                    <span>*</span></label>

                                <input type="text" required class="primary_input4 mb_20"

                                    placeholder="Account number" name="account_number"

                                    value="{{ @old('account_number') }}">

                                <span class="invalid-feedback" role="alert" id="account_number"></span>

                            </div>

                            <div class="col-xl-6 col-md-6">

                                <label for="name" class="mb-2">@lang('setting.Account Holder')

                                    <span>*</span></label>

                                <input type="text" required name="account_holder" class="primary_input4 mb_20"

                                    placeholder="Account Holder" value="{{ @old('account_holder') }}">

                                <span class="invalid-feedback" role="alert" id="account_holder"></span>

                            </div>

                            <input type="hidden" name="deposit_amount" value="{{ $checkout->price }}">





                        </div>



                        <div class="row  mb-20">





                            <div class="col-xl-6 col-md-12">

                                <label for="name" class="mb-2">@lang('setting.Account Type')

                                    <span>*</span></label>

                                <select class="theme_select wide update-select-arrow" name="type" required

                                    id="type" style="margin-top: -10px;">

                                    <option

                                        data-display="{{ __('common.Select') }}  {{ __('setting.Account Type') }}"

                                        value="">{{ __('common.Select') }} {{ __('setting.Account Type') }}

                                    </option>

                                    <option value="Current Account"

                                        {{ (getPaymentEnv('ACCOUNT_TYPE') ? getPaymentEnv('ACCOUNT_TYPE') : '') == 'Current Account' ? 'selected' : '' }}>

                                        {{ __('invoice.Current Account') }}

                                    </option>



                                    <option value="Savings Account"

                                        {{ (getPaymentEnv('ACCOUNT_TYPE') ? getPaymentEnv('ACCOUNT_TYPE') : '') == 'Savings Account' ? 'selected' : '' }}>

                                        {{ __('invoice.Savings Account') }}

                                    </option>

                                    <option value="Salary Account"

                                        {{ (getPaymentEnv('ACCOUNT_TYPE') ? getPaymentEnv('ACCOUNT_TYPE') : '') == 'Salary Account' ? 'selected' : '' }}>

                                        {{ __('invoice.Salary Account') }}

                                    </option>

                                    <option value="Fixed Deposit"

                                        {{ (getPaymentEnv('ACCOUNT_TYPE') ? getPaymentEnv('ACCOUNT_TYPE') : '') == 'Fixed Deposit' ? 'selected' : '' }}>



                                        {{ __('invoice.Fixed Deposit') }}

                                    </option>



                                </select>

                            </div>

                            <div class="col-xl-6 col-md-12">

                                <label for="name" class="mb-2">{{ __('invoice.Cheque Slip') }}

                                    <span>*</span></label>

                                <input type="file" required name="image" class="primary_input4 mb_20">

                                <span class="invalid-feedback" role="alert" id="amount_validation"></span>

                            </div>

                        </div>



                        <fieldset class="mt-3">

                            <legend>{{ __('invoice.Bank Account Info') }}

                            </legend>

                            <table class="table table-bordered">



                                <tr>

                                    <td>@lang('setting.Bank Name')</td>

                                    <td>{{ getPaymentEnv('BANK_NAME') }}</td>

                                </tr>

                                <tr>

                                    <td>@lang('setting.Branch Name')</td>

                                    <td>{{ getPaymentEnv('BRANCH_NAME') }}</td>

                                </tr>

                                <tr>

                                    <td>@lang('setting.Account Type')</td>

                                    <td>{{ getPaymentEnv('ACCOUNT_TYPE') }}</td>

                                </tr>

                                <tr>

                                    <td>@lang('setting.Account Number')</td>

                                    <td>{{ getPaymentEnv('ACCOUNT_NUMBER') }}</td>

                                </tr>



                                <tr>

                                    <td>@lang('setting.Account Holder')</td>

                                    <td>{{ getPaymentEnv('ACCOUNT_HOLDER') }}</td>

                                </tr>

                            </table>

                        </fieldset>

                    </div>

                    <div class="modal-footer d-flex justify-content-between">

                        <button type="button" class=" theme_line_btn "

                            data-dismiss="modal">@lang('common.Cancel')</button>

                        <button class="  theme_btn" type="submit">@lang('payment.Payment')</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endif



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
      Object.values(result.errors).forEach(function (value) {
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
  form.submit();
}



</script>

