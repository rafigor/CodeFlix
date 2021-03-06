<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;

// Password Reset Routes...
Route::group(['prefix'=>'password', 'as'=>'password.', 'namespace'=>'Auth\\'], function(){
    Route::get ('reset'        , 'ForgotPasswordController@showLinkRequestForm')->name('request');
    Route::post('email'        , 'ForgotPasswordController@sendResetLinkEmail') ->name('email');
    Route::get ('reset/{token}', 'ResetPasswordController@showResetForm')       ->name('reset');
    Route::post('reset'        , 'ResetPasswordController@reset');
});

Route::get('email-verification/error', 'EmailVerificationController@getVerificationError')->name('email-verification.error');
Route::get('email-verification/check/{token}', 'EmailVerificationController@getVerification')->name('email-verification.check');

// admin
Route::group(['prefix'=>'admin', 'as' => 'admin.', 'namespace' => 'Admin\\'], function(){
    Route::get ('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');

    Route::group(['middleware' => ['isVerified', 'can:admin']],function(){
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');
        Route::get('dashboard', function(){
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('users/settings', 'Auth\UserSettingsController@edit')->name('user_settings.edit');
        Route::put('users/settings', 'Auth\UserSettingsController@update')->name('user_settings.update');

        Route::resource('users','UsersController');
        Route::resource('categories','CategoriesController');
        Route::get('series/{serie}/thumb_asset','SeriesController@thumbAsset')->name('series.thumb_asset');
        Route::get('series/{serie}/thumb_small_asset','SeriesController@thumbSmallAsset')->name('series.thumb_small_asset');
        Route::resource('series','SeriesController');
        Route::group(['prefix' => 'videos', 'as' => 'videos.'], function(){
            Route::get('{video}/relations', 'VideoRelationsController@create')->name('relations.create');
            Route::post('{video}/relations', 'VideoRelationsController@store')->name('relations.store');
            Route::get('{video}/uploads', 'VideoUploadsController@create')->name('uploads.create');
            Route::post('{video}/uploads', 'VideoUploadsController@store')->name('uploads.store');
        });
        Route::get('videos/{video}/thumb_asset','VideosController@thumbAsset')->name('videos.thumb_asset');
        Route::get('videos/{video}/thumb_smmall_asset','VideosController@thumbSmallAsset')->name('videos.thumb_small_asset');
        Route::get('videos/{video}/file_asset','VideosController@fileAsset')->name('videos.file_asset');
        Route::resource('videos','VideosController');
    });
});

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});