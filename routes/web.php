<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\ChatController;
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
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('chat', ChatController::class);
    Route::get('record', [AudioController::class,'index']);
    Route::post('/upload-audio', [AudioController::class,'uploadAudio'])->name('upload');
    Route::post('get-answer', [AudioController::class,'getAnswer'])->name('get-answer');
    // Route::get('get-answer/{text}', [AudioController::class,'getAnswer'])->name('user');
});

require __DIR__.'/auth.php';
