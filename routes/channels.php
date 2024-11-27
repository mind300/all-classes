<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('testing', function ($user) {
    return true;
});