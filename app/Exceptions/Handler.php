<?php

namespace App\Exceptions;

use Eloquent;
use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\Connector;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\View\ViewException;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\ErrorHandler\Error\FatalError;


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

    public function render($request, Throwable $e)
    {

        Log::error('Data Base error :' . $e->getMessage(), ['exception' => $e]);

        if ($e instanceof QueryException || $e instanceof \PDOException || $e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException || $e instanceof \Illuminate\Database\DeadlockException || $e instanceof ViewException || $e instanceof Model || $e instanceof Connection || $e instanceof Connector || $e instanceof FatalError) {
            // dd('hello world');
            Log::error($e->getMessage(), ['exception' => $e]);
            return response()->view('errors.db_error');
        }
        // Handle model not found exceptions as 404 errors
        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        return parent::render($request, $e);
    }
}
