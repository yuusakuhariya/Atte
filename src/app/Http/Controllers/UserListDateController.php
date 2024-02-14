<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserListDateController extends Controller
{
    public function userListDate($id)
    {
        $users = User::with(['attendance', 'attendance.rest'])
        ->find($id);

        $work_times = []; // $work_timesの初期化
        $rest_times = []; // $rest_timesの初期化

            $attendances = $users->attendance()->paginate(5);

            foreach ($attendances as $attendance) {
                $work_date = $attendance->work_date;
                $start_time = $attendance->start_time;
                $end_time = $attendance->end_time;
                $total_time[$attendance->id] = "";

                if ($start_time && $end_time) {
                    $total_work_time = strtotime($end_time) - strtotime($start_time);
                    $work_time = gmdate('H:i:s', $total_work_time);
                }
                $work_times[$attendance->id] = isset($work_time) ? $work_time : "";

                $rests = $attendance->rest()->get();
                $total_rest_time = 0;
                $rest_times[$attendance->id] = "";
                foreach ($rests as $rest) {
                    $start_rest_time = $rest->start_rest_time;
                    $end_rest_time = $rest->end_rest_time;

                    if ($start_rest_time && $end_rest_time) {
                        $rest_time = strtotime($end_rest_time) - strtotime($start_rest_time);
                        $total_rest_time += $rest_time;
                    } else {
                        $rest_time = 0;
                    }
                    $rest_times[$attendance->id] = gmdate('H:i:s', $total_rest_time);
                }
        }
        return view('userListDate', compact('users', 'attendances', 'work_times','rest_times'));
    }
}

// strtotime() とは、人間が読み取り可能な日付文字列をUnixタイムスタンプに変換するために使用する。（秒数に変換）
// gmdate() とは、秒を時・分・秒に変換する。