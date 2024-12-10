<?php

use Illuminate\Support\Facades\Broadcast;


// Register broadcasting routes
Broadcast::routes();

/*
|--------------------------------------------------------------------------
| Chat -- Channels Routes
|--------------------------------------------------------------------------
*/
Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    return true;
});

/*
|--------------------------------------------------------------------------
| Notifications -- Channels Routes
|--------------------------------------------------------------------------
*/
Broadcast::channel('notification.{chatId}', function ($user, $chatId) {
    return true;
});