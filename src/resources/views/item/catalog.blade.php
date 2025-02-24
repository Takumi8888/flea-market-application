@extends('layouts.header_functional')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/catalog.css') }}">
@endsection

@section('content')
    <div class="container">
        {{-- タグ --}}
        <div class="tag-section">
            <div class="recommend-group">
                <a class="recommend-group__button--{{ $page == 'recommend' ? 'on' : 'off' }}" href="/">
                    {!! $page == 'recommend' ? 'おすすめ' : 'おすすめ' !!}
                </a>
            </div>
            <form id="my-list-form" class="my-list-form" action="/" method="GET" onsubmit="return false;">
                    <input type="hidden" name="page" value="mylist">
                    <button class="my-list-form__button--{{ $page == 'mylist' ? 'on' : 'off' }}" type="button" onclick="submit();">
                        {!! $page == 'mylist' ? 'マイリスト' : 'マイリスト' !!}
                    </button>
            </form>
        </div>
        {{-- 商品 --}}
        <div class="item-section">
            <ul class="item-group">
                @if (auth()->check())
                    {{-- ログイン時：おすすめ --}}
                    {{-- 商品表示：php処理 --}}
                    @if ($page == 'recommend')
                        @php
                            $itemCount = 0;
                            foreach ($items as $item) {
                                $count = $item->id;
                                if (isset($count)){
                                    $itemCount += 1;
                                }
                            }
                        @endphp
                        @for ($i = 0; $i < $itemCount; $i++)
                            @php
                                $item = $items[$i];
                                $exhibitionId = 0;
                                $purchaseId = 0;
                                foreach ($exhibitions as $exhibition) {
                                    if ($exhibition->item_id == $item->id) {
                                        $exhibitionId = $item->id;
                                    }
                                }
                                foreach ($purchases as $purchase) {
                                    if ($purchase->item_id == $item->id) {
                                        $purchaseId = $item->id;
                                    }
                                }
                            @endphp
                            {{-- 商品表示：出品商品は除く --}}
                            @if ($exhibitionId == 0 && $purchaseId == 0)
                                <li class="item-card">
                                    <form class="item-form" action="{{ route('item.show', $item->id) }}" method="GET" onsubmit="return false;">
                                        <button class="item-form__button" type="button" onclick="submit();">
                                            <img class="item-form__button--image" src="{{ asset(Storage::url($item->image)) }}" alt="item">
                                            <span class="item-form__button--name" >{{ $item['name'] }}</span>
                                        </button>
                                    </form>
                                </li>
                            {{-- 購入商品：SOLDOUT表示 --}}
                            @elseif ($exhibitionId == 0 && $purchaseId != 0)
                                <li class="item-card">
                                    <img class="item-form__button--image" src="{{ asset('image/item/sold.png') }}" alt="item">
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <span class="item-form__button--name" >{{ $item['name'] }}</span>
                                </li>
                            @endif
                        @endfor
                    {{-- ログイン時：マイリスト --}}
                    {{-- 商品表示：php処理 --}}
                    @elseif ($page == 'mylist')
                        @php
                            $itemCount = 0;
                            foreach ($items as $item) {
                                $count = $item->id;
                                if (isset($count)){
                                    $itemCount += 1;
                                }
                            }
                        @endphp
                        @for ($i = 0; $i < $itemCount; $i++)
                            @php
                                $item = $items[$i];
                                $exhibitionId = 0;
                                $purchaseId = 0;
                                $likeId = 0;
                                foreach ($exhibitions as $exhibition) {
                                    if ($exhibition->item_id == $item->id) {
                                        $exhibitionId = $item->id;
                                    }
                                }
                                foreach ($purchases as $purchase) {
                                    if ($purchase->item_id == $item->id) {
                                        $purchaseId = $item->id;
                                    }
                                }
                                foreach ($likes as $like) {
                                    if ($like->item_id == $item->id) {
                                        $likeId = $item->id;
                                    }
                                }
                            @endphp
                            {{-- 商品表示：出品商品は除く --}}
                            @if ($exhibitionId == 0 && $purchaseId == 0 && $likeId != 0)
                                <li class="item-card">
                                    <form class="item-form" action="{{ route('item.show', $item->id) }}" method="GET" onsubmit="return false;">
                                        <button class="item-form__button" type="button" onclick="submit();">
                                            <img class="item-form__button--image" src="{{ asset(Storage::url($item->image)) }}" alt="item">
                                            <span class="item-form__button--name" >{{ $item['name'] }}</span>
                                        </button>
                                    </form>
                                </li>
                            {{-- 購入商品：SOLDOUT表示 --}}
                            @elseif ($exhibitionId == 0 && $purchaseId != 0 && $likeId != 0)
                                <li class="item-card">
                                    <img class="item-form__button--image" src="{{ asset('image/item/sold.png') }}" alt="item">
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <span class="item-form__button--name" >{{ $item['name'] }}</span>
                                </li>
                            @endif
                        @endfor
                    @endif
                {{-- ログアウト時 --}}
                @else
                    {{-- ログアウト時：おすすめ --}}
                    {{-- 商品表示：php処理 --}}
                    @if ($page == 'recommend')
                        @php
                            $itemCount = 0;
                            foreach ($items as $item) {
                                $count = $item->id;
                                if (isset($count)){
                                    $itemCount += 1;
                                }
                            }
                        @endphp
                        @for ($i = 0; $i < $itemCount; $i++)
                            @php
                                $item = $items[$i];
                                $purchaseId = 0;
                                foreach ($purchases as $purchase) {
                                    if ($purchase->item_id == $item->id) {
                                        $purchaseId = $item->id;
                                    }
                                }
                            @endphp
                            {{-- 商品表示 --}}
                            @if ($purchaseId == 0)
                                <li class="item-card">
                                    <form class="item-form" action="{{ route('item.show', $item->id) }}" method="GET" onsubmit="return false;">
                                        <button class="item-form__button" type="button" onclick="submit();">
                                            <img class="item-form__button--image" src="{{ asset(Storage::url($item->image)) }}" alt="item">
                                            <span class="item-form__button--name" >{{ $item['name'] }}</span>
                                        </button>
                                    </form>
                                </li>
                            {{-- 購入商品：SOLDOUT表示 --}}
                            @elseif ($purchaseId != 0)
                                <li class="item-card">
                                    <img class="item-form__button--image" src="{{ asset('image/item/sold.png') }}" alt="item">
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <span class="item-form__button--name" >{{ $item['name'] }}</span>
                                </li>
                            @endif
                        @endfor
                    {{-- ログアウト時：マイリスト --}}
                    @elseif ($page == 'mylist')
                    @endif
                @endif
            </ul>
        </div>
    </div>
@endsection

<script src="{{ asset('js/item/catalog.js') }}"></script>