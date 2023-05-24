<?php


namespace Modules\StudentSetting\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\CloverPayment;
use App\Models\UserApplication;
use App\Models\UserAuthorzIationAgreement;
use App\Models\UserSetting;
use App\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class StudentViewController extends Controller
{
    public function index($id)
    {

        try {
            $student = (object)[];

            $student->student =   User::find($id);
            $student->studentsetting =   UserSetting::where('user_id', $id)->first();
            $student->studentapplication =   UserApplication::where('user_id', $id)->first();
            $student->studentauthorziationagreement =   UserAuthorzIationAgreement::where('user_id', $id)->first();
            $payment_detail =  CloverPayment::where('user_id', $id)->where('type', 'new_user')->first();
            $student->payment_detail = [];
            if (!empty($payment_detail)) :
                $student->payment_detail = json_decode($payment_detail->response);
                $student->payment_detail->created_at = $payment_detail->created_at;
            endif;
            return view('studentsetting::student_view', compact('student'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }
    public function StudentDetail(Request $request)
    {
        $rules = [
            'f_name' => 'required',
            'l_name' => 'required',
            'dob' => 'required',
            'SS' => 'required',
            'city' => 'required',
            'state' => 'required',
            'Zip' => 'required',
            'mailing_address' => 'required',
            'program_review' => 'required',
            'student_signature' => 'required',
            'student_signature_date' => 'required',

        ];

        $this->validate($request, $rules, validationMessage($rules));
        try {



            $user = \App\Models\User::where('id', $request->user_id)->first();
            $user->dob = $request->dob;
            $user->Zip = $request->Zip;
            $user->update();

            $this->seveUserSetting($request);

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {


            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function StudentApplication(Request $request)
    {

        $rules = [
            'term_one_text' => 'required',
            'invoice_date_one' => 'required',
            'invoice_date_two' => 'required',
            'term_two_text' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'fax' => 'required',
            'city' => 'required',
            'state' => 'required',
            'Zip' => 'required',
            'country' => 'required',
            'payment_type' => 'required',
            'credit_card_no' => 'required',
            'exp_date' => 'required',
            'card_appears_name' => 'required',
            'digit_on_back' => 'required',
            'dollar_amount' => 'required',
            'stgnature' => 'required',
            'paid_bill_date' => 'required',
            'paid_bill' => 'required',
            'student_signature' => 'required',
            'student_signature_date' => 'required',
            'user_id' => 'required'
        ];
        session()->flash('type', 2);
        $this->validate($request, $rules, validationMessage($rules));
        try {


            $userApplication = UserApplication::where('user_id', (int)$request->user_id);

            if (!$userApplication->count()) {
                $userApplication = new UserApplication;
            } else {
                $userApplication = $userApplication->first();
            }

            $userApplication->term_one_text = $request->term_one_text;
            $userApplication->invoice_date_one = $request->invoice_date_one;
            $userApplication->invoice_date_two = $request->invoice_date_two;
            $userApplication->term_two_text = $request->term_two_text;
            $userApplication->name = $request->name;
            $userApplication->phone = $request->phone;
            $userApplication->address = $request->address;
            $userApplication->fax = $request->fax;
            $userApplication->city = $request->city;
            $userApplication->state = $request->state;
            $userApplication->Zip = $request->Zip;
            $userApplication->country = $request->country;
            $userApplication->payment_type = $request->payment_type;
            $userApplication->credit_card_no = $request->credit_card_no;
            $userApplication->exp_date = $request->exp_date;
            $userApplication->card_appears_name = $request->card_appears_name;
            $userApplication->digit_on_back = $request->digit_on_back;
            $userApplication->dollar_amount = $request->dollar_amount;
            $userApplication->stgnature = $request->stgnature;
            $userApplication->paid_bill_date = $request->paid_bill_date;
            $userApplication->paid_bill = $request->paid_bill;
            $userApplication->student_signature = $request->student_signature;
            $userApplication->student_signature_date = $request->student_signature_date;
            $userApplication->user_id = (int)$request->user_id;
            $userApplication->save();

            session()->flash('type', 2);
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {


            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function StudentAuthenticationAgreement(Request $request)
    {
        $rules = [
            'applican_name' => 'required',
            'authorized_representative' => 'required',
            'address' => 'required',
            'applicant_signature' => 'required',
            'date' => 'required',
            'state' => 'required',
            'country' => 'required',
            'day' => 'required',
            'age' => 'required',
            'name' => 'required',
            'by' => 'required',
            'whose_identity' => 'required',
            'notary_signature' => 'required',
            'printed_name' => 'required',
            'user_id' => 'required'
        ];
        session()->flash('type', 3);
        $this->validate($request, $rules, validationMessage($rules));
        try {

            $AuthorzIationAgreement = UserAuthorzIationAgreement::where('user_id', $request->user_id);
            if (!$AuthorzIationAgreement->count()) {
                $AuthorzIationAgreement = new UserAuthorzIationAgreement;
            } else {
                $AuthorzIationAgreement = $AuthorzIationAgreement->first();
            }

            $AuthorzIationAgreement->applican_name = $request->applican_name;
            $AuthorzIationAgreement->authorized_representative = $request->authorized_representative;
            $AuthorzIationAgreement->address = $request->address;
            $AuthorzIationAgreement->applicant_signature = $request->applicant_signature;
            $AuthorzIationAgreement->date = $request->date;
            $AuthorzIationAgreement->state = $request->state;
            $AuthorzIationAgreement->country = $request->country;
            $AuthorzIationAgreement->day = $request->day;
            $AuthorzIationAgreement->age = $request->age;
            $AuthorzIationAgreement->name = $request->name;
            $AuthorzIationAgreement->by = $request->by;
            $AuthorzIationAgreement->whose_identity = $request->whose_identity;
            $AuthorzIationAgreement->notary_signature = $request->notary_signature;
            $AuthorzIationAgreement->printed_name = $request->printed_name;
            $AuthorzIationAgreement->user_id = (int)$request->user_id;
            $AuthorzIationAgreement->save();

            session()->flash('type', 3);
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {

            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function seveUserSetting(Request $request)
    {

        $program_review = json_encode($request->program_review);
        $userSetting = UserSetting::where('user_id', $request->user_id);
        if (!$userSetting->count()) {
            $userSetting = new UserSetting;
        } else {
            $userSetting = $userSetting->first();
        }
        $userSetting->f_name = $request->f_name;
        $userSetting->l_name = $request->l_name;
        $userSetting->SS = $request->SS;
        $userSetting->mailing_address = $request->mailing_address;
        $userSetting->program_review = $program_review;
        $userSetting->student_signature = $request->student_signature;
        $userSetting->student_signature_date = $request->student_signature_date;
        $userSetting->city = $request->city;
        $userSetting->state = $request->state;
        $userSetting->user_id = $request->user_id;
        $userSetting->save();
        return $userSetting;
    }
}
