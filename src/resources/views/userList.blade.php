@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/userList.css') }}" />
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
        <div class="user_list">
            ユーザー一覧
        </div>
        <div class="user_list_table">
            <table>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>登録日</th>
                </tr>
                @foreach ($lists as $list)
                <tr>
                    <th><a href="{{ route('userListDate', ['id' => $list->id]) }}">{{ $list->id }}</a></th>
                    <th>{{ $list->name }}</th>
                    <th>{{ $list->created_at }}</th>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="pagination">
            {{ $lists->links() }}
        </div>
    </div>
</main>


@endsection