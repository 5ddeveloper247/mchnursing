<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\FrontendManage\Entities\LoginPage;

Route::get('/test', 'Frontend\FrontendHomeController@test');

Auth::routes(['verify' => true]);
//clover
Route::get('get/clover/code', 'CloverController@getclovercode');
//clover

//cron
Route::get('run/cron/incoming_installment', 'CronController@incoming_installment');
Route::get('run/cron/previous_installment', 'CronController@previous_installment');
Route::get('run/cron/classes_reminder', 'CronController@classes_reminder');
Route::get('run/cron/quiz_reminder', 'CronController@quiz_reminder');
//cron


Route::get('send-password-reset-link', 'Auth\ForgotPasswordController@SendPasswordResetLink')->name('SendPasswordResetLink');
Route::get('reset-password', 'Auth\ForgotPasswordController@ResetPassword')->name('ResetPassword');
Route::get('register', 'Auth\RegisterController@RegisterForm')->name('register');
Route::get('register2', 'Auth\RegisterController@RegisterForm2')->name('register.2');
Route::get('register3', 'Auth\RegisterController@RegisterForm3')->name('register.3');
Route::get('register-pay', 'Auth\RegisterController@RegisterFormPay')->name('register.pay');
Route::post('register2', 'Auth\RegisterController@RegisterForm2Create')->name('register.2p');
Route::post('register3', 'Auth\RegisterController@RegisterForm3Create')->name('register.3p');
Route::post('register-pay', 'Auth\RegisterController@RegisterFormPayCreate')->name('register.payp');
Route::get('saas-signup', 'Auth\RegisterController@LmsRegisterForm')->name('lms_register');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::post('/resend', '\App\Http\Controllers\Auth\VerificationController@resend_mail')->name('verification_mail_resend');
Route::get('auto-login/{key}', '\App\Http\Controllers\Auth\LoginController@autologin')->name('auto.login');


