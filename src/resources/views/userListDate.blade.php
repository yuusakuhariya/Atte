@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/userListDate.css') }}" />
@endsection


@section('content')

<header class="header">
    <div class="header_inner">
        <div class="header_logo">
            Atte
        </div>

        <nav class="nav">
            <ul>
                @if (Auth::check())
                <li><a href="/">ホーム</a></li>
                <li><a href="{{ route('currentDayListDate') }}">日付一覧</a></li>
                <li><a href="/user-list">ユーザー一覧</a></li>
                <li>
                    <form action="/logout" method="post">
                        @csrf
                        <button class="header-nav__button">ログアウト</button>
                    </form>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="content">
        <div class="user_list_date">
            ユーザーデータ一覧
        </div>
        <div class="user_date_table">
            <table>
                <tr>
                    <th>日付</th>
                    <th>勤務開始</th>
                    <th>勤務終了</th>
                    <th>休憩時間</th>
                    <th>勤務時間</th>
                </tr>

                @foreach ($attendances as $attendance)
                <tr>
                    <th>{{ $attendance->work_date }}</th>
                    <th>{{ $attendance->start_time }}</th>
                    <th>{{ $attendance->end_time }}</th>
                    <th> @if (isset($rests[$attendance->id]))
                        {{ $rests[$attendance->id] }}
                        @endif
                    </th>
                    <th>{{ $work_times[$attendance->id] }}</th>
                </tr>
                @endforeach

            </table>
        </div>
        <div class="pagination">

        </div>
    </div>
</main>


@endsection