<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;

class DateController extends Controller
{
    public function dayListDate($direction)
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

        // リレーション
        $users = User::whereHas('attendance', function ($query) use ($work_date) {
            $query->where('work_date', '=', $work_date);
        })->with(['attendance' => function ($query) use ($work_date) {
            $query->where('work_date', '=', $work_date);
        }, 'attendance.rest' => function ($query) use ($work_date) {
            $query->where('created_at', 'like', '%' . $work_date . '%');
        }])->paginate(5);

        $user_work_times = [];
        $user_start_times = [];
        $user_end_times = [];
        $user_rest_times = [];

        foreach ($users as $user) {
            $attendances = $user->attendance;

            foreach ($attendances as $attendance) {
                $start_time = $attendance->start_time;
                $end_time = $attendance->end_time;
                $total_time = "";

                if ($start_time && $end_time) {
                    $total_time = strtotime($end_time) - strtotime($start_time);
                    $total_time = gmdate('H:i:s', $total_time);
                }

                $user_work_times[$user->id] = ($end_time !== null) ? $total_time : "";
                $user_start_times[$user->id] = $start_time;
                $user_end_times[$user->id] = $end_time;

                $rests = $attendance->rest;
                $total_rest_time = 0;
                foreach ($rests as $rest) {
                    $start_rest_time = $rest->start_rest_time;
                    $end_rest_time = $rest->end_rest_time;

                    if ($start_rest_time && $end_rest_time) {
                        $rest_time = strtotime($end_rest_time) - strtotime($start_rest_time);
                        $total_rest_time += $rest_time;
                    }
                }
                $user_rest_times[$user->id] = gmdate('H:i:s', $total_rest_time);
            }
        }
        return view('date', compact('users', 'work_date', 'user_start_times' , 'user_end_times', 'user_work_times', 'user_rest_times'));
    }


    public function currentDayListDate()
    {
        session(['work_date' => now()]);

        return Redirect::route('dayListDate', ['direction' => 'current']);
    }
}