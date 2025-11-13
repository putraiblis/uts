<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // ... (kode middlewareGroups dan lainnya biarkan saja) ...

    /**
     * Route middleware.
     */
    // GANTI NAMA PROPERTI DI BAWAH INI
    // protected $routeMiddleware = [
    //      ^
    //      |
    //  INI SALAH untuk Laravel 12

    // UBAH MENJADI SEPERTI INI:
    protected $middlewareAliases = [
    //          ^^^^^^^^^^^^^^^^^
    //          INI YANG BENAR
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // ✅ middleware custom kamu (ini sudah benar)
        'isAdmin' => \App\Http\Middleware\IsAdmin::class,
    ];
}