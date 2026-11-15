<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Str;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // 404: Data model tidak ditemukan.
        $exceptions->render(
            function (
                ModelNotFoundException $e,
                Request $request
            ) {
                if ($request->is('api/*')) {
                    $modelName = Str::lower(
                        class_basename($e->getModel())
                    );

                    return response()->json([
                        'status' => false,
                        'code' => 404,
                        'message' => "Data $modelName tidak ditemukan",
                    ], 404);
                }
            }
        );

        // 404: Route tidak ditemukan.
        $exceptions->render(
            function (
                NotFoundHttpException $e,
                Request $request
            ) {
                if ($request->is('api/*')) {
                    return response()->json([
                        'status' => false,
                        'code' => 404,
                        'message' => 'Route tidak ditemukan',
                    ], 404);
                }
            }
        );
    })->create();
