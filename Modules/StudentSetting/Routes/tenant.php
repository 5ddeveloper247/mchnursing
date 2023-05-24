<?php

Route::group(['prefix' => 'admin/student', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/allStudent', 'StudentSettingController@index')->name('student.student_list')->middleware('RoutePermissionCheck:student.student_list');
    Route::post('/storeAgreementForm', 'StudentSettingController@storeAgreementForm')->name('storeAgreementForm');
    Route::post('/changeStudentFormStatus', 'StudentSettingController@changeStudentFormStatus')->name('changeStudentFormStatus');
    Route::post('/store', 'StudentSettingController@store')->name('student.store')->middleware('RoutePermissionCheck:student.store');
    Route::get('/edit/{id}', 'StudentSettingController@edit')->middleware('RoutePermissionCheck:student.edit');
    Route::post('/update', 'StudentSettingController@update')->name('student.update')->middleware('RoutePermissionCheck:student.edit');
    Route::post('/destroy', 'StudentSettingController@destroy')->name('student.delete')->middleware('RoutePermissionCheck:student.delete');

    Route::group(['prefix' => 'view'], function () {
        Route::get('/{id}', 'StudentViewController@index')->name('student.student.view');
        Route::post('detail', 'StudentViewController@StudentDetail')->name('student.student.detail');
        Route::post('application', 'StudentViewController@StudentApplication')->name('student.student.application');
        Route::post('authentication/agreement', 'StudentViewController@StudentAuthenticationAgreement')->name('student.student.authentication.agreement');
    });




    //  PROGRAM ROUTE END



    Route::get('/all/student-data', 'StudentSettingController@getAllStudentData')->name('student.getAllStudentData')->middleware('RoutePermissionCheck:student.student_list');

    Route::get('assign-courses/{id}', 'StudentSettingController@studentAssignedCourses')->name('student.courses')->middleware('RoutePermissionCheck:student.courses');

    Route::get('assign-programs/{id}', 'StudentSettingController@studentAssignedPrograms')->name('student.programs');

    Route::get('field', 'StudentSettingController@field')->name('student.student_field')->middleware('RoutePermissionCheck:student.student_field');

    Route::post('field/Store', 'StudentSettingController@fieldstore')->name('student.student_field_store')->middleware('RoutePermissionCheck:student.student_field');


    Route::get('/enroll-new', 'StudentSettingController@newEnroll')->name('student.new_enroll')->middleware('RoutePermissionCheck:student.new_enroll');
    Route::post('/enroll-new', 'StudentSettingController@newEnrollSubmit')->name('student.new_enroll_submit')->middleware('RoutePermissionCheck:student.new_enroll');


    Route::get('student-excel-download', 'StudentImportController@export')->name('student_excel_download');
    Route::get('country_list_download', 'StudentImportController@country_list_export')->name('country_list_download');

    Route::get('student-import', 'StudentImportController@index')->name('student_import')->middleware('RoutePermissionCheck:student_import');
    Route::post('student-import', 'StudentImportController@store')->name('student_import_save')->middleware('RoutePermissionCheck:student_import');

    Route::get('regular_student-import', 'StudentImportController@regular')->name('regular_student_import')->middleware('RoutePermissionCheck:regular_student_import');
    Route::post('regular_student-import', 'StudentImportController@regularStore')->name('regular_student_import_save')->middleware('RoutePermissionCheck:regular_student_import');
    Route::get('regular_student-excel-download', 'StudentImportController@regularStudentexport')->name('regular_student_excel_download')->middleware('RoutePermissionCheck:regular_student_import');
    Route::get('skillgroup/{id}', 'StudentSettingController@Skill_group')->name('student.skillgroup');
});


Route::group(['prefix' => 'student/dashboard', 'middleware' => ['auth', 'student']], function () {


    Route::get('/bookmarkSave/{id}', 'BookmarkController@bookmarkSave')->name('bookmarkSave');
    Route::get('/bookmarksDelete/{id}', 'BookmarkController@bookmarksDelete');
    Route::get('/bookmarks/show/{id}', 'BookmarkController@show');
});
Route::group(['prefix' => 'admin/program', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/program-students/{program_id}', 'StudentSettingController@enrolled_students')->name('program.enrolled_students');
    Route::get('/program-students-list/{program_id}', 'StudentSettingController@getAllProgramStudent')->name('program.getAllProgramStudent');
    Route::get('/program-student-notify/{course_id}/{student_id}', 'StudentSettingController@programStudentNotify')->name('program.programStudentNotify');
    //PROGRAMM ROUTE
    Route::get('/getallprogram', 'StudentSettingController@getAllProgram')->name('getallprogram');
    Route::get('/getprogram/{id}', 'StudentSettingController@getProgram')->name('getprogram');
    Route::post('/addprogram', 'StudentSettingController@addprogram')->name('addprogram');
    Route::get('/add_new', 'StudentSettingController@add_new')->name('add_new');
    Route::get('/edit_program/{id}', 'StudentSettingController@edit_program')->name('edit_program');
    Route::get('/delete_program/{id}', 'StudentSettingController@delete_program')->name('delete_program');
    Route::post('/updateprogram', 'StudentSettingController@updateprogram')->name('updateprogram');

    Route::group(['prefix' => 'plan'], function () {
        Route::get('/', 'ProgramPaymentPlanController@index')->name('plan.plan');
        Route::get('/save', 'ProgramPaymentPlanController@save')->name('plan.save');
        Route::get('/get/all/plans', 'ProgramPaymentPlanController@getAllPlans')->name('plan.getAllPlans');
        Route::get('/get/{id}', 'ProgramPaymentPlanController@getPlan')->name('plan.getPlan');

        Route::group(['prefix' => 'detail'], function () {
            Route::get('/', 'ProgramPaymentPlanController@getPlanDetails')->name('plan.getPlandetails');
            Route::get('/get/{id}', 'ProgramPaymentPlanController@getPlanDetail')->name('plan.getPlandetail');
            Route::get('/save', 'ProgramPaymentPlanController@savePlanDetail')->name('plan.detail.save');
            Route::get('/delete_plan/{id}', 'ProgramPaymentPlanController@delete_plan')->name('plan.delete_plan');
            Route::get('/delete_payment_plan_detail/{id}', 'ProgramPaymentPlanController@delete_payment_plan_detail')->name('plan.delete_payment_plan_detail');
        });
    });
});
