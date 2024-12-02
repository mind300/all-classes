<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    // Ensure the user is a participant in the chat
    return $user->chats()->where('id', $chatId)->exists();
});