// Route::get('/test', 'Frontend\FrontendHomeController@test');

Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/', 'FrontendHomeController@index')->name('frontendHomePage');

    Route::get('/get-courses-by-category/{category_id}', 'EdumeFrontendThemeController@getCourseByCategory')->name('getCourseByCategory');
    //wetech theme controller
    Route::get('/wetech/{route_name}', 'WeTechFrontendThemeController@route')->name('weTechController');

    Route::get('/offline', 'WebsiteController@offline')->name('offline');

    //    Route::get('/footer/page/{slug}', 'WebsiteController@page')->name('dynamic.page');
    Route::get('/about-us', 'WebsiteController@aboutData')->name('about');
    Route::get('/contact-us', 'WebsiteController@contact')->name('contact');
    Route::get('/contact', 'WebsiteController@contactUs')->name('contact-us');
    Route::get('/new-page', 'WebsiteController@newPage')->name('new-page');
    Route::get('/application-requirements', 'WebsiteController@application_requirements')->name('application-requirements');

    Route::post('/contact-submit', 'WebsiteController@contactMsgSubmit')->name('contactMsgSubmit');
    Route::get('privacy', 'WebsiteController@privacy')->name('privacy');
    Route::get('calendar-view', 'WebsiteController@calendarView')->name('calendar-view');

    Route::get('instructors', 'InstructorController@instructors')->name('instructors');
    Route::get('become-instructor', 'InstructorController@becomeInstructor')->name('becomeInstructor');
    Route::get('instructorDetails/{id}/{name}', 'InstructorController@instructorDetails')->name('instructorDetails');

    Route::get('tutorDetails/{id}/{name}', 'InstructorController@tutorDetails')->name('tutorDetails');
    Route::get('tutorBooking/{id}', 'InstructorController@tutorBooking')->name('tutorBooking')->middleware('auth');
    Route::post('tutorPayment', 'InstructorController@tutorPayment')->name('tutorPayment')->middleware('auth');
    Route::post('tutorPaymentSubmit', 'InstructorController@tutorPaymentSubmit')->name('tutorPaymentSubmit')->middleware('auth');
    Route::post('checkAvailableSlots', 'InstructorController@checkAvailableSlots')->name('checkAvailableSlots')->middleware('auth');



    Route::get('courses', 'CourseController@courses')->name('courses');
    Route::get('offer', 'CourseController@offer')->name('offer');
    Route::get('courses-details/{slug}', 'CourseController@courseDetails')->name('courseDetailsView');

    Route::get('free-course', 'CourseController@freeCourses')->name('freeCourses');

    Route::get('classes', 'ClassController@classes')->name('classes');
    Route::get('class-details/{slug}', 'ClassController@classDetails')->name('classDetails');
    Route::get('class-start/{slug}/{host}/{meeting_id}', 'ClassController@classStart')->name('classStart');

    Route::get('program', 'ProgramController@programs')->name('programs');
    Route::get('program-detail/{id}', 'ProgramController@programsDetail')->name('programs.detail');

    Route::get('quizzes', 'QuizController@quizzes')->name('quizzes');
    Route::get('quiz-details/{slug}', 'QuizController@quizDetails')->name('quizDetailsView');
    Route::get('quizStart/{id}/{quiz_id}/{slug}', 'QuizController@quizStart')->name('quizStart');
    Route::post('quizSubmit', 'QuizController@quizSubmit')->name('quizSubmit');
    Route::post('quizTestStart', 'QuizController@quizTestStart')->name('quizTestStart')->middleware('auth');
    Route::post('singleQuizSubmit', 'QuizController@singleQuizSubmit')->name('singleQuizSubmit')->middleware('auth');
    Route::get('quizResult/{id}', 'QuizController@quizResult')->name('getQuizResult');
    Route::get('quizResultPreview/{id}', 'QuizController@quizResultPreview')->name('quizResultPreview');
    Route::get('quizResultPreviewApi/{quiz_id}', 'QuizController@quizResultPreviewApi')->name('quizResultPreviewApi')->middleware('auth');


    Route::get('search', 'WebsiteController@search')->name('search');
    Route::get('category/{id}/{name}', 'WebsiteController@categoryCourse')->name('categoryCourse');
    Route::get('sub_category/{id}/{slug}', 'WebsiteController@subCategoryCourse')->name('subCategory.course');

    Route::get('/certificate-verification', 'WebsiteController@searchCertificate')->name('searchCertificate');
    Route::post('/certificate-verification', 'WebsiteController@showCertificate')->name('showCertificate');
    Route::get('/verify-certificate/{number}', 'WebsiteController@certificateCheck')->name('certificateCheck');
    Route::get('/download-certificate/{number}', 'WebsiteController@certificateDownload')->name('certificateDownload');

    Route::get('articles', 'BlogController@allBlog')->name('blogs');
    Route::get('blog-details/{slug}', 'BlogController@blogDetails')->name('blogDetails');
    Route::post('blog-comment-submit', 'BlogController@blogCommentSubmit')->name('blogCommentSubmit');
    Route::post('blog-comment-delete/{id}', 'BlogController@deleteBlogComment')->name('deleteBlogComment');
    Route::get('load-blog-data', 'BlogController@loadMoreData')->name('load-blog-data');

    Route::get('/addToCart/{id}', 'WebsiteController@addToCart')->name('addToCart');
    Route::get('/buyNow/{id}', 'WebsiteController@buyNow')->name('buyNow');
    Route::get('/addToCart/quiz/{id}', 'WebsiteController@addToCartQuiz')->name('addToCartQuiz');
    Route::get('/buyNow/quiz/{id}', 'WebsiteController@buyNowQuiz')->name('buyNowQuiz');
    Route::post('enrollOrCart/{id}', 'WebsiteController@enrollOrCart')->name('enrollOrCart');
    Route::get('my-cart', 'WebsiteController@myCart')->name('myCart');
    Route::get('ajaxCounterCity', 'WebsiteController@ajaxCounterCity')->name('ajaxCounterCity');
    Route::get('ajaxCounterState', 'WebsiteController@ajaxCounterState')->name('ajaxCounterState');
    Route::get('/home/removeItem/{id}', 'WebsiteController@removeItem')->name('removeItem');
    Route::get('/home/removeItemAjax/{id}', 'WebsiteController@removeItemAjax')->name('removeItemAjax');
    Route::post('/submit_ans', 'WebsiteController@submitAns')->name('submitAns');

    Route::get('referral/{code}', 'ReferalController@referralCode')->name('referralCode');
    Route::get('referral', 'ReferalController@referral')->name('referral');


    Route::get('pages/{slug}', 'WebsiteController@frontPage');
    Route::fallback('WebsiteController@frontPage')->name('frontPage');
    Route::post('subscribe', 'WebsiteController@subscribe')->name('subscribe');
    Route::get('getItemList', 'WebsiteController@getItemList')->name('getItemList');

    //subscription module
    Route::get('/course/subscription', 'WebsiteController@subscription')->name('courseSubscription');
    Route::get('/course/subscription/{plan_id}', 'WebsiteController@subscriptionCourseList')->name('subscriptionCourseList');
    Route::get('/course-subscription/checkout', 'WebsiteController@subscriptionCheckout')->name('courseSubscriptionCheckout')->middleware(['auth']);
    Route::get('/subscription-courses', 'WebsiteController@subscriptionCourses')->name('subscriptionCourses');
    Route::get('/continue-course/{slug}', 'WebsiteController@continueCourse')->name('continueCourse');

    //saas module
    Route::get('/saas-packages', 'FrontendSaasController@index')->name('saasPackages');
    Route::get('/saas-packages/checkout', 'FrontendSaasController@saasCheckout')->name('saasCheckout');


    //org subscription module
    Route::get('/org-subscription-courses', 'WebsiteController@orgSubscriptionCourses')->name('orgSubscriptionCourses');
    Route::get('/org-subscription-plan-list/{id}', 'WebsiteController@orgSubscriptionPlanList')->name('orgSubscriptionPlanList');


    Route::post('comment', 'CommentController@saveComment')->name('saveComment')->middleware('auth');
    Route::post('commentAjax', 'CommentController@saveCommentAjax')->name('saveCommentAjax')->middleware('auth');
    Route::post('comment-replay', 'CommentController@submitCommnetReply')->name('submitCommnetReply')->middleware('auth');
    Route::post('comment-replay-ajax', 'CommentController@submitCommnetReplyAjax')->name('submitCommnetReplyAjax')->middleware('auth');
    Route::post('comment-delete/{id}', 'CommentController@deleteComment')->name('deleteComment')->middleware('auth');
    Route::post('review-delete/{id}', 'CommentController@deleteReview')->name('deleteReview')->middleware('auth');
    Route::post('review-tutor-delete/{id}', 'CommentController@deleteTutorReview')->name('deleteTutorReview')->middleware('auth');
    Route::post('comment-replay-delete/{id}', 'CommentController@deleteCommnetReply')->name('deleteCommentReply')->middleware('auth');
});
Route::group(['prefix' => 'saas', 'middleware' => ['auth']], function () {
    Route::post('payment', 'SaasPaymentController@payment')->name('saasPayment');
    Route::post('submit', 'SaasPaymentController@subscriptionSubmit')->name('saasSubmit');
    Route::get('paypalSaasSuccess', 'SaasPaymentController@paypalSubscriptionSuccess')->name('paypalSaasSuccess');
    Route::get('paypalSaasFailed', 'SaasPaymentController@paypalSubscriptionFailed')->name('paypalSaasFailed');
});

