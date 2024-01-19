<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Carbon\Carbon;

class DateController extends Controller
{
    public function date($direction = null)
    {
        $current = session('work_date');

        if ($direction === 'current') {
            $work_date = now()->toDateString();
        }
        // なぜ現在時刻が入らない？



        if ($direction === 'previous') {
            $current->subDay();
        } elseif ($direction === 'next') {
            $current->addDay();
        }

        $work_date = $current->toDateString();

        session(['work_date' => $current]);

        $users = User::with(['attendance' => function ($query) use ($work_date) {
                $query->where('work_date', $work_date);
            }])->get();


        // ここからが分からない

        $workTimes = [];
        $restTimes = [];

        foreach ($users as $user) {
            $attendance = $user->attendance;
            $rest = $user->rest;

            if ($attendance) {
                $start_time = strtotime($attendance->start_time);
                $end_time = strtotime($attendance->end_time);

                $work_timestamp = ($end_time - $start_time);
                $work_time = gmdate("H:i:s", $work_timestamp);

                $workTimes[$user->attendance->user_id] = $work_time;

            }

                if ($rest) {
                    $start_rest_time = strtotime($rest->start_rest_time);
                    $end_rest_time = strtotime($rest->end_rest_time);

                    $rest_timestamp = ($end_rest_time - $start_rest_time);
                    $rest_time = gmdate("H:i:s", $rest_timestamp);

                        $restTimes[$user->rest->attendance_id] = $rest_time;
                }
        }

        return view('date', compact('users', 'work_date', 'workTimes', 'restTimes'));
    }
}


// class DateController extends Controller
// {
//     public function date($direction)
//     {
//         セッションのキーであるwork_dateの値がない場合はnullを返したのを$currentに代入。
//         $current = session('work_date');


//         // directionに応じて日付を変更
//         if ($direction === 'previous') {
//             $current->subDay(); // 1日前
//         } elseif ($direction === 'next') {
//             $current->addDay(); // 1日後
//         }

//         // 新しい日付を取得
//         $work_date = $current->toDateString();
//         セッションに上記で指定した値のcurrentをキーのwork_dateに保存。
//         session(['work_date' => $current]);


//         $users = User::with(['attendance' => function ($query) use ($currentDate) {
//             $query->whereDate('work_date', '=', $currentDate->toDateString());
//         }, 'attendance.rest'])
//         ->get();
//         // with() は Eloquent モデルを読み込むときに指定されたリレーションシップも同時に読み込むために使用する。
//         // UserテーブルからリレーションされているAttendanceテーブルとRestテーブルを同時に読み込む。
//         // 無名関数（クロージャ）を指定し（function ($query)）、外部の変数を取り込むために use を使用（ use ($currentDate)）する。$currentDate は、無名関数外の $currentDate = now(); ここを指定している。
//         // 無名関数で指定した $query から work_date カラムの $currentDate->toDateString() と = （一緒）の値を取り出す。
//         // その読み込まれたAttendanceテーブルに、上記の値を代入し取得する。

//         // 勤務時間差分計算

//         $workTimes = [];
//         // 各ユーザーの勤務時間のデータを保存するための配列を用意。

//         foreach ($users as $user) {
//             // ループ処理をすることで下記の処理を各ユーザーに対して個別に実行される。
//             $attendance = $user->attendance;
//             // 上記の $user の値を attendance（リレーションでs設定した）モデルにアクセスし、 $attendance に代入する。

//             if ($attendance) {
//                 // 上記の $attendance が true なら、
//                 $start_time = strtotime($attendance->start_time);
//                 $end_time = strtotime($attendance->end_time);
//                 // $attendance（attendanceモデル）の勤務開始をUnix タイムスタンプに変換し、変数$start_time に代入。
//                 // // $attendance（attendanceモデル）の勤務終了をUnix タイムスタンプに変換し、変数$end_time に代入。

//                 $work_timestamp = ($end_time - $start_time);
//                 // 差分を計算し、秒単位で取得し、変数$work_timestampに代入。
//                 $work_time = gmdate("H:i:s", $work_timestamp);
//                 // 変数$work_timestampを、「時:分:秒」形式に変換し、変数$work_timeに代入。

//                 $workTimes[$user->attendance->user_id] = $work_time;
//                 // 差分計算した $work_time を $user->attendance->user_id をキーとして配列$workTimeに入れる。
//                 // これをすることによってユーザーごとに差分計算された勤務時間を配列に保存される。


//                 // dd($workTimes);

//             }
//         }



//         return view('date', compact('users', 'work_date', 'workTimes'));
//     }
// }