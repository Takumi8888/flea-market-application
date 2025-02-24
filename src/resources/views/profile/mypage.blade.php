@extends('layouts.header_functional')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/mypage.css') }}">
@endsection

@section('content')
    <div class="container">
        {{-- プロフィール --}}
            <div class="profile-section">
                <img class="profile__image" src="{{ Storage::url($profile->image) }}" alt="No Image">
                <div class="profile__name">{{ $profile->user_name }}</div>
                <a class="profile__button" href="{{ route('profile.edit')}}">プロフィールを編集</a>
            </div>
        {{-- タグ --}}
        <div class="tag-section">
            <form class="sell-form" action="{{ route('item.mypage') }}" method="GET" onsubmit="return false;">
                <input type="hidden" name="page" value="sell">
                <button class="sell-form__button--{{ $page == 'sell' ? 'on' : 'off' }}" type="button" onclick="submit();">
                    {!! $page == 'sell' ? '出品した商品' : '出品した商品' !!}
                </button>
            </form>
            <form class="buy-form" action="{{ route('item.mypage') }}" method="GET" onsubmit="return false;">
                <input type="hidden" name="page" value="buy">
                <button class="buy-form__button--{{ $page == 'buy' ? 'on' : 'off' }}" type="button" onclick="submit();">
                    {!! $page == 'sell' ? '購入した商品' : '購入した商品' !!}
                </button>
            </form>
        </div>
        {{-- 商品 --}}
        <div class="item-section">
            <ul class="item-group">
                {{-- 出品した商品（編集可能） --}}
                @if ($page == 'sell')
                    @foreach ($profile->exhibitions as $item)
                        <li class="item-card">
                            <form class="item-form" action="{{ route('exhibition.edit', $item->id) }}" method="GET" onsubmit="return false;">
                                <button class="item-form__button" type="button" onclick="submit();">
                                    <img class="item-form__button--image" src="{{ asset(Storage::url($item->image)) }}" alt="item">
                                    <span class="item-form__button--name" >{{ $item['name'] }}</span>
                                </button>
                            </form>
                        </li>
                    @endforeach
                {{-- 購入した商品 --}}
                @elseif ($page == 'buy')
                    @foreach ($profile->purchases as $item)
                        <li class="item-card">
                            <div class="buy-item">
                                <img class="buy-item__image" src="{{ asset(Storage::url($item->image)) }}" alt="item">
                                <span class="buy-item__name" >{{ $item['name'] }}</span>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
@endsection