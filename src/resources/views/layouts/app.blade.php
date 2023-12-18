<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('/css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header_inner">
            <div class="header_logo">
                Atte
            </div>
            <nav class="nav">
                <ul>
                    <li><a href="">ホーム</a></li>
                    <li><a href="">日付一覧</a></li>
                    <li><a href="">ログアウト</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
            <small>Atte,inc.</small>
        </div>
    </footer>
</body>

</html>
