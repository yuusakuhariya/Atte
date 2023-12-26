<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function store()
    {
        $user_id = auth()->user()->id;
        $work_date = now()->toDateString();

        if(Attendance::where('user_id', $user_id)->where('work_date', $work_date)->exists())
        {
            return redirect('/');
        }

        Attendance::create([
            'user_id'=> $user_id,
            'work_date' => now()->toDatestring(),
            'start_time' => now()->totimeString(),
            'end_time' => null,
        ]);


        return redirect('/');
    }

    public function update() {
        $user_id = auth()->user()->id;

        $attendance = Attendance::where('user_id', $user_id)
        ->whereDate('work_date', now()->toDateString())
        ->first();

        if($attendance) {
            $attendance->update(['end_time' => now()->toTimeString()]);
        }

        return redirect('/');
    }
}