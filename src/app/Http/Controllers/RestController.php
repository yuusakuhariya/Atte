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
            $rests = Rest::where('attendance_id', $attendance->id)
                ->where('end_rest_time', null)
                ->get();

            // 休憩終了をレコードに追加。
            // $rests を $rest に代入して繰り返す。
            // もし 変数$rest および、変数$rest のend_rest_time カラムが null の場合、$end_rest_time を end_rest_time に代入し、変数$rest に更新する。
            foreach ($rests as $rest) {
                if ($rest && is_null($rest->end_rest_time)) {
                    $rest->update(['end_rest_time' => $end_rest_time]);
                }
            }
        }

        return redirect('/');
    }
}