Route::group(['namespace' => 'Frontend', 'middleware' => ['student']], function () {
    Route::get('student-dashboard', 'StudentController@myDashboard')->name('studentDashboard');
    Route::get('my-programs', 'StudentController@myCourses')->name('myCourses');
    Route::get('my-program-payment-plan/{program_id}', 'StudentController@myProgramPaymentPlan')->name('my.program.payment.plan');
    Route::get('my-payment-plan-installment/{installment_id}', 'StudentController@myPaymentPlanInstallment')->name('my.payment.plan.installment');
    Route::post('my-payment-plan-installment-payment', 'StudentController@myPaymentPlanInstallmentPayment')->name('my.payment.plan.installment.payment');
    Route::get('my-classes', 'StudentController@myCourses')->name('myClasses');
    Route::get('my-online-course', 'StudentController@myCourses')->name('myOnlineCourse');
    Route::get('my-offline-course', 'StudentController@myCourses')->name('myOfflineCourse');
    Route::get('my-quizzes', 'StudentController@myCourses')->name('myQuizzes');
    Route::get('my-tutors', 'TutorController@myTutors')->name('myTutors');
    Route::get('my-report', 'StudentController@myReports')->name('myReports');
    Route::get('my-certificate', 'StudentController@myCertificate')->name('myCertificate');
    Route::get('my-assignment', 'StudentController@myAssignment')->name('myAssignment')->middleware('RoutePermissionCheck:myAssignment');
    Route::get('my-assignment/{id}', 'StudentController@myAssignmentDetails')->name('myAssignment_details')->middleware('RoutePermissionCheck:myAssignment');
    Route::get('my-wishlist', 'StudentController@myWishlists')->name('myWishlists');
    Route::get('my-purchases', 'StudentController@myPurchases')->name('myPurchases');
    Route::get('enrollment-cancellation', 'StudentController@enrollmentCancellation')->name('enrollmentCancellation');
    Route::post('enrollment-cancellation', 'StudentController@enrollmentCancellationSubmit')->name('enrollmentCancellationSubmit');
    Route::get('my-bundle', 'StudentController@myBundle')->name('myBundle');
    Route::get('topic-report/{id}', 'StudentController@topicReport')->name('topicReport');
    Route::get('my-profile', 'StudentController@myProfile')->name('myProfile');
    Route::post('upload-user_form/{id}', 'StudentController@uploadUserForm')->name('uploadUserForm');
    Route::any('ajax-update-profile-image', 'StudentController@ajaxUploadProfilePic')->name('ajaxUploadProfilePic');
    Route::post('my-profile-update', 'StudentController@myProfileUpdate')->name('myProfileUpdate');
    Route::get('my-account', 'StudentController@myAccount')->name('myAccount');
    Route::post('my-password-update', 'StudentController@MyUpdatePassword')->name('MyUpdatePassword');
    Route::post('my-account-delete', 'StudentController@MyAccountDelete')->name('MyAccountDelete');
    Route::post('my-email-update', 'StudentController@MyEmailUpdate')->name('MyEmailUpdate');
    Route::post('reword-point-convert', 'StudentController@rewardPontConvert')->name('rewardPontConvert');

    Route::get('deposit', 'StudentController@deposit')->name('deposit');
    Route::post('deposit', 'StudentController@deposit')->name('depositSelectOption');
    Route::get('logged-in/devices', 'StudentController@loggedInDevices')->name('logged.in.devices');
    Route::post('logged-out/device', 'StudentController@logOutDevice')->name('log.out.device');
    Route::get('invoice/{id}', 'StudentController@Invoice')->name('invoice');
    Route::get('subscription-invoice/{id}', 'StudentController@subInvoice')->name('subInvoice');
    Route::get('StudentApplyCoupon', 'StudentController@StudentApplyCoupon')->name('StudentApplyCoupon');
    Route::get('checkout', 'StudentController@CheckOut')->name('CheckOut');
    Route::get('remove-profile-pic', 'StudentController@removeProfilePic')->name('removeProfilePic');
    Route::get('course-certificate/{id}/{slug}', 'StudentController@getCertificate')->name('getCertificate');
    Route::post('/submitReview', 'StudentController@submitReview')->name('submitReview');
    Route::post('/submitTutorReview', 'StudentController@submitTutorReview')->name('submitTutorReview');

    Route::get('my-study-materials', 'StudyMaterialController@myHomework')->name('myHomework');
    Route::get('my-study-materials/{id}', 'StudyMaterialController@myHomeworkDetails')->name('myHomework_details');


    Route::get('my-leaderboard', 'StudentController@leaderboard')->name('my-leaderboard');
    Route::get('my-skill', 'StudentSkillController@mySkill')->name('mySkill');
});
Route::group(['middleware' => ['student']], function () {
    Route::get('my-notification-setup', 'NotificationController@myNotificationSetup')->name('myNotificationSetup');
    Route::get('my-notifications', 'NotificationController@myNotification')->name('myNotification');
});


