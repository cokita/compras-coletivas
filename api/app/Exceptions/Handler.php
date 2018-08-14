<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * https://httpstatusdogs.com/
     */
    private $descriptions = [
        100 => 'CONTINUE',
        ###
        200 => 'OK', // Requisição realizadao com sucesso.
        201 => 'CREATED', // Registro criado com sucesso.
        202 => 'ACCEPTED', // Requisição foi aceita e colocada na fila.
        203 => 'NON_AUTHORITATIVE_INFORMATION',
        204 => 'NO_CONTENT', // Pedido foi processado, mas não há informações a serem devolvidas.
        205 => 'RESET_CONTENT',
        206 => 'PARTIAL_CONTENT',
        207 => 'MULTI_STATUS',
        208 => 'ALREADY_REPORTED',
        226 => 'IM_USED',
        ###
        300 => 'MULTIPLE_CHOICES',
        301 => 'MOVED_PERMANENTLY',
        302 => 'FOUND',
        303 => 'SEE_OTHER',
        304 => 'NOT_MODIFIED',
        305 => 'USE_PROXY',
        306 => 'SWITCH_PROXY',
        307 => 'TEMPORARY_REDIRECT',
        308 => 'PERMANENT_REDIRECT',
        ###
        400 => 'BAD_REQUEST', // Requisição inválida.
        401 => 'UNAUTHORIZED', // Acesso negado por falta de autenticação.
        402 => 'PAYMENT_REQUIRED', // Acesso negado por falta de pagamento.
        403 => 'FORBIDDEN', // Acesso negado por falta de permissão.
        404 => 'NOT_FOUND', // Registro não encontrado.
        405 => 'METHOD_NOT_ALLOWED', // Metodo não permitido.
        406 => 'NOT_ACCEPTABLE',
        407 => 'PROXY_AUTHENTICATION_REQUIRED',
        408 => 'REQUEST_TIMEOUT', // Pedido recusado por estar expirado.
        409 => 'CONFLICT',
        410 => 'GONE',
        411 => 'LENGTH_REQUIRED',
        412 => 'PRECONDITION_FAILED', // Há condições prévias não satisfeitas.
        413 => 'PAYLOAD_TOO_LARGE',
        414 => 'URI_TOO_LARGE',
        416 => 'REQUEST_RANGE_NOT_SATISFIABLE',
        417 => 'EXPECTATION_FAILED',
        418 => 'IM_A_TEAPOT',
        420 => 'ENHACE_YOUR_CALM',
        422 => 'UNPROCESSABLE_ENTITY',
        423 => 'LOCKED',
        424 => 'FAILED_DEPENDENCY',
        425 => 'UNORDERED_COLLECTION',
        426 => 'UPGRADE_REQUIRED',
        429 => 'TOO_MANY_REQUESTS',
        431 => 'REQUEST_HEADER_FIELD_TOO_LARGE',
        444 => 'NO_RESPONSE',
        450 => 'BLOCKED_BY_WINDOWS_PARENTAL_CONTROLS',
        451 => 'UNAVAILABLE_FOR_LEGAL_REASONS',
        494 => 'REQUEST_HEADER_TOO_LARGE',
        ###
        500 => 'INTERNAL_SERVER_ERROR', // Falha inesperada ao processar a solicitação.
        501 => 'NOT_IMPLEMENTED', // Recurso não implementado.
        502 => 'BAD_GATEWAY',
        503 => 'SERVICE_UNAVAILABLE',
        504 => 'GATEWAY_TIMEOUT',
        506 => 'VARIANT_ALSO_NEGOTIATES',
        507 => 'INSUFFICIENT_STORAGE',
        508 => 'LOOP_DETECTED',
        509 => 'BANDWIDTH_LIMIT_EXCEEDED',
        510 => 'NOT_EXTENDED',
    ];

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
        $route = $request->route();

        //if ($route->gatherMiddleware()[0] != 'api')
        //    return parent::render($request, $exception);

        // RETURN //
        $return = ['status' => 500];

        // STATUS //
        if (!$route) {
            $return['status'] = 501;

        } else if($exception instanceof AuthenticationException){
            $return['status'] = 401;
        }else if ($exception instanceof \Exception) {

            if ($exception instanceof ValidationException) {
                $return['status'] = 412;
            }

        } else if ($exception instanceof HttpException) {
            $return['status'] = $exception->getStatusCode();
        }

        // MESSAGE //
        $return['message'] = trim($exception->getMessage());
        strlen($return['message']) > 0 ? $return['message'] : $return['message'] = $this->descriptions[$return['status']];

        // DEBUG //
        if (env('APP_DEBUG'))
            $return['debug'] = $this->debug($exception);

        return response()->json($return)->setStatusCode($return['status']);
    }

    private function debug(Exception $e, array $debug = null)
    {
        is_null($debug) ? $debug = [] : null;

        $error = [];
        $error['code'] = $e->getCode();
        $error['type'] = class_basename($e);
        $error['message'] = $e->getMessage();
        $error['line'] = $e->getLine();
        $error['file'] = $e->getFile();
        $error['status'] = null;
        $error['headers'] = null;
        if ($e instanceof HttpException) {
            $error['status'] = $e->getStatusCode();
            $error['headers'] = $e->getHeaders();
        }
        $error['trace'] = $e->getTrace();

        $debug[] = $error;

        $e->getPrevious() ? $this->debug($e->getPrevious(), $debug) : null;

        return $debug;
    }
}
