<?php

namespace FmTod\Quotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Illuminate\Support\Facades\RateLimiter;
use FmTod\Quotes\Models\FavoriteQuote;

class FavoritesQuotes
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $quotes = FavoriteQuote::where('user_id', $request->user()->id)->paginate(15);

        if ($request->wantsJson()) {
            return response()->json($quotes);
        }

        return Inertia::render('quotes/FavQuotes', ['quotes' => $quotes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'quote' => 'required|string',
            'author' => 'required|string',
        ]);

        FavoriteQuote::firstOrCreate([
            'user_id' => $request->user()->id,
            'quote_id' => $request->input('id'),
            'quote' => $request->input('quote'),
            'author' => $request->input('author'),
        ]);

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
        $deleted = FavoriteQuote::where('user_id', $request->user()->id)->where('quote_id', $request->input('id'))->delete();
        return response()->json(['status' => $deleted? 'success': 'failed']);
    }
}
