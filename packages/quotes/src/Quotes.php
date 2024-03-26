<?php

namespace FmTod\Quotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Support\Facades\RateLimiter;

class Quotes
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index(Request $request)
     {
        $limit = (int)$request->query('limit', 5)?:5;
        $quotes = [];

        $executed = RateLimiter::attempt(
            'quotes:get',
            $perMinute = 30,
            function () use ($limit, &$quotes, &$rateLimitExceeded) {
                $response = Http::get("https://dummyjson.com/quotes?limit=$limit&skip=".mt_rand(0, 1454-$limit));
                if ($response->successful()) {
                    $quotes = $response->json('quotes');
                }
            }
        );

        $payload = [
            'quotes' => $quotes,
            'ratelimit' => !$executed
        ];

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return Inertia::render('quotes/Dashboard', $payload);
     }
}
