<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Session;
use FmTod\Quotes\Models\FavoriteQuote;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $data = FavoriteQuote::where('user_id', $user->id)->paginate(15);
        // $user = User::find($id);
        return Inertia::render('Admin/Quotes', [
            'quotes' => $data,
            'user' => $user
        ]);
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
            'user_id' => 'required|integer',
            'quote_id' => 'required|integer',
        ]);
        $deleted = FavoriteQuote::where('user_id', $request->input('user_id'))->where('quote_id', $request->input('quote_id'))->delete();
        Session::flash('success', 'Quote removed successfully');
        return response()->json(['status' => $deleted? 'success': 'failed']);
    }
}