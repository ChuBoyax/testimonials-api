<?php

// Vercel entry point — route every request into Laravel's front controller.
// On Vercel the filesystem is read-only except /tmp, so prepare writable storage dirs there.
if (getenv('VERCEL')) {
    foreach (['app/public', 'framework/cache/data', 'framework/sessions', 'framework/views', 'logs'] as $dir) {
        @mkdir("/tmp/storage/{$dir}", 0777, true);
    }
}

require __DIR__ . '/../public/index.php';
