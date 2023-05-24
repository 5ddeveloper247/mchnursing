@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://checkout.sandbox.dev.clover.com/sdk.js"></script>
    <style>
        input {
            background: transparent;
        }
        .borderbottom {
            border-bottom: 1px solid black;
        }

        .formbord {
            border: none;
            width: 70%;
        }

        .formbord:focus {
            border: none;
        }

        .text span {
            font-size: 16px;
            font-weight: bold;
        }

        input:focus-visible {
            outline: none !important;


        }

        .checkbox input {
            width: 40px;
            height: 40px;
        }

        .checkboxdata {
            width: 100%;
        }

        .checkboxdata input {
            width: 20%;
            float: left;
        }

        .checkboxdata h5 {
            width: 50%;
            float: left;

        }

        .bordertop {
            border-top: 1px solid black;
        }

        .page {
            width: 200px;
            height: 30px;
            float: right;

        }

        .borderbottom {
            border-bottom: 1px solid black;
        }

        .formbord {
            border: none;
            width: 70%;
        }

        .formbord:focus {
            border: none;
        }

        .text span {
            font-size: 16px;
            font-weight: bold;
        }

        input:focus-visible {
            outline: none !important;


        }

        .checkbox input {
            width: 40px;
            height: 40px;
        }

        .checkboxdata {
            width: 100%;
        }

        .checkboxdata input {
            width: 20%;
            float: left;
        }

        .checkboxdata h5 {
            width: 50%;
            float: left;

        }

        .bordertop {
            border-top: 1px solid black;
        }

        .page {
            width: 200px;
            height: 30px;
            float: right;

        }

        .nameformbord {
            border: none;
            width: 100%;
        }

        .nameformbord:focus {
            border: none;
        }

        .nameda p {

            margin-top: 0;
            font-size: 16px;
            margin-bottom: 1rem;
            font-weight: bold;
            text-align: justify;
        }

        .borderbottom {
            border-bottom: 1px solid grey;
        }

        .formbord {
            border: none;
            width: 70%;
        }

        .formbord:focus {
            border: none;
        }

        .text span {
            font-weight: bold;
            font-size: 12px;
            color: grey;
        }

        input:focus-visible {
            outline: none !important;


        }

        .checkbox input {
            width: 40px;
            height: 40px;
        }

        .checkboxdata {
            width: 100%;
        }

        .checkboxdata input {
            width: 20%;
            float: left;
        }

        .checkboxdata h5 {
            width: 50%;
            float: left;
            width: 50%;
            font-size: 12px;
            color: grey;
            float: left;

        }

        .bordertop {
            border-top: 1px solid grey;
            border-top: 1px solid rgb(22, 68, 100);
        }

        .page {
            width: 200px;
            height: 30px;
            float: right;

        }

        .nameformbord {
            border: none;
            width: 100%;
        }

        .nameformbord:focus {
            border: none;
        }

        .nameda p {

            margin-top: 0;
            font-size: 16px;
            margin-bottom: 1rem;
            font-weight: bold;
            text-align: justify;
        }

        .nameda1 p {

            margin-top: 0;
            font-size: 17px;
            text-align: justify;
        }

        .containerer {
            width: 100%;
            /* margin:auto; */
        }

        .mdka {
            width: 0%;
            height: 100%;
            float: left;
        }

        .row p {
            font-size: 16px;
            color: rgb(49, 48, 48);
            font-weight: bold;

        }

        .program h5 {
            font-weight: bold;
            font-size: 12px;
            color: grey;
        }

        .program p {
            font-weight: bold;
            font-size: 12px;
            color: grey;
        }

        .program {
            font-weight: bold;
            font-size: 18px;
            color: grey;
        }

        .logo img {
            width: 120px;
            height: 110px;
        }
        .other_links {
            text-align: center;
            padding:12px 0px;
        }
        .data{
            background:rgb(190, 190, 190);
        }
        .thumb img{
            width:90%!important;
        }
        .thumb{
            text-align: center;
        }
        .login_main_info h4{
            font-size: 25px;
            line-height: 30px;
            font-weight: 600;
            text-align: center;
            padding: 12px 0px;
        }
        .shitch_text a{
            color:blue;
        }
        .ff h4{
            font-size: 31px;
            line-height: 30px;
            font-weight: bold;
        }
        .data h5{
            text-align: center;
        }
    </style>


@endpush

@section('mainContent')
    <input type="hidden" name="id" id="accesskey" value="{{  $pakms ?? null }}">
    <section class="admin-visitor-area student-details">
        <div class="container-fluid p-0">
            <div class="row">
                {{--{{ dd($student->studentsetting->l_name) }}--}}
                <div class=" col-md-12  ">
                    <div class="main-title">
                        <h3 class="">

                            {{ __('Clover Test Pay $10') }}
                        </h3>
                    </div>


                    <div class="white_box_30px">
                        <div class="row  mt_0_sm">

                            <!-- Start Sms Details -->
                            <div class="col-lg-12">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <input type="hidden" name="selectTab" id="selectTab">
                                    <div role="tabpanel"
                                         class="tab-pane fade  show active"
                                         id="group_email_sms">
                                        <div class="white_box_30px pl-0 pr-0 pt-0">
                                            <div class="container">
                                                <form action="{{ route('clover.test') }}" method="post" id="payment-form">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ Illuminate\Support\Facades\Auth::user()->id ?? null}}">
                                                    <div class="form-row top-row">
                                                        <div id="amount" class="field card-number">
                                                            <input type="hidden" name="amount" value="{{ convertCurrency(Settings('currency_code') ?? 'BDT', 'USD', 10)*100 }}" placeholder="Amount">
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
    </section>

@endsection
@push('scripts')

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

@endpush
