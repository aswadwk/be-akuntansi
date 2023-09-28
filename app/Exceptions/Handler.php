<?php

namespace App\Exceptions;

use App\Helpers\ResponseFormatter;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenBlacklistedException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
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

        $this->renderable(function (\Exception $e, $request) {
            // route prefix api
            if ($request->is('api/*')) {
                // Jwt Error
                if ($e instanceof TokenBlacklistedException) {
                    return ResponseFormatter::error('Maaf, token di blokir.', $e->getMessage(), 401);
                }

                // validate Error
                if ($e instanceof ValidationException) {

                    $errorCount = $e->validator->getMessageBag()->count() - 1;

                    if ($errorCount > 0) {
                        $message = __('validation.more errors', [
                            'count' => $errorCount,
                            'error' => str()->of($e->getMessage())->before('.')
                        ]);
                        $finalMessage = $message;
                    } else {
                        $finalMessage = $e->getMessage();
                    }


                    return ResponseFormatter::error($finalMessage, $e->validator->getMessageBag()->getMessages(), 400);
                }

                if ($e instanceof NotFoundHttpException) {
                    return ResponseFormatter::error($e->getMessage(), null, $e->getStatusCode());
                }

                if ($e instanceof MethodNotAllowedHttpException) {
                    return ResponseFormatter::error(__('commons.method_not_allowed'), null, 405);
                }

                if ($e instanceof BadRequestException) {
                    return ResponseFormatter::error($e->getMessage(), null, 400);
                }

                if ($e instanceof UnauthorizedException) {
                    return ResponseFormatter::error($e->getMessage(), null, 401);
                }

                if ($e instanceof AuthenticationException) {
                    return ResponseFormatter::error($e->getMessage(), null, 401);
                }

                if (config('app.env') === 'local' || config('app.env') === 'testing') {
                    dd($e);
                }

                return ResponseFormatter::error(null, 'Maaf, kesalahan pada server.', 500);
            }

            if ($e instanceof BadRequestException) {
                return back()->with('error', $e->getMessage());
            }
        });
    }
}
