<?php

// Vercel serverless entry point. The vercel-php runtime preserves the original
// request URI, so Laravel still sees the real path (the /api segment is NOT
// leaked into the routes). On Vercel the filesystem is read-only except /tmp.
if (getenv('VERCEL')) {
    // The function lives at /api/index.php, so SCRIPT_NAME is "/api/index.php".
    // Symfony/Laravel uses that to compute a base path and strips the leading
    // "/api" from the request path — which makes every /api/* route 404.
    // Pretend the script is at the web root so the full path reaches the router.
    $_SERVER['SCRIPT_NAME'] = '/index.php';
    $_SERVER['PHP_SELF'] = '/index.php';

    // Neon requires SNI to route to the right compute endpoint, but the
    // serverless libpq build does not send it. Pass the endpoint id (the first
    // label of the DB host) explicitly via PGOPTIONS, which libpq forwards as
    // the connection "options" param — Neon's documented SNI workaround.
    $dbUrl = getenv('DATABASE_URL') ?: getenv('DB_URL');
    if ($dbUrl && ($dbHost = parse_url($dbUrl, PHP_URL_HOST))) {
        $endpoint = str_replace('-pooler', '', explode('.', $dbHost)[0]);
        if (str_starts_with($endpoint, 'ep-')) {
            putenv("PGOPTIONS=endpoint={$endpoint}");
            $_ENV['PGOPTIONS'] = $_SERVER['PGOPTIONS'] = "endpoint={$endpoint}";
        }
    }

    // writable storage dirs
    foreach (['app/public', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs'] as $dir) {
        @mkdir("/tmp/storage/{$dir}", 0777, true);
    }
    // Laravel writes its bootstrap caches on first boot — point them at /tmp (bootstrap/cache is read-only).
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
