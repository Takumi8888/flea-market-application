@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection


@if(Route::currentRouteName() !== 'profile.addressEdit')
	@section('title', 'プロフィール')
@elseif(Route::currentRouteName() === 'profile.addressEdit')
	@section('title', '配送先変更')
@endif

@section('content')
@include('components.header')
<main>
    <div class="container">
        {{-- 更新メッセージ --}}
		@if(in_array(Route::currentRouteName(), ['profile.edit', 'profile.addressEdit']))
			@if (session('message'))
				<div class="message alert--success">
					{{ session('message') }}
				</div>
			@elseif ($errors->any())
				<div class="message alert--danger">更新できませんでした</div>
			@endif
        @endif
		{{-- ページタイトル --}}
		@if(Route::currentRouteName() !== 'profile.addressEdit')
			<h1 class="page__title">プロフィール設定</h1>
		@elseif(Route::currentRouteName() === 'profile.addressEdit')
			<h1 class="page__title">住所の変更</h1>
		@endif
        {{-- プロフィール --}}
		@if(Route::currentRouteName() !== 'profile.addressEdit')
			<form class="profile-form" action="/mypage/profile" method="post" enctype="multipart/form-data">
				@if(isset($profile))
					@method('put')
				@endif
		@elseif(Route::currentRouteName() === 'profile.addressEdit')
			<form class="profile-form" action="{{ route('profile.addressUpdate', $item->id) }}" method="post">
				@method('put')
		@endif
            @csrf
            {{-- プロフィール画像 --}}
			@if(Route::currentRouteName() !== 'profile.addressEdit')
				<div class="group profile__img">
					@if(empty($profile))
						<img id="image" src="{{ asset('image/profile/profile_default.png') }}" alt="プロフィール画像">
					@elseif(isset($profile))
						<img id="image" src="{{ Storage::url($profile->user_image) }}" alt="プロフィール画像">
					@endif
					<input id="file" name="user_image" type="file" accept=".png, .jpg">
					<div class="profile__img-btn">
						<button id="button" class="btn btn--img" type="button">画像を選択する</button>
						<div class="error error--img">
							@error('user_image'){{ $message }}@enderror
						</div>
					</div>
				</div>
				{{-- ユーザー名 --}}
				<div class="group profile__name">
					<label for="user_name">ユーザー名</label>
					@if(empty($profile))
						<input id="user_name" name="user_name" type="text" placeholder="ユーザー名を入力してください" value="{{ old('user_name') }}">
					@elseif(isset($profile))
						<input id="user_name" name="user_name" type="text" value="{{ $profile->user_name }}">
					@endif
					<div class="error">
						@error('user_name'){{ $message }}@enderror
					</div>
				</div>
			@endif
            {{-- 郵便番号 --}}
            <div class="group profile__postcode">
                <label for="postcode">郵便番号</label>
				@if(empty($profile) && (Route::currentRouteName() !== 'profile.addressEdit'))
					<input id="postcode" name="user_postcode" type="text" placeholder="123-4567" value="{{ old('user_postcode') }}">
				@elseif(isset($profile))
					<input id="postcode" name="user_postcode" type="text" value="{{ $profile->user_postcode }}">
				@endif
                <div class="error">
                    @error('user_postcode'){{ $message }}@enderror
                </div>
            </div>
            {{-- 住所 --}}
            <div class="group profile__address">
                <label for="address">住所</label>
				@if(empty($profile) && (Route::currentRouteName() !== 'profile.addressEdit'))
					<input id="address" name="user_address" type="text" placeholder="東京都新宿区西新宿2-8-1" value="{{ old('user_address') }}">
				@elseif(isset($profile))
					<input id="address" name="user_address" type="text" value="{{ $profile->user_address }}">
				@endif
                <div class="error">
                    @error('user_address'){{ $message }}@enderror
                </div>
            </div>
            {{-- 建物名 --}}
            <div class="group profile__building">
                <label for="building">建物名</label>
				@if(empty($profile) && (Route::currentRouteName() !== 'profile.addressEdit'))
					<input id="building" name="user_building" type="text" placeholder="東京都庁" value="{{ old('user_building') }}">
				@elseif(isset($profile))
					<input id="building" name="user_building" type="text" value="{{ $profile->user_building }}">
				@endif
                <div class="error">
                    @error('user_building'){{ $message }}@enderror
                </div>
            </div>
            {{-- 更新ボタン --}}
			@if(empty($profile) && (Route::currentRouteName() !== 'profile.addressEdit'))
				<button class="btn btn--edit">更新する</button>
			@elseif(isset($profile))
				<button class="btn btn--edit">更新する</button>
			@endif
        </form>
    </div>
</main>

<script src="{{ asset('js/profile.js') }}"></script>

@endsection