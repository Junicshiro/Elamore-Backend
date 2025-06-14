<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // tambahkan ini
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // \App\Http\Middleware\CorsMiddleware::class,
        $middleware->append(\App\Http\Middleware\CorsMiddleware::class);
    })
    // ->withMiddleware([
    //     \App\Http\Middleware\CorsMiddleware::class,
    // ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// return Application::configure(basePath: dirname(__DIR__))
//     ->withRouting(
//         web: __DIR__.'/../routes/web.php',
//         api: __DIR__.'/../routes/api.php', // tambahkan ini
//         commands: __DIR__.'/../routes/console.php',
//         health: '/up',
//     )
//     ->withMiddleware(function (Middleware $middleware) {
//         //
//     })
//     ->withExceptions(function (Exceptions $exceptions) {
//         //
//     });
