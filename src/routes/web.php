<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DateController;
use App\Models\Attendance;
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
    Route::get('/', [AttendanceController::class, 'stamp']);
    Route::get('/date/{direction}/{date?}', [DateController::class, 'dayListDate'])->name('dayListDate');
    Route::get('/current-day-list-date', [DateController::class, 'currentDayListDate'])->name('currentDayListDate');

});

Route::post('/start-time', [AttendanceController::class, 'workStartTime']);
Route::Post('/end-time', [AttendanceController::class, 'workEndTime']);
Route::post('/rest-start-time', [AttendanceController::class, 'restStartTime']);
Route::Post('/rest-end-time', [AttendanceController::class, 'restEndTime']);