<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up', // opsional
    )
    ->withMiddleware(function (Middleware $middleware) {
        // alias untuk middleware role yang kamu buat
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // contoh kalau mau menambah ke group 'web' secara global:
        // $middleware->appendToGroup('web', \App\Http\Middleware\Something::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
