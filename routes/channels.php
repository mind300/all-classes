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
Broadcast::channel('notifications.{user_id}', function ($user, $chatId) {
    return true; // Return true if the user is authorized
});
