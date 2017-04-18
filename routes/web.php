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

// admin
Route::group(['prefix'=>'admin', 'as' => 'admin.', 'namespace' => 'Admin\\'], function(){
    Route::get ('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');

    Route::group(['middleware' => 'can:admin'],function(){

        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        Route::resource('users','UsersController');

        Route::get('dashboard', function(){
            return view('admin.dashboard');
        })->name('dashboard');
    });
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index');
Route::get('force-login', function(){
    Auth::loginUsingId(1);
});