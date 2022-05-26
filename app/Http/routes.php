<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Xử lý người dùng đã đăng nhập
Route::get('/', 'UserController@permissionHandle')->middleware('auth')->name('permissionHandle');

// Người dùng chưa đăng nhập
Route::group(['prefix' => 'guest'], function () {
    Route::get('/', function(){
        return 'Người dùng chưa đăng nhập';
    })->middleware('guest');
});

Route::group(['prefix' => 'auth', 'middleware' => ['guest']], function (){
    Route::get('/login', 'UserController@login')->name('auth.login');
    Route::get('/signup', 'UserController@signup')->name('auth.signup');
    Route::get('/recover', 'UserController@recover')->name('auth.recovery');
});
// Xử lý đăng xuất
Route::get('auth/logout', 'UserController@logout')->name('auth.logout')->middleware('auth');

// Người dùng đã đăng nhập
Route::group(['middleware' => ['auth']], function (){
    // Người dùng mới đăng ký không có quyền
    Route::group(['prefix' => 'member'], function (){
        Route::get('/', 'MemberController@index');

    });
    // Người dùng là nhân viên
    Route::group(['prefix' => 'manager', 'middleware' => 'IsManager'], function (){
        Route::get('/', 'ManagerController@homePage')->name('manager.homepage');
        // Quản lý khảo sát
        Route::get('/survey', 'ManagerController@manageMySurveyView')->name('manager.survey.mySurvey');
        Route::get('/survey/create', 'ManagerController@createSurveyView')->name('manager.survey.create');
        Route::get('/survey/{id}', 'ManagerController@surveyDetailView');
        // Quản lý khách hàng
        Route::get('/customer', 'ManagerController@manageMyCustomerView')->name('manager.customer.myCustomer');

    });

    // Người dùng là Admin
    Route::group(['prefix' => 'admin', 'middleware' => 'IsAdmin'], function (){
        // Trang thống kê
        Route::get('/', 'AdminController@dashboardView')->name('admin');
        // Quản lý khảo sát
        Route::get('/survey/create', 'AdminController@newSurveyView')->name('admin.surveys.create');
        Route::get('/survey', 'AdminController@surveyManagerView')->name('admin.surveys');
        Route::get('/survey/{id}', 'AdminController@surveyDetailView');
        // Quản lý nhân sự
        Route::get('/user', 'AdminController@userManagerView')->name('admin.user.manager');
        // Quản lý dịch vụ
        Route::get('service', 'AdminController@serviceManagerView')->name('admin.service.manager');
        Route::get('/customer', 'AdminController@manageMyCustomerView')->name('admin.customer');
        Route::get('/service/{id}/question', 'AdminController@manageQuestionView')->name('admin.question');
        Route::get('/service/{id}/report', 'AdminController@reportView')->name('admin.question');
        Route::get('/question/{id}', 'AdminController@questionDetails')->name('admin.questionManager');

    });
});

Route::group(['prefix' => 'api/v1'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::post('/signup', 'AuthController@signup')->name('api.v1.signup');
        Route::post('/login', 'AuthController@login')->name('api.v1.login');
        Route::get('/test-api', 'AuthController@create');
    });
    // Refresh token
    Route::post('/refresh', 'AuthController@refresh');

        // Get all customer
        Route::get('/customer', 'Api\CustomerController@index');
        Route::post('/customer', 'Api\CustomerController@store');
        Route::get('/customer/{id}', 'Api\CustomerController@show');
        Route::post('/customer/{id}', 'Api\CustomerController@update');
        Route::delete('/customer/{id}', 'Api\CustomerController@destroy');
        // Kiểm tra xem người dùng có sẵn hay chưa
        Route::post('/customer-check', 'CustomerController@customerCheck')->name('api.v1.customerCheck');

        // Lấy danh sách dịch vụ trang khảo sát
        Route::get('/get-service-survey', 'SurveyController@surveyList')->name('api.v1.surveyList');
        // Lấy nội dung bài khảo sát
        Route::get('/service/{ServiceID}', 'SurveyController@getSurveyDetails')->name('api.v1.getSurveyDetails');

        // Gửi nội dung khảo sát
        Route::post('/survey-submit', 'SurveyController@surveySubmit')->name('api.v1.surveySubmit');
        Route::get('test', 'SurveyController@test');
        Route::get('/customerTest', 'ManagerController@testCustomers');
        Route::post('/user/{id}', 'Api\UserController@update');

        
        Route::post('/service/{id}', 'Api\ServiceController@update');
        Route::post('/service', 'Api\ServiceController@store');


        Route::post('/anwser/{id}', 'Api\AnwserController@update')->name('api.v1.anwser.update');
        Route::post('/question/{id}', 'Api\AnwserController@create')->name('api.v1.anwser.create');

        Route::put('/question-update/{id}', 'Api\QuestionController@update')->name('api.v1.question.update');
        Route::post('/question-create/{id}', 'Api\QuestionController@create')->name('api.v1.question.create');

        Route::post('/question', function(){echo '';})->name('api.v1.question.getQuestionReport');
        Route::post('/question/{Question_id}/report', 'AdminController@getQuestionReport');
});
