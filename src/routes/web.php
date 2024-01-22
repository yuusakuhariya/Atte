<?php

// use App\Http\Controllers\AtteController;
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
    Route::get('/date/{direction}/{date?}', [DateController::class,'date'])->name('date');
    Route::get('/reset-current-time', [DateController::class, 'resetCurrent'])->name('resetCurrent');

});

Route::post('/store', [AttendanceController::class, 'storeAttendance']);
Route::Post('/update', [AttendanceController::class, 'updateAttendance']);
Route::post('/store-rest', [AttendanceController::class, 'storeRest']);
Route::Post('/update-rest', [AttendanceController::class, 'updateRest']);