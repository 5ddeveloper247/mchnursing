<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Jobs\SendGeneralEmail;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseComment;
use Modules\CourseSetting\Entities\CourseCommentReply;
use Modules\CourseSetting\Entities\CourseReveiw;
use Modules\StudentSetting\Entities\TutorReveiws;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }


    public function saveComment(Request $request)
    {
        Session::flash('selected_tab', 'qa');
        $request->validate([
            'course_id' => 'required',
            'comment' => 'required',
        ]);


        try {
            $course = Course::where('id', $request->course_id)->first();

            if (isset($course)) {
                $comment = new CourseComment();
                $comment->user_id = Auth::user()->id;
                $comment->course_id = $request->course_id;
                $comment->instructor_id = $course->user_id;
                $comment->comment = $request->comment;
                $comment->status = 1;
                $comment->save();


                $courseUser = $course->user;
                if (UserEmailNotificationSetup('Course_comment', $courseUser)) {
                    SendGeneralEmail::dispatch($courseUser, 'Course_comment', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'comment' => $comment->comment,
                    ]);

                }
                if (UserBrowserNotificationSetup('Course_comment', $courseUser)) {
                    send_browser_notification($courseUser, 'Course_comment', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'comment' => $comment->comment,
                    ],
                        trans('common.View'),
                        courseDetailsUrl($course->id, $course->type, $course->slug)
                    );
                }

                if (UserMobileNotificationSetup('Course_comment', $courseUser) && !empty($courseUser->device_token)) {
                    send_mobile_notification($courseUser, 'Course_comment', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'comment' => $comment->comment,
                    ]);
                }

                if (isModuleActive('Org')) {
                    addOrgRecentActivity(\auth()->id(), $course->id, 'Comment');
                }

                checkGamification('each_comment', 'communication');

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error('Invalid Action !', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function saveCommentAjax(Request $request)
    {

        try {
            $course = Course::where('id', $request->course_id)->first();

            if (isset($course)) {
                $comment = new CourseComment();
                $comment->user_id = Auth::user()->id;
                $comment->course_id = $request->course_id;
                $comment->instructor_id = $course->user_id;
                $comment->comment = $request->comment;
                $comment->status = 1;
                $comment->save();


                $courseUser = $course->user;
                if (UserEmailNotificationSetup('Course_comment', $courseUser)) {
                    SendGeneralEmail::dispatch($courseUser, 'Course_comment', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'comment' => $comment->comment,
                    ]);

                }
                if (UserBrowserNotificationSetup('Course_comment', $courseUser)) {
                    send_browser_notification($courseUser, 'Course_comment', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'comment' => $comment->comment,
                    ],
                        trans('common.View'),
                        courseDetailsUrl($course->id, $course->type, $course->slug)
                    );
                }

                if (UserMobileNotificationSetup('Course_comment', $courseUser) && !empty($courseUser->device_token)) {
                    send_mobile_notification($courseUser, 'Course_comment', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'comment' => $comment->comment,
                    ]);
                }

                if (isModuleActive('Org')) {
                    addOrgRecentActivity(\auth()->id(), $course->id, 'Comment');
                }
                checkGamification('each_comment', 'communication');

                $isEnrolled = $course->isLoginUserEnrolled;
                return view(theme('partials._single_comment'), ['comment' => $comment, 'isEnrolled' => $isEnrolled, 'course' => $course])->render();

            }
        } catch (\Exception $e) {

        }

        return '';
    }

    public function submitCommnetReply(Request $request)
    {
        Session::flash('selected_tab', 'qa');
        $request->validate([
            'comment_id' => 'required',
            'reply' => 'required'
        ]);
        try {
            $comment = CourseComment::find($request->comment_id);
            $course = $comment->course;
            $commentUser = $comment->user;

            if (isset($course)) {
                $comment = new CourseCommentReply();
                $comment->user_id = Auth::user()->id;
                $comment->course_id = $course->id;
                if (!empty($request->reply_id)) {
                    $comment->reply_id = $request->reply_id;
                } else {
                    $comment->reply_id = null;
                }
                $comment->comment_id = $request->comment_id;
                $comment->reply = $request->reply;
                $comment->status = 1;
                $comment->save();

                if ($course->user->id != Auth::user()->id) {
                    if (UserEmailNotificationSetup('Course_comment_Reply', $course->user)) {
                        SendGeneralEmail::dispatch($course->user, 'Course_comment_Reply', [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->title,
                            'comment' => $comment->comment,
                            'reply' => $comment->reply,
                        ]);
                    }
                    if (UserBrowserNotificationSetup('Course_comment_Reply', $course->user)) {
                        send_browser_notification($course->user, 'Course_comment_Reply', [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->title,
                            'comment' => $comment->comment,
                            'reply' => $comment->reply,
                        ],
                            trans('common.View'),
                            courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                        );
                    }

                    if (UserMobileNotificationSetup('Course_comment_Reply', $course->user) && !empty($course->user->device_token)) {
                        send_mobile_notification($course->user, 'Course_comment_Reply', [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->title,
                            'comment' => $comment->comment,
                            'reply' => $comment->reply,
                        ]);
                    }
                }

                if (UserEmailNotificationSetup('Course_comment_Reply', $commentUser)) {
                    SendGeneralEmail::dispatch($commentUser, 'Course_comment_Reply', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'comment' => $comment->comment,
                        'reply' => $comment->reply,
                    ]);
                }
                if (UserBrowserNotificationSetup('Course_comment_Reply', $commentUser)) {
                    send_browser_notification($commentUser, 'Course_comment_Reply', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'comment' => $comment->comment,
                        'reply' => $comment->reply,
                    ],
                        trans('common.View'),
                        courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                    );
                }

                if (UserMobileNotificationSetup('Course_comment_Reply', $commentUser) && !empty($commentUser->device_token)) {
                    send_mobile_notification($commentUser, 'Course_comment_Reply', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'comment' => $comment->comment,
                        'reply' => $comment->reply,
                    ]);
                }
                checkGamification('each_comment', 'communication');

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error('Invalid Action !', 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function submitCommnetReplyAjax(Request $request)
    {
        try {
            $comment = CourseComment::find($request->comment_id);
            $course = $comment->course;
            $commentUser = $comment->user;

            if (isset($course)) {
                $comment = new CourseCommentReply();
                $comment->user_id = Auth::user()->id;
                $comment->course_id = $course->id;
                if (!empty($request->reply_id)) {
                    $comment->reply_id = $request->reply_id;
                } else {
                    $comment->reply_id = null;
                }
                $comment->comment_id = $request->comment_id;
                $comment->reply = $request->reply;
                $comment->status = 1;
                $comment->save();

                if ($course->user->id != Auth::user()->id) {
                    if (UserEmailNotificationSetup('Course_comment_Reply', $course->user)) {
                        SendGeneralEmail::dispatch($course->user, 'Course_comment_Reply', [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->title,
                            'comment' => $comment->comment,
                            'reply' => $comment->reply,
                        ]);
                    }
                    if (UserBrowserNotificationSetup('Course_comment_Reply', $course->user)) {
                        send_browser_notification($course->user, 'Course_comment_Reply', [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->title,
                            'comment' => $comment->comment,
                            'reply' => $comment->reply,
                        ],
                            trans('common.View'),
                            courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                        );
                    }

                    if (UserMobileNotificationSetup('Course_comment_Reply', $course->user) && !empty($course->user->device_token)) {
                        send_mobile_notification($course->user, 'Course_comment_Reply', [
                            'time' => Carbon::now()->format('d-M-Y, g:i A'),
                            'course' => $course->title,
                            'comment' => $comment->comment,
                            'reply' => $comment->reply,
                        ]);
                    }
                }

                if (UserEmailNotificationSetup('Course_comment_Reply', $commentUser)) {
                    SendGeneralEmail::dispatch($commentUser, 'Course_comment_Reply', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'comment' => $comment->comment,
                        'reply' => $comment->reply,
                    ]);
                }
                if (UserBrowserNotificationSetup('Course_comment_Reply', $commentUser)) {
                    send_browser_notification($commentUser, 'Course_comment_Reply', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'comment' => $comment->comment,
                        'reply' => $comment->reply,
                    ],
                        trans('common.View'),
                        courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                    );
                }

                if (UserMobileNotificationSetup('Course_comment_Reply', $commentUser) && !empty($commentUser->device_token)) {
                    send_mobile_notification($commentUser, 'Course_comment_Reply', [
                        'time' => Carbon::now()->format('d-M-Y, g:i A'),
                        'course' => $course->title,
                        'comment' => $comment->comment,
                        'reply' => $comment->reply,
                    ]);
                }
                $isEnrolled = $course->isLoginUserEnrolled;
                checkGamification('each_comment', 'communication');

                return view(theme('partials._single_comment_reply'), ['replay' => $comment, 'isEnrolled' => $isEnrolled, 'course' => $course])->render();

            }
        } catch (\Exception $e) {
        }
        return "";
    }


    public function deleteComment($id)
    {
        try {
            $comment = CourseComment::find($id);
            $user = Auth::user();
            if ($comment->user_id == $user->id || $user->role_id == 1 || $comment->instructor_id == $user->id) {
                $comment->delete();
                if (isset($comment->replies)) {
                    foreach ($comment->replies as $replay) {
                        $replay->delete();
                    }
                }
                return true;
            } else {
                return false;
            }


        } catch (\Exception $exception) {
            return false;

        }
    }

    public function deleteReview($id)
    {
        try {
            $review = CourseReveiw::find($id);
            $course_id = $review->course_id;
            $user = Auth::user();
            if ($review->user_id == $user->id || $user->role_id == 1 || $review->instructor_id == $user->id) {
                $review->delete();

                $course = Course::find($course_id);
                $total = CourseReveiw::where('course_id', $course->id)->sum('star');
                $count = CourseReveiw::where('course_id', $course->id)->where('status', 1)->count();
                if ($total != 0) {
                    $average = $total / $count;
                } else {
                    $average = 0;
                }
                $course->reveiw = $average;
                $course->total_rating = $average;
                $course->save();


                $course_user = User::find($course->user_id);
                $user_courses = Course::where('user_id', $course_user->id)->get();
                $user_total = 0;
                $user_rating = 0;
                foreach ($user_courses as $u_course) {
                    $total = CourseReveiw::where('course_id', $u_course->id)->sum('star');
                    $count = CourseReveiw::where('course_id', $u_course->id)->where('status', 1)->count();
                    if ($total != 0) {
                        $user_total = $user_total + 1;
                        $average = $total / $count;
                        $user_rating = $user_rating + $average;
                    }
                }
                if ($user_total != 0) {
                    $user_rating = $user_rating / $user_total;
                }
                $course_user->total_rating = $user_rating;
                $course_user->save();

                $total = CourseReveiw::where('course_id', $course->id)->sum('star');
                $count = CourseReveiw::where('course_id', $course->id)->where('status', 1)->count();
                if ($total != 0) {
                    $average = $total / $count;
                } else {
                    $average = 0;
                }
                $course->reveiw = $average;
                $course->total_rating = $average;
                $course->save();


                return true;
            } else {
                return false;
            }


        } catch (\Exception $exception) {
            return false;
        }
    }

    public function deleteTutorReview($id)
    {
        try {
            $review = TutorReveiws::find($id);
            $instructor_id = $review->instructor_id;
            $user = Auth::user();
            if ($review->user_id == $user->id || $user->role_id == 1 || $review->instructor_id == $user->id) {
                $review->delete();

                $user = User::find($instructor_id);
                $total = TutorReveiws::where('instructor_id', $instructor_id)->sum('star');
                $count = TutorReveiws::where('instructor_id', $instructor_id)->where('status', 1)->count();
                if ($total != 0) {
                    $average = $total / $count;
                } else {
                    $average = 0;
                }
                $user->total_tutor_rating = $average;
                $user->save();


//                $course_user = User::find($course->user_id);
//                $user_courses = Course::where('user_id', $course_user->id)->get();
//                $user_total = 0;
//                $user_rating = 0;
//                foreach ($user_courses as $u_course) {
//                    $total = CourseReveiw::where('course_id', $u_course->id)->sum('star');
//                    $count = CourseReveiw::where('course_id', $u_course->id)->where('status', 1)->count();
//                    if ($total != 0) {
//                        $user_total = $user_total + 1;
//                        $average = $total / $count;
//                        $user_rating = $user_rating + $average;
//                    }
//                }
//                if ($user_total != 0) {
//                    $user_rating = $user_rating / $user_total;
//                }
//                $course_user->total_rating = $user_rating;
//                $course_user->save();
//
//                $total = CourseReveiw::where('course_id', $course->id)->sum('star');
//                $count = CourseReveiw::where('course_id', $course->id)->where('status', 1)->count();
//                if ($total != 0) {
//                    $average = $total / $count;
//                } else {
//                    $average = 0;
//                }
//                $course->reveiw = $average;
//                $course->total_rating = $average;
//                $course->save();


                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error('Invalid access', trans('common.Failed'));
                return redirect()->back();
            }


        } catch (\Exception $exception) {
            Toastr::error('Operation Failed', trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function deleteCommnetReply($id)
    {
        try {

            $reply = CourseCommentReply::find($id);
            $course = Course::find($reply->course_id);
            $user = Auth::user();

            if ($reply->user_id == $user->id || $user->role_id == 1 || $course->user_id == $user->id) {
                $reply->delete();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            } else {
                Toastr::error('Invalid access', trans('common.Failed'));
            }
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }
}
