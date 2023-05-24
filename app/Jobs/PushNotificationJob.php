<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $title, $details, $device_token, $type, $id;

    public function __construct($title, $details, $device_token, $id = null, $type = null)
    {
        $this->title = $title;
        $this->details = $details;
        $this->device_token = $device_token;
        $this->id = $id;
        $this->type = $type;
    }


    public function handle()
    {
         Http::withToken(config('services.fcm.key'))
            ->post('https://fcm.googleapis.com/fcm/send', [
                "to" => $this->device_token,
                "notification" => [
                    "priority" => "high",
                    "title" => $this->title,
                    "body" => $this->details,
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    "type" => $this->type,
                    "id" => $this->id,
                    "image" => getCourseImage(Settings('logo'))
                ],
                "data" => [
                    "priority" => "high",
                    "title" => $this->title,
                    "body" => $this->details,
                    "type" => $this->type,
                    "id" => $this->id,
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    "image" => getCourseImage(Settings('logo'))
                ],
            ]);

    }
}
