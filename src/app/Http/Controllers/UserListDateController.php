<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rest;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class UserListDateController extends Controller
{
    public function userListDate($id)
    {
        $users = User::whereHas('attendance', function($query) use ($id) {
        $query->whereHas('rest', function($query) use ($id) {
            $query->where('user_id', $id);
        })->where('user_id', $id); // 追加の条件としてuser_idをチェック
        })->with(['attendance', 'attendance.rest'])->find($id);

            $attendances = $users->attendance()->paginate(5);
            foreach ($attendances as $attendance) {

                $work_date = $attendance->work_date;
                $start_time = $attendance->start_time;
                $end_time = $attendance->end_time;

                if ($start_time && $end_time) {
                    $total_work_time = strtotime($end_time) - strtotime($start_time);
                    // strtotime() とは、人間が読み取り可能な日付文字列をUnixタイムスタンプに変換するために使用する。（秒数に変換）
                    $work_time = gmdate('H:i:s', $total_work_time);
                    // gmdate() とは、秒を時・分・秒に変換する。
                } else {
                    $work_time = "";
                }
                $work_times[$attendance->id] = $work_time;

                $rests = $attendance->rest()->get();
                $total_rest_time = 0;
                $work_date = $attendance->work_date;
                foreach ($rests as $rest) {
                    $start_rest_time = $rest->start_rest_time;
                    $end_rest_time = $rest->end_rest_time;

                    if ($start_rest_time && $end_rest_time) {
                        $rest_time = strtotime($end_rest_time) - strtotime($start_rest_time);
                        $total_rest_time += $rest_time;
                    } else {
                        $total_rest_time = "";
                    }
                    $rest_times[$attendance->id] = gmdate('H:i:s', $total_rest_time);
                }
        }
        return view('userListDate', compact('users', 'attendances', 'work_times','rest_times'));
    }
}
