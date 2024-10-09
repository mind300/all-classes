<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Handle NotFoundHttpException for routes
        if ($exception instanceof NotFoundHttpException) {
            // Return a custom JSON response for 404 errors
            return response()->json(['error' => 'The Route is not found..'], 404);
        }

        // Handle ModelNotFoundException for Eloquent models
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['error' => 'The requested id not found.'], 404);
        }

        // Handle QueryException for database errors
        if ($exception instanceof QueryException && strpos($exception->getMessage(), '1146 Table') !== false) {
            // Return a custom JSON response for 404 errors
            return response()->json(['error' => 'The requested table was not found.'], 404);
        }

        // Call Laravel's default exception handler for all other exceptions
        return parent::render($request, $exception);
    }
}
