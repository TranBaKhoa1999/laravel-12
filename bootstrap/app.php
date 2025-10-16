<?php

use Dotenv\Exception\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        if (env('APP_DEBUG_WITHOUT_JSON', false)) {
            return $exceptions;
        }
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                $classException = get_class($e);
                $lang = null;
                if ($request->lang) {
                    $lang = $request->lang;
                };

                switch ($classException) {
                    case NotFoundHttpException::class:
                        $response =  printJson(null, buildStatusObject('PAGE_NOT_FOUND'), $lang);
                        break;
                    case MethodNotAllowedHttpException::class:
                        $response = printJson(null, buildStatusObject('METHOD_NOT_ALLOWED'), $lang);
                        break;
                    case AccessDeniedHttpException::class:
                    case UnauthorizedException::class:
                        $response = printJson(null, buildStatusObject('FORBIDDEN'), $lang);
                        break;
                    case UnauthorizedHttpException::class:
                    case AuthenticationException::class:
                        $response = printJson(null, buildStatusObject('UNAUTHORIZED'), $lang);
                        break;
                    case ServiceUnavailableHttpException::class:
                        $response = printJson(null, buildStatusObject('SERVICE_UNAVAILABLE'), $lang);
                        break;
                    case ValidationException::class:
                        $response = printJson($e->getMessage(), buildStatusObject('UNPROCESSABLE_ENTITY'), $lang);
                        break;
                    default:
                        $response = printJson(null, buildStatusObject('INTERNAL_SERVER_ERROR'), $lang);
                }
                return $response;
            }
        });
        //
    })->create();