//in this controller we can use for place order
Route::group(['prefix' => 'order', 'middleware' => ['auth']], function () {
    Route::post('clover', 'PaymentController@cloverpayment')->name('cloverpayment');
    Route::post('submit', 'PaymentController@makePlaceOrder')->name('makePlaceOrder');
    Route::get('/payment', 'PaymentController@payment')->name('orderPayment');
    Route::post('/paymentSubmit', 'PaymentController@paymentSubmit')->name('paymentSubmit');
    //paypal url
    Route::get('paypal/success', 'PaymentController@paypalSuccess')->name('paypalSuccess');
    Route::get('paypal/failed', 'PaymentController@paypalFailed')->name('paypalFailed');
});
//deposit
Route::group(['prefix' => 'deposit', 'middleware' => ['auth']], function () {

    Route::post('submit', 'DepositController@depositSubmit')->name('depositSubmit');
    Route::get('paypalDepositSuccess', 'DepositController@paypalDepositSuccess')->name('paypalDepositSuccess');
    Route::get('paypalDepositFailed', 'DepositController@paypalDepositFailed')->name('paypalDepositFailed');
});

Route::group(['prefix' => 'subscription', 'middleware' => ['auth']], function () {
    Route::post('payment', 'SubscriptionPaymentController@payment')->name('subscriptionPayment');
    Route::post('submit', 'SubscriptionPaymentController@subscriptionSubmit')->name('subscriptionSubmit');
    Route::get('paypalSubscriptionSuccess', 'SubscriptionPaymentController@paypalSubscriptionSuccess')->name('paypalSubscriptionSuccess');
    Route::get('paypalSubscriptionFailed', 'SubscriptionPaymentController@paypalSubscriptionFailed')->name('paypalSubscriptionFailed');
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');
    Route::get('getDashboardData', 'HomeController@getDashboardData')->name('getDashboardData')->middleware('RoutePermissionCheck:dashboard');
    Route::get('userLoginChartByDays', 'HomeController@userLoginChartByDays')->name('userLoginChartByDays');
    Route::get('userLoginChartByTime', 'HomeController@userLoginChartByTime')->name('userLoginChartByTime');
    Route::get('/validateGenerate', 'HomeController@validateGenerate')->name('validateGenerate');
    Route::post('/validateGenerate', 'HomeController@validateGenerateSubmit')->name('validateGenerateSubmit');
    Route::post('lesson-complete', 'Frontend\WebsiteController@lessonComplete')->name('lesson.complete');
    Route::any('lesson-complete-ajax', 'Frontend\WebsiteController@lessonCompleteAjax')->name('lesson.complete.ajax');

    Route::get('ajaxNotificationMakeRead', 'NotificationController@ajaxNotificationMakeRead')->name('ajaxNotificationMakeRead');
    Route::get('NotificationMakeAllRead', 'NotificationController@NotificationMakeAllRead')->name('NotificationMakeAllRead');
    Route::get('notification-delete/{id}', 'NotificationController@delete')->name('notificationDelete');
});
Route::get('fullscreen-view/{course_id}/{lesson_id}', 'Frontend\WebsiteController@fullScreenView')->name('fullScreenView');


