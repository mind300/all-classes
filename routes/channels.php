<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    // Example: Check if the user is part of the chat room
    return $user->chats()->where('id', $chatId)->exists();
});
