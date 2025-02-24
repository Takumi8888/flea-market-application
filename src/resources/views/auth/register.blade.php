@extends('layouts.header')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
    <div class="container">
        {{-- ロゴ --}}
        <div class="title-section">
            <h2 class="title__text">会員登録</h2>
        </div>
        <form class="register-form" action="/register" method="POST">
            @csrf
            {{-- ユーザー名 --}}
            <div class="register-form-group">
                <label for="name">ユーザー名</label>
                <input id="name" type="text" name="name" placeholder="山田太郎" value="{{ old('name') }}">
                <div class="register-form__error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            {{-- メールアドレス --}}
            <div class="register-form-group">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" placeholder="sample@example.com" value="{{ old('email') }}">
                <div class="register-form__error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            {{-- パスワード --}}
            <div class="register-form-group">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password">
                <div class="register-form__error">
                    @error('password')
                        {{ $message}}
                    @enderror
                </div>
            </div>
            {{-- 確認用パスワード --}}
            <div class="register-form-group">
                <label for="password-confirmation">確認用パスワード</label>
                <input id="password-confirmation" type="password" name="password_confirmation">
                <div class="register-form__error">
                    @error('password_confirmation')
                        {{ $message}}
                    @enderror
                </div>
            </div>
            {{-- ボタン --}}
            <button class="register-form__button--register" type="submit">登録する</button>
            <a class="register-form__button--login" href="/login">ログインはこちら</a>
        </form>
    </div>
@endsection