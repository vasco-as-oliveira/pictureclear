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
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile']);

Route::get('/course', [App\Http\Controllers\CourseCreation\CreateCourseFormController::class, 'createForm'])->name('course');
Route::get('/course/tier', [App\Http\Controllers\CourseCreation\TierFormController::class, 'createForm'])->name('tier');
Route::post('/course/create', [App\Http\Controllers\CourseCreation\CreateCourseFormController::class, 'CreateCourseForm'])->name('course.store');
Route::post('/course/tiers/create', [App\Http\Controllers\CourseCreation\TierFormController::class, 'CreateCourseForm'])->name('tier.store');
Route::get('/checkCourse', [App\Http\Controllers\CourseCreation\SearchCourseFormController::class, 'checkCourse'])->name('getCourse');
Route::get('/checkCourse/search', [App\Http\Controllers\CourseCreation\CheckCourseFormController::class, 'viewCourse'])->name('getCourse');
Route::post('/checkCourse/update/{id}', [App\Http\Controllers\CourseCreation\CheckCourseFormController::class, 'finishSetup'])->name('finishSetup');
Route::post('/checkCourse/launchcourse/{id}', [App\Http\Controllers\CourseCreation\CheckCourseFormController::class, 'launchCourse']);

Route::get('/addLesson/{id}', [App\Http\Controllers\CourseCreation\LessonFormController::class, 'createForm']);
Route::post('/addLesson/create/{id}', [App\Http\Controllers\CourseCreation\LessonFormController::class, 'LessonForm']);



Route::get('/aboutyou', [App\Http\Controllers\AboutYouController::class, 'index'])->name('about you');
Route::post('/aboutyou/save', [App\Http\Controllers\AboutYouController::class, 'finishSetup']);
Route::post('/aboutyou/skip', [App\Http\Controllers\AboutYouController::class, 'skip']);

Route::get('/editarperfil', [App\Http\Controllers\ProfileController::class, 'index'])->name('edit profile');
Route::post('/editarperfil/save', [App\Http\Controllers\ProfileController::class, 'editProfileSave']);
Route::get('/comprarCurso', [App\Http\Controllers\BuyController::class, 'index']);
Route::post('/comprarCurso/tier',[App\Http\Controllers\BuyController::class, 'buy']);
Route::get('/paymentSuccess', [App\Http\Controllers\BuyController::class, 'success']);

Route::get('/videos/{id}', [App\Http\Controllers\VideoListController::class, 'index'])->name('{id}');
Route::post('/player/{id}/{videoId}', [App\Http\Controllers\VideoListController::class, 'watchvideo']);

Route::post('/publishrating/{id}',[App\Http\Controllers\CourseCreation\CheckCourseFormController::class, 'publishRating']);

Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index']);
