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

    @yield('content')

    <footer>
            <small>Atte,inc.</small>
        </div>
    </footer>
</body>

</html>
