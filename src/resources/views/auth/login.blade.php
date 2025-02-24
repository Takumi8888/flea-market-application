@extends('layouts.header')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
    <div class="container">
        {{-- ロゴ --}}
        <div class="title-section">
            <h2 class="title__text">ログイン</h2>
        </div>
        <form class="login-form" action="/login" method="POST">
            @csrf
            {{-- メールアドレス --}}
            <div class="login-form-group">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" placeholder="sample@example.com" value="{{ old('email') }}">
                <div class="login-form__error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            {{-- パスワード --}}
            <div class="login-form-group">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password" value="{{ old('password') }}">
                <div class="login-form__error">
                    @error('password')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            {{-- ボタン --}}
            <button class="login-form__button--login" type="submit">ログインする</button>
            <a class="login-form__button--register" href="/register">会員登録はこちら</a>
        </form>

    </div>
@endsection