<?php

use App\Http\Controllers\AtteController;
use App\Http\Controllers\AttendanceController;
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
    Route::get('/', [AtteController::class, ('stamp')]);
});

Route::post('/', [AttendanceController::class, 'store']);
Route::Post('/update', [AttendanceController::class, 'update']);