<?php

use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => response()->json([
    'ok' => true,
    'php' => PHP_VERSION,
    'pdo_pgsql' => extension_loaded('pdo_pgsql'),
    'pgsql' => extension_loaded('pgsql'),
]));

Route::get('/diag', function () {
    try {
        $count = DB::table('testimonials')->count();
        return response()->json(['ok' => true, 'db' => 'connected', 'testimonials' => $count]);
    } catch (\Throwable $e) {
        return response()->json([
            'ok' => false,
            'error' => $e->getMessage(),
            'class' => get_class($e),
        ], 500);
    }
});

Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::post('/testimonials', [TestimonialController::class, 'store']);
