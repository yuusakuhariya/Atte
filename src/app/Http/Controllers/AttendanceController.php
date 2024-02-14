<?php

namespace App\Http\Controllers;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    // 出勤
    public function workStartTime()
    {
        $user_id = auth()->user()->id;
        $work_date = now()->toDateString();
        $start_time = now()->toTimeString();

        // 同じ日に出勤できないようにする。
        if(Attendance::where('user_id', $user_id)
            ->where('work_date', $work_date)
            ->where('start_time', $start_time)
            ->exists())
        {
            return redirect()->back();
        }

        Attendance::create([
            'user_id'=> $user_id,
            'work_date' => now()->toDatestring(),
            'start_time' => now()->totimeString(),
            'end_time' => null,
        ]);

        return redirect('/');
    }

    // 退勤
    public function WorkEndTime()
    {
        $user_id = auth()->user()->id;
        $work_date = now()->toDateString();
        $end_time = now()->toTimeString();
        $attendance = Attendance::where('user_id', $user_id)
            ->where('work_date', $work_date)
            ->first();

        if ($attendance && is_null($attendance->end_time)) {
            $attendance -> update(['end_time' => $end_time]);
        }

        return redirect('/');
    }
}