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

Route::get('/course', [App\Http\Controllers\CourseCreation\CreateCourseFormController::class, 'createForm'])->name('course');
Route::get('/course/tier', [App\Http\Controllers\CourseCreation\TierFormController::class, 'createForm'])->name('tier');

Route::post('/course/create', [App\Http\Controllers\CourseCreation\CreateCourseFormController::class, 'CreateCourseForm'])->name('course.store');
Route::post('/course/tiers/create', [App\Http\Controllers\CourseCreation\TierFormController::class, 'CreateCourseForm'])->name('tier.store');
