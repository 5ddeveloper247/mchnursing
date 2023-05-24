<?php

namespace App;

use Carbon\Carbon;
use App\Models\LmsInstitute;
use App\Traits\UserChatMethods;
use Illuminate\Support\Facades\Auth;
use Modules\Forum\Entities\Forum;
use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Log;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgPosition;
use Modules\Forum\Entities\ForumReply;
use Modules\Payment\Entities\Checkout;
use Modules\Payment\Entities\Withdraw;
use Illuminate\Support\Facades\Session;
use Modules\Setting\Entities\UserBadge;
use Modules\StudentSetting\Entities\TutorReveiws;
use Modules\UserType\Entities\UserRole;
use Illuminate\Notifications\Notifiable;
use Modules\Payment\Entities\Subscriber;
use Modules\RolePermission\Entities\Role;
use Modules\Survey\Entities\SurveyAssign;
use Modules\SystemSetting\Entities\Staff;
use Modules\CourseSetting\Entities\Course;
use Modules\Localization\Entities\Language;
use Modules\SystemSetting\Entities\Message;
use Modules\Affiliate\Entities\ReferralUser;
use Modules\StudentSetting\Entities\Program;
use Modules\SystemSetting\Entities\Currency;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Modules\HumanResource\Entities\ApplyLeave;
use Modules\HumanResource\Entities\Attendance;
use Modules\Payment\Entities\InstructorPayout;
use Modules\Setting\Entities\UserLevelHistory;
use Modules\HumanResource\Entities\LeaveDefine;
use App\Notifications\PasswordResetNotification;
use Modules\CourseSetting\Entities\CourseReveiw;
use Modules\Quiz\Entities\StudentTakeOnlineQuiz;
use Modules\Affiliate\Entities\AffiliateWithdraw;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Affiliate\Entities\AffiliateUserWallet;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\OfflinePayment\Entities\OfflinePayment;
use Modules\OrgInstructorPolicy\Entities\OrgPolicy;
use Modules\Setting\Entities\UserGamificationPoint;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Organization\Entities\OrganizationEmployee;
use Modules\Affiliate\Entities\AffiliateReferralPayment;

