<?php

use App\Http\Controllers\Frontend\ThemeDynamicData;
use App\Jobs\PushNotificationJob;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use IvoPetkov\HTML5DOMDocument;
use Modules\Blog\Entities\UserBlog;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\FooterSetting\Entities\FooterSetting;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\HumanResource\Entities\Attendance;
use Modules\OrgSubscription\Entities\OrgCourseSubscription;
use Modules\OrgSubscription\Entities\OrgSubscriptionCheckout;
use Modules\Payment\Entities\Cart;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\Role;
use Modules\Setting\Entities\Badge;
use Modules\Setting\Entities\ErrorLog;
use Modules\Setting\Entities\UserBadge;
use Modules\Setting\Entities\UserGamificationPoint;
use Modules\Setting\Entities\UserLevelHistory;
use Modules\Setting\Model\Currency;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Modules\Setting\Entities\IpBlock;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Modules\Appearance\Entities\Theme;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Modules\Setting\Model\GeneralSetting;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use Modules\CourseSetting\Entities\Category;
use Modules\FrontendManage\Entities\HomeContent;
use Modules\SystemSetting\Entities\EmailSetting;
use Modules\SystemSetting\Entities\EmailTemplate;
use Modules\FrontendManage\Entities\CourseSetting;
use Modules\Membership\Entities\MembershipUpgradeLevel;
use Modules\StudentSetting\Entities\BookmarkCourse;
use Modules\Subscription\Entities\SubscriptionCheckout;
use Modules\NotificationSetup\Entities\RoleEmailTemplate;
use Modules\NotificationSetup\Entities\UserNotificationSetup;

if (!function_exists('send_smtp_mail')) {
    function send_smtp_mail($config, $receiver_email, $receiver_name, $sender_email, $sender_name, $subject, $message)
    {
        $mail_val = [
            'send_to_name' => $receiver_name,
            'send_to' => $receiver_email,
            'email_from' => $config->from_email,
            'email_from_name' => $config->from_name,
            'subject' => $subject,
        ];

        Mail::send('partials.email', ['body' => $message], function ($send) use ($mail_val) {
            $send->from($mail_val['email_from'], $mail_val['email_from_name']);
            $send->replyto($mail_val['email_from'], $mail_val['email_from_name']);
            $send->to($mail_val['send_to'])->subject($mail_val['subject']);
        });
    }

}

