<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {

        if ($e instanceof QueryException || $e instanceof \PDOException || $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException || $e instanceof \Illuminate\Database\DeadlockException) {
            Log::error($e->getMessage(), ['exception' => $e]);
            return response()->view('errors.db_error');
        }
        // Check if the exception is related to maximum execution time
        if ($e instanceof \Symfony\Component\ErrorHandler\Error\FatalError) {
            if (str_contains($e->getMessage(), 'Maximum execution time')) {
                // Return a custom view for the execution timeout error
                return response()->view('errors.time-out', [], Response::HTTP_REQUEST_TIMEOUT);
            }
        }

        return parent::render($request, $e);
    }
}