//class User extends Authenticatable
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, UserChatMethods;

    protected $connection = 'mysql';

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        if (isModuleActive('LmsSaasMD') && SaasDomain() != "main") {
            $this->setConnection('mysql_md');
        }
    }

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['first_name', 'last_name', 'blocked_by_me'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class)->withDefault();
    }

    public function offlinePayments()
    {
        return $this->hasMany(OfflinePayment::class, 'user_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscriber::class, 'user_id', 'id')->whereDate('valid', '>=', Carbon::now());
    }


    public function enrolls()
    {
        return $this->hasManyThrough(CourseEnrolled::class, Course::class);
    }

    public function withdraws()
    {
        return $this->hasMany(Withdraw::class, 'instructor_id');
    }


    public function earnings()
    {
        return $this->hasMany(InstructorPayout::class, 'instructor_id');
    }

    public function forumReply()
    {
        return $this->hasMany(ForumReply::class, 'user_id');
    }

    public function forums()
    {
        return $this->hasMany(Forum::class, 'created_by');
    }

    public function gettotalEarnAttribute()
    {

        return round($this->earnings()->sum('reveune'), 2);
    }

    public function checkouts()
    {
        return $this->hasMany(Checkout::class, 'user_id', 'id');
    }
    public function lastMessage()
    {
        $message = Message::where('sender_id', $this->id)->orWhere('reciever_id', $this->id)->orderBy('id', 'desc')->first();
        if ($message) {
            return $message;
        } else {
            return null;
        }
    }

    public function reciever()
    {
        return $this->hasOne(Message::class, 'reciever_id', 'id')->latest();
    }


    public function sender()
    {
        return $this->hasOne(Message::class, 'sender_id')->latest();
    }

    public function getmessageFormatAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function enrollCourse()
    {
        return $this->belongsToMany(Course::class, 'course_enrolleds', 'user_id', 'course_id');
    }

    public function enrollProgrom()
    {
        return $this->belongsToMany(Program::class, 'course_enrolleds', 'user_id', 'program_id');
    }

    public function enCoursesInstance()
    {
        return $this->hasMany(CourseEnrolled::class)->whereNotNull('course_id')->groupBy(['course_id']);
    }
    public function enProgramsInstance()
    {
        return $this->hasMany(CourseEnrolled::class)->whereNotNull('program_id')->groupBy(['program_id']);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }


    public function recievers()
    {
        return $this->hasMany(Message::class, 'reciever_id')->latest();
    }

    public function senders()
    {
        return $this->hasMany(Message::class, 'sender_id')->latest();
    }

    public function userLanguage()
    {
        return $this->belongsTo(Language::class, 'language_id')->withDefault();
    }

    public function enrollStudents()
    {
        return $this->hasMany(CourseEnrolled::class)->EnrollStudent();
    }

    public function apiKey()
    {
        return $this->zoom_api_key_of_user;
    }

    public function apiSecret()
    {
        return $this->zoom_api_serect_of_user;
    }

    public function submittedExam()
    {
        return $this->hasOne(StudentTakeOnlineQuiz::class, 'student_id')->latest();
    }

    public function userCountry()
    {
        return $this->belongsTo(Country::class, 'country')->withDefault();
    }

    public function totalCourses()
    {
        $totalCourses = Course::where('user_id', '=', $this->id)->count();
        return $totalCourses;
    }

    public function totalEnrolled()
    {
        $totalEnrolled = Course::where('user_id', '=', $this->id)->sum('total_enrolled');
        return $totalEnrolled;
    }

    public function tutorReviews()
    {

        return $this->hasMany(TutorReveiws::class, 'instructor_id')
            ->select(
                'user_id',
                'instructor_id',
                'status',
                'comment',
                'star',
            );
    }
    public function userTutorReviews()
    {

        return $this->tutorReviews()->where('user_id',Auth::id());
    }
    public function totalRating()
    {

        $totalRatings['rating'] = 0;
        $ReviewList = DB::table('courses')
            ->join('course_reveiws', 'course_reveiws.course_id', 'courses.id')
            ->select('courses.id', 'course_reveiws.id as review_id', 'course_reveiws.star as review_star')
            ->where('courses.user_id', $this->id)
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

    public function sendEmailVerificationNotification()
    {
        if (!Session::has('reg_email')) {
            try {
                Session::put('reg_email', $this->email);
                $this->notify(new VerifyEmail());
            } catch (\Exception $e) {
                Log::error($e);
            }
        }
    }

    public function sendPasswordResetNotification($token)
    {
        try {
            $this->notify(new PasswordResetNotification($token));
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function stateDetails()
    {
        return $this->belongsTo(State::class, 'state')->withDefault();
    }

    public function cityDetails()
    {
        return $this->belongsTo(City::class, 'city')->withDefault();
    }

    public function stateName()
    {
        return $this->stateDetails->name;
    }

    public function cityName()
    {
        return $this->cityDetails->name;
    }

    public function totalSellCourse()
    {
        return $this->hasManyThrough(CourseEnrolled::class, Course::class, 'user_id', 'course_id', 'id');
    }

    public function totalReview()
    {
        return $this->hasManyThrough(CourseReveiw::class, Course::class, 'user_id', 'course_id', 'id');
    }

    public function routeNotificationForFcm($notification)
    {
        return $this->device_token;
    }

    public function position()
    {
        return $this->belongsTo(OrgPosition::class, 'org_position_code', 'code')->withDefault();
    }

    public function branch()
    {
        return $this->belongsTo(OrgBranch::class, 'org_chart_code', 'code')->withDefault();
    }

    public function policy()
    {
        return $this->belongsTo(OrgPolicy::class, 'policy_id')->withDefault();
    }

    public function totalCertificate()
    {
        return $this->hasMany(CertificateRecord::class, 'student_id')->count();
    }


    public function totalStudentCourses()
    {
        $enrolls = $this->hasMany(CourseEnrolled::class, 'user_id')->with('course')->get();
        $result['complete'] = 0;
        $result['process'] = 0;
        $result['total'] = $enrolls->count();
        foreach ($enrolls as $enroll) {
            if (!empty($enroll->course->id) && $enroll->course->loginUserTotalPercentage >= 100) {
                $result['complete']++;
            } else {
                $result['process']++;
            }
        }
        return $result;
    }

    public function category()
    {
        $courses = $this->courses;

        $category_ids = [];
        $category = [];
        foreach ($courses as $key => $course) {
            if (!array_search($course->category_id, $category_ids)) {
                $category_ids[] = $course->category_id;
                $category[] = $course->category->name;
            }
        }
        if (count($category) != 0) {
            $result = $category[0];
        } else {
            $result = 'N/A';
        }
        return $result;
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function leaves()
    {
        return $this->hasMany(ApplyLeave::class)->CarryForward();
    }

    public function leaveDefines()
    {
        return $this->hasMany(LeaveDefine::class, 'role_id', 'role_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function attendSurvey($survey)
    {
        $survey->participants->where('user_id', auth()->id())->first();
    }

    public function institute()
    {
        return $this->belongsTo(LmsInstitute::class, 'lms_id', 'id');
    }


    protected static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            if ($model->role_id == 2) {
                saasPlanManagement('instructor', 'create');
            }
            if ($model->role_id == 3) {
                saasPlanManagement('student', 'create');
            }
        });
        self::deleted(function ($model) {
            if ($model->role_id == 2) {
                saasPlanManagement('instructor', 'delete');
            }
            if ($model->role_id == 3) {
                saasPlanManagement('student', 'delete');
            }
        });
    }


    //    public function dropboxTokens(): \Illuminate\Database\Eloquent\Relations\HasMany
    //    {
    //        return $this->hasMany(DropBoxToken::class);
    //    }
    //
    //    public function dropboxToken(): \Illuminate\Database\Eloquent\Relations\HasOne
    //    {
    //        return $this->hasOne(DropBoxToken::class)->latest();
    //    }

    public function googleTokens(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GoogleToken::class);
    }

    public function googleToken(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(GoogleToken::class)->orderBy('id', 'desc');
    }

    public function isReferralUser()
    {
        return $this->hasOne(ReferralUser::class, 'user_id');
    }

    public function affiliateWallet()
    {
        return $this->hasOne(AffiliateUserWallet::class, 'user_id');
    }

    public function affiliateTransaction()
    {
        return $this->hasMany(AffiliateWithdraw::class, 'user_id');
    }

    public function affiliateCommissions()
    {
        return $this->hasMany(AffiliateReferralPayment::class, 'payment_to');
    }

    public function userRoles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function hasRole($role_id)
    {
        return $this->userRoles()->where('role_id', $role_id)->exists();
    }

    public function educations()
    {
        return $this->hasMany('Modules\Appointment\Entities\InstructorEducation', 'instructor_id', 'id');
    }

    public function schedules()
    {
        return $this->hasMany('Modules\Appointment\Entities\Schedule', 'user_id', 'id')->where('status', 1);
    }

    public function hasOneReview()
    {
        return $this->hasOne('Modules\Appointment\Entities\InstructorReview', 'instructor_id', 'id');
    }

    public function hasOneBooked()
    {
        return $this->hasOne('Modules\Appointment\Entities\Booking', 'user_id', 'id')->where('status', 1);
    }

    public function lastDayBooked()
    {
        return $this->hasMany('Modules\Appointment\Entities\Booking', 'instructor_id', 'id')
            ->where('created_at', '>=', Carbon::now()->subDay())->where('status', 1);
    }

    public function lastDayContact()
    {
        return $this->hasMany('Modules\Appointment\Entities\BookTrailLesson', 'instructor_id', 'id')
            ->where('created_at', '>=', Carbon::now()->subDay(1))->where('status', 1);
    }

    public function avgRating()
    {
        return $this->instructorReviews->avg('star');
    }

    public function instructorReviews()
    {
        return $this->hasMany('Modules\Appointment\Entities\InstructorReview', 'instructor_id', 'id')->latest();
    }

    public function timeSlots()
    {
        return $this->hasMany('Modules\Appointment\Entities\TimeSlot', 'user_id', 'id')->where('status', 1);
    }

    public function certificates()
    {
        return $this->hasMany('Modules\Appointment\Entities\InstructorCertificate', 'instructor_id', 'id');
    }

    public function certificateRecords()
    {
        return $this->hasMany(CertificateRecord::class, 'student_id', 'id');
    }

    public function experiences()
    {
        return $this->hasMany('Modules\Appointment\Entities\InstructorWorkExperience', 'instructor_id', 'id');
    }

    public function teachingCategories()
    {
        return $this->hasMany('Modules\Appointment\Entities\InstructorTeachingCategory', 'instructor_id', 'id');
    }

    public function teachingLanguages()
    {
        return $this->hasMany('Modules\Appointment\Entities\InstructorTeachingLanguage', 'instructor_id', 'id');
    }

    public function socials()
    {
        return $this->hasMany('Modules\Appointment\Entities\InstructorSocial', 'instructor_id', 'id');
    }

    public function cpds()
    {
        return $this->hasMany('Modules\CPD\Entities\AssignStudent', 'student_id', 'id');
    }

    public function classes()
    {
        return $this->hasMany('Modules\MyClass\Entities\ClassCourseAssignStudent', 'student_id', 'id');
    }

    public function totalCourse()
    {
        $class_id = $this->classes->pluck('class_id')->toArray();
        $total_course = \Modules\MyClass\Entities\ClassCourse::whereIn('class_id', $class_id)->get()->count();
        return $total_course;
    }

    public function bookStudents()
    {
        return $this->hasMany('Modules\Appointment\Entities\Booking', 'instructor_id', 'id')
            ->groupBy('user_id')->where('status', 1);
    }

    public function userBadges()
    {
        return $this->hasMany(UserBadge::class, 'user_id', 'id');
    }

    public function userLatestBadges()
    {
        return $this->hasMany(UserBadge::class, 'user_id', 'id')->latest();
    }

    public function studentCourses()
    {
        return $this->hasMany(CourseEnrolled::class, 'user_id', 'id');
    }

    public function userGamificationPoints()
    {
        return $this->hasMany(UserGamificationPoint::class, 'user_id',);
    }

    public function userLevelHistories()
    {
        return $this->hasMany(UserLevelHistory::class, 'user_id',);
    }

    public function organizationEmployee()
    {
        return $this->hasOne(OrganizationEmployee::class, 'user_id', 'id');
    }

    public function isSuperAdmin()
    {
        return $this->role_id == 1;
    }

    public function isInstructor(): bool
    {
        return $this->role_id == 2;
    }

    public function isStudent()
    {
        return $this->role_id == 3;
    }

    public function isStaff()
    {
        return $this->role_id == 4;
    }

    public function isOrganization()
    {
        return $this->role_id == 5;
    }

    public function totalOrganizationUsers()
    {
        return $this->hasMany(User::class, 'organization_id', 'id');
    }
}
