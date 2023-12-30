<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{

    public function stamp()
    {
        $user_id = auth()->user()->id;
        // 現在認証されているuser_id情報を取得
        $work_date = now()->toDateString();
        // 今日の日付を取得
        $end_time = now()->totimestring();
        // 退勤時間を取得

        $attendance = Attendance::where('user_id', $user_id)
        ->where('work_date', $work_date)
        ->first();
        // Attendanceテーブルから今日の出勤のuser_idを見つけ、$attendanceに代入する。

        return view('stamp', ['attendance' => $attendance]);
    }


    public function store()
    {
        $user_id = auth()->user()->id;
        $work_date = now()->toDateString();
        $start_time = now()->toTimeString();

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


    public function update()
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