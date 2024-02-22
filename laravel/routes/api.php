<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;


Route::apiResource('files', FileController::class);
Route::post('files/{file}', [FileController::class, 'update_workaround']);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Gestion de Tokens
//  --Token Controller--

//Manera 1

// El guest
Route::middleware('guest')->group(function () {
    Route::post('/register', [TokenController::class, 'register']);
    Route::post('/login', [TokenController::class, 'login']);
});

//Santum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [TokenController::class, 'user']);
    Route::post('logout', [TokenController::class, 'logout']);
});

// //Manera 2
// Route::post('login', [TokenController::class, 'login']);
// Route::post('register', [TokenController::class, 'register']);
// Route::get('user', [TokenController::class, 'user'])->middleware('auth:sanctum');
// Route::post('logout', [TokenController::class, 'logout'])->middleware('auth:sanctum');

//Cosas

// // El guest
// Route::middleware('guest')->group(function () {
//     Route::post('/register', [TokenController::class, 'register']);
// });
// Route::post('login', [TokenController::class, 'login'])->middleware('guest');
// //Santum
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('user', [TokenController::class, 'user']);
//     Route::post('logout', [TokenController::class, 'logout']);
// });

//Pruevas

// Con el Controller

// // El guest
// Route::controller(TokenController::class)->group(function(){
//     Route::middleware('guest')->group(function () {
//         Route::post('register', [TokenController::class, 'register']);
//         Route::post('login', [TokenController::class, 'login']);
//     });
// });

// //Santum
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('user', [TokenController::class, 'user']);
//     Route::get('logout', [TokenController::class, 'logout']);
// });

