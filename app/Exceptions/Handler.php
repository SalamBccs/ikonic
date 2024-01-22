<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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

        $this->renderable(function (Exception $exception, $request) {
            if ($request->is('api/*')) {
                if($exception instanceof NotFoundHttpException)
                {
                    return response()->json([
                        "success" => false,
                        'message' => 'Request Url Not Found.'
                    ], 404);
                }
                else if($exception instanceof AuthenticationException)
                {
                    return response()->json([
                        "success" => false,
                        'message' => 'You must login first.'
                    ], 401);
                }
                else if($exception instanceof UnauthorizedException)
                {
                    return response()->json([
                        "success" => false,
                        'message' => 'Access Denied.'
                    ], 403);
                }
                else
                {
                    return response()->json([
                        "success" => false,
                        'message' => $exception->getMessage()
                    ], 500);
                }
            }
        });
    }
}
