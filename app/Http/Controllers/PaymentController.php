<?php

namespace App\Http\Controllers;

use App\BillingDetails;
use App\Events\OneToOneConnection;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use DrewM\MailChimp\MailChimp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Modules\Affiliate\Events\ReferralPayment;
use Modules\Appointment\Entities\Booking;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\BundleSubscription\Entities\BundleSetting;
use Modules\Coupons\Entities\UserWiseCoupon;
use Modules\Coupons\Entities\UserWiseCouponSetting;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Group\Events\GroupMemberCreate;
use Modules\Invoice\Repositories\Interfaces\InvoiceRepositoryInterface;
use Modules\MercadoPago\Http\Controllers\MercadoPagoController;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\Payment\Entities\Cart;
use Modules\Payment\Entities\Checkout;
use Modules\Payment\Entities\InstructorPayout;
use Modules\Payment\Entities\StudentProgramPaymentPlans;
use Modules\StudentSetting\Entities\Program;
use Modules\Survey\Entities\Survey;
use Modules\Survey\Http\Controllers\SurveyController;
use Omnipay\Omnipay;

class PaymentController extends Controller
{
    public $payPalGateway;

    public function __construct()
    {
        $this->middleware('maintenanceMode');

        $this->payPalGateway = Omnipay::create('PayPal_Rest');
        $this->payPalGateway->setClientId(getPaymentEnv('PAYPAL_CLIENT_ID'));
        $this->payPalGateway->setSecret(getPaymentEnv('PAYPAL_CLIENT_SECRET'));
        $this->payPalGateway->setTestMode(getPaymentEnv('IS_PAYPAL_LOCALHOST') == 'true'); //set it to 'false' when go live
    }

