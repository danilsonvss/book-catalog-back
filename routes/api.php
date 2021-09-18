<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoginController;
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

Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/auth', [AuthController::class, 'auth']);
Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{id}', [BookController::class, 'index']);
    Route::post('/books', [BookController::class, 'create']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'delete']);
});
