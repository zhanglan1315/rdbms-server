<?php

namespace App\Exceptions;

use Exception;
use App\Services\Transaction;

use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
    public function render($request, Exception $e)
    {
        // 回滚已开启的事务
        if (Transaction::working()) Transaction::rollback();

        // 处理跨域请求的问题
        // 为无法匹配路由的options请求自动返回一个200响应

        if ($e instanceof CustomerExpection) {
            return $e->response;
        }

        if ($e instanceof ValidationException) {
            $result = $e->errors();
            $result['data'] = request()->all();
            return response()->json($result, 422);
        }

        return parent::render($request, $e);
    }
}
