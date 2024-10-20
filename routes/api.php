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

        // News / Comments
        Route::apiResource('news/comment', 'News\CommentController');
        Route::get('news/comment/{news_id}', 'News\CommentController@show')->name('comment.show');


        // News / Comments / Replies
        Route::apiResource('news/comment/reply', 'News\ReplyController');
        Route::get('news/comment/reply/{comment_id}', 'News\ReplyController@show')->name('reply.show');

        // Events
        Route::apiResource('events', 'Events\EventController');
        Route::post('events/{event}', 'Events\EventController@update')->name('events.update');

        // Events Histories
        Route::apiResource('event/history', 'Events\EventHistoryController');

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
        Route::get('offers/category/{category}', 'Offers\OfferController@index')->name('offers.index');
        Route::post('offers/{offer}', 'Offers\OfferController@update')->name('offers.update');
        Route::post('offers/scan/qrcode', 'Offers\OfferUseController@scanOffer');

        // Rewards
        Route::apiResource('rewards', 'Rewards\RewardController');
        Route::post('rewards/{reward}', 'Rewards\RewardController@update')->name('rewards.update');

        // Charities
        Route::apiResource('charities', 'Charities\CharityController');
        Route::post('charities/{charity}', 'Charities\CharityController@update')->name('charities.update');

        // Policies
        Route::apiResource('policies', 'Charities\CharityController');

        // Terms & Condations
        Route::apiResource('terms', 'Charities\CharityController');

        // About
        Route::apiResource('abouts', 'Charities\CharityController');
    });
});
