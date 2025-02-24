@extends('layouts.header_functional')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/purchase.css') }}">
@endsection

@section('content')
    <div class="container">
        <form class="purchase-form" action="{{ route('purchase.store', $item->id) }}" method="POST">
            @csrf
            {{-- 左側 --}}
            <div class="purchase-form-section-left">
                <div class="purchase-form-group-item">
                    {{-- 商品画像 --}}
                    <img class="purchase-form__image" src="{{ asset(Storage::url($item['image'])) }}" alt="No Image">
                    {{-- 商品名／販売価格 --}}
                    <div class="purchase-form__name-price">
                        <input class="purchase-form__input--name" type="text" name="name" value="{{ $item['name'] }}" readonly />
                        <div class="purchase-form__price">
                            <span class="purchase-form__input--yen">￥</span>
                            <input class="purchase-form__input--price" type="text" name="price" value="{{ number_format($item['price']) }}" readonly />
                        </div>
                    </div>
                </div>
                {{-- 支払方法 --}}
                <div class="purchase-form-group">
                    <h4 class="purchase-form__text">支払い方法</h4>
                    <select id="select" class="purchase-form__select" name="purchase">
                        <option value="" hidden>選択してください</option>
                        <option value="1">コンビニ払い</option>
                        <option value="2">カード支払い</option>
                    </select>
                    <div class="purchase-form__error">
                        @error('purchase')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- 配送先 --}}
                <div class="purchase-form-group">
                    <div class="purchase-form-address-change">
                        <h4 class="purchase-form__text">配送先</h4>
                        <a class="purchase-form__button--address" href="{{ route('address.edit', $item->id) }}">変更する</a>
                    </div>
                    <div class="purchase-form-shipping-address">
                        <input class="purchase-form__postcode" type="text" name="postcode" value="{{ $profile['postcode'] }}" readonly />
                        <div class="purchase-form__address-build">
                            <input type="hidden" name="address" value="{{ $profile['address'] }}" readonly />
                            <span class="purchase-form__address">{{ $profile['address'] }}</span>
                            <input type="hidden" name="building" value="{{ $profile['building'] }}" readonly />
                            <span class="purchase-form__build">{{ $profile['building'] }}</span>
                        </div>
                    </div>
                    <div class="purchase-form__error">
                        @error('address')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- 右側 --}}
            <div class="purchase-form-section-right">
                {{-- 表 --}}
                <table class="purchase-form-table">
                    <tr class="purchase-form-table__row">
                        <th class="purchase-form-table__header--price">商品代金</th>
                        <td class="purchase-form-table__price">
                            <div class="purchase-form-table__input">
                                <span class="purchase-form-table__input--yen">￥</span>
                                <input class="purchase-form-table__input--price" type="text" name="price" value="{{ number_format($item['price']) }}" readonly />
                            </div>
                        </td>
                    </tr>
                    <tr class="purchase-form-table__row">
                        <th class="purchase-form-table__header--purchase">支払い方法</th>
                        <td class="purchase-form-table__method">
                            <div id="display"></div>
                        </td>
                    </tr>
                </table>
                {{-- 購入ボタン --}}
                <input type="hidden" name="id" value="{{ $item['id'] }}">
                <button class="purchase-form__button--purchase" type="submit">購入する</button>
            </div>
        </form>
    </div>
<script src="{{ asset('js/item/purchase.js') }}"></script>

@endsection