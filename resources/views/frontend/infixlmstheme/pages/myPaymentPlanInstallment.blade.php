@extends(theme('layouts.dashboard_master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('Payment Plan Installment')}} @endsection
@section('css') @endsection
@section('js') @endsection

@section('mainContent')
    <input type="hidden" name="id" id="accesskey" value="{{  $pakms ?? null }}">
    <div class="main_content_iner main_content_padding">
        <div class="dashboard_lg_card">
            <div class="container-fluid no-gutters">
                <div class="row">
                    <div class="col-12">
                        <div class="p-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">
                                        <h3 class="mb-0">{{__('Payment Plan Installment')}}</h3>
                                        <h4></h4>
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="mainform m-0 row">
                                            <div class="col-md-12">
                                                <div class="input_box_tittle">

                                                    <h4>@lang('Payment $'){{ $installment->amount }}</h4>

                                                    @if($errors->first('Error'))
                                                        <span class="text-danger" role="alert">{{$errors->first('Error')}}</span>
                                                    @endif
                                                    <div class="container">
                                                        <form action="{{ route('my.payment.plan.installment.payment') }}" method="post" id="payment-form">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{$user->id ?? null}}">
                                                            <input type="hidden" name="installment_id" value="{{$installment->id ?? null}}">
                                                            <div class="form-row top-row">
                                                                <div id="amount" class="field card-number">
                                                                    <input type="hidden" name="amount" value="{{ convertCurrency(Settings('currency_code') ?? 'BDT', 'USD', $installment->amount)*100 }}" placeholder="Amount">
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
                                                                    <button class="btn btn-secondary h6">Pay Now</button>
                                                                @endif
                                                            </div>

                                                        </form>
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
    </div>

    <script src="https://checkout.sandbox.dev.clover.com/sdk.js"></script>
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
            console.log(hiddenInput);
            form.submit();
        }



    </script>
@endsection
