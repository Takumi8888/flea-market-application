@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('title','ログイン')

@section('content')
@include('components.header')
<main>
    <div class="container">
		<h1 class="page__title">ログイン</h1>
        <form class="login-form" action="/login" method="post">
            @csrf
			{{-- メールアドレス --}}
            <div class="login-form-group">
                <label for="email">メールアドレス</label>
                <input id="email" type="email" name="email" placeholder="sample@example.com" value="{{ old('email') }}">
                <div class="error">
                    @error('email'){{ $message }}@enderror
                </div>
            </div>
			{{-- パスワード --}}
            <div class="login-form-group">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password" value="{{ old('password') }}">
                <div class="error">
                    @error('password'){{ $message }}@enderror
                </div>
            </div>
            {{-- ボタン --}}
            <button class="btn btn--login" type="submit">ログインする</button>
            <a class="link-btn btn--register" href="/register">会員登録はこちら</a>
        </form>
    </div>
</main>
@endsection