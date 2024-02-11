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
        // $work_date = '2024-01-16';
        // $users = User::whereHas('attendance')->with(['attendance' => function ($query) use ($work_date) {
        //     $query->where('created_at', $work_date);
        // }, 'attendance.rest' => function ($query) use ($work_date) {
        //     $query->where('created_at', 'like', '%' . $work_date . '%');
        // }])->find($id);

        // $users = User::whereHas('attendance')->with(['attendance', 'attendance.rest' => function ($query) {
        //     $query->whereColumn('created_at', 'like', '%' . 'attendances.created_at' . '%');
        // }])->find($id);

        // $users = User::whereHas('attendance')->with(['attendance', 'attendance.rest' => function ($query) {
        //     $query->where('created_at', 'like', DB::raw("CONCAT('%', attendances.created_at, '%')"));
        // }])->find($id);



        // $users = User::whereHas('attendance')->with(['attendance', 'attendance.rest'])->find($id);
        // $users = User::whereHas('attendance', function ($query) use ($id) {

        //     $query->whereHas('rest', function ($query) use ($id) {

        //         $query->where('attendance_id', $id);
        //     });
        // })->with(['attendance', 'attendance.rest'])->find($id);

        $users = User::whereHas('attendance', function($query) use ($id) {

        $query->whereHas('rest', function($query) use ($id) {

            $query->where('user_id', $id);

        })->where('user_id', $id); // 追加の条件としてuser_idをチェック

        })->with(['attendance', 'attendance.rest'])->find($id);
        // dd($users);
        // $users = User::with(['attendance' => function ($query) {
        //     $query->whereHas('rest', function ($query) {
        //         $query->whereColumn('rests.created_at', '=' ,'attendances.created_at');
        //     });
        // }])->find($id);

        // $users = User::with(['attendance' => function ($query) {
        //     $query->whereHas('rest',
        //         function ($query) {
        //             $query->whereColumn('rests.created_at', '=', 'attendances.created_at');
        //         }
        //     );
        // }])->find($id);



            $attendances = $users->attendance()->paginate(5);    // $usersからattendanceモデルのレコードを取得し、$attendanceに代入。
            
            foreach ($attendances as $attendance) {    // 複数あるレコードの入っている$attendancesを1つずつのレコード$attendanceにする。
                $work_date = $attendance->work_date;    // そのレコードのwork_date（日付）カラムを$work_dateに代入する。
                $start_time = $attendance->start_time;    // そのレコードのstart_time（出勤）カラムを$start_timeに代入する。
                $end_time = $attendance->end_time;    // そのレコードのend_time（退勤）カラムを$work_dateに代入する

                if ($start_time && $end_time) {    // もしstart_time（出勤）とend_time（退勤）が存在するなら、
                    $total_time = strtotime($end_time) - strtotime($start_time);    // 退勤の時間から出勤の時間を減算し、差分を秒で出す。
                    // strtotime() とは、人間が読み取り可能な日付文字列をUnixタイムスタンプに変換するために使用する。（秒数に変換）
                    $work_time = gmdate('H:i:s', $total_time);    // $total_timeを時・分・秒に変換し、$work_timeに代入する。
                    // gmdate() とは、秒を時・分・秒に変換する。
                } else {    // もしstart_time（出勤）とend_time（退勤）が存在しないなら、
                    $work_time = "";    // $work_timeを空欄にする。
                }
                $work_times[$attendance->id] = $work_time;    // 上記の$work_timeの値を配列$work_times[]に入れ、そのキーに$attendance->id（$usersからattendanceモデルのレコードを取得し、$attendanceに代入した値のidカラムにアクセスした）を代入する。
                // dd($work_times[$attendance->id]);
                $rests = $attendance->rest()->get();
                
                foreach ($rests as $rest) {
                    $rest_time = $rest->stat_rest_time;
                    
                }
                
            // $rests = $attendance->rest->filter(function ($rest) use ($attendance) {
            //     // restモデルのcreated_atがattendanceモデルのwork_dateと同じ日付か確認
            //     return $rest->created_at->toDateString() === $attendance->work_date;
            // });
            //     $total_rest_time = 0;
            //     $work_date = $attendance->work_date;
            //     foreach ($rests as $rest) {
            //         $start_rest_time = $rest->start_rest_time;
            //         $end_rest_time = $rest->end_rest_time;

            //         if ($start_rest_time && $end_rest_time) {
            //             $rest_time = strtotime($end_rest_time) - strtotime($start_rest_time);
            //             $total_rest_time += $rest_time;
            //         } else {
            //             $rest_time = "";
            //         }
            //         $rest_times[$attendance->id] = gmdate('H:i:s', $rest_time);
            //     }
            }
            
        return view('userListDate', compact('users', 'attendances', 'work_times'));
    }
}
