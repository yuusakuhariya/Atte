<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Rest;

class RestController extends Controller
{
    // 休憩開始
    public function restStartTime()
    {
        $user_id = auth()->user()->id;
        $work_date = now()->toDateString();
        $attendance = Attendance::where('user_id', $user_id)
            ->where('work_date', $work_date)
            ->first();

        $start_rest_time = now();

        if ($attendance) {
            Rest::create([
                'attendance_id' => $attendance->id,
                'start_rest_time' => $start_rest_time,
                'end_rest_time' => null,
            ]);
        }

        return redirect('/');
    }

    // 休憩終了
    public function restEndTime()
    {
        $user_id = auth()->user()->id;
        $work_date = now()->toDateString();
        $attendance = Attendance::where('user_id', $user_id)
            ->where('work_date', $work_date)
            ->whereNull('end_time')
            ->first();

        if ($user_id) {
            $end_rest_time = now()->toTimeString();

            $rests = Rest::where('attendance_id', $attendance->id)
                ->where('end_rest_time', null)
                ->get();

            foreach ($rests as $rest) {
                if ($rest && is_null($rest->end_rest_time)) {
                    $rest->update(['end_rest_time' => $end_rest_time]);
                }
            }
        }

        return redirect('/');
    }
}
