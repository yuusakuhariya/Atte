@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/date.css') }}" />
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
                <li><a href="{{ route('date', ['direction' => 'current']) }}">日付一覧</a></li>
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
        <div class="mouth_date">
            <a class="mouth" href="{{ route('date', ['direction' => 'previous']) }}">&lt;</a>
            <span>{{ $work_date }}</span>
            <a class="mouth" href="{{ route('date', ['direction' => 'next']) }}">&gt;</a>
        </div>
        <div class="date_table">
            <table>
                <tr>
                    <th>名前</th>
                    <th>勤務開始</th>
                    <th>勤務終了</th>
                    <th>休憩時間</th>
                    <th>勤務時間</th>
                </tr>
                @foreach ($users as $user)
                <tr>
                    <th>{{ $user->name }}</th>
                    <!-- optional()を使用。（nullでもエラーにならない） -->
                    <th>{{ optional($user->attendance)->start_time }}</th>
                    <th>{{ optional($user->attendance)->end_time }}</th>
                    <th>{{ $workTimes[$user->attendance->user_id] }}</th>
                    <th></th>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="pagination">
            ページネーションが入る
        </div>
    </div>
</main>

@endsection