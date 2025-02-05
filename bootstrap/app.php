<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'custom-auth' => \Zus1\LaravelAuth\Middleware\CustomAuth::class,
            'custom-authorize' => \Zus1\LaravelAuth\Middleware\CustomAuthorize::class,
            'upload-owner-binding' => \App\Http\Middleware\UploadOwnerMiddleware::class,
        ]);
        $middleware->api([
            \App\Http\Middleware\SnakeCaseMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
