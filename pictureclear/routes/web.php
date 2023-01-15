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
//Route::post('/home/dropdown', [App\Http\Controllers\HomeController::class, 'changeOrder']);
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile']);

//Página da criação do curso
Route::get('/course', [App\Http\Controllers\CourseCreation\CreateCourseFormController::class, 'createForm'])->name('course');
//Página da criação do tier
Route::get('/course/tier', [App\Http\Controllers\CourseCreation\TierFormController::class, 'createForm'])->name('tier');
//Envia para o controller que irá guardar as informações do curso em session
Route::post('/course/create', [App\Http\Controllers\CourseCreation\CreateCourseFormController::class, 'CreateCourseForm'])->name('course.store');
//Envia para o controller que irá criar o curso e os seus tiers correspondentes
Route::post('/course/tiers/create', [App\Http\Controllers\CourseCreation\TierFormController::class, 'CreateCourseForm'])->name('tier.store');
//Vai buscar a página do curso
Route::get('/checkCourse', [App\Http\Controllers\CourseCreation\SearchCourseFormController::class, 'checkCourse'])->name('getCourse');
//Procura as páginas de curso
Route::get('/checkCourse/search', [App\Http\Controllers\CourseCreation\CheckCourseFormController::class, 'viewCourse'])->name('getCourse');
//Dá update das informações do curso
Route::post('/checkCourse/update/{id}', [App\Http\Controllers\CourseCreation\CheckCourseFormController::class, 'finishSetup'])->name('finishSetup');
//Torna o curso público
Route::post('/checkCourse/launchcourse/{id}', [App\Http\Controllers\CourseCreation\CheckCourseFormController::class, 'launchCourse']);
//Página de adição de licões
Route::get('/addLesson/{id}', [App\Http\Controllers\CourseCreation\LessonFormController::class, 'createForm']);
//Controller que cria as lições
Route::post('/addLesson/create/{id}', [App\Http\Controllers\CourseCreation\LessonFormController::class, 'LessonForm']);

Route::get('/aboutyou', [App\Http\Controllers\AboutYouController::class, 'index'])->name('about you');
Route::post('/aboutyou/save', [App\Http\Controllers\AboutYouController::class, 'finishSetup']);
Route::post('/aboutyou/skip', [App\Http\Controllers\AboutYouController::class, 'skip']);

Route::get('/editarperfil', [App\Http\Controllers\ProfileController::class, 'index'])->name('edit profile');
Route::post('/editarperfil/save', [App\Http\Controllers\ProfileController::class, 'editProfileSave']);
Route::get('/comprarCurso', [App\Http\Controllers\BuyController::class, 'index']);
Route::post('/comprarCurso/tier',[App\Http\Controllers\BuyController::class, 'buy']);
Route::get('/paymentSuccess', [App\Http\Controllers\BuyController::class, 'success']);

//Página dos videos
Route::get('/videos/{id}', [App\Http\Controllers\VideoListController::class, 'index'])->name('{id}');
//Controller que vai reencaminha para uma página com o player
Route::post('/player/{id}/{videoId}', [App\Http\Controllers\VideoListController::class, 'watchvideo']);

Route::post('/publishrating/{id}',[App\Http\Controllers\CourseCreation\CheckCourseFormController::class, 'publishRating']);
Route::get('/painelAdmin/courses',[App\Http\Controllers\AdminController::class, 'courses']);
Route::get('/painelAdmin/users',[App\Http\Controllers\AdminController::class, 'users']);
Route::post('/admin/apagarCurso',[App\Http\Controllers\AdminController::class, 'deleteCourse']);
Route::post('/admin/deleteUser',[App\Http\Controllers\AdminController::class, 'deleteUser']);

//Página dos chats
Route::get('/chat/{id}', [App\Http\Controllers\ChatController::class, 'showChat']);
//Controller que envia a mensagem
Route::post('/messageSent/{id}', [App\Http\Controllers\ChatController::class, 'messageSent']);

//Adição de uma hora
Route::post('/addHour/{id}', [App\Http\Controllers\ScheduleController::class, 'addHour']);
//Página do calendário
Route::get('/schedule/{id}', [App\Http\Controllers\ScheduleController::class, 'checkSchedule']);
//Página da reserva do calendário
Route::get('/schedule/reserve/{id}/{slotId}', [App\Http\Controllers\ScheduleController::class, 'makeAnAppointment']);
//Página para apagar o calendário
Route::post('/schedule_slot_delete/{id}/{slotId}', [App\Http\Controllers\ScheduleController::class, 'deleteSlot']);
