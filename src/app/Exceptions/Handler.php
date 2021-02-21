<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponser;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof ModelNotFoundException){
            $modelName = strtolower(class_basename($exception->getModel()));
            $modelName = substr($modelName,2);

            return $this->responser("Does not exists any {$modelName} with the specified identificator", 404);
        }

        if($exception instanceof UnauthorizedHttpException){
            $res = [
                'code'          => 401,
                'redirect'      => true,
                'description'   => 'The request has not been applied!'
            ];
            return $this->responser('Request has not been applied', 401);
        }

        if($exception instanceof NotFoundHttpException){
            return $this->responser('Url Not Valid', 404);
        }

        if($exception instanceof MethodNotAllowedHttpException){
            return $this->responser("The specified method for the request is invalid",405);
        }

        return $this->responser('Unexpected Exception. Try Later', 500, null, $exception->getMessage());
        // return parent::render($request, $exception);
    }
}
