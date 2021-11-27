<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use \App\Http\Controllers\TransactionController;

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

/* User Routes */
Route::get('/user/', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user', [UserController::class, 'store']);
Route::put('/user', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);

/* Transaction Routes */
Route::get('/transaction', [TransactionController::class, 'index']); // Teste
Route::post('/transaction', [TransactionController::class, 'store']);
