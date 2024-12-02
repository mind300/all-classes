<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(); // Register broadcasting routes

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    // Replace the authorization logic as needed
    return true; // Return true if the user is authorized
});
