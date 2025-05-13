@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('title', '会員登録')

@section('content')
@include('components.header')
<main>
    <div class="container">
		<h1 class="page__title">会員登録</h1>
        <form class="register-form" action="/register" method="post">
            @csrf
            {{-- ユーザー名 --}}
            <div class="register-form-group">
                <label for="name">お名前</label>
                <input id="name" type="text" name="name" placeholder="山田太郎" value="{{ old('name') }}">
                <div class="error">
                    @error('name'){{ $message }}@enderror
                </div>
            </div>
            {{-- メールアドレス --}}
            <div class="register-form-group">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" placeholder="sample@example.com" value="{{ old('email') }}">
                <div class="error">
                    @error('email'){{ $message }}@enderror
                </div>
            </div>
            {{-- パスワード --}}
            <div class="register-form-group">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password">
                <div class="error">
                    @error('password'){{ $message}}@enderror
                </div>
            </div>
            {{-- 確認用パスワード --}}
            <div class="register-form-group">
                <label for="password-confirmation">確認用パスワード</label>
                <input id="password-confirmation" type="password" name="password_confirmation">
                <div class="error">
                    @error('password_confirmation'){{ $message}}@enderror
                </div>
            </div>
            {{-- ボタン --}}
            <button class="btn btn--register" type="submit">登録する</button>
            <a class="link-btn btn--login" href="/login">ログインはこちら</a>
        </form>
    </div>
</main>
@endsection