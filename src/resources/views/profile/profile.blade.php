@extends('layouts.header_functional')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/profile.css') }}">
@endsection

@section('content')
    <div class="container">
        {{-- アラート --}}
        @if (isset($profile))
            <div class="profile-section">
                @if (session('message'))
                    <div class="profile__alert--success">
                        {{ session('message') }}
                    </div>
                @elseif ($errors->any())
                    <div class="profile__alert--danger">プロフィールを更新できませんでした</div>
                @endif
            </div>
        @endif
        {{-- ロゴ --}}
        <div class="title-section">
            <h2 class="title__text">プロフィール設定</h2>
        </div>
        {{-- プロフィール --}}
        <form class="profile-form" action="/mypage/profile" method="POST" enctype="multipart/form-data">
            @if (empty($profile))
            @else
                @method('PUT')
            @endif
            @csrf
            {{-- プロフィール画像 --}}
            <div class="profile-form-group">
                <div class="profile-form__flex">
                    @if (empty($profile))
                        <img id="image" class="profile-form__image" src="{{ asset('image/profile/profile_default.png') }}" alt="No Image">
                    @else
                        <img id="image" class="profile-form__image" src="{{ Storage::url($profile->image) }}" alt="No Image">
                    @endif
                    <div class="profile-form__input">
                        <input id="file" name="image" type="file" accept=".png, .jpg">
                        <button id="button" type="button">画像を選択する</button>
                    </div>
                </div>
                <div class="profile-form__error">
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            {{-- ユーザー名 --}}
            <div class="profile-form-group">
                <label for="user_name">ユーザー名</label>
                <div class="profile-form__input">
                    @if (empty($profile))
                        <input id="user_name" name="user_name" type="text" placeholder="ユーザー名を入力してください" value="{{ old('user_name') }}">
                    @else
                        <input id="user_name" name="user_name" type="text" value="{{ $profile['user_name'] }}">
                    @endif
                </div>
                <div class="profile-form__error">
                    @error('user_name')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            {{-- 郵便番号 --}}
            <div class="profile-form-group">
                <label for="postcode">郵便番号</label>
                <div class="profile-form__input">
                    @if (empty($profile))
                        <input id="postcode" name="postcode" type="text" placeholder="123-4567" value="{{ old('postcode') }}">
                    @else
                        <input id="postcode" name="postcode" type="text" value="{{ $profile['postcode'] }}">
                    @endif
                </div>
                <div class="profile-form__error">
                    @error('postcode')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            {{-- 住所 --}}
            <div class="profile-form-group">
                <label for="address">住所</label>
                <div class="profile-form__input">
                    @if (empty($profile))
                        <input id="address" name="address" type="text" placeholder="東京都新宿区西新宿2-8-1" value="{{ old('address') }}">
                    @else
                        <input id="address" name="address" type="text" value="{{ $profile['address'] }}">
                    @endif
                </div>
                <div class="profile-form__error">
                    @error('address')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            {{-- 建物名 --}}
            <div class="profile-form-group">
                <label for="building">建物名</label>
                <div class="profile-form__input">
                    @if (empty($profile))
                        <input id="building" name="building" type="text" placeholder="東京都庁" value="{{ old('building') }}">
                    @else
                        <input id="building" name="building" type="text" value="{{ $profile['building'] }}">
                    @endif
                </div>
                <div class="profile-form__error">
                    @error('building')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            {{-- 更新ボタン --}}
            <div class="profile-form__button">
                @if (empty($profile))
                    <button class="profile-form__button--edit">更新する</button>
                @else
                    <button class="profile-form__button--edit">更新する</button>
                @endif
            </div>
        </form>
    </div>

<script src="{{ asset('js/profile/profile.js') }}"></script>

@endsection