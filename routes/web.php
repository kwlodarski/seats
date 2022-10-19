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
Auth::routes();

Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employees', 'EmployeeController@getAllEmployees');

Route::post('/addPresence', 'PresenceController@addPresence');
Route::post('/addPresences', 'PresenceController@addPresences');
Route::post('/removePresence', 'PresenceController@removePresence');
Route::post('/removePresences', 'PresenceController@removePresences');
Route::post('/getPresences', 'PresenceController@getPresences');

Route::post('/addEmployee', 'EmployeeController@addEmployee')->middleware('auth');
Route::post('/deleteEmployee', 'EmployeeController@deleteEmployee')->middleware('auth');
Route::post('/editEmployee', 'EmployeeController@editEmployee')->middleware('auth');


