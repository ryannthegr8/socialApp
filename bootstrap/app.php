<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        //After making a middleware in terminal, you provide the alias to be able to use it.
        $middleware->alias([
            'mustBeLoggedIn' => \app\Http\Middleware\MustBeLoggedIn::class,
        ])
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
