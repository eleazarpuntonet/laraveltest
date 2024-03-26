<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::where('id', '!=', $request->user()->id)->paginate(15);
        return Inertia::render('Admin/Users', [
            'users' => $data,
        ]);
    }

    /**
     * Show the form for ban a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ban(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        if ($request->input('user_id') === $request->user()->id) {
            return response()->json(['status' => 'failed', 'message' => 'can\'t ban yourself']);
        }

        $user = User::where('id', $request->input('user_id'))->first();

        if (!$user) {
            return response()->json(['status' => 'failed']);
        }

        $user->active = !$user->active;
        $user->save();

        Session::flash('success', 'User updated successfully');
        return response()->json(['status' => 'success']);
    }
}