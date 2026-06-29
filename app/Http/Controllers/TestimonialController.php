<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Return approved testimonials for the public site.
     */
    public function index()
    {
        return Testimonial::query()
            ->where('approved', true)
            ->latest()
            ->take(30)
            ->get(['name', 'role', 'rating', 'message', 'created_at']);
    }

    /**
     * Store a visitor-submitted testimonial (unapproved until reviewed in Filament).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'role' => ['nullable', 'string', 'max:80'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'max:500'],
        ]);

        $data['approved'] = false;
        Testimonial::create($data);

        return response()->json([
            'ok' => true,
            'message' => 'Salamat! Your feedback was submitted for review.',
        ], 201);
    }
}
