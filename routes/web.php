<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name(WELCOME);

Route::prefix('managers')->group(function () {
    Route::get('/login', 'ManagerLoginController@showLoginForm')->name(LOGIN_MANAGER);
    Route::post('/login', 'ManagerLoginController@login');
    Route::middleware(['auth:manager'])->group(function () {
        Route::get('logout', 'ManagerLoginController@logout')->name(LOGOUT_MANAGER);
        Route::get('/', function () {
            return view('pages.manager.pages.manager');
        })->name(MANAGER);

        Route::resource('lecturers', 'LecturersController');
        Route::resource('laboratories', 'LaboratoriesController');
        Route::resource('compartments', 'CompartmentsController');
        Route::get('get-notification', 'ManagersController@getNotifications');
        Route::resource('message', 'MessagesController');
        Route::get('get-students', 'ManagersController@getStudents')->name(LIST_STUDENTS_MANGER);
        Route::get('get-projects', 'ManagersController@getProjects')->name(LIST_PROJECTS_MANGER);
    });
});

Route::prefix('lecturers')->group(function () {
    Route::get('/login', 'LecturerLoginController@showLoginForm')->name(LOGIN_LECTURER);
    Route::post('/login', 'LecturerLoginController@login');
    Route::put('forgot-password', 'LecturersController@forgotPassword');
    Route::middleware(['auth:lecturer'])->group(function () {
        Route::get('logout', 'LecturerLoginController@logout')->name(LOGOUT_LECTURER);
        Route::get('/', function () {
            return view('pages.lecturer.lecturer');
        })->name(LECTURER);
        Route::resource('students', 'StudentsController');
        Route::get('search-student', 'StudentsController@searchStudent');
        Route::resource('topics', 'TopicsController');
        Route::resource('projects', 'ProjectsController');
        Route::get('infoLaboratories', 'LecturersController@getInfoLaboratories');
    });
});

Route::prefix('students')->group(function () {
    Route::get('/login', 'StudentLoginController@showLoginForm')->name(LOGIN_STUDENT);
    Route::post('/login', 'StudentLoginController@login');
    Route::put('forgot-password', 'StudentLoginController@forgotPassword');
    Route::middleware(['auth:student'])->group(function () {
        Route::get('logout', 'StudentLoginController@logout')->name(LOGOUT_STUDENT);
        Route::get('/', function () {
            return view('pages.student.student');
        })->name(STUDENT);
        Route::get('lecturers', 'StudentsController@getLecturers')->name(LIST_LECTURES_STUDENT);
        Route::get('projects', 'StudentsController@getProjects')->name(LIST_PROJECTS_STUDENT);
        Route::get('infoLaboratories', 'StudentsController@getInfoLaboratories');
    });
});
