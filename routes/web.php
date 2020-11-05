<?php

// Route::post('login', 'Auth\LoginController@login')->name('login');
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::group(['namespace' => 'Admin'], function () {
    Route::get('login', 'LoginController@login')->name('login');
    Route::post('postLogin', 'LoginController@postLogin')->name('postLogin');
    Route::get('password-reset', 'PasswordResetController@resetForm')->name('password-reset');
    Route::post('send-email-link', 'PasswordResetController@sendEmailLink')->name('sendEmailLink');
    Route::get('reset-password/{token}', 'PasswordResetController@passwordResetForm')->name('passwordResetForm');
    Route::post('update-password', 'PasswordResetController@updatePassword')->name('updatePassword');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'namespace' => 'Admin',], function () {
    // prefix => admin makes url admin/
    // namespace => admin makes Admin/DashboardController@index

    Route::get('logout', 'LoginController@Logout')->name('logout');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::group(['middleware' => 'admin'], function () {
        Route::get('setting', 'SettingController@index')->name('setting');
        Route::put('setting/save/{id}', 'SettingController@update')->name('setting.update');
        Route::get('video-booking', 'BookingController@allBookings')->name('admin.allBookings');
        Route::get('booking/{bookingId}', 'BookingController@edit')->name('booking.edit');
        Route::put('booking/{bookingId}', 'BookingController@update')->name('booking.update');
        Route::get('report/daily', 'ReportController@daily_report')->name('admin.daily_report');
        Route::resource('refer', 'ReferController');
        Route::post('export-visitors', 'VisitorController@exportVisitors')->name('exportVisitors');
        Route::resource('visitor', 'VisitorController');
    });

    Route::group(['middleware' => ['role']], function () {
        Route::post('student-export', 'UserController@exportAllStudents')->name('exportAllStudents');
        Route::get('student', 'UserController@allCustomers')->name('admin.allCustomers');
        Route::get('student-edit/{id}', 'UserController@customerEdit')->name('customerEdit');
        Route::post('student-edit/{id}', 'UserController@customerUpdate')->name('customerUpdate');
        Route::resource('user', 'UserController');
        Route::resource('category', 'CategoryController');
        Route::resource('country', 'CountryController');
        Route::resource('year', 'YearController');
        Route::resource('academic', 'AcademicController');
        Route::resource('proficiency', 'ProficiencyController');
        Route::resource('scholarship', 'ScholarshipController');
        Route::resource('branch', 'BranchController');
        Route::resource('subscriber', 'SubscriberController');
        Route::resource('datetime', 'DateTimeController');

        Route::get('exhibitor/{id}/edit-info', 'ExhibitorController@edit_info')->name('exhibitor.edit_info');
        Route::resource('exhibitor', 'ExhibitorController');
        Route::put('exhibitor/{id}/edit-info', 'ExhibitorController@update_info')->name('exhibitor.update_info');
    });
});

