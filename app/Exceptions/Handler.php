<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthenticationException;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // Validate if Content Type is application/json
        if ($request->wantsJson() || Str::contains($request->url(), '/api/')) {
            return $this->renderAPI($exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Render an API exception into an JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    private function renderAPI($exception)
    {
        $exception = $this->prepareException($exception);
        if ($exception instanceof UserNotFoundException) {
            return $this->response($exception, 404);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->response(new Exception('404 Model Not Found.'), 404);
        }

        //This action is unauthorized.
        if ($exception instanceof AuthorizationException) {
            return $this->response($exception, 403);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->response($exception, 401);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->response(new Exception('405 Method Not Allowed.'), 405);
        }

        if ($exception instanceof PostTooLargeException) {
            return $this->response(new Exception('413 Post Too Large.'), 413);
        }

        if ($exception instanceof BadResponseException) {
            if ($exception->getCode() === 400) {
                return response()->json('400. Invalid Request', 400);
            }

            if ($exception->getCode() === 401) {
                return response()->json('401. Credentials invalid', 401);
            }

            return response()->json('Somehting went wrong...', 520);
        }

        return $this->response($exception, 520);
    }

    /**
     * Return response
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $statusCode
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    protected function response(Throwable $exception, int $statusCode = null)
    {
        return response()->json(
            [
                'code' => $statusCode ?? $exception->getCode(),
                'message' => $exception->getMessage()
            ],
            $statusCode
        );
    }
}
