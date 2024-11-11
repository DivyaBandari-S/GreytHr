<?php

namespace App\Exceptions;

use BadMethodCallException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Log;
use Livewire\Exceptions\MethodNotFoundException;


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
     */
    public function render($request, Throwable $e)
    {
        Log::error('Exception Encountered : ' . $e->getMessage(), ['exception' => $e]);

        // Handle database and fatal errors
        if ($this->isDatabaseOrFatalError($e)) {
            return response()->view('errors.db_error');
        }

        // Handle 404 and HTTP-specific errors
        if ($e instanceof MethodNotFoundException || $e instanceof BadMethodCallException) {
            return response()->view('errors.404', [], 404);
        }

        return parent::render($request, $e);
    }

    /**
     * Determine if the exception is a database or fatal error.
     */
    protected function isDatabaseOrFatalError(Throwable $e): bool
    {
        return $e instanceof QueryException ||
            $e instanceof \PDOException ||
            $e instanceof ModelNotFoundException ||
            $e instanceof \Illuminate\Database\DeadlockException ||
            $e instanceof \Illuminate\View\ViewException ||
            $e instanceof \Symfony\Component\ErrorHandler\Error\FatalError ||
            $e instanceof Model;
    }
}
