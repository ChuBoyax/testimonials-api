<?php

// Vercel entry point — route every request into Laravel's front controller.
// On Vercel the filesystem is read-only except /tmp.
if (getenv('VERCEL')) {
    // writable storage dirs
    foreach (['app/public', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs'] as $dir) {
        @mkdir("/tmp/storage/{$dir}", 0777, true);
    }
    // Laravel writes its bootstrap caches (package/service manifests, etc.) on first boot —
    // point them at /tmp since bootstrap/cache is read-only in the deployment.
    @mkdir('/tmp/bootstrap', 0777, true);
    foreach ([
        'APP_PACKAGES_CACHE' => '/tmp/bootstrap/packages.php',
        'APP_SERVICES_CACHE' => '/tmp/bootstrap/services.php',
        'APP_CONFIG_CACHE'   => '/tmp/bootstrap/config.php',
        'APP_ROUTES_CACHE'   => '/tmp/bootstrap/routes.php',
        'APP_EVENTS_CACHE'   => '/tmp/bootstrap/events.php',
    ] as $key => $val) {
        putenv("{$key}={$val}");
        $_ENV[$key] = $val;
        $_SERVER[$key] = $val;
    }
}

require __DIR__ . '/../public/index.php';
