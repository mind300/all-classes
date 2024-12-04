<?php

namespace App\Http\Middleware;

use App\Services\DatabaseSwitcher;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class VerifyApp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $database = $request->header('Database-App');

        // Check if the database connection exists
        if (!config()->has('database.connections.' . $database)) {
            return response()->json([
                'error' => 'Invalid database connection specified.'
            ], 400);
        }

        $databaseSwitcher = new DatabaseSwitcher();
        $databaseSwitcher->setConnection($database);
            
        return $next($request);
    }
}
