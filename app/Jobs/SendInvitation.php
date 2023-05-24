<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendInvitation
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $course;
    public $user;

    public function __construct($course, $user)
    {
        $this->course = $course;
        $this->user = $user;
    }

    public function handle()
    {
        if (UserEmailNotificationSetup('Course_Invitation', $this->user)) {
            SendGeneralEmail::dispatch($this->user, 'Course_Invitation', [
                'name' => $this->user->name,
                'course_name' => $this->course->title,
                'instructor_name' => $this->course->user->name,
                'course_url' => route('courseDetailsView', $this->course->slug),
                'price' => $this->course->price,
                'about' => $this->course->about,
            ]);
        }
        if (UserBrowserNotificationSetup('Course_Invitation', $this->user)) {
            send_browser_notification($this->user, 'Course_Invitation', [
                'name' => $this->user->name,
                'course_name' => $this->course->title,
                'instructor_name' => $this->course->user->name,
                'course_url' => route('courseDetailsView', $this->course->slug),
                'price' => $this->course->price,
                'about' => $this->course->about,
            ],
                trans('common.View'),
                courseDetailsUrl(@$this->course->id, @$this->course->type, @$this->course->slug),
            );
        }

        if (UserMobileNotificationSetup('Course_Invitation', $this->user) && !empty($this->user->device_token)) {
            send_mobile_notification($this->user, 'Course_Invitation', [
                'name' => $this->user->name,
                'course_name' => $this->course->title,
                'instructor_name' => $this->course->user->name,
                'course_url' => route('courseDetailsView', $this->course->slug),
                'price' => $this->course->price,
                'about' => $this->course->about,
            ]);
        }
    }
}
