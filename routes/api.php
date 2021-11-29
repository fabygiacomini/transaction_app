<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserControllerInterface;
use \App\Http\Controllers\TransactionControllerInterface;

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
Route::get('/user/', [UserControllerInterface::class, 'index']);
Route::get('/user/{id}', [UserControllerInterface::class, 'show']);
Route::post('/user', [UserControllerInterface::class, 'store']);
Route::put('/user', [UserControllerInterface::class, 'update']);
Route::delete('/user/{id}', [UserControllerInterface::class, 'destroy']);

/* Transaction Routes */
Route::get('/transaction', [TransactionControllerInterface::class, 'index']);
Route::post('/transaction', [TransactionControllerInterface::class, 'store']);
