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

// Get Auth User Member
if (!function_exists('auth_user_member')) {
    function auth_user_member()
    {
        return auth_user()->member;
    }
}

// Get Auth Branch ID
if (!function_exists('auth_branch_id')) {
    function auth_branch_id()
    {
        return auth_user()->manager->id;
    }
}
// Get Auth Brand ID
if (!function_exists('auth_brand_id')) {
    function auth_brand_id()
    {
        return auth_user()->brand_id;
    }
}
