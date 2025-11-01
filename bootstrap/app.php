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
    ->withMiddleware(function (Middleware $middleware): void {
        // Register our custom role-based middleware
        $middleware->alias([
            'staff' => \App\Http\Middleware\StaffMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'ceo' => \App\Http\Middleware\CeoMiddleware::class,
            'client' => \App\Http\Middleware\ClientMiddleware::class,
            '2fa' => \App\Http\Middleware\TwoFactorMiddleware::class,
        ]);

        // Apply 2FA middleware to auth routes
        $middleware->appendToGroup('web', \App\Http\Middleware\TwoFactorMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
