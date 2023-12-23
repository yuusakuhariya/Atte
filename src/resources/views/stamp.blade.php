@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/stamp.css') }}" />
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
                <li><a href="">ホーム</a></li>
                <li><a href="">日付一覧</a></li>
                <li>
                    <form action="/logout" method="post">
                        @csrf
                        <button class="header-nav__button">ログアウト</button>
                    </form>
                    @endif
                </li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="content">
        <div class=content_message>{{ auth()->user()->name }} さんお疲れ様です！</div>
        <div class="content_stamp">
            <form class="stamp_frame" action="" method="">
                <button class="start_time-button" type="submit">勤務開始</button>
            </form>

            <form class="stamp_frame" action="" method="">
                <button class="end_time-button" type="submit">勤務終了</button>
            </form>

            <form class="stamp_frame" action="" method="">
                <button class="break_start_time-button" type="submit">休憩開始</button>
            </form>

            <form class="stamp_frame" action="" method="">
                <button class="break_end_time-button" type="submit">休憩終了</button>
            </form>
        </div>
    </div>
</main>

@endsection