if (!function_exists('sendMailBySendGrid')) {
    function sendMailBySendGrid($config, $receiver_email, $receiver_name, $sender_email, $sender_name, $subject, $message)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($config->from_email, $config->from_name);
        $email->setSubject($subject);
        $email->addTo($receiver_email, $receiver_email);
        $email->addContent(
            "text/html", (string)view('partials.email', ['body' => $message])
        );
        $sendgrid = new \SendGrid($config->api_key);
        try {
            $response = $sendgrid->send($email);
            if ($response->statusCode() == 202) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}


if (!function_exists('shortcode_replacer')) {

    function shortcode_replacer($shortcode, $replace_with, $template_string)
    {
        if ($shortcode == "{{currency}}") {
            return str_replace($shortcode, '', $template_string);
        }

        if ($shortcode == "{{amount}}" || $shortcode == "{{price}}" || $shortcode == "{{rev}}") {
            return str_replace($shortcode, getPriceFormat($replace_with), $template_string);
        }
        return str_replace($shortcode, $replace_with, $template_string);
    }
}

if (!function_exists('send_email')) {

    function send_email($user, $type, $shortcodes = [])
    {
        try {
            $query = EmailTemplate::query();
            if (!showEcommerce()) {
                $query->where('ecommerce', 0);
            }
            $email_template = $query->where('act', $type)->first();

            if ($email_template && $email_template->status == 1) {

                $message = $email_template->email_body;

                foreach ($shortcodes as $code => $value) {
                    $message = shortcode_replacer('{{' . $code . '}}', $value, $message);
                }

                $message = shortcode_replacer('{{footer}}', Settings('email_template'), $message);

                $config = EmailSetting::where('active_status', 1)->first();

                if ($type == "CONTACT_MESSAGE") {
                    $to_email = Settings('email');
                } else {
                    $to_email = $user->email;
                }

                if ($config->id == 1) {
                    send_php_mail($to_email, $user->name, $config->from_email, $email_template->subj, $message);
                } else if ($config->id == 2) {
                    send_smtp_mail($config, $to_email, $user->name, $config->from_email, Settings('site_title'), $email_template->subj, $message);
                } else if ($config->id == 3) {
                    sendMailBySendGrid($config, $to_email, $user->name, $config->from_email, Settings('site_title'), $email_template->subj, $message);
                }
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }


    }
}


if (!function_exists('getTrx')) {
    function getTrx($length = 12)
    {
        $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 12; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('routeIsExist')) {
    function routeIsExist($route)
    {
        if (Route::has($route)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('validRouteUrl')) {
    function validRouteUrl($route)
    {
        $url = null;
        try {
            if (routeIsExist($route)) {
                $url = \route($route);
            }
        } catch (\Exception $e) {
        }
        return $url;
    }
}

if (!function_exists('routeIs')) {
    function routeIs($route)
    {
        if (Route::currentRouteName() == $route) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('appMode')) {
    function appMode()
    {
        return Config::get('app.app_sync');
    }
}

if (!function_exists('demoCheck')) {
    function demoCheck($message = '')
    {
        if (appMode()) {
            if (empty($message)) {
                $message = trans('common.For the demo version, you cannot change this');
            }
            Toastr::error($message, trans('common.Failed'));
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('userName')) {
    function userName($id)
    {
        if (User::find($id) != null) {
            return User::find($id)->name;
        }
        return null;
    }
}
if (!function_exists('fileUpload')) {
    function fileUpload($file, $destination)
    {
        $contains = Str::contains($destination, SaasDomain() . '/');
        if (!$contains) {
            $destination = explode('public/uploads/', $destination);
            $destination = $destination[0] . 'public/uploads/' . SaasDomain() . '/' . $destination[array_key_last($destination)];
        }


        $fileName = "";

        if (!$file) {
            return $fileName;
        }

        $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }
        $file->move($destination, $fileName);
        $fileName = $destination . $fileName;
        return $fileName;

    }
}

if (!function_exists('fileUpdate')) {
    function fileUpdate($databaseFile, $file, $destination)
    {
        $contains = Str::contains($destination, SaasDomain() . '/');
        if (!$contains) {
            $destination = explode('public/uploads/', $destination);
            $destination = $destination[0] . 'public/uploads/' . SaasDomain() . '/' . $destination[array_key_last($destination)];
        }

        $fileName = "";

        if ($file) {
            $fileName = fileUpload($file, $destination);

            if ($databaseFile && file_exists($databaseFile)) {

                unlink($databaseFile);

            }
        } elseif (!$file and $databaseFile) {
            $fileName = $databaseFile;
        }

        return $fileName;

    }
}
if (!function_exists('showPicName')) {
    function showPicName($data)
    {
        if (empty($data)) {
            return '';
        }
        $name = explode('/', $data);
        return $name[array_key_last($name)];
    }
}
if (!function_exists('vimeoVideoEmbed')) {
    function vimeoVideoEmbed($video_uri, $title, $height, $width)
    {
        // return '<iframe class="video_iframe" src="https://player.vimeo.com/video/'.showPicName($video_uri).'?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id='.env("VIMEO_APP_ID").'" width="'.$width.'" height="'.$height.'" frameborder="0" allow="autoplay; fullscreen" allowfullscreen title="LMS Basic"></iframe>';
        return '<iframe class="video_iframe" src="https://player.vimeo.com/video/' . showPicName($video_uri) . '?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=' . saasEnv("VIMEO_APP_ID") . '"  frameborder="0" allow="autoplay; fullscreen" allowfullscreen title="LMS Basic"></iframe>';
    }
}


if (!function_exists('getSetting')) {
    function getSetting()
    {
        try {
            return app('getSetting');

        } catch (Exception $exception) {
            return false;
        }
    }
}
if (!function_exists('getVideoId')) {
    function getVideoId($v_id)
    {
        $video_id = explode("=", $v_id);
        return $video_id[array_key_last($video_id)];
    }
}
if (!function_exists('youtubeVideo')) {
    function youtubeVideo($video_url)
    {
        if (Str::contains($video_url, 'youtu.be')) {

            $url = explode("/", $video_url);
            return 'https://www.youtube.com/watch?v=' . $url[3];
        }

        if (Str::contains($video_url, '&')) {
            return substr($video_url, 0, strpos($video_url, "&"));
        } else {
            return $video_url;
        }


    }
}


if (!function_exists('isBookmarked')) {
    function isBookmarked($user_id, $course_id)
    {
        $bookmarked = BookmarkCourse::where('user_id', $user_id)->where('course_id', $course_id)->first();
        if ($bookmarked) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('cartItem')) {
    function cartItem()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::user()->id)->when(isModuleActive('Appointment'), function ($query) {
                $query->whereNotNull('course_id');
            })->count();
        } else if (session()->get('cart')) {
            return count(session()->get('cart'));
        } else {
            return 0;
        }
    }
}

if (!function_exists('totalWhiteList')) {
    function totalWhiteList()
    {
        if (Auth::check()) {
            $bookmarks = BookmarkCourse::where('user_id', Auth::id())->count();
            return $bookmarks;
        } else {
            return 0;
        }
    }
}


function send_php_mail($receiver_email, $receiver_name, $sender_email, $subject, $message)
{
    $headers = "From: <$sender_email> \r\n";
    $headers .= "Reply-To: " . Settings('site_title') . " <$sender_email> \r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    return mail($receiver_email, $subject, $message, $headers);

}


if (!function_exists('checkCurrency')) {
    function checkCurrency($currency_code)
    {
        $currency = Currency::where('code', $currency_code)->first();
        if ($currency != null) {
            return true;
        }
        return null;
    }
}


if (!function_exists('showStatus')) {
    function showStatus($status)
    {
        if ($status == 1) {
            return 'Active';
        }
        return 'Inactive';
    }
}


if (!function_exists('permissionCheck')) {
    function permissionCheck($route_name)
    {
        if (auth()->check()) {
            if (auth()->user()->role_id == 1) {
                return TRUE;
            } else {

                if (isModuleActive('OrgInstructorPolicy')) {
                    if (auth()->user()->role_id == 2) {
                        $roles = app('policy_permission_list');
                        $role = $roles->where('id', auth()->user()->policy_id)->first();
                    } else {
                        $roles = app('permission_list');
                        $role = $roles->where('id', auth()->user()->role_id)->first();

                    }
                    if ($role != null && $role->permissions->contains('route', $route_name)) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                } else {
                    $roles = app('permission_list');
                    $role = $roles->where('id', auth()->user()->role_id)->first();
                    if ($role != null && $role->permissions->contains('route', $route_name)) {
                        return TRUE;
                    } else {
                        return FALSE;
                    }
                }

            }
        }
        return FALSE;
    }
}

//formats price to home default price with convertion
if (!function_exists('single_price')) {
    function single_price($price)
    {
        return getPriceFormat($price);
    }
}


//Messages
if (!function_exists('getConversations')) {
    function getConversations($messages)
    {
        $output = '';
        if ($messages) {
            foreach ($messages as $key => $message) {
                if ($message->sender_id == Auth::id()) {
                    $output .= '
                            <div class="single_message_chat">
                                <div class="message_pre_left">
                                    <div class="message_preview_thumb">
                                        <img src="' . getProfileImage(@$message->sender->image) . '" alt="">
                                    </div>
                                    <div class="messges_info">
                                        <h4>' . @$message->sender->name . '</h4>
                                        <p>' . @$message->created_at . '</p>
                                    </div>
                                </div>
                                <div class="message_content_view red_border">
                                    <p>' . @$message->message . '</p>
                                </div>
                            </div>';
                } else {
                    $output .= '
                        <div class="single_message_chat sender_message">
                            <div class="message_pre_left">
                                <div class="messges_info">
                                <h4>' . @$message->sender->name . '</h4>
                                <p>' . @$message->created_at . '</p>
                                </div>
                                <div class="message_preview_thumb">
                                <img src="' . getProfileImage(@$message->sender->image) . '" alt="">
                                </div>
                            </div>
                            <div class="message_content_view">
                                <p>' . @$message->message . '</p>
                            </div>
                        </div>';
                }
            }
            return $output;
        } else {
            $message = trans("communication.Let's say Hi");
            $output = '<p class="NoMessageFound">' . $message . '!</p>';
        }
        return $output;

    }
}


// checking module enable/disable
if (!function_exists('checkModuleEnable')) {
    function checkModuleEnable($module = null, $name = null)
    {
        if ($name) {
            return true;
        } else {
            return false;
        }

    }
}


if (!function_exists('getHeaderCategories')) {
    function getHeaderCategories()
    {
        return Category::with('subcategories')->where('status', 1)->orderBy('position_order', 'ASC')->get();
    }
}


if (!function_exists('returnList')) {
    function returnList()
    {

        //version 5
        $list = [
            "fab fa-500px",
            "fab fa-accessible-icon",
            "fab fa-accusoft",
            "fas fa-address-book",
            "far fa-address-book",
            "fas fa-address-card",
            "far fa-address-card",
            "fas fa-adjust",
            "fab fa-adn",
            "fab fa-adversal",
            "fab fa-affiliatetheme",
            "fab fa-algolia",
            "fas fa-align-center",
            "fas fa-align-justify",
            "fas fa-align-left",
            "fas fa-align-right",
            "fab fa-amazon",
            "fas fa-ambulance",
            "fas fa-american-sign-language-interpreting",
            "fab fa-amilia",
            "fas fa-anchor",
            "fab fa-android",
            "fab fa-angellist",
            "fas fa-angle-double-down",
            "fas fa-angle-double-left",
            "fas fa-angle-double-right",
            "fas fa-angle-double-up",
            "fas fa-angle-down",
            "fas fa-angle-left",
            "fas fa-angle-right",
            "fas fa-angle-up",
            "fab fa-angrycreative",
            "fab fa-angular",
            "fab fa-app-store",
            "fab fa-app-store-ios",
            "fab fa-apper",
            "fab fa-apple",
            "fab fa-apple-pay",
            "fas fa-archive",
            "fas fa-arrow-alt-circle-down",
            "far fa-arrow-alt-circle-down",
            "fas fa-arrow-alt-circle-left",
            "far fa-arrow-alt-circle-left",
            "fas fa-arrow-alt-circle-right",
            "far fa-arrow-alt-circle-right",
            "fas fa-arrow-alt-circle-up",
            "far fa-arrow-alt-circle-up",
            "fas fa-arrow-circle-down",
            "fas fa-arrow-circle-left",
            "fas fa-arrow-circle-right",
            "fas fa-arrow-circle-up",
            "fas fa-arrow-down",
            "fas fa-arrow-left",
            "fas fa-arrow-right",
            "fas fa-arrow-up",
            "fas fa-arrows-alt",
            "fas fa-arrows-alt-h",
            "fas fa-arrows-alt-v",
            "fas fa-assistive-listening-systems",
            "fas fa-asterisk",
            "fab fa-asymmetrik",
            "fas fa-at",
            "fab fa-audible",
            "fas fa-audio-description",
            "fab fa-autoprefixer",
            "fab fa-avianex",
            "fab fa-aviato",
            "fab fa-aws",
            "fas fa-backward",
            "fas fa-balance-scale",
            "fas fa-ban",
            "fab fa-bandcamp",
            "fas fa-barcode",
            "fas fa-bars",
            "fas fa-bath",
            "fas fa-battery-empty",
            "fas fa-battery-full",
            "fas fa-battery-half",
            "fas fa-battery-quarter",
            "fas fa-battery-three-quarters",
            "fas fa-bed",
            "fas fa-beer",
            "fab fa-behance",
            "fab fa-behance-square",
            "fas fa-bell",
            "far fa-bell",
            "fas fa-bell-slash",
            "far fa-bell-slash",
            "fas fa-bicycle",
            "fab fa-bimobject",
            "fas fa-binoculars",
            "fas fa-birthday-cake",
            "fab fa-bitbucket",
            "fab fa-bitcoin",
            "fab fa-bity",
            "fab fa-black-tie",
            "fab fa-blackberry",
            "fas fa-blind",
            "fab fa-blogger",
            "fab fa-blogger-b",
            "fab fa-bluetooth",
            "fab fa-bluetooth-b",
            "fas fa-bold",
            "fas fa-bolt",
            "fas fa-bomb",
            "fas fa-book",
            "fas fa-bookmark",
            "far fa-bookmark",
            "fas fa-braille",
            "fas fa-briefcase",
            "fab fa-btc",
            "fas fa-bug",
            "fas fa-building",
            "far fa-building",
            "fas fa-bullhorn",
            "fas fa-bullseye",
            "fab fa-buromobelexperte",
            "fas fa-bus",
            "fab fa-buysellads",
            "fas fa-calculator",
            "fas fa-calendar",
            "far fa-calendar",
            "fas fa-calendar-alt",
            "far fa-calendar-alt",
            "fas fa-calendar-check",
            "far fa-calendar-check",
            "fas fa-calendar-minus",
            "far fa-calendar-minus",
            "fas fa-calendar-plus",
            "far fa-calendar-plus",
            "fas fa-calendar-times",
            "far fa-calendar-times",
            "fas fa-camera",
            "fas fa-camera-retro",
            "fas fa-car",
            "fas fa-caret-down",
            "fas fa-caret-left",
            "fas fa-caret-right",
            "fas fa-caret-square-down",
            "far fa-caret-square-down",
            "fas fa-caret-square-left",
            "far fa-caret-square-left",
            "fas fa-caret-square-right",
            "far fa-caret-square-right",
            "fas fa-caret-square-up",
            "far fa-caret-square-up",
            "fas fa-caret-up",
            "fas fa-cart-arrow-down",
            "fas fa-cart-plus",
            "fab fa-cc-amex",
            "fab fa-cc-apple-pay",
            "fab fa-cc-diners-club",
            "fab fa-cc-discover",
            "fab fa-cc-jcb",
            "fab fa-cc-mastercard",
            "fab fa-cc-paypal",
            "fab fa-cc-stripe",
            "fab fa-cc-visa",
            "fab fa-centercode",
            "fas fa-certificate",
            "fas fa-chart-area",
            "fas fa-chart-bar",
            "far fa-chart-bar",
            "fas fa-chart-line",
            "fas fa-chart-pie",
            "fas fa-check",
            "fas fa-check-circle",
            "far fa-check-circle",
            "fas fa-check-square",
            "far fa-check-square",
            "fas fa-chevron-circle-down",
            "fas fa-chevron-circle-left",
            "fas fa-chevron-circle-right",
            "fas fa-chevron-circle-up",
            "fas fa-chevron-down",
            "fas fa-chevron-left",
            "fas fa-chevron-right",
            "fas fa-chevron-up",
            "fas fa-child",
            "fab fa-chrome",
            "fas fa-circle",
            "far fa-circle",
            "fas fa-circle-notch",
            "fas fa-clipboard",
            "far fa-clipboard",
            "fas fa-clock",
            "far fa-clock",
            "fas fa-clone",
            "far fa-clone",
            "fas fa-closed-captioning",
            "far fa-closed-captioning",
            "fas fa-cloud",
            "fas fa-cloud-download-alt",
            "fas fa-cloud-upload-alt",
            "fab fa-cloudscale",
            "fab fa-cloudsmith",
            "fab fa-cloudversify",
            "fas fa-code",
            "fas fa-code-branch",
            "fab fa-codepen",
            "fab fa-codiepie",
            "fas fa-coffee",
            "fas fa-cog",
            "fas fa-cogs",
            "fas fa-columns",
            "fas fa-comment",
            "far fa-comment",
            "fas fa-comment-alt",
            "far fa-comment-alt",
            "fas fa-comments",
            "far fa-comments",
            "fas fa-compass",
            "far fa-compass",
            "fas fa-compress",
            "fab fa-connectdevelop",
            "fab fa-contao",
            "fas fa-copy",
            "far fa-copy",
            "fas fa-copyright",
            "far fa-copyright",
            "fab fa-cpanel",
            "fab fa-creative-commons",
            "fas fa-credit-card",
            "far fa-credit-card",
            "fas fa-crop",
            "fas fa-crosshairs",
            "fab fa-css3",
            "fab fa-css3-alt",
            "fas fa-cube",
            "fas fa-cubes",
            "fas fa-cut",
            "fab fa-cuttlefish",
            "fab fa-d-and-d",
            "fab fa-dashcube",
            "fas fa-database",
            "fas fa-deaf",
            "fab fa-delicious",
            "fab fa-deploydog",
            "fab fa-deskpro",
            "fas fa-desktop",
            "fab fa-deviantart",
            "fab fa-digg",
            "fab fa-digital-ocean",
            "fab fa-discord",
            "fab fa-discourse",
            "fab fa-dochub",
            "fab fa-docker",
            "fas fa-dollar-sign",
            "fas fa-dot-circle",
            "far fa-dot-circle",
            "fas fa-download",
            "fab fa-draft2digital",
            "fab fa-dribbble",
            "fab fa-dribbble-square",
            "fab fa-dropbox",
            "fab fa-drupal",
            "fab fa-dyalog",
            "fab fa-earlybirds",
            "fab fa-edge",
            "fas fa-edit",
            "far fa-edit",
            "fas fa-eject",
            "fas fa-ellipsis-h",
            "fas fa-ellipsis-v",
            "fab fa-ember",
            "fab fa-empire",
            "fas fa-envelope",
            "far fa-envelope",
            "fas fa-envelope-open",
            "far fa-envelope-open",
            "fas fa-envelope-square",
            "fab fa-envira",
            "fas fa-eraser",
            "fab fa-erlang",
            "fab fa-etsy",
            "fas fa-euro-sign",
            "fas fa-exchange-alt",
            "fas fa-exclamation",
            "fas fa-exclamation-circle",
            "fas fa-exclamation-triangle",
            "fas fa-expand",
            "fas fa-expand-arrows-alt",
            "fab fa-expeditedssl",
            "fas fa-external-link-alt",
            "fas fa-external-link-square-alt",
            "fas fa-eye",
            "fas fa-eye-dropper",
            "fas fa-eye-slash",
            "far fa-eye-slash",
            "fab fa-facebook",
            "fab fa-facebook-f",
            "fab fa-facebook-messenger",
            "fab fa-facebook-square",
            "fas fa-fast-backward",
            "fas fa-fast-forward",
            "fas fa-fax",
            "fas fa-female",
            "fas fa-fighter-jet",
            "fas fa-file",
            "far fa-file",
            "fas fa-file-alt",
            "far fa-file-alt",
            "fas fa-file-archive",
            "far fa-file-archive",
            "fas fa-file-audio",
            "far fa-file-audio",
            "fas fa-file-code",
            "far fa-file-code",
            "fas fa-file-excel",
            "far fa-file-excel",
            "fas fa-file-image",
            "far fa-file-image",
            "fas fa-file-pdf",
            "far fa-file-pdf",
            "fas fa-file-powerpoint",
            "far fa-file-powerpoint",
            "fas fa-file-video",
            "far fa-file-video",
            "fas fa-file-word",
            "far fa-file-word",
            "fas fa-film",
            "fas fa-filter",
            "fas fa-fire",
            "fas fa-fire-extinguisher",
            "fab fa-firefox",
            "fab fa-first-order",
            "fab fa-firstdraft",
            "fas fa-flag",
            "far fa-flag",
            "fas fa-flag-checkered",
            "fas fa-flask",
            "fab fa-flickr",
            "fab fa-fly",
            "fas fa-folder",
            "far fa-folder",
            "fas fa-folder-open",
            "far fa-folder-open",
            "fas fa-font",
            "fab fa-font-awesome",
            "fab fa-font-awesome-alt",
            "fab fa-font-awesome-flag",
            "fab fa-fonticons",
            "fab fa-fonticons-fi",
            "fab fa-fort-awesome",
            "fab fa-fort-awesome-alt",
            "fab fa-forumbee",
            "fas fa-forward",
            "fab fa-foursquare",
            "fab fa-free-code-camp",
            "fab fa-freebsd",
            "fas fa-frown",
            "far fa-frown",
            "fas fa-futbol",
            "far fa-futbol",
            "fas fa-gamepad",
            "fas fa-gavel",
            "fas fa-gem",
            "far fa-gem",
            "fas fa-genderless",
            "fab fa-get-pocket",
            "fab fa-gg",
            "fab fa-gg-circle",
            "fas fa-gift",
            "fab fa-git",
            "fab fa-git-square",
            "fab fa-github",
            "fab fa-github-alt",
            "fab fa-github-square",
            "fab fa-gitkraken",
            "fab fa-gitlab",
            "fab fa-gitter",
            "fas fa-glass-martini",
            "fab fa-glide",
            "fab fa-glide-g",
            "fas fa-globe",
            "fab fa-gofore",
            "fab fa-goodreads",
            "fab fa-goodreads-g",
            "fab fa-google",
            "fab fa-google-drive",
            "fab fa-google-play",
            "fab fa-google-plus",
            "fab fa-google-plus-g",
            "fab fa-google-plus-square",
            "fab fa-google-wallet",
            "fas fa-graduation-cap",
            "fab fa-gratipay",
            "fab fa-grav",
            "fab fa-gripfire",
            "fab fa-grunt",
            "fab fa-gulp",
            "fas fa-h-square",
            "fab fa-hacker-news",
            "fab fa-hacker-news-square",
            "fas fa-hand-lizard",
            "far fa-hand-lizard",
            "fas fa-hand-paper",
            "far fa-hand-paper",
            "fas fa-hand-peace",
            "far fa-hand-peace",
            "fas fa-hand-point-down",
            "far fa-hand-point-down",
            "fas fa-hand-point-left",
            "far fa-hand-point-left",
            "fas fa-hand-point-right",
            "far fa-hand-point-right",
            "fas fa-hand-point-up",
            "far fa-hand-point-up",
            "fas fa-hand-pointer",
            "far fa-hand-pointer",
            "fas fa-hand-rock",
            "far fa-hand-rock",
            "fas fa-hand-scissors",
            "far fa-hand-scissors",
            "fas fa-hand-spock",
            "far fa-hand-spock",
            "fas fa-handshake",
            "far fa-handshake",
            "fas fa-hashtag",
            "fas fa-hdd",
            "far fa-hdd",
            "fas fa-heading",
            "fas fa-headphones",
            "fas fa-heart",
            "far fa-heart",
            "fas fa-heartbeat",
            "fab fa-hire-a-helper",
            "fas fa-history",
            "fas fa-home",
            "fab fa-hooli",
            "fas fa-hospital",
            "far fa-hospital",
            "fab fa-hotjar",
            "fas fa-hourglass",
            "far fa-hourglass",
            "fas fa-hourglass-end",
            "fas fa-hourglass-half",
            "fas fa-hourglass-start",
            "fab fa-houzz",
            "fab fa-html5",
            "fab fa-hubspot",
            "fas fa-i-cursor",
            "fas fa-id-badge",
            "far fa-id-badge",
            "fas fa-id-card",
            "far fa-id-card",
            "fas fa-image",
            "far fa-image",
            "fas fa-images",
            "far fa-images",
            "fab fa-imdb",
            "fas fa-inbox",
            "fas fa-indent",
            "fas fa-industry",
            "fas fa-info",
            "fas fa-info-circle",
            "fab fa-instagram",
            "fab fa-internet-explorer",
            "fab fa-ioxhost",
            "fas fa-italic",
            "fab fa-itunes",
            "fab fa-itunes-note",
            "fab fa-jenkins",
            "fab fa-joget",
            "fab fa-joomla",
            "fab fa-js",
            "fab fa-js-square",
            "fab fa-jsfiddle",
            "fas fa-key",
            "fas fa-keyboard",
            "far fa-keyboard",
            "fab fa-keycdn",
            "fab fa-kickstarter",
            "fab fa-kickstarter-k",
            "fas fa-language",
            "fas fa-laptop",
            "fab fa-laravel",
            "fab fa-lastfm",
            "fab fa-lastfm-square",
            "fas fa-leaf",
            "fab fa-leanpub",
            "fas fa-lemon",
            "far fa-lemon",
            "fab fa-less",
            "fas fa-level-down-alt",
            "fas fa-level-up-alt",
            "fas fa-life-ring",
            "far fa-life-ring",
            "fas fa-lightbulb",
            "far fa-lightbulb",
            "fab fa-line",
            "fas fa-link",
            "fab fa-linkedin",
            "fab fa-linkedin-in",
            "fab fa-linode",
            "fab fa-linux",
            "fas fa-lira-sign",
            "fas fa-list",
            "fas fa-list-alt",
            "far fa-list-alt",
            "fas fa-list-ol",
            "fas fa-list-ul",
            "fas fa-location-arrow",
            "fas fa-lock",
            "fas fa-lock-open",
            "fas fa-long-arrow-alt-down",
            "fas fa-long-arrow-alt-left",
            "fas fa-long-arrow-alt-right",
            "fas fa-long-arrow-alt-up",
            "fas fa-low-vision",
            "fab fa-lyft",
            "fab fa-magento",
            "fas fa-magic",
            "fas fa-magnet",
            "fas fa-male",
            "fas fa-map",
            "far fa-map",
            "fas fa-map-marker",
            "fas fa-map-marker-alt",
            "fas fa-map-pin",
            "fas fa-map-signs",
            "fas fa-mars",
            "fas fa-mars-double",
            "fas fa-mars-stroke",
            "fas fa-mars-stroke-h",
            "fas fa-mars-stroke-v",
            "fab fa-maxcdn",
            "fab fa-medapps",
            "fab fa-medium",
            "fab fa-medium-m",
            "fas fa-medkit",
            "fab fa-medrt",
            "fab fa-meetup",
            "fas fa-meh",
            "far fa-meh",
            "fas fa-mercury",
            "fas fa-microchip",
            "fas fa-microphone",
            "fas fa-microphone-slash",
            "fab fa-microsoft",
            "fas fa-minus",
            "fas fa-minus-circle",
            "fas fa-minus-square",
            "far fa-minus-square",
            "fab fa-mix",
            "fab fa-mixcloud",
            "fab fa-mizuni",
            "fas fa-mobile",
            "fas fa-mobile-alt",
            "fab fa-modx",
            "fab fa-monero",
            "fas fa-money-bill-alt",
            "far fa-money-bill-alt",
            "fas fa-moon",
            "far fa-moon",
            "fas fa-motorcycle",
            "fas fa-mouse-pointer",
            "fas fa-music",
            "fab fa-napster",
            "fas fa-neuter",
            "fas fa-newspaper",
            "far fa-newspaper",
            "fab fa-nintendo-switch",
            "fab fa-node",
            "fab fa-node-js",
            "fab fa-npm",
            "fab fa-ns8",
            "fab fa-nutritionix",
            "fas fa-object-group",
            "far fa-object-group",
            "fas fa-object-ungroup",
            "far fa-object-ungroup",
            "fab fa-odnoklassniki",
            "fab fa-odnoklassniki-square",
            "fab fa-opencart",
            "fab fa-openid",
            "fab fa-opera",
            "fab fa-optin-monster",
            "fab fa-osi",
            "fas fa-outdent",
            "fab fa-page4",
            "fab fa-pagelines",
            "fas fa-paint-brush",
            "fab fa-palfed",
            "fas fa-paper-plane",
            "far fa-paper-plane",
            "fas fa-paperclip",
            "fas fa-paragraph",
            "fas fa-paste",
            "fab fa-patreon",
            "fas fa-pause",
            "fas fa-pause-circle",
            "far fa-pause-circle",
            "fas fa-paw",
            "fab fa-paypal",
            "fas fa-pen-square",
            "fas fa-pencil-alt",
            "fas fa-percent",
            "fab fa-periscope",
            "fab fa-phabricator",
            "fab fa-phoenix-framework",
            "fas fa-phone",
            "fas fa-phone-square",
            "fas fa-phone-volume",
            "fab fa-pied-piper",
            "fab fa-pied-piper-alt",
            "fab fa-pied-piper-pp",
            "fab fa-pinterest",
            "fab fa-pinterest-p",
            "fab fa-pinterest-square",
            "fas fa-plane",
            "fas fa-play",
            "fas fa-play-circle",
            "far fa-play-circle",
            "fab fa-playstation",
            "fas fa-plug",
            "fas fa-plus",
            "fas fa-plus-circle",
            "fas fa-plus-square",
            "far fa-plus-square",
            "fas fa-podcast",
            "fas fa-pound-sign",
            "fas fa-power-off",
            "fas fa-print",
            "fab fa-product-hunt",
            "fab fa-pushed",
            "fas fa-puzzle-piece",
            "fab fa-python",
            "fab fa-qq",
            "fas fa-qrcode",
            "fas fa-question",
            "fas fa-question-circle",
            "far fa-question-circle",
            "fab fa-quora",
            "fas fa-quote-left",
            "fas fa-quote-right",
            "fas fa-random",
            "fab fa-ravelry",
            "fab fa-react",
            "fab fa-rebel",
            "fas fa-recycle",
            "fab fa-red-river",
            "fab fa-reddit",
            "fab fa-reddit-alien",
            "fab fa-reddit-square",
            "fas fa-redo",
            "fas fa-redo-alt",
            "fas fa-registered",
            "far fa-registered",
            "fab fa-rendact",
            "fab fa-renren",
            "fas fa-reply",
            "fas fa-reply-all",
            "fab fa-replyd",
            "fab fa-resolving",
            "fas fa-retweet",
            "fas fa-road",
            "fas fa-rocket",
            "fab fa-rocketchat",
            "fab fa-rockrms",
            "fas fa-rss",
            "fas fa-rss-square",
            "fas fa-ruble-sign",
            "fas fa-rupee-sign",
            "fab fa-safari",
            "fab fa-sass",
            "fas fa-save",
            "far fa-save",
            "fab fa-schlix",
            "fab fa-scribd",
            "fas fa-search",
            "fas fa-search-minus",
            "fas fa-search-plus",
            "fab fa-searchengin",
            "fab fa-sellcast",
            "fab fa-sellsy",
            "fas fa-server",
            "fab fa-servicestack",
            "fas fa-share",
            "fas fa-share-alt",
            "fas fa-share-alt-square",
            "fas fa-share-square",
            "far fa-share-square",
            "fas fa-shekel-sign",
            "fas fa-shield-alt",
            "fas fa-ship",
            "fab fa-shirtsinbulk",
            "fas fa-shopping-bag",
            "fas fa-shopping-basket",
            "fas fa-shopping-cart",
            "fas fa-shower",
            "fas fa-sign-in-alt",
            "fas fa-sign-language",
            "fas fa-sign-out-alt",
            "fas fa-signal",
            "fab fa-simplybuilt",
            "fab fa-sistrix",
            "fas fa-sitemap",
            "fab fa-skyatlas",
            "fab fa-skype",
            "fab fa-slack",
            "fab fa-slack-hash",
            "fas fa-sliders-h",
            "fab fa-slideshare",
            "fas fa-smile",
            "far fa-smile",
            "fab fa-snapchat",
            "fab fa-snapchat-ghost",
            "fab fa-snapchat-square",
            "fas fa-snowflake",
            "far fa-snowflake",
            "fas fa-sort",
            "fas fa-sort-alpha-down",
            "fas fa-sort-alpha-up",
            "fas fa-sort-amount-down",
            "fas fa-sort-amount-up",
            "fas fa-sort-down",
            "fas fa-sort-numeric-down",
            "fas fa-sort-numeric-up",
            "fas fa-sort-up",
            "fab fa-soundcloud",
            "fas fa-space-shuttle",
            "fab fa-speakap",
            "fas fa-spinner",
            "fab fa-spotify",
            "fas fa-square",
            "far fa-square",
            "fab fa-stack-exchange",
            "fab fa-stack-overflow",
            "fas fa-star",
            "far fa-star",
            "fas fa-star-half",
            "far fa-star-half",
            "fab fa-staylinked",
            "fab fa-steam",
            "fab fa-steam-square",
            "fab fa-steam-symbol",
            "fas fa-step-backward",
            "fas fa-step-forward",
            "fas fa-stethoscope",
            "fab fa-sticker-mule",
            "fas fa-sticky-note",
            "far fa-sticky-note",
            "fas fa-stop",
            "fas fa-stop-circle",
            "far fa-stop-circle",
            "fab fa-strava",
            "fas fa-street-view",
            "fas fa-strikethrough",
            "fab fa-stripe",
            "fab fa-stripe-s",
            "fab fa-studiovinari",
            "fab fa-stumbleupon",
            "fab fa-stumbleupon-circle",
            "fas fa-subscript",
            "fas fa-subway",
            "fas fa-suitcase",
            "fas fa-sun",
            "far fa-sun",
            "fab fa-superpowers",
            "fas fa-superscript",
            "fab fa-supple",
            "fas fa-sync",
            "fas fa-sync-alt",
            "fas fa-table",
            "fas fa-tablet",
            "fas fa-tablet-alt",
            "fas fa-tachometer-alt",
            "fas fa-tag",
            "fas fa-tags",
            "fas fa-tasks",
            "fas fa-taxi",
            "fab fa-telegram",
            "fab fa-telegram-plane",
            "fab fa-tencent-weibo",
            "fas fa-terminal",
            "fas fa-text-height",
            "fas fa-text-width",
            "fas fa-th",
            "fas fa-th-large",
            "fas fa-th-list",
            "fab fa-themeisle",
            "fas fa-thermometer-empty",
            "fas fa-thermometer-full",
            "fas fa-thermometer-half",
            "fas fa-thermometer-quarter",
            "fas fa-thermometer-three-quarters",
            "fas fa-thumbs-down",
            "far fa-thumbs-down",
            "fas fa-thumbs-up",
            "far fa-thumbs-up",
            "fas fa-thumbtack",
            "fas fa-ticket-alt",
            "fas fa-times",
            "fas fa-times-circle",
            "far fa-times-circle",
            "fas fa-tint",
            "fas fa-toggle-off",
            "fas fa-toggle-on",
            "fas fa-trademark",
            "fas fa-train",
            "fas fa-transgender",
            "fas fa-transgender-alt",
            "fas fa-trash",
            "fas fa-trash-alt",
            "far fa-trash-alt",
            "fas fa-tree",
            "fab fa-trello",
            "fab fa-tripadvisor",
            "fas fa-trophy",
            "fas fa-truck",
            "fas fa-tty",
            "fab fa-tumblr",
            "fab fa-tumblr-square",
            "fas fa-tv",
            "fab fa-twitch",
            "fab fa-twitter",
            "fab fa-twitter-square",
            "fab fa-typo3",
            "fab fa-uber",
            "fab fa-uikit",
            "fas fa-umbrella",
            "fas fa-underline",
            "fas fa-undo",
            "fas fa-undo-alt",
            "fab fa-uniregistry",
            "fas fa-universal-access",
            "fas fa-university",
            "fas fa-unlink",
            "fas fa-unlock",
            "fas fa-unlock-alt",
            "fab fa-untappd",
            "fas fa-upload",
            "fab fa-usb",
            "fas fa-user",
            "far fa-user",
            "fas fa-user-circle",
            "far fa-user-circle",
            "fas fa-user-md",
            "fas fa-user-plus",
            "fas fa-user-secret",
            "fas fa-user-times",
            "fas fa-users",
            "fab fa-ussunnah",
            "fas fa-utensil-spoon",
            "fas fa-utensils",
            "fab fa-vaadin",
            "fas fa-venus",
            "fas fa-venus-double",
            "fas fa-venus-mars",
            "fab fa-viacoin",
            "fab fa-viadeo",
            "fab fa-viadeo-square",
            "fab fa-viber",
            "fas fa-video",
            "fab fa-vimeo",
            "fab fa-vimeo-square",
            "fab fa-vimeo-v",
            "fab fa-vine",
            "fab fa-vk",
            "fab fa-vnv",
            "fas fa-volume-down",
            "fas fa-volume-off",
            "fas fa-volume-up",
            "fab fa-vuejs",
            "fab fa-weibo",
            "fab fa-weixin",
            "fab fa-whatsapp",
            "fab fa-whatsapp-square",
            "fas fa-wheelchair",
            "fab fa-whmcs",
            "fas fa-wifi",
            "fab fa-wikipedia-w",
            "fas fa-window-close",
            "far fa-window-close",
            "fas fa-window-maximize",
            "far fa-window-maximize",
            "fas fa-window-minimize",
            "fas fa-window-restore",
            "far fa-window-restore",
            "fab fa-windows",
            "fas fa-won-sign",
            "fab fa-wordpress",
            "fab fa-wordpress-simple",
            "fab fa-wpbeginner",
            "fab fa-wpexplorer",
            "fab fa-wpforms",
            "fas fa-wrench",
            "fab fa-xbox",
            "fab fa-xing",
            "fab fa-xing-square",
            "fab fa-y-combinator",
            "fab fa-yahoo",
            "fab fa-yandex",
            "fab fa-yandex-international",
            "fab fa-yelp",
            "fas fa-yen-sign",
            "fab fa-yoast",
            "fab fa-youtube"
        ];
        $str = '';
        foreach ($list as $class) {
            $name = explode("-", $class);
            $name1 = explode($name[0] . '-', $class);
            $str .= '<option value="' . $class . '"><i class="' . $class . '"></i> ' . $name1[1] . ' </option>';
        }

        return $str;
    }
}


if (!function_exists('socialIconList')) {
    function socialIconList()
    {
        $list = [
            'fa-facebook',
            'fa-twitter',
            'fa-linkedin',
            'fa-instagram',
            'fa-dribbble',
            'fa-google-plus',
            'fa-youtube',
            'fa-vimeo',
            'fa-reddit',

        ];
        $str = '';
        foreach ($list as $class) {
            $str .= '<option value="fab ' . $class . '"><i class="fa ' . $class . '"></i> ' . $class . ' </option>';
        }
        return $str;
    }
}


if (!function_exists('getProfileImage')) {
    function getProfileImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset('public/assets/profile/no_image_available.png');
        }
    }
}

if (!function_exists('getCourseImage')) {
    function getCourseImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset('public/assets/course/no_image.png');
        }
    }
}


if (!function_exists('getLogoImage')) {
    function getLogoImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset('public/uploads/settings/logo.png');
        }
    }
}


