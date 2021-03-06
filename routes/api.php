<?php

use App\Http\Controllers\SiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/siswa', [SiswaController::class, 'index']);
// Route::post('/siswa', [SiswaController::class, 'store']);
// Route::put('/siswa/{id}', [SiswaController::class, 'update']);
// Route::delete('/siswa/{id}', [TransactionController::class, 'destroy']);

Route::resource('/siswa', SiswaController::class)->except(['create','edit']);