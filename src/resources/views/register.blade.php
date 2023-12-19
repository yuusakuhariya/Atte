@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/register.css') }}" />
@endsection


@section('content')

<header class="header">
    <div class="header_inner">
        <div class="header_logo">
            Atte
        </div>
    </div>
</header>

<main>
    <div class="content">
        <div class=content_title>会員登録</div>
        <div class="form">
            <form class="form_register" action="" method="">
                <div class="form_field">
                    <input class="input_name" type="name" name="name" placeholder="  名前" value="">
                </div>

                <div class="form_field">
                    <input class="input_email" type="email" name="email" placeholder="  メールアドレス" value="">
                </div>

                <div class="form_field">
                    <input class="input_password" type="password" name="password" placeholder="  パスワード" value="" required>
                </div>

                <div class="form_field">
                    <input class="input_password_confirmation" type="password" name="password_confirmation" placeholder="  確認用パスワード" value="" required>
                </div>

                <div class="form_field">
                    <button class="form__button-submit" type="submit">会員登録</button>
                </div>
            </form>
            <div class="text">
                <p class="login_text">アカウントをお持ちの方はこちらから</p>
                <a class="login_button" href="">ログイン</a>
            </div>
        </div>
    </div>
</main>

@endsection