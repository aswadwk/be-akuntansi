<?php

namespace App\Exceptions;

use App\Helpers\ResponseFormatter;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Exception $e, $request) {

            if($e instanceof AuthenticationException){
                return ResponseFormatter::error($e->getMessage(), $e->getMessage(), 401);
            }

            // validate Error
            if ($e instanceof TokenBlacklistedException) {
                return ResponseFormatter::error('Maaf, token di blokir.', $e->getMessage(), 401);
            }

            // validate Error
            if ($e instanceof ValidationException) {
                return ResponseFormatter::error($e->getMessage(), $e->validator->getMessageBag()->getMessages(), 400);
            }

            if ($e instanceof NotFoundHttpException) {
                return ResponseFormatter::error('data not found', null, $e->getStatusCode());
            }

            if ($e instanceof ClientError) {
                return ResponseFormatter::error($e->getMessage(), null, 404);
            }

            if (config('app.debug')) {
                return dd($e);
            }

            return ResponseFormatter::error(null, 'Maaf, kesalahan pada server.', 500);
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return ResponseFormatter::error($exception->getMessage(), $exception->getMessage(), 401);
        }
    }
}
