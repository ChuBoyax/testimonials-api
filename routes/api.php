<?php

use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::post('/testimonials', [TestimonialController::class, 'store']);
