<?php

namespace App\Http\Controllers;


use App\Models\CloverPayment;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Modules\Affiliate\Events\ReferralPayment;
use Modules\Appointment\Entities\Booking;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\BundleSubscription\Entities\BundleSetting;

use Modules\Group\Events\GroupMemberCreate;

use Modules\Invoice\Repositories\Interfaces\InvoiceRepositoryInterface;
use Modules\MercadoPago\Http\Controllers\MercadoPagoController;

use Modules\Payment\Entities\Checkout;

use Modules\PaymentMethodSetting\Entities\PaymentMethod;
use Modules\PaymentMethodSetting\Entities\PaymentMethodCredential;

use Modules\Survey\Entities\Survey;
use Modules\Survey\Http\Controllers\SurveyController;


class CloverController extends Controller
{

    public function makePayment(Request $request, $type = 'new_user', $response = false, $installment_id = null)
    {
        $post = $request->all();
        $post['currency'] = 'USD';
        $post['source'] = $_POST['cloverToken'];
        $clover_details = $this->getCloverConfig();

        $url = env('CLOVER_CHARGE_END_POINT');
        if ($clover_details->is_test == 'true') {
            $url = env('CLOVER_CHARGE_END_POINT_TEST');
        }

        $post = json_encode($post);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'accept: application/json',
            'authorization: Bearer ' . $clover_details->access_token,
            'content-type: application/json',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // execute!
        $getresponse = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        // do anything you want with your response
        $response1 = json_decode($getresponse);

        if (isset($response1->paid)) {
            $this->saveCloverResponce((int)$request->user_id, $getresponse, $type);
            $this->saveCheckout($request, $response1, $type, $installment_id, $getresponse);
            if ($response) {
                return $response1;
            }
            return true;
        } else {
            return false;
        }
    }

    public function saveCheckout($request, $response1, $type, $installment_id, $getresponse)
    {

        $checkout_info = new Checkout();
        $checkout_info->tracking = $response1->id;
        $checkout_info->user_id = ((Auth::id()) ?? (session()->get('user')->id));
        $checkout_info->installment_id = $installment_id;
        $checkout_info->purchase_price = $response1->amount / 100;
        $checkout_info->price = $response1->amount / 100;
        $checkout_info->status = 1;
        $checkout_info->payment_method = 'clover';
        $checkout_info->type = $type;
        $checkout_info->response = $getresponse;
        $checkout_info->save();
        return;
    }
    public function saveCloverResponce($user_id, $response, $type)
    {

        $pay = new CloverPayment;
        $pay->response = $response;
        $pay->user_id = $user_id;
        $pay->type = $type;
        $pay->save();

        return $pay;
    }

    public function getCloverConfig()
    {
        $clover = (object)[];
        $method = PaymentMethod::find(15);
        $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));
        $clover->client_id = $method_setup->CLOVER_CLIENT_ID;
        $clover->code = $method_setup->CLOVER_CODE;
        $clover->client_secret =  $method_setup->CLOVER_CLIENT_SECRET;
        $clover->merchant_id = $method_setup->CLOVER_MERCHANT_ID;
        $clover->employee_id = $method_setup->CLOVER_EMPLOYEE_ID;
        $clover->is_test = $method_setup->IS_CLOVER_LOCALHOST;
        $clover->access_token = !empty($method_setup->CLOVER_ACCESS_TOKEN) ? $method_setup->CLOVER_ACCESS_TOKEN : getPaymentEnv('CLOVER_ACCESS_TOKEN');
        return $clover;
    }

    public function getAccessToken($client_id, $client_secret, $code, $is_test)
    {


        $url = env('CLOVER_TOKEN_END_POINT');
        if ($is_test == 'true') {
            $url = env('CLOVER_TOKEN_END_POINT_TEST');
        }

        $data = array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $code
        );

        $msg = http_build_query($data);

        $url .= $msg;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result1 = json_decode($result);
        if (isset($result1->access_token)) {
            return $result1->access_token;
        } else {
            return $result1;
        }
    }
    public function getCloverPakmsKey($access_token, $is_test)
    {

        $url = env('CLOVER_PAKMS_END_POINT');
        if ($is_test == 'true') {
            $url = env('CLOVER_PAKMS_END_POINT_TEST');
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . $access_token
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $response1 = json_decode($response);
        if (isset($response1->apiAccessKey)) {
            return $response1->apiAccessKey;
        } else {
            return $response1;
        }
    }
    public function getPakmsKey()
    {

        $clover_details = $this->getCloverConfig();
        $access_token = $clover_details->access_token;

        if (isset($access_token->message)) {
            return $access_token;
        } else {
            $clover_details = $this->getCloverPakmsKey($access_token, $clover_details->is_test);
            return $clover_details;
        }
    }

    public function getclovercode(Request $request)
    {

        $method = PaymentMethod::find(15);
        try {
            $method_setup = PaymentMethodCredential::firstOrNew(array('lms_id' => $method->lms_id));

            $method_setup->CLOVER_CLIENT_ID = trim($request->client_id);
            $method_setup->CLOVER_CODE = trim($request->code);
            $method_setup->CLOVER_MERCHANT_ID = trim($request->merchant_id);
            $method_setup->CLOVER_EMPLOYEE_ID = trim($request->employee_id);
            $access_token = $this->getAccessToken($request->client_id, $method_setup->CLOVER_CLIENT_SECRET, $request->code, $method_setup->IS_CLOVER_LOCALHOST);
            if (isset($access_token->message)) {
                return  "Something went wrong Trying Again:" . $access_token->message;
            }
            $method_setup->CLOVER_ACCESS_TOKEN = $access_token;
            $method_setup->save();

            return "Successfully Save Into Your Database: " . json_encode([
                'client_id' => $method_setup->CLOVER_CLIENT_ID,
                'client_secret' => $method_setup->CLOVER_CLIENT_SECRET,
                'code' => $method_setup->CLOVER_CODE,
                'merchant_id' => $method_setup->CLOVER_MERCHANT_ID,
                'employee_id' => $method_setup->CLOVER_EMPLOYEE_ID,
                'access_token' => $method_setup->CLOVER_ACCESS_TOKEN,
                'is_test' => $method_setup->IS_CLOVER_LOCALHOST
            ]);
        } catch (\Throwable $th) {
            return  "Something went wrong : \n" . $th;
        }
    }
}
