<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TimerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebcamController;
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

Route::middleware(['auth'])->group(function() {
    //StudentInfo
    Route::get('student/{id}/info',[StudentController::class,'show'])->name('student.info');
    Route::get('/home',[StudentController::class,'showAll'])->name('students.all');
    //Student Update
    Route::get('student/{id}/edit',[StudentController::class,'edit'])->name('student.edit');
    Route::post('student/{id}/edit',[StudentController::class,'update'])->name('student.update');
    //Student Add
    Route::get('student/create',[StudentController::class,'create'])->name('students.create');  
    Route::post('student/create',[StudentController::class,'store'])->name('students.save');
    //Student Delete
    Route::get('student/{id}/delete',[StudentController::class,'destroy'])->name('student.delete');
    //printAllStudent
    Route::get('students/print',[StudentController::class,'printAllStudent'])->name('printstudents'); 
});

Route::get('login', [AuthController::class, 'index'])->name('login');//LoginRoute
Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register-user');//RegisterRoute
Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');//SignoutRoute


//Timer
Route::view('/timer','timer')->name('timer');
Route::view('/newtimer','newtimer')->name('newtimer');
Route::post('/join/{id}/statusTimer', [TimerController::class, 'statusTimer'])->name('timer.status');
Route::post('/join/{id}/updateTimer', [TimerController::class, 'syncTimer'])->name('timer.sync');
Route::get('/join/{id}/getSyncTimer', [TimerController::class, 'getSyncTimer'])->name('timer.getSync');

Route::get('webcam', [WebcamController::class, 'index']);
Route::post('webcam', [WebcamController::class, 'store'])->name('webcam.capture');

Route::view('/testing', 'test')->name('testing');