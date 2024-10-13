<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['api']], function () {
    // Authentication
    Route::group(['middleware' => 'verify.app', 'prefix' => 'auth'], function () {
        Route::post('login', 'Auth\AuthController@login');
        Route::post('register', 'Auth\AuthController@register');

        // Authorization Auth
        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('me', 'Auth\AuthController@me');
            Route::post('refresh', 'Auth\AuthController@refresh');
            Route::post('logout', 'Auth\AuthController@logout');
        });

        Route::post('/password/forget', 'Auth\AuthController@forgetPassword')->name('password.email');
        Route::post('/password/reset', 'Auth\AuthController@resetPassword')->name('password.reset');
        Route::post('/check/token', 'Auth\AuthController@checkToken');
    });

    // Authorization
    Route::group(['middleware' => 'auth:api'], function () {
        // Applications
        Route::apiResource('applications', 'Applications\ApplicationController');

        // Members
        Route::apiResource('members', 'Members\MemberController');
        Route::post('members/{member}', 'Members\MemberController@update')->name('members.update');

        // Admins
        Route::apiResource('admins', 'Admins\AdminController');
        Route::post('admins/{admin}', 'Admins\AdminController@update')->name('admins.update');

        // News
        Route::apiResource('news', 'News\NewsController');
        Route::get('news/like/{news}', 'News\NewsController@likeOrUnlike')->name('news.likeOrUnlike');
        Route::post('news/comment', 'News\NewsController@comment')->name('news.comment');
        Route::post('news/comment/reply', 'News\NewsController@reply')->name('news.reply');

        // Events
        Route::apiResource('events', 'Events\EventController');
        Route::post('events/{event}', 'Events\EventController@update')->name('events.update');

        // Jobs
        Route::apiResource('jobs', 'Jobs\JobController');
        Route::post('jobs/{job}', 'Jobs\JobController@update')->name('jobs.update');

        // Buy & Sell
        Route::apiResource('buysells', 'BuySell\BuySellController');
        Route::post('buysells/{buysell}', 'BuySell\BuySellController@update')->name('buysells.update');

        // Brands
        Route::apiResource('brands', 'Brands\BrandController');
        Route::post('brands/{brand}', 'Brands\BrandController@update')->name('brands.update');

        // Offers
        Route::apiResource('offers', 'Offers\OfferController');
        Route::post('offers/{offer}', 'Offers\OfferController@update')->name('offers.update');

        // Rewards
        Route::apiResource('rewards', 'Rewards\RewardController');
        Route::post('rewards/{reward}', 'Rewards\RewardController@update')->name('rewards.update');

        // Charities
        Route::apiResource('charities', 'Charities\CharityController');
        Route::post('charities/{charity}', 'Charities\CharityController@update')->name('charities.update');
    });
});