    public function makePlaceOrder(Request $request)
    {
        $carts = Cart::where('user_id', Auth::id())->count();
        if ($carts == 0) {
            return redirect('/');
        }
        $rules = [
            'old_billing' => 'required_if:billing_address,previous',
            'first_name' => 'required_if:billing_address,new',
            'last_name' => 'required_if:billing_address,new',
            'country' => 'required_if:billing_address,new',
            'address1' => 'required_if:billing_address,new',
            'phone' => 'required_if:billing_address,new',
            'email' => 'required_if:billing_address,new',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        if ($request->billing_address == 'new') {
            $bill = BillingDetails::where('tracking_id', $request->tracking_id)->first();

            if (empty($bill)) {
                $bill = new BillingDetails();
            }

            $bill->user_id = Auth::id();
            $bill->tracking_id = $request->tracking_id;
            $bill->first_name = $request->first_name;
            $bill->last_name = $request->last_name;
            $bill->company_name = $request->company_name;
            $bill->country = $request->country;
            $bill->address1 = $request->address1;
            $bill->address2 = $request->address2;
            $bill->city = $request->city;
            $bill->state = $request->state;
            $bill->zip_code = $request->zip_code;
            $bill->phone = $request->phone;
            $bill->email = $request->email;
            $bill->details = $request->details;
            $bill->payment_method = null;
            $bill->save();
        } else {

            $bill = BillingDetails::where('id', $request->old_billing)->first();
            if ($request->previous_address_edit == 1) {
                $bill->user_id = Auth::id();
                $bill->tracking_id = $request->tracking_id;
                $bill->first_name = $request->first_name;
                $bill->last_name = $request->last_name;
                $bill->company_name = $request->company_name;
                $bill->country = $request->country;
                $bill->address1 = $request->address1;
                $bill->address2 = $request->address2;
                $bill->city = $request->city;
                $bill->state = $request->state;

                $bill->zip_code = $request->zip_code;
                $bill->phone = $request->phone;
                $bill->email = $request->email;
                $bill->details = $request->details;
                $bill->payment_method = null;
                $bill->save();
            }
        }

        $tracking = Cart::where('user_id', Auth::id())->first()->tracking;
        $checkout_info = Checkout::where('tracking', $tracking)->where('user_id', Auth::id())->latest()->first();
        $carts = Cart::where('tracking', $checkout_info->tracking)->get();

        if ($checkout_info) {
            $checkout_info->billing_detail_id = $bill->id;
            $checkout_info->save();

            if ($checkout_info->purchase_price == 0) {
                $checkout_info->payment_method = 'None';
                $bill->payment_method = 'None';
                $checkout_info->save();
                foreach ($carts as $cart) {
                    $this->directEnroll($cart->program_id, $checkout_info->tracking);
                    $cart->delete();
                }

                Toastr::success('Checkout Successfully Done', 'Success');
                if (Settings('frontend_active_theme') == 'tvt') {
                    return redirect('/');
                }
                return redirect(route('studentDashboard'));
            } else {
                return redirect()->route('orderPayment');
            }
        } else {
            Toastr::error("Something Went Wrong", 'Failed');
            return \redirect()->back();
        }
        //payment method start skip for now

    }


    public function cloverpayment(Request $req)
    {


        $post = $req->all();

        $post['currency'] = 'USD';
        $post['source'] = $_POST['cloverToken'];

        $post = json_encode($post);
        $ch = curl_init('https://scl-sandbox.dev.clover.com/v1/charges');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $headers = [
            'accept: application/json',
            'authorization: Bearer 5151f4b4-01c9-6685-8423-ffa3b58c7800',
            'idempotency-key AFNDYVA7CTE11',
            'content-type: application/json',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // execute!
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        // do anything you want with your response
        var_dump($response);
    }

    public function payment(Request $request)
    {

        $clover = new CloverController();
        $pakms = $clover->getPakmsKey();

        Config::set('apiaccess', $pakms);

        try {
            $carts = Cart::where('user_id', Auth::id())->count();
            if ($carts == 0) {
                return redirect('/');
            }
            return view(theme('pages.payment'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function paymentSubmit(Request $request)
    {


        $clover = new CloverController();
        if ($response = $clover->makePayment($request, 'pay', true)) {
            $this->payWithGateWay($response, "clover", $user = null, session()->get('invoice'));
            Toastr::success('Payment Successfully Done', 'Success');
            return redirect()->route('frontendHomePage');
        } else {
            Toastr::error('Something Went Wrong', 'Error');
            return redirect()->back();
        }


        //        if (!empty($checkout_info)) {
        //            if ($request->payment_method == "Sslcommerz") {
        //                $post_data = array();
        //                $post_data['total_amount'] = $checkout_info->purchase_price; # You cant not pay less than 10
        //                $post_data['currency'] = Settings('currency_code') ?? 'USD';
        //                $post_data['tran_id'] = uniqid(); // tran_id must be unique
        //
        //                # CUSTOMER INFORMATION
        //                $post_data['cus_name'] = $request->first_name ?? 'Customer Name';
        //                $post_data['cus_email'] = $request->email ?? 'customer@mail.com';
        //                $post_data['cus_add1'] = $request->address1 ?? 'Customer Address';
        //                $post_data['cus_add2'] = $request->address2 ?? '';
        //                $post_data['cus_city'] = $request->city ?? 'Dhaka';
        //                $post_data['cus_state'] = "";
        //                $post_data['cus_postcode'] = $request->zip_code ?? '';
        //                $post_data['cus_country'] = $request->country ?? '';
        //                $post_data['cus_phone'] = $request->phone ?? '8801XXXXXXXXX';
        //                $post_data['cus_fax'] = "";
        //
        //                # SHIPMENT INFORMATION
        //                $post_data['ship_name'] = "Store Test";
        //                $post_data['ship_add1'] = "Dhaka";
        //                $post_data['ship_add2'] = "Dhaka";
        //                $post_data['ship_city'] = "Dhaka";
        //                $post_data['ship_state'] = "Dhaka";
        //                $post_data['ship_postcode'] = "1000";
        //                $post_data['ship_phone'] = "";
        //                $post_data['ship_country'] = "Bangladesh";
        //
        //                $post_data['shipping_method'] = "NO";
        //                $post_data['product_name'] = "Computer";
        //                $post_data['product_category'] = "Goods";
        //                $post_data['product_profile'] = "physical-goods";
        //
        //                # OPTIONAL PARAMETERS
        //                $post_data['value_a'] = $checkout_info->id;
        //                $post_data['value_b'] = $checkout_info->tracking;
        //                $post_data['value_c'] = "ref003";
        //                $post_data['value_d'] = "ref004";
        //
        //                #Before  going to initiate the payment order status need to update as Pending.
        //                $update_product = DB::table('orders')
        //                    ->where('transaction_id', $post_data['tran_id'])
        //                    ->updateOrInsert([
        //                        'user_id' => $checkout_info->user->id,
        //                        'tracking' => $checkout_info->tracking,
        //                        'name' => $post_data['cus_name'] ?? '',
        //                        'email' => $post_data['cus_email'] ?? '',
        //                        'phone' => $post_data['cus_phone'] ?? '',
        //                        'amount' => $post_data['total_amount'] ?? '',
        //                        'status' => 'Pending',
        //                        'address' => $post_data['cus_add1'] ?? '',
        //                        'transaction_id' => $post_data['tran_id'],
        //                        'currency' => $post_data['currency'],
        //                    ]);
        //                $sslc = new SslCommerzNotification();
        //                # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        //                $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');
        //                $payment_options = \GuzzleHttp\json_decode($payment_options);
        //
        //                if ($payment_options->status == "success") {
        //                    return Redirect::to($payment_options->data);
        //                } else {
        //                    Toastr::error('Something went wrong', 'Failed');
        //                    return Redirect::back();
        //                }
        //
        //            } elseif ($request->payment_method == "PayPal") {
        //
        //                try {
        //                    $response = $this->payPalGateway->purchase(array(
        //                        'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', Settings('currency_code'), $checkout_info->purchase_price),
        //                        'currency' => Settings('currency_code'),
        //                        'returnUrl' => route('paypalSuccess'),
        //                        'cancelUrl' => route('paypalFailed'),
        //
        //                    ))->send();
        //
        //                    if ($response->isRedirect()) {
        //                        $response->redirect(); // this will automatically forward the customer
        //                    } else {
        //                        Toastr::error($response->getMessage(), trans('common.Failed'));
        //                        return \redirect()->back();
        //                    }
        //                } catch (\Exception$e) {
        //                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        //
        //                }
        //            } elseif ($request->payment_method == "Payeer") {
        //
        //                try {
        //                    $payeer = new PayeerController();
        //                    $request->merge(['type' => 'Payment']);
        //                    $request->merge(['amount' => $checkout_info->purchase_price]);
        //                    $response = $payeer->makePayment($request);
        //
        //                    if ($response) {
        //                        return \redirect()->to($response);
        //                    } else {
        //                        Toastr::error('Something went wrong', 'Failed');
        //                        return \redirect()->back();
        //                    }
        //                } catch (\Exception$e) {
        //                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        //
        //                }
        //
        //            } elseif ($request->payment_method == "Midtrans") {
        //
        //                try {
        //                    $midtrans = new MidtransController();
        //                    $request->merge(['type' => 'Payment']);
        //                    $request->merge(['amount' => $checkout_info->purchase_price]);
        //                    $response = $midtrans->makePayment($request);
        //
        //                    if ($response) {
        //                        return $response;
        //                    } else {
        //                        Toastr::error('Something went wrong', 'Failed');
        //                        return \redirect()->back();
        //                    }
        //                } catch (\Exception$e) {
        //                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        //
        //                }
        //
        //            } elseif ($request->payment_method == "MercadoPago") {
        //                $mercadoPagoController = new MercadoPagoController();
        //                $response = $mercadoPagoController->payment($request->all());
        //                return response()->json(['target_url' => $response]);
        //            } elseif ($request->payment_method == "Instamojo") {
        //
        //                $amount = convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $checkout_info->purchase_price);
        //                $instamojo = new InstamojoController();
        //                $response = $instamojo->paymentProcess($amount);
        //                if ($response) {
        //                    return \redirect()->to($response);
        //                } else {
        //                    Toastr::error('Something went wrong', 'Failed');
        //                    return \redirect()->back();
        //                }
        //
        //            } elseif ($request->payment_method == "Mobilpay") {
        //
        //                $amount = convertCurrency(Settings('currency_code') ?? Settings('currency_code'), 'RON', $checkout_info->purchase_price);
        //                $mobilpay = new MobilpayController();
        //                $mobilpay->paymentProcess($amount);
        //
        //            } elseif ($request->payment_method == "Stripe") {
        //
        //                $request->validate([
        //                    'stripeToken' => 'required',
        //                ]);
        //                $token = $request->stripeToken ?? '';
        //                $gatewayStripe = Omnipay::create('Stripe');
        //                $gatewayStripe->setApiKey(getPaymentEnv('STRIPE_SECRET'));
        //
        //                //$formData = array('number' => '4242424242424242', 'expiryMonth' => '6', 'expiryYear' => '2030', 'cvv' => '123');
        //                $response = $gatewayStripe->purchase(array(
        //                    'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', Settings('currency_code'), $checkout_info->purchase_price),
        //                    'currency' => Settings('currency_code'),
        //                    'token' => $token,
        //                ))->send();
        //
        //                if ($response->isRedirect()) {
        //                    // redirect to offsite payment gateway
        //                    $response->redirect();
        //                } elseif ($response->isSuccessful()) {
        //                    // payment was successful: update database
        //
        //                    $payWithStripe = $this->payWithGateWay($response->getData(), "Stripe", $user = null, session()->get('invoice'));
        //                    if ($payWithStripe) {
        //                        Toastr::success('Payment done successfully', 'Success');
        //                        if (Settings('frontend_active_theme') == 'tvt') {
        //                            return redirect('/');
        //                        }
        //                        return redirect(route('studentDashboard'));
        //                    } else {
        //                        Toastr::error('Something Went Wrong', 'Error');
        //                        return \redirect()->back();
        //                    }
        //                } else {
        //
        //                    if ($response->getCode() == "amount_too_small") {
        //                        $amount = round(convertCurrency(Settings('currency_code'), strtoupper(Settings('currency_code') ?? 'BDT'), 0.5));
        //                        $message = "Amount must be at least " . Settings('currency_symbol') . ' ' . $amount;
        //                        Toastr::error($message, 'Error');
        //                    } else {
        //                        Toastr::error($response->getMessage(), 'Error');
        //                    }
        //                    return redirect()->back();
        //                }
        //
        //            } //payment getway
        //            elseif ($request->payment_method == "RazorPay") {
        //
        //                if (empty($request->razorpay_payment_id)) {
        //                    Toastr::error('Something Went Wrong', 'Error');
        //                    return \redirect()->back();
        //                }
        //
        //                $payment = new RazorpayController();
        //                $response = $payment->payment($request->razorpay_payment_id);
        //
        //                if ($response['type'] == "error") {
        //                    Toastr::error($response['message'], 'Error');
        //                    return \redirect()->back();
        //                }
        //
        //                $payWithRazorPay = $this->payWithGateWay($response['response'], "RazorPay", $user = null, session()->get('invoice'));
        //
        //                if ($payWithRazorPay) {
        //                    Toastr::success('Payment done successfully', 'Success');
        //                    if (Settings('frontend_active_theme') == 'tvt') {
        //                        return redirect('/');
        //                    }
        //                    return redirect(route('studentDashboard'));
        //                } else {
        //                    Toastr::error('Something Went Wrong', 'Error');
        //                    return \redirect()->back();
        //                }
        //
        //            } //payment getway
        //            elseif ($request->payment_method == "PayTM") {
        //
        //                $userData = [
        //                    'user' => $checkout_info['tracking'],
        //                    'mobile' => $checkout_info->billing->phone,
        //                    'email' => $checkout_info->billing->email,
        //                    'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $checkout_info->purchase_price),
        //                    'order' => $checkout_info->billing->phone . "_" . rand(1, 1000),
        //                ];
        //
        //                $payment = new PaytmController();
        //                return $payment->payment($userData);
        //
        //            } //payment getway
        //
        //            elseif ($request->payment_method == "PayStack") {
        //
        //                try {
        //                    return Paystack::getAuthorizationUrl()->redirectNow();
        //
        //                } catch (\Exception$e) {
        //                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        //
        //                }
        //
        //            } elseif ($request->payment_method == "Pesapal") {
        //
        //                try {
        //                    $paymentData = [
        //                        'amount' => $checkout_info->purchase_price,
        //                        'currency' => Settings('currency_code'),
        //                        'description' => 'Payment',
        //                        'type' => 'MERCHANT',
        //                        'reference' => 'Payment|' . $checkout_info->purchase_price,
        //                        'first_name' => Auth::user()->first_name,
        //                        'last_name' => Auth::user()->last_name,
        //                        'email' => Auth::user()->email,
        //                    ];
        //
        //                    $iframe_src = Pesapal::getIframeSource($paymentData);
        //
        //                    return view('laravel_pesapal::iframe', compact('iframe_src'));
        //                } catch (\Exception$e) {
        //                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        //                }
        //
        //            } //payment getway
        //
        //            elseif ($request->payment_method == "Wallet") {
        //
        //                $payment = new WalletController();
        //                $response = $payment->payment($request);
        //
        //                if ($response['type'] == "error") {
        //                    Toastr::error($response['message'], 'Error');
        //                    return \redirect()->back();
        //                }
        //
        //                $payWithWallet = $this->payWithGateWay($response['response'], "Wallet", $user = null, session()->get('invoice'));
        //
        //                if ($payWithWallet) {
        //                    Toastr::success('Payment done successfully', 'Success');
        //                    if (Settings('frontend_active_theme') == 'tvt') {
        //                        return redirect('/');
        //                    }
        //
        //                    return redirect(route('studentDashboard'));
        //                } else {
        //                    Toastr::error('Something Went Wrong', 'Error');
        //                    return \redirect()->back();
        //                }
        //
        //            }
        //
        //        } else {
        //            Toastr::error('Something went wrong', 'Failed');
        //            return Redirect::back();
        //        }

    }

    public function directEnroll($id, $tracking = null)
    {
        try {
            $success = trans('lang.Enrolled') . ' ' . trans('lang.Successfully');
            $user = Auth::user();


            $checkout = new Checkout();
            if (empty($tracking)) {
                $tracking = Cart::where('user_id', Auth::id())->first()->tracking;
            }

            $checkout->discount = 0;
            $checkout->coupon_id = null;
            $checkout->purchase_price = 0;


            $checkout->tracking = $tracking;
            $checkout->user_id = Auth::id();
            $checkout->price = 0;
            $checkout->status = 0;
            $checkout->save();


            $this->payWithGateway([], 'None', $user);
            return response()->json([
                'success' => $success,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Operation Failed")]);
        }
    }

    public function paypalSuccess(Request $request)
    {

        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->payPalGateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                // The customer has successfully paid.
                $arr_body = $response->getData();
                $payWithPapal = $this->payWithGateWay($arr_body, "PayPal", $user = null, session()->get('invoice'));
                if ($payWithPapal) {
                    Toastr::success('Payment done successfully', 'Success');
                    if (Settings('frontend_active_theme') == 'tvt') {
                        return redirect('/');
                    }
                    return redirect(route('studentDashboard'));
                } else {
                    Toastr::error('Something Went Wrong', 'Error');
                    if (Settings('frontend_active_theme') == 'tvt') {
                        return redirect('/');
                    }
                    return redirect(route('studentDashboard'));
                }
            } else {
                $msg = str_replace("'", " ", $response->getMessage());
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            }
        } else {
            Toastr::error('Transaction is declined');
            return redirect()->back();
        }
    }

    public function paypalFailed()
    {
        Toastr::error('User is canceled the payment.', 'Failed');
        if (Settings('frontend_active_theme') == 'tvt') {
            return redirect('/');
        }
        return redirect(route('studentDashboard'));
    }

    public function payWithGateWay($response, $gateWayName, $user = null, $invoice = null)
    {
        try {

            if (Auth::check()) {
                if (!$user) {
                    $user = Auth::user();
                }
            }


            if ($user) {
                $certificate = session()->get('certificate_order') ?? null;
                $checkout_info = Checkout::where('user_id', $user->id)->latest()->first();
                if ($invoice) {
                    $checkout_info = Checkout::where('user_id', $invoice->user_id)
                        ->where('tracking', $invoice->tracking)
                        ->where('invoice_id', $invoice->id)->first();
                }

                if ($certificate) {
                    $checkout_info = Checkout::where('user_id', $certificate->user_id)
                        ->where('tracking', $certificate->tracking)
                        ->where('type', 'certificate')
                        ->where('order_certificate_id', $certificate->id)->first();
                }
                if (isset($checkout_info)) {

                    $discount = $checkout_info->discount;

                    $carts = Cart::where('user_id', $user->id)->latest()->get();

                    if ($invoice) {
                        $carts = $invoice->programs;
                    } elseif ($certificate) {
                        $carts = $certificate;
                    }

                    $courseType = collect();
                    $renew = 'new';
                    $bundleId = 0;

                    foreach ($carts as $cartKey => $cart) {
                        if ($checkout_info->type == 'appointment') {
                            $instructor = User::find($cart->instructor_id);
                            $this->forAppointment($checkout_info, $instructor, $discount, $cart, $carts, $gateWayName);
                        } elseif ($certificate) {
                        } else {
                            $this->defaultPayment($checkout_info, $user, $discount, $cart, $carts, $courseType, $gateWayName, $response);
                        }
                    }
                    $bill = BillingDetails::with('country')->where('user_id', Auth::id())->latest()->first();
                    $checkout_info->billing_detail_id = $bill->id;
                    $checkout_info->save();
                    foreach ($carts as $old) {
                        $old->delete();
                    }
                    Toastr::success('Checkout Successfully Done', 'Success');
                    return true;
                    // out of foreach
                    $checkout_info->payment_method = $gateWayName;
                    $checkout_info->status = 1;
                    $checkout_info->response = json_encode($response);
                    if ($certificate || $invoice) {
                        if ($checkout_info) {
                            // for invoice
                            if (isModuleActive('Invoice') && $invoice) {
                                $invoice->update([
                                    'payment_method' => $gateWayName,
                                    'status' => 'paid',
                                    'checkout_id' => $checkout_info->id,
                                ]);
                            }
                            // end invoice
                            if (isModuleActive('Invoice') && $certificate) {
                                $certificate->update([
                                    'status' => 'ordered',
                                    'checkout_id' => $checkout_info->id,
                                    'payment_status' => 1,
                                ]);

                                $admin = User::where('role_id', 1)->first();
                                $shortCodes = [
                                    'student_name' => $certificate->user->name,
                                    'course' => $certificate->course->title
                                ];
                                if (UserBrowserNotificationSetup('certificate_order', $admin)) {
                                    send_browser_notification($admin, $type = 'certificate_order', $shortCodes);
                                }
                                if (UserEmailNotificationSetup('certificate_order', $admin)) {
                                    send_email($admin, 'certificate_order', $shortCodes);
                                }
                            }
                        }
                    } else {
                        // bundlesSubscription
                        if (isModuleActive('BundleSubscription')) {
                            $checkout_info->bundle_id = (int)$bundleId;
                            $checkout_info->renew = $renew;

                            if (isset($courseType->bundle) && $courseType->bundle == 1 && isset($courseType->single) && $courseType->single == 1) {
                                $checkout_info->course_type = 'multi';
                            } elseif (isset($courseType->single) && $courseType->single == 1) {
                                $checkout_info->course_type = 'single';
                            } else {
                                $checkout_info->course_type = 'bundle';
                            }
                        }
                        $checkout_info->save();
                        // end bundle Subscription
                    }

                    if ($checkout_info->user->status == 1 && !$invoice && !$certificate) {
                        foreach ($carts as $old) {
                            $old->delete();
                        }
                    }


                    Toastr::success('Checkout Successfully Done', 'Success');
                    return true;
                } else {
                    Toastr::error('Something Went Wrong', 'Error');
                    return false;
                }
            } else {
                Toastr::error('Something Went Wrong', 'Error');
                return false;
            }
        } catch (\Exception $e) {

            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);
        }
    }

    private function forAppointment($checkout_info, $instructor, $discount = 0, $cart, $carts, $gateWayName)
    {
        if (isModuleActive('Appointment') && $cart->schedule_id) {
            if ($discount != 0 || !empty($discount)) {
                $itemPrice = $instructor->hour_rate - ($discount / count($carts));
                $discount_amount = $instructor->hour_rate - $itemPrice;
            } else {
                $itemPrice = $instructor->hour_rate;
                $discount_amount = 0.00;
            }
            $exit = Booking::where('schedule_id', $cart->schedule_id)
                ->where('user_id', auth()->user()->id)->first();

            // for appointment  module
            if (!$exit) {
                $scheduleBooking = new Booking;
                $scheduleBooking->schedule_id = $cart->schedule_id;
                $scheduleBooking->tracking = $cart->tracking;
                $scheduleBooking->user_id = auth()->user()->id;
                $scheduleBooking->instructor_id = $cart->instructor_id;
                $scheduleBooking->purchase_price = $itemPrice ?? 0;
                $scheduleBooking->coupon = null;
                $scheduleBooking->discount_amount = $discount_amount;
                $scheduleBooking->timezone = $cart->timezone;
                $scheduleBooking->status = 0;
                $scheduleBooking->save();

                if (!is_null($instructor->appointment_special_commission) && $instructor->appointment_special_commission != 0) {
                    $commission = $instructor->appointment_special_commission;
                    $revenue = ($itemPrice * $commission) / 100;
                } else {
                    $commission = 100 - Settings('appointment_commission');
                    $revenue = ($itemPrice * $commission) / 100;
                }

                $payout = new InstructorPayout();
                $payout->instructor_id = $cart->instructor_id;
                $payout->reveune = $revenue;
                $payout->status = 0;
                $payout->save();
                $this->emailNotification($checkout_info, $cart, $gateWayName);
            }
        }
    }

    public function emailNotification($checkout_info, $cart, $gateWayName)
    {
        $start_time = date('h:i A', strtotime($cart->schedule->slotInfo->start_time));
        $end_time = date('h:i A', strtotime($cart->schedule->slotInfo->end_time));
        $hour_rate = $cart->schedule->userInfo->hour_rate;
        $timeSlot = $cart->schedule->schedule_date . '(' . $start_time . '-' . $end_time . ')';
        $topic = $cart->schedule->category->name . '(' . $cart->schedule->subCategory->name . ')';
        $admin = User::where('role_id', 1)->first();

        $shortCodes = [
            'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
            'timeSlot' => $timeSlot,
            'topic' => $topic,
            'currency' => $cart->instructor->currency->symbol ?? '$',
            'price' => $hour_rate,
            'student_name' => $cart->student->name,
            'gateway' => $gateWayName,
        ];
        // for instructor

        if (UserEmailNotificationSetup('Appointment_Enroll_Instructor', $cart->instructor)) {
            send_email($cart->instructor, 'Appointment_Enroll_Instructor', $shortCodes);
        }
        // for student
        if (UserEmailNotificationSetup('Appointment_Enroll_Payment', $cart->student)) {
            send_email($cart->student, 'Appointment_Enroll_Payment', [
                'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                'timeSlot' => $timeSlot,
                'topic' => $topic,
                'currency' => $cart->student->currency->symbol ?? '$',
                'price' => $hour_rate,
                'instructor' => $cart->schedule->userInfo->name,
                'gateway' => $gateWayName,
            ]);
        }

        // for admin
        if (UserEmailNotificationSetup('Appointment_Enroll_Admin', $admin)) {
            send_email($admin, 'Appointment_Enroll_Admin', [
                'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                'timeSlot' => $timeSlot,
                'topic' => $topic,
                'currency' => $admin->currency->symbol ?? '$',
                'price' => $hour_rate,
                'instructor' => $cart->schedule->userInfo->name,
                'student_name' => $cart->student->name,
                'gateway' => $gateWayName,
            ]);
        }

        // browser student notification
        if (UserBrowserNotificationSetup('Appointment_Enroll_Payment', $cart->student)) {
            send_browser_notification(
                $cart->student,
                $type = 'Appointment_Enroll_Payment',
                $shortcodes = [
                    'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                    'timeSlot' => $timeSlot,
                    'topic' => $topic,
                    'currency' => $cart->student->currency->symbol ?? '$',
                    'price' => $hour_rate,
                    'instructor' => $cart->schedule->userInfo->name,
                    'gateway' => $gateWayName,
                ],
                '', //actionText
                '' //actionUrl
            );
        }
        // browser admin notification
        if (UserBrowserNotificationSetup('Appointment_Enroll_Admin', $admin)) {
            send_browser_notification(
                $admin,
                $type = 'Appointment_Enroll_Admin',
                $shortcodes = [
                    'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                    'timeSlot' => $timeSlot,
                    'topic' => $topic,
                    'currency' => $admin->currency->symbol ?? '$',
                    'price' => $hour_rate,
                    'instructor' => $cart->schedule->userInfo->name,
                    'student_name' => $cart->student->name,
                    'gateway' => $gateWayName,
                ],
                '', //actionText
                '' //actionUrl
            );
        }
        // browser instructor notification
        if (UserBrowserNotificationSetup('Appointment_Enroll_Instructor', $cart->instructor)) {
            send_browser_notification(
                $cart->instructor,
                $type = 'Appointment_Enroll_Instructor',
                $shortcodes = [
                    'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                    'timeSlot' => $timeSlot,
                    'topic' => $topic,
                    'currency' => $cart->instructor->currency->symbol ?? '$',
                    'price' => $hour_rate,
                    'student_name' => $cart->student->name,
                    'gateway' => $gateWayName,
                ],
                '', //actionText
                '' //actionUrl
            );
        }
    }

    public function defaultPayment($checkout_info, $user, $discount = 0, $cart, $carts, $courseType, $gateWayName = null, $response)
    {

        if ($cart->program_id > 0) {
            $courseType->single = 1;

            $Program = Program::where('id', $cart->program_id)->with(['programPlans' => function ($q) use ($cart) {
                $q->where('id', $cart->plan_id)->with('initialProgramPalnDetail');
            }])->first();

            $enrolled = $Program->total_enrolled;
            $Program->total_enrolled = ($enrolled + 1);

            //==========================Start Referral========================
            $purchase_history = CourseEnrolled::where('user_id', $user->id)->first();
            $referral_check = UserWiseCoupon::where('invite_accept_by', $user->id)->where('category_id', null)->where('course_id', null)->first();
            $referral_settings = UserWiseCouponSetting::where('role_id', $user->role_id)->first();

            if ($purchase_history == null && $referral_check != null) {
                $referral_check->category_id = $Program->category_id;
                $referral_check->subcategory_id = $Program->subcategory_id;
                $referral_check->program_id = $Program->id;
                $referral_check->save();
                $percentage_cal = ($referral_settings->amount / 100) * $checkout_info->price;

                if ($referral_settings->type == 1) {
                    if ($checkout_info->price > $referral_settings->max_limit) {
                        $bonus_amount = $referral_settings->max_limit;
                    } else {
                        $bonus_amount = $referral_settings->amount;
                    }
                } else {
                    if ($percentage_cal > $referral_settings->max_limit) {
                        $bonus_amount = $referral_settings->max_limit;
                    } else {
                        $bonus_amount = $percentage_cal;
                    }
                }

                $referral_check->bonus_amount = $bonus_amount;
                $referral_check->save();

                $invite_by = User::find($referral_check->invite_by);
                $invite_by->balance += $bonus_amount;
                $invite_by->save();

                $invite_accept_by = User::find($referral_check->invite_accept_by);
                $invite_accept_by->balance += $bonus_amount;
                $invite_accept_by->save();
            }

            //==========================Save student program payment plan ========================

            if (isset($Program->programPlans[0])) {
                $program_payment_plans = $Program->programPlans[0]->programPalnDetail;

                if (count($program_payment_plans)) {
                    foreach ($program_payment_plans as $program_payment_plan) {

                        $student_program_plan = new StudentProgramPaymentPlans;

                        $student_program_plan->type = $program_payment_plan->type;
                        $student_program_plan->amount = $program_payment_plan->amount;
                        $student_program_plan->sdate = $program_payment_plan->sdate;
                        $student_program_plan->edate = $program_payment_plan->edate;
                        $student_program_plan->program_id = $cart->program_id;
                        $student_program_plan->plan_id = $cart->plan_id;
                        $student_program_plan->user_id = $user->id;
                        $student_program_plan->pay_status = 'pay';
                        $student_program_plan->save();
                    }

                    $student_program_payment_plan = StudentProgramPaymentPlans::where('type', 0)->where('program_id', $cart->program_id)->where('plan_id', $cart->plan_id)->where('user_id', $user->id)->first();
                    $student_program_payment_plan->pay_status = 'paid';
                    $student_program_payment_plan->save();
                }
            }

            //==========================End Referral========================
            if ($discount != 0 || !empty($discount)) {
                $itemPrice = $cart->price - ($discount / count($carts));
                $discount_amount = $cart->price - $itemPrice;
            } else {
                $itemPrice = $cart->price;
                $discount_amount = 0.00;
            }

            $enroll = new CourseEnrolled();
            $instractor = User::find($cart->instructor_id);
            $enroll->user_id = $user->id;
            $enroll->tracking = $response->id;
            $enroll->program_id = $Program->id;
            $enroll->plan_id = $cart->plan_id;
            $enroll->purchase_price = $itemPrice;
            $enroll->coupon = null;
            $enroll->discount_amount = $discount_amount;
            $enroll->status = 1;

            // if (!is_null($Program->special_commission) && $Program->special_commission != 0) {
            //     $commission = $Program->special_commission;
            //     $reveune = ($itemPrice * $commission) / 100;
            //     $enroll->reveune = $reveune;
            // } elseif (!is_null($instractor->special_commission) && $instractor->special_commission != 0) {
            //     $commission = $instractor->special_commission;
            //     $reveune = ($itemPrice * $commission) / 100;
            //     $enroll->reveune = $reveune;
            // } else {
            //     $commission = 100 - Settings('commission');
            //     $reveune = ($itemPrice * $commission) / 100;
            //     $enroll->reveune = $reveune;
            // }

            // $payout = new InstructorPayout();
            // $payout->instructor_id = $Program->user_id;
            // $payout->reveune = $reveune;
            // $payout->status = 0;
            // $payout->save();
            $enroll->save();
            // if (isModuleActive('Group')) {
            //     if ($Program->isGroupCourse) {
            //         Event::dispatch(new GroupMemberCreate($Program->id, $user->id));
            //     }
            // }

            $Program->reveune = (($Program->reveune) + ($enroll->reveune));
            $Program->save();
            checkGamification('each_enroll', 'sales', $instractor);

            if (isModuleActive('Chat')) {
                event(new OneToOneConnection($instractor, $user, $Program));
            }
            if (isModuleActive('Survey')) {
                $hasSurvey = Survey::where('course_id', $Program->id)->get();
                foreach ($hasSurvey as $survey) {
                    $surveyController = new SurveyController();
                    $surveyController->assignSurvey($survey->id, $user->id);
                }
            }

            if (isModuleActive('Affiliate')) {
                if ($user->isReferralUser) {
                    Event::dispatch(new ReferralPayment($user->id, $Program->id, $Program->price));
                }
            }
            if (isModuleActive('Invoice')) {
                if ($checkout_info->invoice_id) {
                    $interface = App::make(InvoiceRepositoryInterface::class);
                    $interface->sendInvoice($checkout_info->user->id, null, $checkout_info);
                }
            }
            $shortCodes = [
                'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                'program' => $Program->title,
                'currency' => $checkout_info->user->currency->symbol ?? '$',
                'price' => ($checkout_info->user->currency->conversion_rate * $itemPrice),
                'instructor' => $Program->user->name,
                'gateway' => $gateWayName,
            ];
            if (UserEmailNotificationSetup('Course_Enroll_Payment', $checkout_info->user)) {
                send_email($checkout_info->user, 'Course_Enroll_Payment', $shortCodes);
            }
            if (UserBrowserNotificationSetup('Course_Enroll_Payment', $checkout_info->user)) {
                send_browser_notification($checkout_info->user, $type = 'Course_Enroll_Payment', $shortCodes);
            }
            $browserNotificationShortCodes = [
                'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                'Program' => $Program->title,
                'currency' => $instractor->currency->symbol ?? '$',
                'price' => ($instractor->currency->conversion_rate * $itemPrice),
                'rev' => @$reveune,
            ];
            if (UserEmailNotificationSetup('Enroll_notify_Instructor', $instractor)) {
                send_email($instractor, 'Enroll_notify_Instructor', $browserNotificationShortCodes);
            }
            if (UserBrowserNotificationSetup('Enroll_notify_Instructor', $instractor)) {
                send_browser_notification(
                    $instractor,
                    $type = 'Enroll_notify_Instructor',
                    $browserNotificationShortCodes,
                    '', //actionText
                    '' //actionUrl
                );
            }

            //start email subscription
            if ($instractor->subscription_api_status == 1) {
                try {
                    if ($instractor->subscription_method == "Mailchimp") {
                        $list = $Program->subscription_list;
                        $MailChimp = new MailChimp($instractor->subscription_api_key);
                        $MailChimp->post("lists/$list/members", [
                            'email_address' => $user->email,
                            'status' => 'subscribed',
                        ]);
                    } elseif ($instractor->subscription_method == "GetResponse") {

                        $list = $Program->subscription_list;
                        $getResponse = new \GetResponse($instractor->subscription_api_key);
                        $getResponse->addContact(array(
                            'email' => $user->email,
                            'campaign' => array('campaignId' => $list),

                        ));
                    } elseif ($instractor->subscription_method == "Acelle") {

                        $list = $Program->subscription_list;
                        $email = $user->email;
                        $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                        $acelleController = new AcelleController();
                        $response = $acelleController->curlPostRequest($make_action_url);
                    }
                } catch (\Exception $exception) {
                    GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);
                }
            }
        } else if ($cart->course_id > 0) {

            $courseType->single = 1;
            $course = Course::find($cart->course_id);

            $enrolled = $course->total_enrolled;
            $course->total_enrolled = ($enrolled + 1);

            //==========================Start Referral========================
            $purchase_history = CourseEnrolled::where('user_id', $user->id)->first();
            $referral_check = UserWiseCoupon::where('invite_accept_by', $user->id)->where('category_id', null)->where('course_id', null)->first();
            $referral_settings = UserWiseCouponSetting::where('role_id', $user->role_id)->first();

            if ($purchase_history == null && $referral_check != null) {
                $referral_check->category_id = $course->category_id;
                $referral_check->subcategory_id = $course->subcategory_id;
                $referral_check->course_id = $course->id;
                $referral_check->save();
                $percentage_cal = ($referral_settings->amount / 100) * $checkout_info->price;

                if ($referral_settings->type == 1) {
                    if ($checkout_info->price > $referral_settings->max_limit) {
                        $bonus_amount = $referral_settings->max_limit;
                    } else {
                        $bonus_amount = $referral_settings->amount;
                    }
                } else {
                    if ($percentage_cal > $referral_settings->max_limit) {
                        $bonus_amount = $referral_settings->max_limit;
                    } else {
                        $bonus_amount = $percentage_cal;
                    }
                }

                $referral_check->bonus_amount = $bonus_amount;
                $referral_check->save();

                $invite_by = User::find($referral_check->invite_by);
                $invite_by->balance += $bonus_amount;
                $invite_by->save();

                $invite_accept_by = User::find($referral_check->invite_accept_by);
                $invite_accept_by->balance += $bonus_amount;
                $invite_accept_by->save();
            }

            //            //==========================Save student program payment plan ========================
            //
            //            if(!empty($Program->currentProgramPlan[0])){
            //                $program_payment_plans = $Program->currentProgramPlan[0]->programPalnDetail;
            //
            //
            //                foreach ($program_payment_plans as $program_payment_plan){
            //
            //                    $student_program_plan = new StudentProgramPaymentPlans;
            //
            //                    $student_program_plan->type = $program_payment_plan->type;
            //                    $student_program_plan->amount = $program_payment_plan->amount;
            //                    $student_program_plan->sdate = $program_payment_plan->sdate;
            //                    $student_program_plan->edate = $program_payment_plan->edate;
            //                    $student_program_plan->program_id = $cart->program_id;
            //                    $student_program_plan->user_id = $user->id;
            //                    $student_program_plan->pay_status = 'pay';
            //                    $student_program_plan->save();
            //
            //                }
            //
            //                $student_program_payment_plan = StudentProgramPaymentPlans::where('type',0)->where('program_id',$cart->program_id)->where('user_id',$user->id)->first();
            //                $student_program_payment_plan->pay_status = 'paid';
            //                $student_program_payment_plan->save();
            //
            //            }

            //==========================End Referral========================
            if ($discount != 0 || !empty($discount)) {
                $itemPrice = $cart->price - ($discount / count($carts));
                $discount_amount = $cart->price - $itemPrice;
            } else {
                $itemPrice = $cart->price;
                $discount_amount = 0.00;
            }

            $enroll = new CourseEnrolled();
            $instractor = User::find($cart->instructor_id);
            $enroll->user_id = $user->id;
            $enroll->tracking = $response->id;
            $enroll->course_id = $course->id;
            if (!empty($cart->course_type)) {
                $enroll->course_type = $cart->course_type;
            }
            $enroll->purchase_price = $itemPrice;
            $enroll->coupon = null;
            $enroll->discount_amount = $discount_amount;
            $enroll->status = 1;

            // if (!is_null($course->special_commission) && $course->special_commission != 0) {
            //     $commission = $course->special_commission;
            //     $reveune = ($itemPrice * $commission) / 100;
            //     $enroll->reveune = $reveune;
            // } elseif (!is_null($instractor->special_commission) && $instractor->special_commission != 0) {
            //     $commission = $instractor->special_commission;
            //     $reveune = ($itemPrice * $commission) / 100;
            //     $enroll->reveune = $reveune;
            // } else {
            //     $commission = 100 - Settings('commission');
            //     $reveune = ($itemPrice * $commission) / 100;
            //     $enroll->reveune = $reveune;
            // }

            // $payout = new InstructorPayout();
            // $payout->instructor_id = $course->user_id;
            // $payout->reveune = $reveune;
            // $payout->status = 0;
            // $payout->save();
            $enroll->save();
            // if (isModuleActive('Group')) {
            //     if ($course->isGroupCourse) {
            //         Event::dispatch(new GroupMemberCreate($course->id, $user->id));
            //     }
            // }

            $course->reveune = (($course->reveune) + ($enroll->reveune));
            $course->save();
            checkGamification('each_enroll', 'sales', $instractor);

            if (isModuleActive('Chat')) {
                event(new OneToOneConnection($instractor, $user, $course));
            }
            if (isModuleActive('Survey')) {
                $hasSurvey = Survey::where('course_id', $course->id)->get();
                foreach ($hasSurvey as $survey) {
                    $surveyController = new SurveyController();
                    $surveyController->assignSurvey($survey->id, $user->id);
                }
            }

            if (isModuleActive('Affiliate')) {
                if ($user->isReferralUser) {
                    Event::dispatch(new ReferralPayment($user->id, $course->id, $course->price));
                }
            }
            if (isModuleActive('Invoice')) {
                if ($checkout_info->invoice_id) {
                    $interface = App::make(InvoiceRepositoryInterface::class);
                    $interface->sendInvoice($checkout_info->user->id, null, $checkout_info);
                }
            }
            $shortCodes = [
                'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                'Quiz' => $course->title,
                'currency' => $checkout_info->user->currency->symbol ?? '$',
                'price' => ($checkout_info->user->currency->conversion_rate * $itemPrice),
                'instructor' => $course->user->name,
                'gateway' => $gateWayName,
            ];
            if (UserEmailNotificationSetup('Course_Enroll_Payment', $checkout_info->user)) {
                send_email($checkout_info->user, 'Course_Enroll_Payment', $shortCodes);
            }
            if (UserBrowserNotificationSetup('Course_Enroll_Payment', $checkout_info->user)) {
                send_browser_notification($checkout_info->user, $type = 'Course_Enroll_Payment', $shortCodes);
            }
            $browserNotificationShortCodes = [
                'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                'Quiz' => $course->title,
                'currency' => $instractor->currency->symbol ?? '$',
                'price' => ($instractor->currency->conversion_rate * $itemPrice),
                'rev' => @$reveune,
            ];
            if (UserEmailNotificationSetup('Enroll_notify_Instructor', $instractor)) {
                send_email($instractor, 'Enroll_notify_Instructor', $browserNotificationShortCodes);
            }
            if (UserBrowserNotificationSetup('Enroll_notify_Instructor', $instractor)) {
                send_browser_notification(
                    $instractor,
                    $type = 'Enroll_notify_Instructor',
                    $browserNotificationShortCodes,
                    '', //actionText
                    '' //actionUrl
                );
            }

            //start email subscription
            if ($instractor->subscription_api_status == 1) {
                try {
                    if ($instractor->subscription_method == "Mailchimp") {
                        $list = $course->subscription_list;
                        $MailChimp = new MailChimp($instractor->subscription_api_key);
                        $MailChimp->post("lists/$list/members", [
                            'email_address' => $user->email,
                            'status' => 'subscribed',
                        ]);
                    } elseif ($instractor->subscription_method == "GetResponse") {

                        $list = $course->subscription_list;
                        $getResponse = new \GetResponse($instractor->subscription_api_key);
                        $getResponse->addContact(array(
                            'email' => $user->email,
                            'campaign' => array('campaignId' => $list),

                        ));
                    } elseif ($instractor->subscription_method == "Acelle") {

                        $list = $course->subscription_list;
                        $email = $user->email;
                        $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                        $acelleController = new AcelleController();
                        $response = $acelleController->curlPostRequest($make_action_url);
                    }
                } catch (\Exception $exception) {
                    GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);
                }
            }
        } else {
            $bundleCheck = BundleCoursePlan::find($cart->bundle_course_id);

            $totalCount = count($bundleCheck->course);
            $price = $bundleCheck->price;
            if ($price != 0) {
                $price = $price / $totalCount;
            }

            $courseType->bundle = 1;
            if ($cart->renew != 1) {
                foreach ($bundleCheck->course as $course) {

                    $enrolled = $course->course->total_enrolled;
                    $course->course->total_enrolled = ($enrolled + 1);

                    $enroll = new CourseEnrolled();
                    $instractor = User::find($cart->instructor_id);
                    $enroll->user_id = $user->id;
                    $enroll->tracking = $checkout_info->tracking;
                    $enroll->course_id = $course->course->id;
                    $enroll->purchase_price = $price;
                    $enroll->coupon = null;
                    $enroll->discount_amount = 0;
                    $enroll->status = 1;
                    $enroll->bundle_course_id = $cart->bundle_course_id;
                    $enroll->bundle_course_validity = $cart->bundle_course_validity;
                    //$enroll->reveune = $reveune / count($bundleCheck->course);
                    $enroll->save();

                    $course->course->save();
                }
            } else {
                $enrollBundleCourse = CourseEnrolled::where('bundle_course_id', $cart->bundle_course_id)->where('user_id', Auth::id())->get();
                foreach ($enrollBundleCourse as $enroll) {

                    $instractor = User::find($cart->user_id);
                    $enroll->bundle_course_id = $cart->bundle_course_id;
                    $enroll->bundle_course_validity = $cart->bundle_course_validity;
                    //$enroll->reveune = $enroll->reveune + $reveune / count($enrollBundleCourse);
                    $enroll->save();
                }
                $bundleId = $cart->bundle_course_id;
                $renew = 1;
            }
            $bundleCommission = BundleSetting::getData();
            if ($bundleCommission) {
                $commission = $bundleCommission->commission_rate;
                $reveune = ($bundleCheck->price * $commission) / 100;
                $bundleCheck->reveune += $reveune;
                $bundleCheck->student += 1;
                $bundleCheck->save();
            }
            $payout = new InstructorPayout();
            $payout->instructor_id = $bundleCheck->user_id;
            $payout->reveune = $reveune;
            $payout->status = 0;
            $payout->save();

            if (UserEmailNotificationSetup('Course_Enroll_Payment', $checkout_info->user)) {
                send_email($checkout_info->user, 'Course_Enroll_Payment', [
                    'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                    'course' => $bundleCheck->title,
                    'currency' => $checkout_info->user->currency->symbol ?? '$',
                    'price' => ($checkout_info->user->currency->conversion_rate * $bundleCheck->price),
                    'instructor' => $bundleCheck->user->name,
                    'gateway' => 'Sslcommerz',
                ]);
            }
            if (isModuleActive('Invoice')) {
                $interface = App::make(InvoiceRepositoryInterface::class);
                $interface->sendInvoice($checkout_info->user->id, null, $checkout_info);
            }
            if (UserBrowserNotificationSetup('Course_Enroll_Payment', $checkout_info->user)) {

                send_browser_notification(
                    $checkout_info->user,
                    $type = 'Course_Enroll_Payment',
                    $shortcodes = [
                        'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                        'course' => $bundleCheck->title,
                        'currency' => $checkout_info->user->currency->symbol ?? '$',
                        'price' => ($checkout_info->user->currency->conversion_rate * $bundleCheck->price),
                        'instructor' => $bundleCheck->user->name,
                        'gateway' => $gateWayName,
                    ],
                    '', //actionText
                    '' //actionUrl
                );
            }

            if (UserEmailNotificationSetup('Enroll_notify_Instructor', $instractor)) {
                send_email($instractor, 'Enroll_notify_Instructor', [
                    'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                    'course' => $bundleCheck->title,
                    'currency' => $instractor->currency->symbol ?? '$',
                    'price' => ($instractor->currency->conversion_rate * $bundleCheck->price),
                    'rev' => @$reveune,
                ]);
            }
            if (UserBrowserNotificationSetup('Enroll_notify_Instructor', $instractor)) {

                send_browser_notification(
                    $instractor,
                    $type = 'Enroll_notify_Instructor',
                    $shortcodes = [
                        'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                        'course' => $bundleCheck->title,
                        'currency' => $instractor->currency->symbol ?? '$',
                        'price' => ($instractor->currency->conversion_rate * $bundleCheck->price),
                        'rev' => @$reveune,
                    ],
                    '', //actionText
                    '' //actionUrl
                );
            }

            if (isModuleActive('Chat')) {
                event(new OneToOneConnection($instractor, $user, $course));
            }

            if (isModuleActive('Survey')) {
                $hasSurvey = Survey::where('course_id', $course->id)->get();
                foreach ($hasSurvey as $survey) {
                    $surveyController = new SurveyController();
                    $surveyController->assignSurvey($survey->id, $user->id);
                }
            }

            //start email subscription
            if ($instractor->subscription_api_status == 1) {
                try {
                    if ($instractor->subscription_method == "Mailchimp") {
                        $list = $course->subscription_list;
                        $MailChimp = new MailChimp($instractor->subscription_api_key);
                        $MailChimp->post("lists/$list/members", [
                            'email_address' => Auth::user()->email,
                            'status' => 'subscribed',
                        ]);
                    } elseif ($instractor->subscription_method == "GetResponse") {

                        $list = $course->subscription_list;
                        $getResponse = new \GetResponse($instractor->subscription_api_key);
                        $getResponse->addContact(array(
                            'email' => Auth::user()->email,
                            'campaign' => array('campaignId' => $list),

                        ));
                    }
                } catch (\Exception $exception) {
                    GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);
                }
            }
        }
    }
}
