<div>
    <style>
        .pb_50 {
            padding-bottom: 50px;
        }
    </style>
    <div class="main_content_iner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="purchase_history_wrapper pb_50">
                        <div class="row">
                            <div class="col-12">
                                <div class="section__title3 mb_40">
                                    <h3 class="mb-0">{{ __('invoice.Invoice List') }}</h3>
                                    <h4></h4>
                                </div>
                            </div>
                        </div>
                        @if (count($myInvoices) == 0)
                            <div class="col-12">
                                <div class="section__title3 margin_50">
                                    <p class="text-center">{{ __('invoice.No Invoice Generate Yet') }}!</p>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table class="table custom_table3">
                                            <thead>
                                            <tr>
                                                <th scope="col">{{ __('common.SL') }}</th>
                                                <th scope="col">{{ __('invoice.Invoice Number') }}</th>
                                                <th scope="col">{{ __('common.Date') }}</th>
                                                <th scope="col">{{ __('common.Total Courses') }}</th>
                                                <th scope="col">{{ __('payment.Total Price') }}</th>
                                                {{-- <th scope="col">{{ __('common.Discount') }}</th> --}}
                                                @if (hasTax())
                                                    <th scope="col">{{ __('tax.TAX') }}</th>
                                                @endif
                                                <th scope="col">{{ __('common.Status') }}</th>
                                                <th scope="col">{{ __('common.Payment Type') }}</th>
                                                <th scope="col">{{ __('payment.Invoice') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if (isset($myInvoices))
                                                @foreach ($myInvoices as $key => $invoice)

                                                    <tr>
                                                        <td class="m-2"><strong>{{ $loop->iteration }}</strong></td>
                                                        <td>{{ $invoice->invoice_number }} </td>
                                                        <td>{{ showDate($invoice->created_at) }}</td>
                                                        <td class="text-center">{{ $invoice->courses_count }}</td>
                                                        <td>{{ getPriceFormat($invoice->purchase_price) }}</td>
                                                        <td>
                                                            @if($invoice->offlinePayment)
                                                                <strong>{{__('invoice.Pending')}}</strong>
                                                            @elseif ($invoice->status != 'paid')
                                                                <a href="{{ route('invoice.orderPayment', @$invoice->encryptId()) }}"
                                                                   class="link_value theme_btn small_btn4">{{ __('invoice.Pay Now') }}</a>
                                                            @elseif($invoice->status == 'paid')
                                                                <strong>{{strtoupper($invoice->status)}}</strong>
                                                            @endif
                                                        </td>
                                                        <td>{{ $invoice->payment_type == 1 ? 'Online' : 'Offline' }}
                                                            {{ $invoice->status == 'paid' ?  '['. $invoice->payment_method.']' : '' }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('invoice.student.show', @$invoice->encryptId()) }}"
                                                               class="link_value theme_btn small_btn4">{{ __('common.View') }}</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        <div class="mt-4">
                                            {{ $myInvoices->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    @if (isSubscribe())
                        <div class="purchase_history_wrapper mt-0 pt-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section__title3 mb_40">
                                        <h3 class="mb-0">{{ __('subscription.Subscription History') }}</h3>
                                        <h4></h4>
                                    </div>
                                </div>
                            </div>
                            @if (count($checkouts) == 0)
                                <div class="col-12">
                                    <div class="section__title3 margin_50">
                                        <p class="text-center">{{ __('subscription.No Subscription Purchased Yet') }}!
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table custom_table3 mb-0">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{ __('common.SL') }}</th>
                                                    <th scope="col">{{ __('subscription.Plan') }}</th>
                                                    <th scope="col">{{ __('subscription.Start Date') }}</th>
                                                    <th scope="col">{{ __('subscription.End Date') }}</th>
                                                    <th scope="col">{{ __('subscription.Days') }}</th>
                                                    <th scope="col">{{ __('subscription.Price') }}</th>
                                                    <th scope="col">{{ __('subscription.Payment Method') }}</th>
                                                    <th scope="col">{{ __('subscription.Status') }}</th>
                                                    <th scope="col">{{ __('payment.Invoice') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if (isset($checkouts))

                                                    @foreach ($checkouts as $key => $checkout)
                                                        <tr>
                                                            <td scope="row">{{ @$key + 1 }}</td>
                                                            <td>{{ $checkout->plan->title }}</td>

                                                            <td>{{ showDate($checkout->start_date) }}</td>
                                                            <td>{{ showDate($checkout->end_date) }}</td>


                                                            <td> {{ $checkout->days }} </td>
                                                            <td> {{ $checkout->price }} </td>
                                                            <td> {{ $checkout->payment_method }} </td>
                                                            <td>
                                                                @php
                                                                    $date_of_subscription = $checkout->end_date;
                                                                    $now = new DateTime();
                                                                    $startdate = new DateTime($checkout->start_date);
                                                                    $enddate = new DateTime($checkout->end_date);

                                                                    if ($startdate <= $now && $now <= $enddate) {
                                                                        echo 'Valid';
                                                                    } else {
                                                                        echo 'Expire';
                                                                    }
                                                                @endphp
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('subInvoice', $checkout->id) }}"
                                                                   class="link_value theme_btn small_btn4">{{ __('common.View') }}</a>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                            <div class="mt-4">
                                                {{ $checkouts->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