//Admin Routes Here
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {


    Route::post('/get-user-data/{id}', 'AdminController@getUserDate')->name('getUserDate');


    Route::get('/reveune-list', 'AdminController@reveuneList')->name('reveuneList')->middleware('RoutePermissionCheck:admin.reveuneList');
    Route::get('/reveuneListInstructor', 'AdminController@reveuneListInstructor')->name('reveuneListInstructor')->middleware('RoutePermissionCheck:admin.reveuneListInstructor');
    //
    Route::get('/enrol-list', 'AdminController@enrollLogs')->name('enrollLogs')->middleware('RoutePermissionCheck:admin.enrollLogs');
    Route::get('/cancel-list', 'AdminController@cancelLogs')->name('cancelLogs')->middleware('RoutePermissionCheck:admin.enrollLogs');

    Route::get('/enrol-delete/{id}', 'AdminController@enrollDelete')->name('enrollDelete')->middleware('RoutePermissionCheck:admin.enrollLogs');
    Route::get('/instructor-payout', 'AdminController@instructorPayout')->name('instructor.payout')->middleware('RoutePermissionCheck:admin.instructor.payout');
    Route::post('/instructor-payout-request', 'AdminController@instructorRequestPayout')->name('instructor.instructorRequestPayout')->middleware('RoutePermissionCheck:admin.instructor.payout');
    Route::post('/instructor-payout-complete', 'AdminController@instructorCompletePayout')->name('instructor.instructorCompletePayout')->middleware('RoutePermissionCheck:admin.instructor.payout');
    Route::get('/enrollFilter', 'AdminController@enrollLogs');
    Route::post('/enrollFilter', 'AdminController@enrollFilter')->name('enrollFilter');
    Route::get('/courseEnrolls/{id}', 'AdminController@courseEnrolls')->name('enrollLog');
    Route::post('/courseEnrolls/{id}', 'AdminController@sortByDiscount')->name('sortByDiscount');

    Route::get('/all/enrol-list-data', 'AdminController@getEnrollLogsData')->name('getEnrollLogsData')->middleware('RoutePermissionCheck:admin.enrollLogs');
    Route::get('/all/enrol-list-data-quiz', 'AdminController@getEnrollLogsQuiz')->name('getEnrollLogsQuiz');
    Route::get('/all/cancel-list-data', 'AdminController@getCancelLogsData')->name('getCancelLogsData')->middleware('RoutePermissionCheck:admin.enrollLogs');
    Route::get('/all/cancel-program-list-data', 'AdminController@getCancelProgramLogsData')->name('getCancelProgramLogsData');
    Route::get('/all/payout-data', 'AdminController@getPayoutData')->name('getPayoutData');
});



