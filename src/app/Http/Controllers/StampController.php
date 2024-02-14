<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Http\Request;

class StampController extends Controller
{
    public function stamp()
    {
        // 出勤、退勤の活性、非活性
        $user_id = auth()->user()->id;
        $work_date = now()->toDateString();

        $attendance = Attendance::where('user_id', $user_id)
            ->where('work_date', $work_date)
            ->first();

        // 休憩開始、休憩終了の活性、非活性
        $attendanceRecord = Attendance::where('user_id', $user_id)
            ->where('work_date', $work_date)
            ->whereNull('end_time')
            ->first();

        if ($attendanceRecord) {
            $attendance_id = $attendanceRecord->id;

            $end_rest_time = Rest::where('attendance_id', $attendance_id)
                ->where('end_rest_time', null)
                ->first();
        } else {  // $attendanceRecordが存在しない場合の処理
            $attendance_id = null;
            $end_rest_time = null;
        }

        return view(
            'stamp', compact('attendance', 'attendanceRecord', 'end_rest_time')
        );
    }
}
