<?php

namespace App\Http\Controllers;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function workStartTime()
    {
        $user_id = auth()->user()->id;
        $work_date = now()->toDateString();
        $start_time = now()->toTimeString();

        if (!Attendance::where('user_id', $user_id)
            ->where('work_date', $work_date)
            ->where('start_time', $start_time)
            ->exists())
        {
            Attendance::create([
                'user_id' => $user_id,
                'work_date' => $work_date,
                'start_time' => $start_time,
                'end_time' => null,
            ]);
        }

        return redirect('/');
    }

    public function WorkEndTime()
    {
        $user_id = auth()->user()->id;
        $work_date = now()->toDateString();
        $end_time = now()->toTimeString();
        $attendance = Attendance::where('user_id', $user_id)
            ->where('work_date', $work_date)
            ->whereNull('end_time')
            ->first();

        if ($attendance) {
            $attendance -> update(['end_time' => $end_time]);
        }

        return redirect('/');
    }
}