Route::group(['namespace' => 'Admin', 'prefix' => 'course', 'as' => 'course.', 'middleware' => ['auth', 'admin']], function () {


    Route::get('categories', 'CourseController@category')->name('category')->middleware('RoutePermissionCheck:course.category');
    Route::post('categories/status-update', 'CourseController@category_status_update')->name('category.status_update')->middleware('RoutePermissionCheck:course.category.status_update');
    Route::post('categories/store', 'CourseController@category_store')->name('category.store')->middleware('RoutePermissionCheck:course.category.store');
    Route::post('categories/update', 'CourseController@category_update')->name('category.update')->middleware('RoutePermissionCheck:course.category.edit');
    Route::get('categories/edit/{id}', 'CourseController@category_edit')->name('category.edit')->middleware('RoutePermissionCheck:course.category.edit');
    Route::get('categories/delete/{id}', 'CourseController@category_delete')->name('category.delete')->middleware('RoutePermissionCheck:course.category.delete');


    Route::get('sub-categories', 'CourseController@sub_category')->name('subcategory')->middleware('RoutePermissionCheck:course.subcategory');
    Route::post('sub-categories/status-update', 'CourseController@sub_category_status_update')->name('subcategory.status_update')->middleware('RoutePermissionCheck:course.subcategory.status_update');
    Route::post('sub-categories/store', 'CourseController@sub_category_store')->name('subcategory.store')->middleware('RoutePermissionCheck:course.subcategory.store');
    Route::post('sub-categories/update', 'CourseController@sub_category_update')->name('subcategory.update')->middleware('RoutePermissionCheck:course.subcategory.edit');
    Route::get('sub-categories/edit/{id}', 'CourseController@sub_category_edit')->name('subcategory.edit')->middleware('RoutePermissionCheck:course.subcategory.edit');
    Route::get('sub-categories/delete/{id}', 'CourseController@sub_category_delete')->name('subcategory.delete')->middleware('RoutePermissionCheck:course.subcategory.delete');
});
Route::get('status-enable-disable', 'AjaxController@statusEnableDisable')->name('statusEnableDisable')->middleware(['auth']);

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('profile-settings', 'UserController@changePassword')->name('changePassword');
    Route::post('profile-settings', 'UserController@UpdatePassword')->name('updatePassword');
    Route::post('profile-update', 'UserController@update_user')->name('update_user');
});
//Route::post('get-user-by-role', 'UserController@getUsersByRole')->name('getUsersByRole')->middleware('auth');

