@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('title', 'メール認証')

@section('content')
@include('components.header')
<main>
    <div class="container">
        {{-- ロゴ --}}
        <div class="message">
            <p>登録していただいたメールアドレスに認証メールを送信しました。
			<br/>メール認証を完了してください。</p>
        </div>
		{{-- 認証ボタン --}}
		<div class="verification__btn">
			<a class="link btn--verification" href="http://localhost:8025/">認証はこちらから</a>
		</div>
		{{-- 再送ボタン --}}
		<form class="resend-form" action="{{ route('verification.send') }}" method="post">
			@csrf
			<button class="btn btn--resend" type="submit">認証メールを再送する</button>
		</form>
    </div>
</main>
@endsection