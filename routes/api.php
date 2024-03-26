<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TokenAuthController;
use FmTod\Quotes\Quotes;
use FmTod\Quotes\FavoritesQuotes;
// use FmTod\Quotes\TokenAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::post('/login', [TokenAuthController::class, 'store']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [TokenAuthController::class, 'destroy']);
});

// // Ruta para mostrar el formulario de actualización de perfil
// Route::get('/profile', [ProfileController::class, 'edit'])->middleware('auth');

// // Ruta para guardar los cambios en el perfil
// Route::put('/profile', [ProfileController::class, 'update'])->middleware('auth');