Route::group(['namespace' => 'Admin', 'prefix' => 'communication', 'as' => 'communication.', 'middleware' => ['auth', 'admin']], function () {
    Route::get('private-messages', 'CommunicationController@PrivateMessage')->name('PrivateMessage');
    Route::get('questions-answer', 'CommunicationController@QuestionAnswer')->name('QuestionAnswer')->middleware('RoutePermissionCheck:communication.QuestionAnswer');
    Route::any('StorePrivateMessage', 'CommunicationController@StorePrivateMessage')->name('StorePrivateMessage');
    Route::post('getMessage', 'CommunicationController@getMessage')->name('getMessage');
});


Route::get('change-language/{language_code}', 'UserController@changeLanguage')->name('changeLanguage');
Route::get('secret-login/{user_id}', 'UserController@secretLogin')->name('secretLogin');
Route::get('secret-login-exit', 'UserController@secretLoginExit')->name('secretLoginExit');
Route::post('/search', 'SearchController@search')->name('routeSearch');

Route::prefix('filepond/api')->group(function () {
    Route::post('/process', 'FilepondController@upload')->name('filepond.upload');
    Route::patch('/process', 'FilepondController@chunk')->name('filepond.chunk');
    Route::delete('/process', 'FilepondController@delete')->name('filepond.delete');
});
Route::get('get_preview_modal/{id}', 'AjaxController@get_preview_modal')->name('get_preview_modal');
Route::get('ajaxGetSubCategoryList', 'AjaxController@ajaxGetSubCategoryList')->name('ajaxGetSubCategoryList');
Route::get('ajaxGetCourseList', 'AjaxController@ajaxGetCourseList')->name('ajaxGetCourseList');
Route::get('ajaxGetQuizList', 'AjaxController@ajaxGetQuizList')->name('ajaxGetQuizList');
Route::get('update-activity', 'AjaxController@updateActivity')->name('updateActivity');
Route::get('get_preview_modal/{id}', 'AjaxController@get_preview_modal')->name('get_preview_modal');
Route::get('get_cart_price', 'AjaxController@get_cart_price')->name('get_cart_price');

Route::post('summer-note-file-upload', 'UploadFileController@upload_image')->name('summerNoteFileUpload');


//auth adding
Route::get('auth/social', 'Auth\LoginController@showLoginForm')->name('social.login');
Route::get('oauth/{driver}', 'Auth\LoginController@redirectToProvider')->name('social.oauth');
Route::get('oauth/{driver}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');

Route::get('vimeo/video/{vimeo_id}', 'Frontend\WebsiteController@vimeoPlayer')->name('vimeoPlayer');
Route::get('scorm/video/{lesson_id}/{id}', 'Frontend\WebsiteController@scormPlayer')->name('scormPlayer');
Route::get('document/video/{lesson_id}', 'Frontend\WebsiteController@documentPlayer')->name('documentPlayer');
Route::get('get-dynamic-data', 'Frontend\ThemeDynamicData')->name('getDynamicData');
