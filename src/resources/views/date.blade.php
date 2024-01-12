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
                <li><a href="/date">日付一覧</a></li>
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
            <a class="mouth" href="">&lt;</a>
            <span>{{ $work_date }}</span>
            <a class="mouth" href="">&gt;</a>
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
                    <th>{{ $user->attendance->start_time }}</th>
                    <th>{{ $user->attendance->end_time }}</th>
                    <th></th>
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