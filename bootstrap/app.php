<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; // Pastikan 'use' ini ada

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // TAMBAHKAN BARIS INI DI DALAM FUNGSI:
        // Ini adalah cara baru mendaftarkan alias middleware
        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
        ]);

        // (Mungkin ada kode lain di sini, biarkan saja)

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // ...
    })->create();