if (!function_exists('getTestimonialImage')) {
    function getTestimonialImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset('public/demo/testimonial/thumb/img.png');
        }
    }
}
if (!function_exists('getInstructorImage')) {
    function getInstructorImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset('public/demo/user/instructor.jpg');
        }
    }
}

if (!function_exists('getStudentImage')) {
    function getStudentImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset('public/demo/user/student.png');
        }
    }
}
if (!function_exists('getBlogImage')) {
    function getBlogImage($path)
    {
        if (File::exists($path)) {
            return asset($path);
        } else {
            return asset('public/demo/blog/no-image.jpg');
        }
    }
}
if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
}

if (!function_exists('isInstructor')) {
    function isInstructor()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 2) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


if (!function_exists('isStudent')) {
    function isStudent()
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 3) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('isFree')) {
    function isFree($course_id)
    {
        $course = Course::find($course_id);
        if ($course) {
            if ($course->price == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


if (!function_exists('totalUnreadMessages')) {
    function totalUnreadMessages()
    {
        return \Modules\SystemSetting\Entities\Message::where('seen', '=', 0)->where('reciever_id', '=', Auth::id())->count();
    }
}


if (!function_exists('getLanguageList')) {
    function getLanguageList()
    {
        if (isModuleActive('LmsSaas')) {
            $domain = SaasDomain();
        } else {
            $domain = 'main';
        }
        return Cache::rememberForever('LanguageList_' . $domain, function () {
            return DB::table('languages')
                ->where('status', 1)
                ->select('code', 'name', 'native')
                ->where('lms_id', SaasInstitute()->id)
                ->get();
        });
    }
}


if (!function_exists('putEnvConfigration')) {
    function putEnvConfigration($envKey, $envValue)
    {
        $envValue = str_replace('\\', '\\' . '\\', $envValue);
        $value = '"' . $envValue . '"';
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $str .= "\n";
        $keyPosition = strpos($str, "{$envKey}=");


        if (is_bool($keyPosition)) {

            $str .= $envKey . '="' . $envValue . '"';

        } else {
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
            $str = str_replace($oldLine, "{$envKey}={$value}", $str);

            $str = substr($str, 0, -1);
        }

        if (!file_put_contents($envFile, $str)) {
            return false;
        } else {
            return true;
        }

    }
}


if (!function_exists('courseDetailsUrl')) {
    function courseDetailsUrl($id, $type, $slug)
    {
        if ($type == 1) {
            $details = 'courses-details';
        } elseif ($type == 2) {
            $details = 'quiz-details';
        } elseif ($type == 3) {
            $details = 'class-details';
        } else {
            $details = 'courses-details';
        }
        return url($details . '/' . $slug);
    }
}
if (!function_exists('UserEmailNotificationSetup')) {
    function UserEmailNotificationSetup($act, $user)
    {

        $role_email_template = RoleEmailTemplate::where('role_id', $user->role_id)->where('template_act', $act)->where('status', 1)->first();
        if ($role_email_template) {
            $user_notification_setup = UserNotificationSetup::where('user_id', $user->id)->first();
            if ($user_notification_setup) {
                $email_ids = explode(',', $user_notification_setup->email_ids);

                if (in_array($act, $email_ids)) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return true;
            }
        }
    }
}
if (!function_exists('UserBrowserNotificationSetup')) {
    function UserBrowserNotificationSetup($act, $user)
    {

        $role_email_template = RoleEmailTemplate::where('role_id', $user->role_id)->where('template_act', $act)->where('status', 1)->first();

        if ($role_email_template) {
            $user_notification_setup = UserNotificationSetup::where('user_id', $user->id)->first();

            if ($user_notification_setup) {
                $browser_ids = explode(',', $user_notification_setup->browser_ids);

                if (in_array($act, $browser_ids)) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return true;
            }
        }
    }
}

if (!function_exists('UserMobileNotificationSetup')) {
    function UserMobileNotificationSetup($act, $user)
    {

        $role_email_template = RoleEmailTemplate::where('role_id', $user->role_id)->where('template_act', $act)->where('status', 1)->first();

        if ($role_email_template) {
            $user_notification_setup = UserNotificationSetup::where('user_id', $user->id)->first();

            if ($user_notification_setup) {
                $mobile_ids = explode(',', $user_notification_setup->mobile_ids);

                if (in_array($act, $mobile_ids)) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return true;
            }
        }
    }
}
if (!function_exists('send_browser_notification')) {

    function send_browser_notification($user, $type, $shortcodes = [], $actionText = '', $actionURL = '', $notificationType = null, $id = null)
    {
        $status = EmailTemplate::where('act', $type)->first()->status;
        if ($status == 1) {
            $email_template = EmailTemplate::where('act', $type)->where('status', 1)->first();
            if ($email_template->browser_message == null) {
                $message = $email_template->subj;
            } else {
                $message = $email_template->browser_message;
            }


            foreach ($shortcodes as $code => $value) {
                $message = shortcode_replacer('{{' . $code . '}}', $value, $message);
            }
            // $message = shortcode_replacer('{{footer}}', $general->email_template, $message);


            $details = [
                'title' => $email_template->subj,
                'body' => $message,
                'actionText' => $actionText,
                'actionURL' => $actionURL,
                'notification_type' => $notificationType,
                'id' => $id
            ];
            Notification::send($user, new GeneralNotification($details));
        }

    }
}

if (!function_exists('send_mobile_notification')) {

    function send_mobile_notification($user, $type, $shortcodes = [])
    {
        $status = EmailTemplate::where('act', $type)->first()->status;
        if ($status == 1) {
            $email_template = EmailTemplate::where('act', $type)->where('status', 1)->first();

            if ($email_template->browser_message == null) {
                $message = $email_template->subj;
            } else {
                $message = $email_template->browser_message;
            }


            foreach ($shortcodes as $code => $value) {
                $message = shortcode_replacer('{{' . $code . '}}', $value, $message);
            }


            PushNotificationJob::dispatch($email_template->subj, $message, $user->device_token);
        }

    }
}


if (!function_exists('htmlPart')) {
    function htmlPart($subject, $body)
    {
        $html = '
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
<style>

     .social_links {
        background: #F4F4F8;
        padding: 15px;
        margin: 30px 0 30px 0;
    }

    .social_links a {
        display: inline-block;
        font-size: 15px;
        color: #252B33;
        padding: 5px;
    }


</style>

<div class="">
<div style="color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: center; background-color: rgb(65, 80, 148); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;"><h1 style="margin: 20px 0px 10px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; font-size: 36px;">
' . $subject . '

</h1></div><div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;">
<p style="color: rgb(85, 85, 85);"><br></p>
<p style="color: rgb(85, 85, 85);">' . $body . '</p></div>
</div>

<div class="email_invite_wrapper" style="text-align: center">


    <div class="social_links">
        <a href="https://twitter.com/codetheme"> <i class="fab fa-facebook-f"></i> </a>
        <a href="https://codecanyon.net/user/codethemes/portfolio"><i class="fas fa-code"></i> </a>
        <a href="https://twitter.com/codetheme" target="_blank"> <i class="fab fa-twitter"></i> </a>
        <a href="https://dribbble.com/codethemes"> <i class="fab fa-dribbble"></i></a>
    </div>
</div>

';
        return $html;
    }
}

if (!function_exists('getPriceFormat')) {
    function getPriceFormat($price, $text = true)
    {
        if (!showEcommerce()) {
            return '';
        }
        $symbol = Settings('currency_symbol');
        $type = Settings('currency_show');
        if (!empty($price) || $price != 0) {
            $price = number_format((float)str_replace(',', '', $price), 2);

            if ($type == 1) {
                $result = $symbol . $price;

            } elseif ($type == 2) {
                $result = $symbol . ' ' . $price;

            } elseif ($type == 3) {
                $result = $price . $symbol;

            } elseif ($type == 4) {
                $result = $price . ' ' . $symbol;

            } else {
                $result = $price;
            }
        } else {
            if ($text) {
                $result = trans('common.Free');
            } else {
                $result = 0;
            }
        }

        return $result;
    }
}


if (!function_exists('totalQuizQus')) {
    function totalQuizQus($quiz_id)
    {
        $total = \Modules\Quiz\Entities\OnlineExamQuestionAssign::where('online_exam_id', $quiz_id)->count();
        return $total;
    }
}

if (!function_exists('totalQuizMarks')) {
    function totalQuizMarks($quiz_id)
    {
        $totalMark = 0;
        $total = \Modules\Quiz\Entities\OnlineExamQuestionAssign::where('online_exam_id', $quiz_id)->with('questionBank')->get();

        foreach ($total as $question) {
            $totalMark = $totalMark + $question->questionBank->marks;
        }
        return $totalMark;
    }
}

if (!function_exists('theme')) {
    function theme($fileName)
    {
        if (!empty(Settings('frontend_active_theme'))) {
            $theme = Settings('frontend_active_theme');
        } else {
            $theme = 'infixlmstheme';
        }
        $path = 'frontend.' . $theme . '.' . $fileName;
        if (View::exists($path)) {
            return $path;
        } else {
            return 'frontend.infixlmstheme' . '.' . $fileName;
        }

    }
}


if (!function_exists('themeAsset')) {
    function themeAsset($fileName)
    {
        if (!empty(Settings('frontend_active_theme'))) {
            $theme = Settings('frontend_active_theme');
        } else {
            $theme = 'infixlmstheme';
        }
        $path = 'public/frontend/' . $theme . '/' . $fileName;
        return asset($path);

    }
}

if (!function_exists('backendComponent')) {
    function backendComponent($fileName)
    {
        return 'backend.components.' . $fileName;

    }
}

//Start Compact Helper

if (!function_exists('topbarSetting')) {
    function topbarSetting()
    {
        return app()->topbarSetting;
    }
}
if (!function_exists('courseSetting')) {
    function courseSetting()
    {
        return CourseSetting::getData();
    }
}
if (!function_exists('itemsGridSize')) {
    function itemsGridSize()
    {
        if (Settings('frontend_active_theme') == 'edume') {
            $view_grid = 5;
            return $view_grid * 2;
        }
        if (courseSetting()->size_of_grid == 3) {
            $view_grid = 4;
        } else {
            $view_grid = 3;
        }

        return $view_grid * 3;
    }
}
//End Compact Helper

if (!function_exists('Settings')) {
    function Settings($value = null)
    {
        try {
            if (isModuleActive('LmsSaas')) {
                $domain = SaasDomain();
            } else {
                $domain = 'main';
            }
            if ($value == "frontend_active_theme") {
                return Cache::rememberForever('frontend_active_theme_' . $domain, function () {
                    $setting = GeneralSetting::where('key', 'frontend_active_theme')->first();
                    return $setting->value;
                });
            } elseif ($value == "active_time_zone") {
                if (!isValidTimeZone(app('getSetting')[$value])) {
                    return 'Asia/Dhaka';
                }
            } elseif ($value == "start_site") {
                if (!isset(app('getSetting')[$value])) {
                    if (isModuleActive('Org')) {
                        return 'loginpage';
                    } else {
                        return 'homepage';
                    }
                }
            }
            return app('getSetting')[$value];
        } catch (Exception $exception) {
            return false;
        }
    }
}
if (!function_exists('isValidTimeZone')) {
    function isValidTimeZone($timezone = null)
    {
        try {
            Carbon::now($timezone);
        } catch (Exception $exception) {
            return false;
        }
        return true;
    }
}

if (!function_exists('isModuleActive')) {
    function isModuleActive($module)
    {

        try {
            $haveModule = app('ModuleList')->where('name', $module)->first();
            if (empty($haveModule)) {
                return false;
            }
            $modulestatus = $haveModule->status;


            $is_module_available = 'Modules/' . $module . '/Providers/' . $module . 'ServiceProvider.php';

            if (file_exists($is_module_available)) {


                $moduleCheck = \Nwidart\Modules\Facades\Module::find($module)->isEnabled();


                if (!$moduleCheck) {

                    return false;
                }


                if ($modulestatus == 1) {
                    $is_verify = app('ModuleManagerList')->where('name', $module)->first();

                    if (!empty($is_verify->purchase_code)) {
                        return true;
                    }
                }
            }


//            }
            return false;
        } catch (\Throwable $th) {


            return false;
        }

    }
}


if (!function_exists('getPercentageRating')) {
    function getPercentageRating($review_data, $value)
    {
        if ($review_data['total'] > 0) {
            $data['total'] = $review_data['total'] ?? 0;
            switch ($value) {
                case 1 :
                    $per = $review_data['1'];
                    break;
                case 2 :
                    $per = $review_data['2'];
                    break;
                case 3 :
                    $per = $review_data['3'];
                    break;
                case 4 :
                    $per = $review_data['4'];
                    break;
                case 5 :
                    $per = $review_data['5'];
                    break;
                default:
                    $per = 0;
                    break;
            }

            if ($per > 0) {
                $data['per'] = ($per / $data['total']) * 100;
            } else {
                $data['per'] = 0;
            }
        } else {
            $data['per'] = 0;
        }
        $data['per'] = number_format($data['per'], 2);
        return $data['per'] ?? 0;
    }
}

if (!function_exists('userRating')) {
    function userRating($user_id)
    {
        $totalRatings['rating'] = 0;
        $ReviewList = DB::table('courses')
            ->join('course_reveiws', 'course_reveiws.course_id', 'courses.id')
            ->select('courses.id', 'course_reveiws.id as review_id', 'course_reveiws.star as review_star')
            ->where('courses.user_id', $user_id)
            ->get();
        $totalRatings['total'] = count($ReviewList);

        foreach ($ReviewList as $Review) {
            $totalRatings['rating'] += $Review->review_star;
        }

        if ($totalRatings['total'] != 0) {
            $avg = ($totalRatings['rating'] / $totalRatings['total']);
        } else {
            $avg = 0;
        }

        if ($avg != 0) {
            if ($avg - floor($avg) > 0) {
                $rate = number_format($avg, 1);
            } else {
                $rate = number_format($avg, 0);
            }
            $totalRatings['rating'] = $rate;
        }
        return $totalRatings;
    }
}


if (!function_exists('getPriceWithConversion')) {
    function getPriceWithConversion($price)
    {
        $price = str_replace(',', '', $price);
        $price = $price * 1;
        return $price;
    }
}


function convertCurrency($from_currency, $to_currency, $amount)
{
    $from = urlencode($from_currency);
    $to = urlencode($to_currency);
    $apikey = Settings('fixer_key') ?? '';
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://data.fixer.io/api/latest?access_key=" . $apikey,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "content-type: application/json"
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {

        return number_format($amount, 2, '.', '');
    } else {

        $info = json_decode($response);
        $cur = (array)@$info->rates;
        $from_ = null;
        $to_ = null;
        foreach ($cur as $key => $value) {
            if ($key == $from) {
                $from_ = $value;
            }
            if ($key == $to) {
                $to_ = $value;
            }

        }
        if ($to_ > 0) {
            $total = ($to_ / $from_) * $amount;
        } else {
            $total = $amount;
        }

        return number_format($total, 2, '.', '');
    }
}

if (!function_exists('isRtl')) {
    function isRtl()
    {
        if (Auth::check()) {
            $rtl = Auth::user()->language_rtl;
        } elseif (\Illuminate\Support\Facades\Session::get('locale')) {
            $rtl = \Illuminate\Support\Facades\Session::get('language_rtl');
        } else {
            $rtl = Settings('language_rtl');
        }

        if ($rtl == 1) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('getDomainName')) {
    function getDomainName($url)
    {
        $url_domain = preg_replace("(^https?://)", "", $url);
        $url_domain = preg_replace("(^http?://)", "", $url_domain);
        $url_domain = str_replace("/", "", $url_domain);
        return $url_domain;

    }
}

if (!function_exists('getMenuLink')) {
    function getMenuLink($menu)
    {
        $url = url('/');
        if ($menu) {
            if (!empty($menu->link)) {
                if (substr($menu->link, 0, 1) == '/') {
                    if ($menu->link == "/") {
                        return url($menu->link) . '/';

                    }
                    return url($menu->link);
                }
                return $menu->link;
            }
            $type = $menu->type;
            $element_id = $menu->element_id;
            if ($type == "Dynamic Page") {

                $page = FrontPage::find($element_id);
                if ($page) {
                    $url = url($page->slug);
//                    $url = \route('frontPage', [$page->slug]);
                }
            } elseif ($type == "Static Page") {
                $page = FrontPage::find($element_id);
                if ($page) {
                    $url = url($page->slug);

                }
            } elseif ($type == "Category") {
                $url = route('courses') . "?category=" . $element_id;

            } elseif ($type == "Sub Category") {
                $url = route('courses') . "?category=" . $element_id;

            } elseif ($type == "Course") {
                $course = Course::find($element_id);
                if ($course) {
                    $url = route('courseDetailsView', [$course->id, $course->slug]);

                }
            } elseif ($type == "Quiz") {
                $course = Course::find($element_id);
                if ($course) {
                    $url = route('classDetails', [$course->id, $course->slug]);

                }
            } elseif ($type == "Class") {
                $course = Course::find($element_id);
                if ($course) {
                    $url = route('courseDetailsView', [$course->id, $course->slug]);

                }
            } elseif ($type == "Custom Link") {
                $url = '';
            }
        }


        return $url;

    }
}

if (!function_exists('isSubscribe')) {
    function isSubscribe()
    {
        if (isModuleActive('Subscription') && Auth::check()) {
            $user = Auth::user();
            $date_of_subscription = $user->subscription_validity_date;
            if (empty($date_of_subscription)) {
                return false;
            }

            $expires_at = new DateTime($date_of_subscription);
            $today = new DateTime('now');


            if ($expires_at < $today)
                return false;

            else {
                return true;
            }
        } else {
            return false;
        }

        return false;

    }
}


if (!function_exists('userCurrentPlan')) {
    function userCurrentPlan()
    {
        if (isModuleActive('Subscription')) {
            if (Auth::check()) {
                $user = Auth::user();
                $date_of_subscription = $user->subscription_validity_date;
                if (empty($date_of_subscription)) {
                    return null;
                }

                $check = SubscriptionCheckout::select('plan_id')->where('end_date', '>=', date('Y-m-d'))->get();
                if (count($check) != 0) {
                    $plan = [];
                    foreach ($check as $p) {
                        $plan[] = $p->plan_id;
                    }
                    return $plan;
                }


            }
        } else {
            return null;
        }

        return null;

    }
}
if (!function_exists('hasTable')) {
    function hasTable($table)
    {
        if (Schema::hasTable($table)) {
            return true;
        } else {
            return false;
        }

    }
}


if (!function_exists('reviewCanDelete')) {
    function reviewCanDelete($review_user_id, $instructor_id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($review_user_id == $user->id || $user->role_id == 1 || $instructor_id == $user->id) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
}
if (!function_exists('commentCanDelete')) {
    function commentCanDelete($comment_user_id, $instructor_id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($comment_user_id == $user->id || $user->role_id == 1 || $instructor_id == $user->id) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
}
if (!function_exists('blogCommentCanDelete')) {
    function blogCommentCanDelete()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role_id == 1) {
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('ReplyCanDelete')) {
    function ReplyCanDelete($reply_user_id, $instructor_id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($reply_user_id == $user->id || $user->role_id == 1 || $instructor_id == $user->id) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


if (!function_exists('hasTax')) {
    function hasTax()
    {
        if (isModuleActive('Tax')) {
            if (Settings('tax_status') == 1) {
                return true;
            } else {
                return false;
            }

        }
        return false;
    }
}

if (!function_exists('countryWishTaxRate')) {
    function countryWishTaxRate()
    {
        $vat = 0;
        if (Auth::check()) {
            $country_id = Auth::user()->country;

            $countryWishTaxList = Cache::rememberForever('countryWishTaxList_' . SaasDomain(), function () {
                return DB::table('country_wish_taxes')
                    ->select('country_id', 'tax')
                    ->where('status', 1)
                    ->get();
            });

            $setting = $countryWishTaxList->where('country_id', $country_id)->first();
            if ($setting) {
                $vat = $setting->tax;
            }
        }
        return $vat;
    }
}
if (!function_exists('applyTax')) {
    function applyTax($price)
    {
        $type = Settings('tax_type');
        if ($type == 1) {
            $vat = Settings('tax_percentage');
        } else {
            $vat = countryWishTaxRate();
        }
        $vatToPay = ($price / 100) * $vat;
        $totalPrice = $price + $vatToPay;

        return $totalPrice;

    }
}
if (!function_exists('taxAmount')) {
    function taxAmount($price)
    {
        $type = Settings('tax_type');
        if ($type == 1) {
            $vat = Settings('tax_percentage');
        } else {
            $vat = countryWishTaxRate();
        }
        $vatToPay = ($price / 100) * $vat;
        return $vatToPay;

    }
}

if (!function_exists('getPriceAsNumber')) {
    function getPriceAsNumber($price)
    {
        return str_replace(',', '', $price);

    }
}


if (!function_exists('currentTheme')) {
    function currentTheme()
    {
        if (app()->bound('getSetting')) {
            return Theme::where('is_active', 1)->first()->name;
        } else {
            return 'infixlmstheme';
        }


    }
}

if (!function_exists('shortDetails')) {
    function shortDetails($string, $length)
    {
        $string = strip_tags($string);
        if (strlen($string) > $length) {

            // truncate string
            $stringCut = substr($string, 0, $length);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '...';
        }
        return $string;
    }
}

if (!function_exists('totalReviews')) {
    function totalReviews($course_id)
    {
        return \Modules\CourseSetting\Entities\CourseReveiw::where('course_id', $course_id)->count();
    }
}

if (!function_exists('validationMessage')) {
    function validationMessage($validation_rules)
    {
        $message = [];
        foreach ($validation_rules as $attribute => $rules) {

            if (is_array($rules)) {
                $single_rule = $rules;
            } else {
                $single_rule = explode('|', $rules);
            }

            foreach ($single_rule as $rule) {
                $string = explode(':', $rule);
                $key = $attribute;
                if (strpos($attribute, '.')) {
                    $attr = explode('.', $attribute);
                    $key = $attr[0] ?? '';
                }
                $message [$attribute . '.' . $string[0]] = __('validation.' . $key . '.' . $string[0]);
            }
        }

        return $message;
    }
}

if (!function_exists('escapHtmlChar')) {
    function escapHtmlChar($str)
    {
        $find = ['"', "'"];
        $replace = ['&quot;', '&apos;'];
        return str_replace($find, $replace, htmlspecialchars($str));


    }
}
if (!function_exists('doubleQuotes2singleQuotes')) {
    function doubleQuotes2singleQuotes($str)
    {
        $find = ['"'];
        $replace = ["'"];
        return str_replace($find, $replace, htmlspecialchars($str));


    }
}


if (!function_exists('showDate')) {
    function showDate($date)
    {
        if (!$date) {
            return "";
        }
        try {
            return Carbon::parse($date)->locale(app()->getLocale())->translatedFormat(Settings('active_date_format'));
        } catch (\Exception $e) {
            return "";
        }
    }
}

if (!function_exists('checkParent')) {
    function checkParent($category, $string = null)
    {
        if (!empty($category->parent->id)) {
            return checkParent($category->parent, $string . '-');
        }
        if ($string) {
            $string = $string . '>';
        }
        return $string;

    }
}


if (!function_exists('GettingError')) {
    function GettingError($message, $url = '', $ip = '', $agent = '', $return = false)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = 0;
        }
        ErrorLog::create([
            'subject' => $message,
            'type' => '1',
            'url' => $url,
            'ip' => $ip,
            'agent' => $agent,
            'user_id' => $user_id,
        ]);
        if ($return) {
            return false;
        } else {
            abort('500', trans('frontend.Something went wrong, Please check error log'));
        }

    }
}

if (!function_exists('isViewable')) {
    function isViewable($course)
    {
        $isViewable = true;
        if ($course->status == 0) {
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->role_id != 1 && $course->user_id != $user->id) {
                    $isViewable = false;
                }
            } else {
                $isViewable = false;
            }
        }
        return $isViewable;


    }
}

if (!function_exists('MinuteFormat')) {
    function MinuteFormat($minutes)
    {
        $minutes = intval($minutes);
        $hours = floor($minutes / 60);
        $min = $minutes - ($hours * 60);
        $result = '';
        if ($hours == 1) {
            $result .= $hours . ' Hour ';
        } elseif ($hours > 1) {
            $result .= $hours . ' Hours ';
        }

        if ($min == 1) {
            $result .= $min . ' Min';
        } elseif ($min > 1) {
            $result .= $min . ' Min';
        }

        return $result;
    }
}

if (!function_exists('UpdateGeneralSetting')) {
    function UpdateGeneralSetting($key, $value)
    {
        try {
            $setting = GeneralSetting::where('key', $key)->first();
            if ($setting) {
                $setting->value = $value;
            } else {
                $setting = new GeneralSetting();
                $setting->key = $key;
                $setting->value = $value;
                $setting->updated_at = now();
                $setting->created_at = now();
            }
            $setting->save();
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('GenerateGeneralSetting')) {
    function GenerateGeneralSetting($domain)
    {
        if (Schema::hasColumn('general_settings', 'key')) {
            $path = Storage::path('settings.json');
            $settings = GeneralSetting::get(['key', 'value'])->pluck('value', 'key')->toArray();
            if (!Storage::has('settings.json')) {
                $strJsonFileContents = null;
            } else {
                $strJsonFileContents = file_get_contents($path);

            }
            $file_data = json_decode($strJsonFileContents, true);
            $setting_array[$domain] = $settings;
            if (!empty($file_data)) {
                $merged_array = array_merge($file_data, $setting_array);
            } else {
                $merged_array = $setting_array;
            }
            $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
            file_put_contents($path, $merged_array);

        }
    }
}

if (!function_exists('GenerateHomeContent')) {
    function GenerateHomeContent($domain)
    {

        if (Schema::hasColumn('home_contents', 'key')) {
            $path = Storage::path('homeContent.json');
            $settings = HomeContent::get(['key', 'value'])->pluck('value', 'key')->toArray();
            if (!Storage::has('homeContent.json')) {
                $strJsonFileContents = null;
            } else {
                $strJsonFileContents = file_get_contents($path);
            }
            $file_data = json_decode($strJsonFileContents, true);
            $setting_array[$domain] = $settings;
            if (!empty($file_data)) {
                $merged_array = array_merge($file_data, $setting_array);
            } else {
                $merged_array = $setting_array;
            }
            $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
            file_put_contents($path, $merged_array);
        }
    }
}


if (!function_exists('UpdateHomeContent')) {
    function UpdateHomeContent($key, $value)
    {

        $setting = HomeContent::where('key', $key)->first();
        if (!$setting) {
            $setting = new HomeContent();
            $setting->key = $key;
        }
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $setting->setTranslation('value', $k, $v);
            }
        } else {
            $setting->setTranslation('value', 'en', $value);
        }
        $setting->save();
    }
}

if (!function_exists('getIpBlockList')) {
    function getIpBlockList()
    {
        if (isModuleActive('LmsSaas')) {
            $domain = SaasDomain();
        } else {
            $domain = 'main';
        }

        Cache::rememberForever('ipBlockList_' . $domain, function () {
            $data = [];
            $rowData = IpBlock::select('ip_address')->get();
            foreach ($rowData as $single) {
                $data[] = $single['ip_address'];
            }
            return $data;
        });
    }
}


if (!function_exists('HomeContents')) {
    function HomeContents($value = null)
    {
        $setting = app('getHomeContent')->where('key', $value)->first();
        return $setting ? $setting->value : '';
    }
}

if (!function_exists('getHomeContents')) {
    function getRawHomeContents($all, $value, $lang)
    {
        $result = '';
        try {
            $row = $all->where('key', $value)->first();
            $result = $row ? $row->getTranslation('value', $lang) : '';
        } catch (\Exception $e) {

        }
        return $result;

    }
}

if (!function_exists('generateBlockPosition')) {
    function generateBlockPosition()
    {
        $homepage_block_positions = DB::table('homepage_block_positions')->orderBy('order', 'asc')->get();
        UpdateHomeContent('homepage_block_positions', json_encode($homepage_block_positions));
    }
}
if (!function_exists('isBundleValid')) {
    function isBundleExpire($course_id)
    {
        $enroll = null;
        if (Auth::check()) {
            $enroll = CourseEnrolled::where('user_id', Auth::user()->id)->where('course_id', $course_id)->first();
        }
        if ($enroll) {
            $validity = $enroll->bundle_course_validity;
            if (!empty($validity)) {
                if (!Carbon::parse($validity)->isFuture()) {
                    return true;
                }
            }

        }

        return false;
    }
}


if (!function_exists('orgSubscriptionCourseValidity')) {
    function orgSubscriptionCourseValidity($courseId)
    {
        if (Auth::user()->role_id == 3) {
            if (isModuleActive('OrgSubscription') && Auth::check()) {
                $enroll = CourseEnrolled::where('course_id', $courseId)->where('user_id', Auth::id())->first();

                if ($enroll && $enroll->subscription == 1) {
                    $time = $enroll->subscription_validity_time;
                    if (!empty($time)) {
                        $validity = $enroll->subscription_validity_date;
                    } else {
                        $validity = $enroll->subscription_validity_date . ' ' . $time;
                    }


                    if (!empty($validity)) {
                        if (!Carbon::parse($validity)->isFuture()) {
                            return false;
                        }
                    }

                }


            }
        }

        return true;
    }
}


if (!function_exists('orgSubscriptionCourseSequence')) {
    function orgSubscriptionCourseSequence($courseId)
    {
        if (isModuleActive('OrgSubscription') && Auth::check()) {

            $org_subscription_checkouts = OrgSubscriptionCheckout::where('user_id', Auth::id())->get();
            $access_courses = [];
            $plan_id = '';
            foreach ($org_subscription_checkouts as $cko) {
                if ($cko->plan->type == 1) {
                    if ($cko->plan->sequence == 1 && date('Y-m-d', strtotime($cko->plan->end_date)) > date('Y-m-d')) {
                        foreach ($cko->plan->assign as $course) {
                            if ($course->course_id == $courseId) {
                                $plan_id = $course->plan_id;
                            }
                        }
                    }

                } else {
                    $end_date = Carbon::parse($cko->start_date)->addDays($cko->days);
                    if ($cko->plan->sequence == 1 && $end_date->format('Y-m-d') > date('Y-m-d')) {
                        foreach ($cko->plan->assign as $course) {
//                            $access_courses[] = $course->course_id;
                            if ($course->course_id == $courseId) {
                                $plan_id = $course->plan_id;
                            }

                        }
                    }

                }
            }
            if ($plan_id) {
                $plan = OrgCourseSubscription::find($plan_id);
                if ($plan) {
                    foreach ($plan->assign as $course) {
                        $access_courses[] = $course->course_id;
                        if ($course->course->type == 1 && $course->loginUserTotalPercentage != 100) {
                            break;
                        }
                    }
                }

            } else {
                return true;
            }

            if (in_array($courseId, $access_courses)) {
                return true;
            }
        }
        return false;
    }
}


if (!function_exists('updateEnrolledCourseLastView')) {
    function updateEnrolledCourseLastView($course_id)
    {
        if (Auth::check()) {
            $enroll = CourseEnrolled::where('course_id', $course_id)->where('course_id', $course_id)->first();
            if ($enroll) {
                $enroll->last_view_at = now();
                $enroll->save();
            }
        }
    }
}

if (!function_exists('dateConvert')) {

    function dateConvert($input_date)
    {
        try {
            $system_date_format = session()->get('system_date_format');
            if (empty($system_date_format)) {
                $date_format_id = SmGeneralSettings::where('id', 1)->first(['date_format_id'])->date_format_id;
                $system_date_format = SmDateFormat::where('id', $date_format_id)->first(['format'])->format;
                session()->put('system_date_format', $system_date_format);
                return date_format(date_create($input_date), $system_date_format);
            } else {
                return date_format(date_create($input_date), $system_date_format);
            }
        } catch (\Throwable $th) {
            return $input_date;
        }
    }
}

if (!function_exists('canApprove')) {
    function canApprove($staff_id = null)
    {
        if (Auth::user()->role_id == 1)
            return true;
        else {
            if ($staff_id) {
                $staff = Staff::find($staff_id);
                if ($staff) {
                    $department = Department::find($staff->department_id);
                    if ($department && $department->user_id && in_array(auth()->id(), $department->user_id))
                        return true;
                }
            }
            return false;
        }
    }
}


if (!function_exists('attendanceCheck')) {
    function attendanceCheck($user_id, $type, $date)
    {
        $attendance = Attendance::where('user_id', $user_id)->whereDate('date', \Carbon\Carbon::parse($date)->format('Y-m-d'))->first();
        if ($attendance != null) {
            if ($attendance->attendance == $type) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }
}
if (!function_exists('attendanceInfo')) {
    function attendanceInfo($user_id, $date)
    {
        $attendance = Attendance::where('user_id', $user_id)->whereDate('date', \Carbon\Carbon::parse($date)->format('Y-m-d'))->first();

        return $attendance;
    }
}


if (!function_exists('attendanceNote')) {
    function attendanceNote($user_id)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', \Carbon\Carbon::today()->toDateString())->first();
        if ($todayAttendance != null) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('attendanceNoteDateWise')) {
    function attendanceNoteDateWise($user_id, $date)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', date('Y-m-d', strtotime($date)))->first();
        if ($todayAttendance != null) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('LateNote')) {
    function LateNote($user_id, $date)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', date('Y-m-d', strtotime($date)))->first();
        if ($todayAttendance) {
            return $todayAttendance->late_note;
        } else {
            return '';
        }
    }
}


if (!function_exists('Note')) {
    function Note($user_id)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', \Carbon\Carbon::today()->toDateString())->first();
        if ($todayAttendance != null && $todayAttendance->note != null) {
            return $todayAttendance->note;
        } else {
            return false;
        }
    }
}
if (!function_exists('NoteDateWise')) {
    function NoteDateWise($user_id, $date)
    {
        $todayAttendance = Attendance::where('user_id', $user_id)->where('date', date('Y-m-d', strtotime($date)))->first();
        if ($todayAttendance != null && $todayAttendance->note != null) {
            return $todayAttendance->note;
        } else {
            return false;
        }
    }
}

if (!function_exists('transformExcelDate')) {
    function transformExcelDate($value, $format = 'd/m/Y')
    {
        try {
            $date = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
            return $date->format($format);
        } catch (\ErrorException $e) {
            $date = \Carbon\Carbon::createFromFormat($format, $value);
            return $date->format($format);
        }
    }
}


if (!function_exists('assignStaffToUser')) {
    function assignStaffToUser($user)
    {
        $check = DB::table('staffs')->where('user_id', $user->id)->first();
        if ($check) {
            DB::table('staffs')->insert([
                'user_id' => $user->id
            ]);
        }
    }
}


if (!function_exists('generateUniqueId')) {
    function generateUniqueId($random_id_length = 10)
    {
        $rnd_id = Hash::make((uniqid(rand(), 1)));
        $rnd_id = strip_tags(stripslashes($rnd_id));
        $rnd_id = str_replace(".", "", $rnd_id);
        $rnd_id = strrev(str_replace("/", "", $rnd_id));
        return substr($rnd_id, 0, $random_id_length);
    }
}

if (!function_exists('updateModuleParentRoute')) {
    function updateModuleParentRoute()
    {
        if (Schema::hasColumn('permissions', 'parent_route')) {
            $permissions = DB::table('permissions')->whereNotNull('parent_id')->get(['parent_id', 'route']);
            foreach ($permissions as $permission) {
                $parent_route = null;
                if (!empty($permission->parent_id)) {
                    $parent = DB::table('permissions')->where('id', $permission->parent_id)->first();
                    if ($parent) {
                        $parent_route = $parent->route;
                    }
                }
                DB::table('permissions')
                    ->where('route', $permission->route)->update([
                        'parent_route' => $parent_route,
                        'module_id' => null,
                        'parent_id' => null,
                    ]);
            }
            Cache::forget('PermissionList_' . SaasDomain());
            Cache::forget('RoleList_' . SaasDomain());
            Cache::forget('PolicyPermissionList_' . SaasDomain());
            Cache::forget('PolicyRoleList_' . SaasDomain());

        }

    }
}


if (!function_exists('paymentGateWayCredentialsEmptyCheck')) {
    function paymentGateWayCredentialsEmptyCheck($method)
    {
        if ($method == 'PayPal') {
            if (!empty(getPaymentEnv('PAYPAL_CLIENT_ID')) && !empty(getPaymentEnv('PAYPAL_CLIENT_SECRET')) && !empty(getPaymentEnv('IS_PAYPAL_LOCALHOST'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Instamojo') {
            if (!empty(getPaymentEnv('Instamojo_API_AUTH')) && !empty(getPaymentEnv('Instamojo_API_AUTH_TOKEN')) && !empty(getPaymentEnv('Instamojo_URL'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Midtrans') {
            if (!empty(getPaymentEnv('MIDTRANS_SERVER_KEY'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Payeer') {
            if (!empty(getPaymentEnv('PAYEER_MERCHANT')) && !empty(getPaymentEnv('PAYEER_KEY'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Pesapal') {
            if (!empty(getPaymentEnv('PESAPAL_KEY')) && !empty(getPaymentEnv('PESAPAL_SECRET'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Mobilpay') {
            if (!empty(getPaymentEnv('MOBILPAY_MERCHANT_ID')) && !empty(getPaymentEnv('MOBILPAY_TEST_MODE')) && !empty(getPaymentEnv('MOBILPAY_PUBLIC_KEY_PATH')) && !empty(getPaymentEnv('MOBILPAY_PRIVATE_KEY_PATH'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'PayPal') {
            if (!empty(getPaymentEnv('PAYPAL_CLIENT_ID')) && !empty(getPaymentEnv('PAYPAL_CLIENT_SECRET'))) {
                $result = true;
            } else {
                $result = false;
            }
        }elseif ($method == 'Clover') {
            if (!empty(getPaymentEnv('CLOVER_CLIENT_ID')) && !empty(getPaymentEnv('CLOVER_CLIENT_SECRET')) && !empty(getPaymentEnv('CLOVER_CODE')) && !empty(getPaymentEnv('CLOVER_MERCHANT_ID')) && !empty(getPaymentEnv('CLOVER_EMPLOYEE_ID'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Stripe') {
            if (!empty(getPaymentEnv('STRIPE_SECRET')) && !empty(getPaymentEnv('STRIPE_KEY'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'PayStack') {
            if (!empty(getPaymentEnv('PAYSTACK_PUBLIC_KEY')) && !empty(getPaymentEnv('PAYSTACK_SECRET_KEY')) && !empty(getPaymentEnv('MERCHANT_EMAIL')) && !empty(getPaymentEnv('PAYSTACK_PAYMENT_URL'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'RazorPay') {
            if (!empty(getPaymentEnv('RAZOR_KEY')) && !empty(getPaymentEnv('RAZOR_SECRET'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'MercadoPago') {
            if (!empty(getPaymentEnv('MERCADO_PUBLIC_KEY')) && !empty(getPaymentEnv('MERCADO_ACCESS_TOKEN'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'PayTM') {
            if (!empty(getPaymentEnv('PAYTM_MERCHANT_ID')) && !empty(getPaymentEnv('PAYTM_MERCHANT_KEY')) && !empty(getPaymentEnv('PAYTM_MERCHANT_WEBSITE')) && !empty(getPaymentEnv('PAYTM_CHANNEL')) && !empty(getPaymentEnv('PAYTM_INDUSTRY_TYPE'))) {
                $result = true;
            } else {
                $result = false;
            }
        } elseif ($method == 'Bkash') {
            if (!empty(getPaymentEnv('BKASH_APP_KEY')) && !empty(getPaymentEnv('BKASH_APP_SECRET')) && !empty(getPaymentEnv('BKASH_USERNAME')) && !empty(getPaymentEnv('BKASH_PASSWORD')) && !empty(getPaymentEnv('IS_BKASH_LOCALHOST'))) {
                $result = true;
            } else {
                $result = false;
            }
        } else {
            $result = true;
        }
        return $result;
    }
}


if (!function_exists('affiliateConfig')) {
    function affiliateConfig($key)
    {
        try {
            if ($key) {
                if (Cache::has('affiliate_config_' . SaasDomain())) {
                    $affiliate_configs = Cache::get('affiliate_config_' . SaasDomain());
                    return $affiliate_configs[$key];

                } else {
                    Cache::forget('affiliate_config_' . SaasDomain());
                    $datas = [];
                    foreach (\Modules\Affiliate\Entities\AffiliateConfiguration::get() as $setting) {
                        $datas[$setting->key] = $setting->value;
                    }
                    Cache::rememberForever('affiliate_config_' . SaasDomain(), function () use ($datas) {
                        return $datas;
                    });
                    $affiliate_configs = Cache::get('affiliate_config_' . SaasDomain());
                    return $affiliate_configs[$key];
                }
            } else {
                return false;
            }

        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('isAffiliateUser')) {
    function isAffiliateUser()
    {
        try {
            if (isModuleActive('Affiliate')) {
                if (auth()->check()) {
                    if (auth()->user()->affiliate_request == 1) {
                        return true;
                    }
                }
            }
            return false;

        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('hasAffiliateAccess')) {
    function hasAffiliateAccess()
    {
        try {
            if (isModuleActive('Affiliate')) {
                if (auth()->check()) {
                    if (auth()->user()->role->id == 1) {
                        return true;
                    }
                    if (auth()->user()->affiliate_request == 1 && auth()->user()->accept_affiliate_request == 1) {
                        return true;
                    }
                }
            }

            return false;

        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('showPrice')) {
    function showPrice($price)
    {
        $symbol = Settings('currency_symbol');
        $type = Settings('currency_show');
        if (!empty($price) || $price != 0) {

            $price = number_format(str_replace(',', '', $price), 2);

            if ($type == 1) {
                $result = $symbol . $price;

            } elseif ($type == 2) {
                $result = $symbol . ' ' . $price;

            } elseif ($type == 3) {
                $result = $price . $symbol;

            } elseif ($type == 4) {
                $result = $price . ' ' . $symbol;

            } else {
                $result = $price;
            }
        } else {
            $result = 0;
        }
        return $result;
    }
}
if (!function_exists('showEcommerce')) {
    function showEcommerce()
    {
        if (Settings('hide_ecommerce') != '1') {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('onlySubscription')) {
    function onlySubscription()
    {
        if (isModuleActive('Subscription') && Settings('only_subscription') == '1') {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('getAllChildCodeIds')) {
    function getAllChildCodeIds($child, $pathCode = [])
    {
        if (isset($child->childs)) {
            if (count($child->childs) != 0) {
                foreach ($child->childs as $child) {
                    $pathCode[] = $child->id;
                    $pathCode = getAllChildCodeIds($child, $pathCode);
                }
                return $pathCode;
            }
        }
        return $pathCode;
    }
}

if (!function_exists('orgGetStartEndDate')) {
    function orgGetStartEndDate($enroll, $course)
    {
        $days['start'] = '';
        $days['end'] = '';
        if ($enroll->org_subscription_plan_id != 0) {
            $plan = $enroll->orgSubscriptionPlan;
            if ($plan->type == 1) {
                if (!empty($plan->join_date)) {
                    $days['start'] = Carbon::createFromFormat('m/d/Y', $plan->join_date)->format('d/m/Y') . ' ' . $plan->join_time;
                }
                if (!empty($plan->end_date)) {
                    $days['end'] = Carbon::createFromFormat('m/d/Y', $plan->end_date)->format('d/m/Y') . ' ' . $plan->end_time;
                }
            } else {
                $start = $plan->subscription->start_date;
                $end = $plan->subscription->end_date;
                if (!empty($start)) {
                    $days['start'] = Carbon::parse($start . '')->format('d/m/y h:i A');
                }
                if (!empty($end)) {
                    $days['end'] = Carbon::parse($end)->format('d/m/y h:i A');
                }

            }
        } else {
            $days['start'] = Carbon::parse($course->created_at)->format('d/m/y h:i A');
            $days['end'] = trans('org.Limitless');
        }

        return $days;
    }
}

if (!function_exists('addOrgRecentActivity')) {
    function addOrgRecentActivity($user_id, $course_id, $type)
    {
        if (isModuleActive('Org')) {
            $activity = new \Modules\Org\Entities\OrgRecentActivity();
            $activity->user_id = $user_id;
            $activity->course_id = $course_id;
            $activity->type = $type;
            $activity->save();
        }
    }
}


if (!function_exists('getPercentage')) {
    function getPercentage($value, $total, $decimal = 0)
    {
        try {
            if ($value > 0 && $total > 0) {
                $count1 = $value / $total;
                $count2 = $count1 * 100;
                return number_format($count2, $decimal);
            } else {
                return 0;
            }

        } catch (\Exception $e) {
            return 0;
        }
    }
}

if (!function_exists('applyDefaultRoleToUser')) {
    function applyDefaultRoleToUser($user)
    {
        if (isModuleActive('UserType')) {
            $user->userRoles()->sync($user->role_id);
        }
    }
}

if (!function_exists('assetVersion')) {
    function assetVersion()
    {
        if (config('app.debug')) {
            $ver = rand(1, 9999);
        } else {
            $ver = Storage::has('.version') ? Storage::get('.version') : Settings('system_version');
        }
        return '?v=' . $ver;
    }
}
if (!function_exists('ob_fresh')) {
    function ob_fresh()
    {
        ob_end_clean();
        ob_start();
    }
}
if (!function_exists('clearAllLangCache')) {
    function clearAllLangCache($key)
    {
        if (Schema::hasTable('lms_institutes')) {
            $langs = getLanguageList();
        } else {
            $lang = collect();
            $lang->code = 'en';
            $langs[0] = $lang;
        }

        foreach ($langs as $lang) {
            Cache::forget($key . $lang->code . SaasDomain());
        }
    }
}
if (!function_exists('footerSettings')) {
    function footerSettings($key)
    {
        $footerSetting = Cache::rememberForever('footerSetting_' . app()->getLocale() . SaasDomain(), function () {
            return FooterSetting::all();
        });
        $setting = $footerSetting->where('key', $key)->first();
        return $setting ? $setting->value : '';
    }
}

if (!function_exists('convertToSlug')) {
    function convertToSlug($str, $delimiter = '-')
    {
        $unwanted_array = ['ś' => 's', 'ą' => 'a', 'ć' => 'c', 'ç' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ź' => 'z', 'ż' => 'z',
            'Ś' => 's', 'Ą' => 'a', 'Ć' => 'c', 'Ç' => 'c', 'Ę' => 'e', 'Ł' => 'l', 'Ń' => 'n', 'Ó' => 'o', 'Ź' => 'z', 'Ż' => 'z'];
        $str = strtr($str, $unwanted_array);

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
    }
}

if (!function_exists('byte2mb')) {
    function formatBytes($bytes)
    {
        if ($bytes > 0) {
            $i = floor(log($bytes) / log(1024));
            $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            return sprintf('%.02F', round($bytes / pow(1024, $i), 1)) * 1 . ' ' . @$sizes[$i];
        } else {
            return 0;
        }
    }
}

if (!function_exists('selfHosted')) {
    function selfHosted($type)
    {
        $self = ['Self', 'SCORM', 'XAPI', 'PowerPoint', 'Excel', 'Text', 'Word', 'PDF', 'Image', 'Zip'];
        if (in_array($type, $self)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('getActiveJsDateFormat')) {
    function getActiveJsDateFormat(): string
    {
        switch (Settings('active_date_format')) {
            case 'Y-m-d':
                $jsFormat = 'yyyy-mm-dd';
                break;
            case 'Y-d-m':
                $jsFormat = 'yyyy-dd-mm';
                break;
            case 'd-m-Y':
                $jsFormat = 'dd-mm-yyyy';
                break;
            case 'm-d-Y':
                $jsFormat = 'mm-dd-yyyy';
                break;
            case 'Y/m/d':
                $jsFormat = 'yyyy/mm/dd';
                break;
            case 'Y/d/m':
                $jsFormat = 'yyyy/dd/mm';
                break;
            case 'd/m/Y':
                $jsFormat = 'dd/mm/yyyy';
                break;
            case 'm/d/Y':
                $jsFormat = 'mm/dd/yyyy';
                break;
            default:
                $jsFormat = 'mm/dd/yyyy';
        }

        return $jsFormat;
    }

}
if (!function_exists('getActivePhpDateFormat')) {
    function getActivePhpDateFormat(): string
    {
        $valid = [
            'Y-m-d',
            'Y-d-m',
            'd-m-Y',
            'm-d-Y',
            'Y/m/d',
            'Y/d/m',
            'd/m/Y',
            'm/d/Y'
        ];
        if (!in_array(Settings('active_date_format'), $valid)) {
            $format = 'm/d/Y';
        } else {
            $format = Settings('active_date_format');
        }
        return $format;
    }
}

if (!function_exists('getJsDateFormat')) {
    function getJsDateFormat($date): string
    {
        try {
            $format = getActivePhpDateFormat();
            return Carbon::createFromFormat('m/d/Y', $date)->format($format);
        } catch (Exception $e) {
            return '';
        }
    }
}

if (!function_exists('getPhpDateFormat')) {
    function getPhpDateFormat($date): string
    {
        $format = getActivePhpDateFormat();
        try {
            return Carbon::createFromFormat($format, $date)->format('m/d/Y');
        } catch (Exception $e) {
            return '';
        }
    }
}

if (!function_exists('hasDynamicPage')) {
    function hasDynamicPage()
    {
        $themes = [
            'infixlmstheme',
            'kidslms'
        ];
        if (!in_array(currentTheme(), $themes)) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('MarkAsBlogRead')) {
    function MarkAsBlogRead($blog_id = 0)
    {
        if (Auth::check()) {
            UserBlog::updateOrInsert([
                'user_id' => Auth::id(),
                'blog_id' => $blog_id,
            ]);
        }

    }
}
if (!function_exists('upgradeLevelPayment')) {
    function upgradeLevelPayment(int $checkout_id, int $level_id, int $user_id = null)
    {
        $userId = $user_id ?? auth()->user()->id;
        $exit = MembershipUpgradeLevel::where('membership_checkout_id', $checkout_id)->where('level_id', $level_id)->where('user_id', $userId)->first();
        if ($exit) {
            return true;
        }
        return false;


    }
}
if (!function_exists('spn_active_link')) {
    function spn_active_link($route_or_path, $class = 'mm-active')
    {
        if (is_array($route_or_path)) {
            foreach ($route_or_path as $route) {
                if (request()->is($route)) {
                    return $class;
                }
            }
            return in_array(request()->route()->getName(), $route_or_path) ? $class : false;
        } else {
            if (request()->route()->getName() == $route_or_path) {
                return $class;
            }

            if (request()->is($route_or_path)) {
                return $class;
            }
        }

        return false;
    }
}

if (!function_exists('childrenRoute')) {
    function childrenRoute($menu, $routes = [])
    {
        if (@$menu->route) {
            $routes[] = $menu->route;
        }
        if (!empty($menu->childs) && $menu->childs->count()) {
            foreach ($menu->childs as $child) {
                $routes = childrenRoute($child, $routes);
            }
            return $routes;
        }
        return $routes;
    }
}

if (!function_exists('parentRoute')) {
    function parentRoute($menu, $routes = [])
    {
        $count = count($routes);
        if (@$menu->route) {
            $routes[$count]['route'] = $menu->route;
            $routes[$count]['name'] = $menu->name;
        }
        if ($menu->parent) {
            return parentRoute($menu->parent, $routes);
        }
        return $routes;
    }
}

if (!function_exists('dynamicContentAppend')) {
    function dynamicContentAppend($content = null)
    {
        try {
            $dom = new HTML5DOMDocument();
            $dom->loadHTML($content, HTML5DOMDocument::ALLOW_DUPLICATE_IDS);
            $nodes = $dom->querySelectorAll('.dynamicData');

            if ($nodes) {
                foreach ($nodes as $node) {

                    $parent_data = $node->parentNode->getAttributes();
                    $request = [];
                    $param = [];
                    foreach ($parent_data as $key => $data) {
//                        $param[] = $key;
                        $param[$key] = $data;
                    }

                    $request['param'] = $param;
                    request()->merge($request);

                    $themeDynamic = new ThemeDynamicData();
                    $data = $themeDynamic->__invoke(request());
                    if (response($data)->status() == 200) {
                        $content = response($data)->content();
                        $newnode = $dom->createDocumentFragment();
                        $newnode->appendXML('<div>' . htmlspecialchars($content) . '</div>');
                        $node->appendChild($newnode);
                    } else {
                        return '';
                    }
                }
            }

            return $dom->saveHTML();
        } catch (\Exception $exception) {
            return '';
        }
    }
}

if (!function_exists('generateBreadcrumb')) {
    function generateBreadcrumb($currentRoute = null)
    {
        try {
            if (empty($currentRoute)) {
                $currentRoute = Route::currentRouteName();
            }
            $menu = Permission::where('route', $currentRoute)->first();

            if ($menu) {
                $links = parentRoute($menu);
                krsort($links);
                return view('backend.partials.breadcrumb', compact('links', 'menu'));
            }
        } catch (\Exception $e) {
            return '';
        }

    }
}
if (!function_exists('dbDateFormat')) {
    function dbDateFormat($date)
    {
        $format = getActiveJsDateFormat();
        try {
            return \Illuminate\Support\Carbon::createFromFormat($format, $date)->format('Y-m-d');
        } catch (\Exception $e) {
            return '';
        }
    }
}
if (!function_exists('checkGamification')) {
    function checkGamification($type, $badge_type, $user = null)
    {

        $point = 0;
        $enable = false;
        if (Settings('gamification_status') && Settings('gamification_point_status')) {
            if (empty($user)) {
                $user = Auth::user();
            }
            $user_id = $user->id;

            if ($user->role_id == 1) {
                return false;
            }
            if (currentTheme() != 'infixlmstheme') {
                return false;
            }


            if ($type == 'each_login' && Settings('gamification_point_each_login_status')) {
                $point = Settings('gamification_point_each_login_point');
                $enable = true;
            } elseif ($type == 'each_unit_complete' && Settings('gamification_point_each_unit_complete_status')) {
                $point = Settings('gamification_point_each_unit_complete_point');
                $enable = true;
            } elseif ($type == 'each_course_complete' && Settings('gamification_point_each_course_complete_status')) {
                $point = Settings('gamification_point_each_course_complete_point');
                $enable = true;
            } elseif ($type == 'each_certificate' && Settings('gamification_point_each_certificate_status')) {
                $point = Settings('gamification_point_each_certificate_point');
                $enable = true;
            } elseif ($type == 'each_test_complete' && Settings('gamification_point_each_test_complete_status')) {
                $point = Settings('gamification_point_each_test_complete_point');
                $enable = true;
            } elseif ($type == 'each_assignment_complete' && Settings('gamification_point_each_assignment_complete_status')) {
                $point = Settings('gamification_point_each_assignment_complete_point');
                $enable = true;
            } elseif ($type == 'each_comment' && Settings('gamification_point_each_comment_status')) {
                $point = Settings('gamification_point_each_comment_point');
                $enable = true;
            } elseif ($type == 'each_perfectionism' && Settings('gamification_badges_perfectionism_status')) {
                $enable = true;
            } elseif ($type == 'each_survey' && Settings('gamification_badges_survey_status')) {
                $enable = true;
            } elseif ($type == 'each_survey' && Settings('gamification_badges_survey_status')) {
                $enable = true;
            }
            if ($enable) {
                UserGamificationPoint::create([
                    'user_id' => $user_id,
                    'type' => $type,
                    'badge_type' => $badge_type,
                    'point' => $point,
                ]);
                if ($point != 0) {
                    $notification_title = '+' . $point . ' ' . trans('setting.Points') . ' ' . trans('common.for') . ' ' . str_replace('_', ' ', $type);
                    Toastr::success($notification_title, trans('common.Success'));

                    $user_new_point = $user->gamification_total_points + $point;

                    $user->gamification_points = $user->gamification_points + $point;
                    $user->gamification_total_points = $user_new_point;
                    $user->save();

                    $details = [
                        'title' => $notification_title,
                        'body' => $notification_title,
                        'actionText' => '',
                        'actionURL' => '#',
                    ];
                    Notification::send($user, new GeneralNotification($details));
                }


            }

            $totalGamificationPoint = UserGamificationPoint::where('badge_type', $badge_type)->count();

            $badge = Badge::where('type', $badge_type)->where('point', $totalGamificationPoint)->where('status', 1)->orderBy('point', 'desc')->first();

            if ($badge && Settings('gamification_badges_' . $badge_type . '_status')) {

                $userBadge = UserBadge::updateOrCreate([
                    'user_id' => $user_id,
                    'badge_id' => $badge->id,
                ]);
                if ($userBadge->wasRecentlyCreated) {
                    $badge_notification_title = trans('common.A new badge has been unlocked');
                    Toastr::success($badge_notification_title, trans('common.Congratulations'));
                    $details = [
                        'title' => $badge_notification_title,
                        'body' => $badge_notification_title,
                        'actionText' => '',
                        'actionURL' => '#',
                    ];
                    Notification::send($user, new GeneralNotification($details));
                }
            }

            checkUserLevel($user);


        }
        return false;
    }
}


if (!function_exists('checkUserLevel')) {
    function checkUserLevel($user)
    {
        if (Settings('gamification_level_status')) {
            if (Settings('gamification_level_entry_point_status')) {
                $point = Settings('gamification_level_entry_point');
                if ($user->gamification_points >= $point) {
                    $user->gamification_points = $user->gamification_points - $point;
                    $user->save();
                    createUserLevelHistory($user->id, 'point', $point);
                }
            }
            if (Settings('gamification_level_entry_complete_status')) {
                $point = (int)Settings('gamification_level_entry_complete_point');
                $total_courses = $user->studentCourses->count();

                if ($user->user_level_course_complete >= $point) {
                    $user->user_level_course_complete = $total_courses - $point;
                    $user->save();
                    createUserLevelHistory($user->id, 'course', $point);
                }

            }
            if (Settings('gamification_level_entry_badge_status')) {
                $point = (int)Settings('gamification_level_entry_badge_point');
                $total_badges = $user->userBadges->count();

                if ($user->user_level_badge >= $point) {
                    $user->user_level_badge = $total_badges - $point;
                    $user->save();
                    createUserLevelHistory($user->id, 'course', $point);
                }
//                if (!empty($total_badges)) {
//                    $avg = (int)number_format($total_badges / $point) + 1;
//                    $alreadyHave = $user->userLevelHistories->where('type', 'badge')->count();
//                    $level_up = $avg - $alreadyHave;
//                    if ($level_up > 0) {
//                        $user->user_level = $user->user_level + $level_up;
//                        $user->save();
//                        createUserLevelHistory($user->id, 'badge', $point);
//                    }
//                }
            }

        }

    }
}

if (!function_exists('createUserLevelHistory')) {
    function createUserLevelHistory($id, $type, $point)
    {
        $check = UserLevelHistory::where('user_id', $id)->where('type', $type)->where('count', $point)->first();
        if ($check) {
            UserLevelHistory::create([
                'user_id' => $id,
                'type' => $type, //point|course|badge
                'count' => $point,

            ]);
            Toastr::success(trans('common.A new level has been unlocked'), trans('common.Congratulations'));
        }


    }
}

if (!function_exists('organizationSettings')) {
    function organizationSettings($name)
    {
        try {
            if ($name) {
                if (Cache::has('organization_settings')) {
                    $settings = Cache::get('organization_settings');
                    return $settings[$name];

                } else {
                    Cache::forget('organization_settings');
                    $datas = [];
                    foreach (\Modules\Organization\Entities\OrganizationSetting::get() as $setting) {
                        $datas[$setting->key] = $setting->value;
                    }
                    Cache::rememberForever('organization_settings', function () use ($datas) {
                        return $datas;
                    });
                    $settings = Cache::get('organization_settings');
                    return $settings[$name];
                }
            } else {
                return false;
            }

        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('availableRolesForBadges')) {
    function availableRolesForBadges($name)
    {
        try {
            $roles = Role::where('id', '!=', 1)->get();
            if ($name == 'activity' || $name == 'registration') {
                $roles = $roles->pluck('name')->toArray();
                $availableRoles = implode(', ', $roles);
            } elseif ($name == 'courses' || $name == 'rating' || $name == 'sales' || $name == 'blogs') {
                $roles = $roles->where('id', '!=', 3)->pluck('name')->toArray();
                $availableRoles = implode(', ', $roles);
            } elseif ($name == 'learning' || $name == 'test' || $name == 'assignment' || $name == 'performance' || $name == 'survey' || $name == 'comment' || $name == 'certification') {
                $roles = $roles->where('id', 3)->pluck('name')->toArray();
                $availableRoles = implode(', ', $roles);
            }
            return $availableRoles;

        } catch (\Exception $exception) {
            return false;
        }
    }
}


if (!function_exists('checkGamificationReg')) {
    function checkGamificationReg()
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            return false;
        }
        $reg_badges = Badge::select('id', 'title', 'image', 'point')->where('type', 'registration')->where(function ($query) {
            $totalDay = 0;
            if (Auth::check()) {
                $created = new \Illuminate\Support\Carbon(Auth::user()->created_at);
                $now = Carbon::now();
                $totalDay = $now->diffInDays($created);
            }
            $query->where('point', '<=', $totalDay);
        })->orderBy('point', 'asc')->get();


        foreach ($reg_badges as $badge) {
            if (Settings('gamification_status') && Settings('gamification_badges_status') && Settings('gamification_badges_registration_status')) {

                $userBadge = UserBadge::updateOrCreate([
                    'user_id' => Auth::id(),
                    'badge_id' => $badge->id,
                ]);
                if ($userBadge->wasRecentlyCreated) {
                    $badge_notification_title = trans('common.A new badge has been unlocked');
                    Toastr::success($badge_notification_title, trans('common.Congratulations'));
                    $details = [
                        'title' => $badge_notification_title,
                        'body' => $badge_notification_title,
                        'actionText' => '',
                        'actionURL' => '#',
                    ];
                    Notification::send(Auth::user(), new GeneralNotification($details));
                }
            }
        }


    }
}

if (!function_exists('pluralize')) {
    function pluralize($quantity, $singular, $plural = null)
    {
        if ($quantity == 1 || !strlen($singular)) return $singular;
        if ($plural !== null) return $plural;

        $last_letter = strtolower($singular[strlen($singular) - 1]);
        switch ($last_letter) {
            case 'y':
                return substr($singular, 0, -1) . 'ies';
            case 's':
                return $singular . 'es';
            default:
                return $singular . 's';
        }
    }
}