Route::group(['namespace' => 'Front'], function () {
    Route::get('/', 'DefaultController@index')->name('home');
    Route::post('save-subscriber', 'DefaultController@saveSubscriber')->name('saveSubscriber');
    Route::get('exhibitors', 'DefaultController@allExhibitors')->name('allExhibitors');
    Route::get('scholarships', 'DefaultController@allScholarships')->name('allScholarships');
    Route::get('exhibition-hall', 'DefaultController@allExhibitionHalls')->name('allExhibitionHalls');
    Route::get('exhibitors/{slug}', 'DefaultController@exhibitorDetail')->name('exhibitorDetail');
    Route::get('institution/{id}', 'DefaultController@institutionDetail')->name('institutionDetail');
    Route::get('scholarship/{id}', 'DefaultController@scholarshipDetail')->name('scholarshipDetail');
    Route::get('account-activate/{activation_token}', 'CustomerController@VerifyNewAccount')->name('activate-account');

    Route::get('exhibitor-login', 'CustomerController@exhibitorLogin')->name('exhibitorLogin');
    Route::post('exhibitor-login', 'CustomerController@exhibitorPostLogin')->name('exhibitorPostLogin');
    Route::get('exhibitor-dashboard', 'CustomerController@exhibitorDashboard')->name('exhibitorDashboard');

    Route::post('customer-register', 'CustomerController@customerRegister')->name('customerRegister');
    Route::get('login-register', 'CustomerController@loginRegister')->name('loginRegister');

    /*
    * OTP required routes
    */

    Route::get('otp', 'CustomerController@getOTPLogin')->name('getOTPLogin');
    Route::post('verify/otp', 'CustomerController@verifyOTP')->name('verifyOTP');

    Route::post('customer-login', 'CustomerController@customerLogin')->name('customerLogin');
    Route::get('customer-logout', 'CustomerController@logout')->name('customerLogout');
    Route::get('exhibitor-logout', 'CustomerController@exhibitorLogout')->name('exhibitorLogout');
    Route::get('exhibitor-dashboard', 'CustomerController@exhibitorDashboard')->name('exhibitorDashboard');

    Route::group(['middleware' => ['customer'], 'prefix' => 'student'], function () {
        Route::get('dashboard', 'CustomerController@customerDashboard')->name('customerDashboard');
        Route::get('user-profile', 'CustomerController@customerProfile')->name('customerProfile');
        Route::post('user-profile/{id}', 'CustomerController@customerProfileUpdate')->name('customerProfileUpdate');
    });

    Route::get('time-by-date', 'CustomerController@get__time_by_date')->name('get__time_by_date');

    Route::group(['middleware' => ['exhibitor'], 'as' => 'front.', 'prefix' => 'exhibitor-detail'], function () {
        Route::get('exhibitor-show/{id}', 'ExhibitorController@show')->name('exhibitor.show');
        Route::get('exhibitor-edit/{exhibitor}/edit', 'ExhibitorController@edit_info')->name('exhibitor.edit');
    });

    Route::group(['middleware' => 'auth', 'prefix' => 'exhibitor-detail', 'as' => 'front.'], function () {
        Route::put('exhibitor/{id}/edit-info', 'ExhibitorController@update_info')->name('exhibitor.update_info');
        Route::get('{exhibitorId}/scholarship/list', 'ExhibitorController@scholarship_list')->name('scholarship.list');
        Route::get('{exhibitorId}/scholarship/create', 'ExhibitorController@scholarship_create')->name('scholarship.create');
        Route::post('{exhibitorId}/scholarship/store', 'ExhibitorController@scholarship_store')->name('scholarship.store');
        Route::get('{scholarshipId}/scholarship/edit', 'ExhibitorController@scholarship_edit')->name('scholarship.edit');
        Route::put('{scholarshipId}/scholarship/edit', 'ExhibitorController@scholarship_update')->name('scholarship.update');

        Route::get('{id}/datetime/list', 'ExhibitorController@datetime_list')->name('datetime.list');
        Route::get('{exhibitorId}/datetime/create', 'ExhibitorController@datetime_create')->name('datetime.create');
        Route::post('{exhibitorId}/datetime/store', 'ExhibitorController@datetime_store')->name('datetime.store');
        Route::get('{datetimeId}/datetime/edit', 'ExhibitorController@datetime_edit')->name('datetime.edit');
        Route::put('{datetimeId}/datetime/edit', 'ExhibitorController@datetime_update')->name('datetime.update');

        Route::post('export', 'BookingController@studentExport')->name('studentExport');
        Route::post('export-visitor', 'VisitorController@exportVisitor')->name('exportVisitor');

        Route::resource('booking', 'BookingController');

        /**
         * Get Branch of specific exhibitor
         * @params exhibitorId is needed in every routes and branchId is needed in E,U,D of specific branch
         */
        Route::group(['prefix' => '{exhibitorId}'], function () {
            Route::resource('branch', 'BranchController');
            Route::resource('visitor', 'VisitorController');
        });

        Route::resource('refer', 'ReferController');

        Route::resource('chat', 'ChatController');

        Route::get('report/daily', 'ReportController@daily_report')->name('daily_report');
    });

    Route::group(['middleware' => 'auth',], function () {
        Route::get('message/{receiverId}', 'ChatController@getMessage')->name('front.getMessage');
        Route::post('message', 'ChatController@sendMessage')->name('front.sendMessage');
    });

    Route::get('search-exhibition', 'DefaultController@searchExhibition')->name('searchExhibition');
    Route::post('store-refer', 'DefaultController@addRefer')->name('addRefer');
    Route::post('video-booking', 'DefaultController@video__booking')->name('video__booking');
    Route::get('export-chat/{receiverId}', 'ChatController@exportPDF')->name('exportPDF');

    // this should be in last
    // Route::get('/{slug}', 'DefaultController@dynamicPages')->name('getPage');
});


// Route::group(['middleware' => ['exhibitor']], function () {
//     Route::get('exhibitor-list', 'ExhibitorController@index')->name('exhibitor.index');
//     Route::get('exhibitor-create', 'ExhibitorController@create')->name('exhibitor.create');
//     Route::post('exhibitor', 'ExhibitorController@store')->name('exhibitor.store');
//     Route::get('exhibitor-show/{exhibitor}', 'ExhibitorController@show')->name('exhibitor.show');
//     Route::get('exhibitor-edit/{exhibitor}/edit', 'ExhibitorController@edit')->name('exhibitor.edit');
//     Route::put('exhibitor/{exhibitor}', 'ExhibitorController@update')->name('exhibitor.update');
//     Route::delete('exhibitor/{exhibitor}', 'ExhibitorController@destroy')->name('exhibitor.destroy');
// });