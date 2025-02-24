@extends('layouts.header')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/email_verified.css') }}">
@endsection

@section('content')
    <div class="container">
        {{-- ロゴ --}}
        <div class="message-section">
            <p class="message__text">登録していただいたメールアドレスに認証メールを送信しました。<br>
            メール認証を完了してください。</p>
        </div>
        <form class="email-verified-form" method="POST">
            @csrf
            {{-- ボタン --}}
            <button class="email-verified-form__button--verify" type="submit" formaction="">認証はこちらから</button>
            <button class="email-verified-form__button--resend" href="/register" formaction="">認証メールを再送する</button>
        </form>
    </div>
@endsection