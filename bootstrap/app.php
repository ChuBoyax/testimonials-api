<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Vercel terminates TLS at the edge and forwards over http with
        // X-Forwarded-Proto: https. Trust it so Laravel/Filament generate
        // https asset URLs (otherwise the browser blocks them as mixed content).
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();

// On Vercel (serverless) only /tmp is writable — point Laravel's storage there.
if (getenv('VERCEL')) {
    $app->useStoragePath('/tmp/storage');
}

return $app;
