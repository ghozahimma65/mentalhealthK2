<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware; // Import middleware AdminMiddleware

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan middleware alias untuk penggunaan di route
        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);

        // Anda juga bisa mendaftarkan middleware group jika diperlukan,
        // tapi untuk kasus ini, alias sudah cukup.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();