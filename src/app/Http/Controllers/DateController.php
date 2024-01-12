<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;

class DateController extends Controller
{
    public function date() {

        $work_date = now()->toDateString();

        $users = User::with(['attendance', 'attendance.rest'])->get();

        

        return view('date', compact('users', 'work_date'));
    }

}
