<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;
use Psr\Log\LoggerInterface;
use Illuminate\Http\Request;

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
        // Log the exception details
        $this->logException($e, $request);

        if ($e instanceof ValidationException) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        if ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();

            switch ($statusCode) {
                case 400:
                    return response()->view('errors.400', [], 400);
                case 401:
                    return response()->view('errors.401', [], 401);
                case 403:
                    return response()->view('errors.403', [], 403);
                case 404:
                    return response()->view('errors.404', [], 404);
                case 419:
                    return response()->view('errors.419', [], 419);
                case 429:
                    return response()->view('errors.429', [], 429);
                case 500:
                    return response()->view('errors.500', [], 500);
                case 503:
                    return response()->view('errors.503', [], 503);
                default:
                    return response()->view('errors.default', ['statusCode' => $statusCode], $statusCode);
            }
        }

        if ($e instanceof QueryException) {
            return response()->view('errors.db_error', [], 500);
        }

        // For other exceptions, log and show a generic error message
        return response()->view('errors.default', ['message' => 'Something went wrong. Please try again later.'], 500);
    }

    /**
     * Log the exception with request context.
     *
     * @param  \Throwable  $e
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function logException(Throwable $e, Request $request): void
    {
        $logger = app(LoggerInterface::class);

        // Log detailed exception information
        $logger->error($e->getMessage(), [
            'exception' => $e,
            'stack_trace' => $e->getTraceAsString(),
            'request' => [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'headers' => $request->headers->all(),
                'body' => $request->all(),
            ],
            'user' => optional($request->user())->toArray(),
        ]);
    }
}
