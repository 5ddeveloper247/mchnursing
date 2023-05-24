<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Payment\Entities\Checkout;

class MyInvoicePageSection extends Component
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        $enroll = Checkout::where('id', $this->id);
        if (Auth::user()->role_id != 1) {
            $enroll =  $enroll->where('user_id', Auth::user()->id);
        }
        $enroll = $enroll->with('courses', 'billing','user', 'courses.course', 'courses.program','tutorHirings','tutorHirings.instructor', 'studentIstallment.program', 'studentIstallment.plan')->first();

        if (!$enroll) {
            abort(404);
        }
//dd($enroll);
        return view(theme('components.my-invoice-page-section'), compact('enroll'));
    }
}
