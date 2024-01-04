<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;

class AttendanceController extends Controller
{

    public function stamp()
    {
        // 出勤、退勤の活性、非活性
        $user_id = auth()->user()->id;
        $work_date = now()->toDateString();

        $attendance = Attendance::where('user_id', $user_id)
        ->where('work_date', $work_date)
        ->first();
        // Attendanceテーブルから今日の出勤のuser_idを見つけ、$attendanceに代入する。


        // 休憩開始、休憩終了の活性、非活性
        $attendance_id = Attendance::whereNull('end_time')->first()->user_id;

        $end_rest_time = Rest::where('attendance_id', $attendance_id)
        ->where('end_rest_time', null)
        ->first();


        return view('stamp', ['attendance' => $attendance, 'end_rest_time' => $end_rest_time]);
    }


    public function storeAttendance()
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


    public function updateAttendance()
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


    // ここから休憩の実装
    // 休憩開始
    public function storeRest()
    {
        $attendance = Attendance::whereNull('end_time')->first();
        $start_rest_time = now()->totimeString();

        if ($attendance)
        {
            Rest::create([
            'attendance_id' => $attendance->user_id,
            'start_rest_time' => $start_rest_time,
            'end_rest_time' => null,
            'rest_time' => null,
            ]);
        }

        return redirect('/');
    }

    // 休憩終了＋休憩合計時間
    public function updateRest()
    {
        $attendance_id = Attendance::whereNull('end_time')->first()->user_id;
        $end_rest_time = now()->totimeString();

        // 休憩レコードの休憩終了が null のレコードを取得し、変数$rest に代入する。（複数あるから get() メソッドを使用する）
        $rests = Rest::where('attendance_id', $attendance_id)->where('end_rest_time', null)->get();

        // 休憩終了をレコードに追加。
        // $rests を $rest に代入して繰り返す。
        // もし 変数$rest および、変数rest のend_rest_time カラムが null の場合、$end_rest_time を end_rest_time に代入し、変数$rest に更新する。
        foreach ($rests as $rest) {
            if ($rest && is_null($rest->end_rest_time)) {
                $rest -> update(['end_rest_time' => $end_rest_time]);
            }
        }

        // 休憩レコードの休憩終了が not null のレコードを取得し、休憩時間が null のレコード取得し、それを $restTimes に代入する。（複数あるから get() メソッドを使用する）
        $restTimes = Rest::where('attendance_id', $attendance_id)->whereNotNull('end_rest_time')->whereNull('rest_time')->get();

        // 休憩時間の差分計算しレコードに追加。
        foreach ($restTimes as $restTime) {
            $startRestTime =strtotime($restTime->start_rest_time);
            $endRestTime = strtotime($restTime->end_rest_time);

            $rest_time = ($endRestTime - $startRestTime);

            $restTime->update(['rest_time' => $rest_time]);
        }

        return redirect('/');

    }
}