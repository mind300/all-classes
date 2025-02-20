<?php

use App\Http\Controllers\Api\Tests\TestController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Authentication -- API Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['api']], function () {

    Route::group(['middleware' => 'verify.app', 'controller' => 'Auth\AuthController', 'prefix' => 'auth'], function () {
        // Authintication
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('/password/forget', 'passwordForget');
        Route::post('/password/reset', 'passwordReset');
        Route::post('/otp/check', 'otpCheck');
    });

    Route::group(['middleware' => 'auth:mind,suppliers,community', 'controller' => 'Auth\AuthController', 'prefix' => 'auth'], function () {
        // Authorization
        Route::post('me', 'me');
        Route::post('password/change', 'changePassword');
        Route::post('permissions', 'permissions');
        Route::post('refresh', 'refresh');
        Route::post('logout', 'logout');
    });

    /*
    |--------------------------------------------------------------------------
    | Mind -- API Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['auth:mind']], function () {

        // Dashboard Mind
        Route::get('dashboard/mind', 'Dashboard\MindDashboardController@mindDashboard');

        // Brands
        Route::apiResource('brands', 'Brands\BrandController');
        Route::post('brands/{brand}', 'Brands\BrandController@update')->name('brands.update');

        // Subscriptions Plans
        Route::apiResource('subscriptions/plans', 'Subscriptions\Plans\SubscriptionPlanController');
        Route::post('subscriptions/plans/suspend/{plan}', 'Subscriptions\Plans\SubscriptionPlanController@suspend');
        Route::post('subscriptions/plans/resume/{plan}', 'Subscriptions\Plans\SubscriptionPlanController@resume');

        // Point Actions
        Route::apiResource('point/systems', 'PointSystems\PointSystemController');

        // Subscriptions Plans Paymob
        Route::get('paymob/login', 'Paymob\SubscriptionController@login');

        // Transactions
        Route::apiResource('transactions', 'Transactions\TransactionController');

        // Point Actions
        Route::apiResource('point/systems', 'PointSystems\PointSystemController');
    });

    /*
    |--------------------------------------------------------------------------
    | Suppliers -- API Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['auth:suppliers']], function () {

        // Profiles
        Route::apiResource('profiles', 'Profiles\ProfileController');
        Route::post('profiles/{profile}', 'Profiles\ProfileController@update')->name('profiles.update');

        // Branches
        Route::resource('branches', 'Branches\BranchController');

        // Cahiers
        Route::apiResource('cashiers', 'Cashiers\CashierController');
        Route::post('cashiers/{cashier}', 'Cashiers\CashierController@update')->name('cashiers.update');

        // Scan Offer
        Route::apiResource('scan/offers', 'ScanOffers\ScanOfferController');
    });

    /*
    |--------------------------------------------------------------------------
    | Community -- API Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['auth:community']], function () {

        // Dashboard Commmunity
        Route::get('dashboard/community', 'Dashboard\CommunityDashboardController@communityDashboard');


        // Home
        Route::get('home', 'Home\HomeController@index');

        // Applications
        Route::apiResource('applications', 'Applications\ApplicationController');

        // Members
        Route::apiResource('members', 'Members\MemberController');
        Route::post('members/{member}', 'Members\MemberController@update')->name('members.update');
        Route::post('members/questions/answers', 'Members\MemberController@answer')->name('members.answer');

        // Commmunity Questions
        Route::apiResource('community/questions', 'CommunityQuestions\CommunityQuestionController');

        // Admins
        Route::apiResource('admins', 'Admins\AdminController');
        Route::post('admins/{admin}', 'Admins\AdminController@update')->name('admins.update');

        // News
        Route::apiResource('news', 'News\NewsController');
        Route::post('news/{news}/update', 'News\NewsController@update')->name('news.update');

        // News / Likes
        Route::get('news/like/{news}', 'News\NewsController@likeOrUnlike')->name('news.likeOrUnlike');

        // Events Histories
        Route::apiResource('event/history', 'Events\EventHistoryController');

        // Jobs
        Route::apiResource('jobs', 'Jobs\JobController');
        Route::post('jobs/{job}', 'Jobs\JobController@update')->name('jobs.update');

        // Buy & Sell
        Route::apiResource('buysells', 'BuySell\BuySellController');
        Route::post('buysells/{buysell}', 'BuySell\BuySellController@update')->name('buysells.update');

        // Events
        Route::apiResource('events', 'Events\EventController');
        Route::post('events/{event}', 'Events\EventController@update')->name('events.update');

        // Rewards
        Route::apiResource('rewards', 'Rewards\RewardController');
        Route::post('rewards/{reward}', 'Rewards\RewardController@update')->name('rewards.update');

        // Reward Redeems
        Route::apiResource('reward/redeems', 'Rewards\RewardRedeemController');

        // Point Histories
        Route::apiResource('points/histories', 'PointHistories\PointHistoryController');

        // Policies
        Route::apiResource('policies', 'Policies\PolicyController');

        // Terms & Condations
        Route::apiResource('terms', 'TermCondations\TermCondationController');

        // About
        Route::apiResource('abouts', 'Abouts\AboutController');
        Route::post('abouts/{about}', 'Abouts\AboutController@update')->name('abouts.update');

        // Connections
        Route::apiResource('connections', 'Connections\ConnectionController');

        // Subscriptions Users
        Route::get('subscriptions/users', 'Subscriptions\Users\SubscriptionUserController@index');
        Route::get('subscriptions/users/plans', 'Subscriptions\Users\SubscriptionUserController@plans');
        Route::post('subscriptions/users/intention', 'Subscriptions\Users\SubscriptionUserController@store');

        // Cards
        Route::apiResource('cards', 'Cards\CardController');

        // Invite Friends
        Route::apiResource('invite/friends', 'InviteFriends\InviteFriendController');

        // Chats
        Route::resource('chats', 'Chats\ChatController');
        Route::post('chats/create', 'Chats\ChatController@create')->name('chats.create');

        // Chats
        Route::apiResource('rooms', 'Rooms\RoomController');

        // Posts
        Route::apiResource('posts', 'Posts\PostController');
        Route::post('posts/{post}', 'Posts\PostController@update')->name('posts.update');

        // Posts/like
        Route::get('posts/like/{post}', 'Posts\PostController@likeOrUnlike')->name('posts.likeOrUnlike');

        // Notifications
        Route::get('chat/notifications', 'Chats\ChatController@notification')->name('chats.notification');

        // Comments
        Route::apiResource('comments', 'Comments\CommentController');
        Route::get('comments/{model_id}/{model_type}', 'Comments\CommentController@show')->name('comments.show');

        // Comments / Replies
        Route::apiResource('comment/reply', 'Replies\ReplyController');
        Route::get('comment/reply/{comment_id}', 'Replies\ReplyController@show')->name('reply.show');
    });

    /*
    |--------------------------------------------------------------------------
    | Common -- API Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'auth:mind,community'], function () {
        // Offers
        Route::apiResource('offers', 'Offers\OfferController');
        Route::get('offers/category/{category}', 'Offers\OfferController@index')->name('offers.index');
        Route::post('offers/{offer}', 'Offers\OfferController@update')->name('offers.update');

        // Charities
        Route::apiResource('charities', 'Charities\CharityController');
        Route::post('charities/{charity}', 'Charities\CharityController@update')->name('charities.update');
    });

    Route::get('test', 'News\NewsController@test');
});


Route::get('test', [TestController::class, 'testRole']);
