<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/aboutyou', [App\Http\Controllers\AboutYouController::class, 'index'])->name('about you');
Route::post('/aboutyou/save', [App\Http\Controllers\AboutYouController::class, 'finishSetup']);
Route::post('/aboutyou/skip', [App\Http\Controllers\AboutYouController::class, 'skip']);
Route::get('/editarPerfil', [App\Http\Controllers\ProfileController::class, 'editProfile'])->name('editProfile');
Route::post('/editarPerfil/save', [App\Http\Controllers\ProfileController::class, 'editProfileSave']);
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile']);