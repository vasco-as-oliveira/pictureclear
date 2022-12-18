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
Route::get('/checkCourse', [App\Http\Controllers\CourseCreation\CheckCourseFormController::class, 'checkCourse']);
Route::get('/checkCourse/search', [App\Http\Controllers\CourseCreation\CheckCourseFormController::class, 'viewCourse'])->name('getCourse');



Route::get('/aboutyou', [App\Http\Controllers\AboutYouController::class, 'index'])->name('about you');
Route::post('/aboutyou/save', [App\Http\Controllers\AboutYouController::class, 'finishSetup']);
Route::post('/aboutyou/skip', [App\Http\Controllers\AboutYouController::class, 'skip']);

Route::get('/editarperfil', [App\Http\Controllers\ProfileController::class, 'index'])->name('edit profile');
Route::post('/editarperfil/save', [App\Http\Controllers\ProfileController::class, 'editProfileSave']);
