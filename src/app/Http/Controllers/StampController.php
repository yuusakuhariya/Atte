<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Http\Request;

class StampController extends Controller
{
    public function stamp()
    {
        $user_id = auth()->user()->id;
        $work_date = now()->toDateString();

        $attendance = Attendance::where('user_id', $user_id)
            ->where('work_date', $work_date)
            ->first();

        $attendanceRecord = Attendance::where('user_id', $user_id)
            ->where('work_date', $work_date)
            ->whereNull('end_time')
            ->first();

        if ($attendanceRecord) {
            $attendance_id = $attendanceRecord->id;

            $end_rest_time = Rest::where('attendance_id', $attendance_id)
                ->whereNull('end_rest_time')
                ->first();
        } else {
            $attendance_id = null;
            $end_rest_time = null;
        }

        return view(
            'stamp', compact('attendance', 'attendanceRecord', 'end_rest_time')
        );
    }
}
