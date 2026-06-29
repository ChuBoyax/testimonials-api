<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// TEMP diagnostic: shows exactly what path Laravel receives on Vercel.
Route::fallback(fn (\Illuminate\Http\Request $r) => response()->json([
    'laravel_path' => $r->path(),
    'full_url' => $r->fullUrl(),
    'REQUEST_URI' => $_SERVER['REQUEST_URI'] ?? null,
    'PATH_INFO' => $_SERVER['PATH_INFO'] ?? null,
    'SCRIPT_NAME' => $_SERVER['SCRIPT_NAME'] ?? null,
], 404));
