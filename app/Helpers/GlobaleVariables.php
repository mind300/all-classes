<?php

// Get Auth User
if (!function_exists('auth_user')) {
    function auth_user()
    {
        return auth()->user();
    }
}

// Get Auth User ID
if (!function_exists('auth_user_id')) {
    function auth_user_id()
    {
        return auth()->id();
    }
}
