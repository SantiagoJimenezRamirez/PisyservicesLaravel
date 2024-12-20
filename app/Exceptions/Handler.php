<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->wantsJson()) {
            // Aquí puedes personalizar cómo manejar las excepciones para respuestas JSON
            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'error' => 'Resource not found',
                    'message' => $exception->getMessage()
                ], 404);
            }

            // Puedes agregar más excepciones personalizadas aquí
            return response()->json([
                'error' => 'An error occurred',
                'message' => $exception->getMessage()
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
