<?php

use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
Route::get('/vacations', [App\Http\Controllers\VacationController::class, 'index'])->name('vacations');

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/employees', 'EmployeeController@getAllEmployees');
Route::get('/users', 'UserController@getAllUsers');
Route::get('/activeUsers', 'UserController@getActiveUsers');

Route::post('/addPresence', 'PresenceController@addPresence');
Route::post('/addPresences', 'PresenceController@addPresences');
Route::post('/removePresence', 'PresenceController@removePresence');
Route::post('/removePresences', 'PresenceController@removePresences');
Route::post('/getPresences', 'PresenceController@getPresences');

Route::post('/changeStatus', 'UserController@changeStatus')->middleware('auth');
Route::post('/deleteUser', 'UserController@deleteUser')->middleware('auth');

Route::get('/getUserVacations', 'VacationController@getUserVacations')->middleware('auth');
Route::post('/addVacation', 'VacationController@addVacation')->middleware('auth');
Route::post('/getAllUsersVacations', 'VacationController@getAllUsersVacations');

// Route::post('/editEmployee', 'EmployeeController@editEmployee')->middleware('auth');


