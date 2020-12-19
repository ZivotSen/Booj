<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
    }

    public function render($request, Throwable $e)
    {
        if($request->ajax() || $request->is('api/*')){
            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => false,
                    'message' => 'Resource not found'
                ]);
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                $method = strtoupper($request->getMethod());
                return response()->json([
                    'status' => false,
                    'message' => "The {$method} method is not supported for this route."
                ]);
            }
        }

        return parent::render($request, $e);
    }
}
