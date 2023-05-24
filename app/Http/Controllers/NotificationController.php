<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\CourseSetting\Entities\Notification;

class NotificationController extends Controller
{
    public function ajaxNotificationMakeRead(Request $request)
    {
        $url = '';
        if (Auth::check()) {
            $notification = Auth::user()->unreadNotifications->find($request->id);

            if ($notification) {
                $url = $notification->data['actionURL'] ?? '';
                $notification->markAsRead();
            }
        }


        return json_encode($url);
    }

    public function NotificationMakeAllRead(Request $request)
    {

        if (!Auth::check()) {
            return redirect('login');
        }
        try {
            Auth::user()->unreadNotifications->markAsRead();
            Toastr::success('All Notification Marked As Read !', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function myNotificationSetup()
    {
        return view(theme('pages.myNotificationsSetup'));
    }

    public function myNotification(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        try {
            return view(theme('pages.myNotifications'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function delete($id)
    {
        try {
            Notification::where('id', $id)->delete();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $exception) {
            GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

}
