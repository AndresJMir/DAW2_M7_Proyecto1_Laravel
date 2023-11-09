<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use Illuminate\Http\Request;
// ...
Route::get('/dashboard', function (Request $request) {
   $request->session()->flash('info', 'TEST flash messages');
   return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');;
//Implement the correo service
use App\Http\Controllers\MailController;
// ...
Route::get('mail/test', [MailController::class, 'test']);
// or
// Route::get('mail/test', 'App\Http\Controllers\MailController@test');

use App\Http\Controllers\FileController;
Route::resource('files', FileController::class)->middleware(['auth', 'role:2']);

// Route::resource('files', FileController::class);
// Permetre l’accés al CRUD de files només quan estem autenticats
// Route::resource('files', FileController::class)->middleware(['auth']);
// Permetre l’accés al CRUD de files només quan estem sense autenticar.
// Route::resource('files', FileController::class)->middleware(['guest']);
