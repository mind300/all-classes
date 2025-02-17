<?php

// For Auth Response
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;

if (!function_exists('authResponse')) {
    function authResponse($token = null, $message = null, $status = 200)
    {
        try {
            $is_member = auth_user()->member ? true : false;
            $points = auth_user_member()->points ?? 0;
        } catch (QueryException $e) {
            if ($e->getCode() == '42S02') {
                $is_member = false;
                $points = 0;
            } else {
                throw $e;
            }
        }

        // Mind Response
        if (Config::get('database.default') == 'mind') {
            return response()->json([
                'user_id' => auth_user_id(),
                'name' => auth_user()->name,
                'role' => auth_user()->roles[0]?->name ?? Null,
                'token' => $token,
                'device_token' => auth_user()->device_token,
                'message' => $message,
                'is_active' => auth_user()->is_active,
                'expire_in' => auth()->factory()->getTTL(),
            ], $status);
        }

        // Suppliers Response
        if (Config::get('database.default') == 'suppliers') {
            return response()->json([
                'user_id' => auth_user_id(),
                'name' => auth_user()->profile?->name,
                'is_new' => auth_user()->profile ? false : true,
                'role' => auth_user()->roles[0]->name,
                'token' => $token,
                'device_token' => auth_user()->device_token,
                'message' => $message,
                'is_active' => auth_user()->is_active,
                'expire_in' => auth()->factory()->getTTL(),
            ], $status);
        }

        // Commuity Response
        return response()->json([
            'user_id' => auth_user_id(),
            'name' => auth_user()->name,
            'email' => auth_user()->email,
            'points' => $points,
            'is_member' => $is_member,
            'member_status' => auth_user()->is_active ? 'Approved' : 'Review',
            'device_token' => auth_user()->device_token,
            'token' => $token,
            'message' => $message,
            'is_active' => auth_user()->is_active,
            'expire_in' => auth()->factory()->getTTL(),
        ], $status);
    }
}

// For Content Response
if (!function_exists('contentResponse')) {
    function contentResponse($content, $message = 'success', $success = true, $status = 200)
    {
        $response = [
            'content' => $content,
            'success' => $success,
            'message' => $message,
            'status' => $status,
        ];

        // If pagination data is passed, include it in the response
        if ($content instanceof \Illuminate\Pagination\LengthAwarePaginator || $content instanceof \Illuminate\Pagination\Paginator) {
            $response['content'] = $content->items();

            $response['pagination'] = [
                'total_items' => $content->total(),
                'per_page' => $content->perPage(),
                'current_page' => $content->currentPage(),
                'last_page' => $content->lastPage(),
                'from' => $content->firstItem(),
                'to' => $content->lastItem(),
                'first_page_url' => $content->url(1),
                'next_page_url' => $content->nextPageUrl(),
                'pervious_page_url' => $content->previousPageUrl(1),
            ];
        }

        return response()->json($response, $status);
    }
}

// For Message Response
if (!function_exists('messageResponse')) {
    function messageResponse($message = 'success', $success = true, $status = 200)
    {
        return response()->json([
            'message' => $message,
            'success' => $success,
            'status' => $status,
        ], $status);
    }
}
