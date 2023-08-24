<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\ChatController;
use App\Models\Chat;
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

Route::resource('chat', ChatController::class);

Route::get('record', [AudioController::class,'index']);
Route::get('get-answer/{text}', [AudioController::class,'getAnswer'])->name('user');
// Route::get('/test', [AudioController::class,'test'])->name('upload');
// Route::post('/upload-audio', [AudioController::class,'uploadAudio'])->name('upload');


