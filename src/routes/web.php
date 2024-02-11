<?php

use App\Http\Controllers\StampController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\UserListDateController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware('auth')->group(function () {
    Route::get('/', [StampController::class, 'stamp']);
    Route::get('/date/{direction}/{date?}', [DateController::class, 'dayListDate'])->name('dayListDate');
    Route::get('/current-day-list-date', [DateController::class, 'currentDayListDate'])->name('currentDayListDate');
    Route::get('/user-list', [UserListController::class, 'userList']);
    Route::get('/users/{id}', [UserListDateController::class, 'userListDate'])->name('userListDate');

});

Route::post('/start-time', [AttendanceController::class, 'workStartTime']);
Route::Post('/end-time', [AttendanceController::class, 'workEndTime']);
Route::post('/rest-start-time', [RestController::class, 'restStartTime']);
Route::Post('/rest-end-time', [RestController::class, 'restEndTime']);

