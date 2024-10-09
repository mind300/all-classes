<?php

// For Auth Response
if (!function_exists('authResponse')) {
    function authResponse($token = null, $message = null, $status = 200)
    {
        return response()->json([
            'token' => $token,
            'message' => $message,
            'status' => $status,
            'expire_in' => auth()->factory()->getTTL(),
        ], $status);
    }
}

// For Content Response
if (!function_exists('contentResponse')) {
    function contentResponse($content, $message = 'success', $success = true, $status = 200)
    {
        return response()->json([
            'content' => $content,
            'success' => $success,
            'message' => $message,
            'status' => $status,
        ], $status);
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
