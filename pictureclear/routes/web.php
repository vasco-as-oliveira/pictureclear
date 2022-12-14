<?php

use Illuminate\Support\Facades\Route;

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

