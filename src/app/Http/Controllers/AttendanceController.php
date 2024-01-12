<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Rest;

class AttendanceController extends Controller
{

    public function stamp()
    {
        // 出勤、退勤の活性、非活性
        $user_id = auth()->user()->id;
        // 現在認証しているユーザーのidを取得
        $work_date = now()->toDateString();
        // 現在の日にちを取得

        $attendance = Attendance::where('user_id', $user_id)
        ->where('work_date', $work_date)
        ->first();
        // Attendanceテーブルから現在認証されているユーザーの今日の出勤のidの最初のレコードを取得


        // 休憩開始、休憩終了の活性、非活性
        $attendanceRecord = Attendance::where('user_id', $user_id)->whereNull('end_time')->first();
        // 現在認証されているユーザーを打刻のレコードから探し、そして退勤が空欄のレコードを探して、変数$attendanceRecordに代入。

        if ($attendanceRecord) {
            $attendance_id = $attendanceRecord->user_id;

            $end_rest_time = Rest::where('attendance_id', $attendance_id)
            ->where('end_rest_time',null)
            ->first();
        } else {
            // $attendanceRecordが存在しない場合の処理
            $attendance_id = null;
            $end_rest_time = null;
        }

        return view('stamp', [
            'attendance' => $attendance,
            'attendanceRecord' => $attendanceRecord,
            'end_rest_time' => $end_rest_time
        ]);
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
        $user_id = auth()->user()->id;
        $work_date = now()->toDateString();
        $attendance = Attendance::where('user_id', $user_id)
            ->where('work_date', $work_date)
            ->first();
        $start_rest_time = now();

        if ($attendance) {
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
        // 現在認証しているユーザーのidを取得
        // Attendanceモデル（Attendancesテーブル）の、user_idカラムから、現在ログインしているユーザーのidを取得し、
        // 勤務終了（end_time）が空欄のカラムうを取得する。
        // この条件に一致する最初のレコードを取得。取
        // 取得したレコードを変数$attendanceに代入する。
        $user_id = auth()->user()->id;
        $attendance = Attendance::where('user_id', $user_id)
        ->whereNull('end_time')
        ->first();


        if ($user_id) {

            // 変数$end_rest_timeに現在の時間を代入
            $end_rest_time = now()->toTimeString();

            // Restモデル（Restsテーブル）の、attendance_idカラムから、変数$attendance（ログイン済みユーザーの勤務終了が空欄の最初のレコード）から取得したidを取得し、
            // 休憩終了カラムがnullのレコードを取得し、
            // 変数$restに複数代入する。（複数あるから get() メソッドを使用する）
            $rests = Rest::where('attendance_id', $attendance->user_id)
            ->where('end_rest_time', null)
            ->get();

            // 休憩終了をレコードに追加。
            // $rests を $rest に代入して繰り返す。
            // もし 変数$rest および、変数$rest のend_rest_time カラムが null の場合、$end_rest_time を end_rest_time に代入し、変数$rest に更新する。
            foreach ($rests as $rest) {
                if ($rest && is_null($rest->end_rest_time)) {
                    $rest -> update(['end_rest_time' => $end_rest_time]);
                }
            }

            // // Restモデル（Restsテーブル）の、attendance_idカラムから、変数$attendance（ログイン済みユーザーの勤務終了が空欄の最初のレコード）から取得したidを取得し、
            // 休憩終了カラムが空欄ではなく、
            // 休憩時間が空欄のレコードを取得し、
            // $restTimes に代入する。（複数あるから get() メソッドを使用する）
            $restTimes = Rest::where('attendance_id', $attendance)
            ->where('rest_time', Null)
            ->get();

            // 休憩時間の差分計算しレコードに追加。
            foreach ($restTimes as $restTime) {
                $startRestTime = strtotime($restTime->start_rest_time);
                $endRestTime = strtotime($restTime->end_rest_time);

                $rest_time = ($endRestTime - $startRestTime);

                $restTime->update(['rest_time' => $rest_time]);
            }
        }


        return redirect('/');

    }
}