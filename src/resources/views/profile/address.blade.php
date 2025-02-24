@extends('layouts.header_functional')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/address.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="title-section">
            <h2 class="title__text">住所の変更</h2>
        </div>
        <form class="address-form" action="{{ route('address.update', $item->id) }}" method="POST">
            @method('PUT')
            @csrf
            {{-- 郵便番号 --}}
            <div class="address-form-group">
                <label for="postcode">郵便番号</label>
                <input id="postcode" name="postcode" type="text" value="{{ $profile['postcode'] }}">
                <div class="address-form__error">
                    @error('postcode')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            {{-- 住所 --}}
            <div class="address-form-group">
                <label for="address">住所</label>
                <input id="address" type="text" name="address" value="{{ $profile['address'] }}">
                <div class="address-form__error">
                    @error('address')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            {{-- 建物名 --}}
            <div class="address-form-group">
                <label for="building">建物名</label>
                <input id="building" type="text" name="building" value="{{ $profile['building'] }}">
                <div class="address-form__error">
                    @error('building')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <button class="address-form__button--edit" type="submit">更新する</button>
        </form>
    </div>
@endsection