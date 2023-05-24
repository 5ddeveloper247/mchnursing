<?php

namespace Modules\Setting\Http\Controllers;

use App\Jobs\PushNotificationJob;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;


class PushNotificationController extends Controller
{
    public function pushNotification()
    {
        return view('setting::push-notification');
    }


    public function pushNotificationSubmit(Request $request)
    {
        $users = User::where('role_id', 3)
            ->whereNotNull('device_token')
            ->where('status', 1)
            ->get();
        foreach ($users as $user) {
            PushNotificationJob::dispatch($request->title, $request->details, $user->device_token);
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }
}
