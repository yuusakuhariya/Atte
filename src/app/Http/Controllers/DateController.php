<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class DateController extends Controller
{
    public function date($direction)
    {
        $currentDate = session('work_date', now());
        $current = Carbon::parse($currentDate);

        if ($direction === 'previous') {
            $current->subDay();
        } elseif ($direction === 'next') {
            $current->addDay();
        }

        $work_date = $current->toDateString();
        session(['work_date' => $current]);


        $users = User::whereHas('attendance', function ($query) use ($work_date) {
            $query->where('work_date', '=', $work_date);
        })->with(['attendance' => function ($query) use ($work_date) {
                $query->where('work_date', '=', $work_date)
                ->with(['rest' => function($query) {
                    $query->whereColumn('rests.attendance_id', 'attendances.user_id');
                }]);
            }])->get();

        dd($users);


        $user_work_times = [];  // 空の配列に$work_time（各ユーザーの勤務時間）を格納する変数を用意。

        foreach ($users as $user) {
            $start_time = optional($user->attendance)->start_time;
            $end_time = optional($user->attendance)->end_time;

            if ($start_time && $end_time) {  // 勤務開始と勤務終了がtrueの場合、
                $total_time = strtotime($end_time) - strtotime($start_time);  // 差分計算
                $work_time = gmdate('H:i:s', $total_time);  // 時:分:秒にフォーマット変更
            } else {  // 勤務開始と勤務終了がtrueではない場合
                $work_time = "";  // 空欄を入れる
            }

            $user_work_times[$user->id] = $work_time;  // $work_time（各ユーザーの勤務時間）のデータを$user_work_times[$user->id]ここに格納する。
        }


        return view('date', compact('users', 'work_date', 'user_work_times'));
    }


    public function resetCurrent()
    {
        session(['work_date' => now()]);

        return Redirect::route('date', ['direction' => 'current']);
    }
}



        // if ($direction === 'current') {
        //     $work_date = now()->toDateString();
        // }
        // // なぜ現在時刻が入らない？


        // if ($direction === 'previous') {
        //     $work_date = $current->subDay()->toDateString();
        // } elseif ($direction === 'next') {
        //     $work_date = $current->addDay()->toDateString();
        // }

        // $work_date = $current->toDateString();

        // session(['work_date' => $current]);

        // $users = User::with(['attendance' => function ($query) use ($work_date) {
        //         $query->where('work_date', $work_date);
        //     }])->get();

        // dd($user);
        // Attendancesテーブルのリレーションはできているけど、Restsテーブルのリレーションができてない。デバックで確認するとRestはnullになっている。

        // ここからが分からない

        // $workTimes = [];
        // $restTimes = [];

        // foreach ($users as $user) {
            // $attendance = $users->attendance;
            // $rest = $users->rest;

            // if ($users) {
                // $start_time = strtotime($users->attendance->start_time);
                // $end_time = strtotime($users->attendance->end_time);

                // $work_timestamp = ($end_time - $start_time);
                // $work_time = gmdate("H:i:s", $work_timestamp);

                // $workTimes[$user->attendance->user_id] = $work_time;

            // }

                // $start_time = $users->where($users->attendance->start_time)->strtotime();


        // dd($work_time);

                // if ($rest) {
                //     $start_rest_time = strtotime($rest->start_rest_time);
                //     $end_rest_time = strtotime($rest->end_rest_time);

                //     $rest_timestamp = ($end_rest_time - $start_rest_time);
                //     $rest_time = gmdate("H:i:s", $rest_timestamp);

                //     $restTimes[$user->rest->attendance_id] = $rest_time;
                // }
        // }



// class DateController extends Controller
// {
//     public function date($direction)
//     {
//         セッションのキーであるwork_dateの値がない場合はnullを返したのを$currentに代入。
//         $current = session('work_date');


//         directionに応じて日付を変更
//         if ($direction === 'previous') {
//             $current->subDay(); // 1日前
//         } elseif ($direction === 'next') {
//             $current->addDay(); // 1日後
//         }

//         新しい日付を取得
//         $work_date = $current->toDateString();
//         セッションに上記で指定した値のcurrentをキーのwork_dateに保存。
//         session(['work_date' => $current]);


//         $users = User::with(['attendance' => function ($query) use ($currentDate) {
//             $query->whereDate('work_date', '=', $currentDate->toDateString());
//         }, 'attendance.rest'])
//         ->get();
//         with() は Eloquent モデルを読み込むときに指定されたリレーションシップも同時に読み込むために使用する。
//         UserテーブルからリレーションされているAttendanceテーブルとRestテーブルを同時に読み込む。
//         無名関数（クロージャ）を指定し（function ($query)）、外部の変数を取り込むために use を使用（ use ($currentDate)）する。$currentDate は、無名関数外の $currentDate = now(); ここを指定している。
//         無名関数で指定した $query から work_date カラムの $currentDate->toDateString() と = （一緒）の値を取り出す。
//         その読み込まれたAttendanceテーブルに、上記の値を代入し取得する。

//         勤務時間差分計算

//         $workTimes = [];
//         各ユーザーの勤務時間のデータを保存するための配列を用意。

//         foreach ($users as $user) {
//             ループ処理をすることで下記の処理を各ユーザーに対して個別に実行される。
//             $attendance = $user->attendance;
//             上記の $user の値を attendance（リレーションでs設定した）モデルにアクセスし、 $attendance に代入する。

//             if ($attendance) {
//                 上記の $attendance が true なら、
//                 $start_time = strtotime($attendance->start_time);
//                 $end_time = strtotime($attendance->end_time);
//                 $attendance（attendanceモデル）の勤務開始をUnix タイムスタンプに変換し、変数$start_time に代入。
//                 $attendance（attendanceモデル）の勤務終了をUnix タイムスタンプに変換し、変数$end_time に代入。

//                 $work_timestamp = ($end_time - $start_time);
//                 差分を計算し、秒単位で取得し、変数$work_timestampに代入。
//                 $work_time = gmdate("H:i:s", $work_timestamp);
//                 変数$work_timestampを、「時:分:秒」形式に変換し、変数$work_timeに代入。

//                 $workTimes[$user->attendance->user_id] = $work_time;
//                 差分計算した $work_time を $user->attendance->user_id をキーとして配列$workTimeに入れる。
//                 これでユーザーごとに差分計算された勤務時間を配列に保存される。

//             }
//         }



//         return view('date', compact('users', 'work_date', 'workTimes'));
//     }
// }