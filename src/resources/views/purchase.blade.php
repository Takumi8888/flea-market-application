@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('title', '購入')

@section('content')
@include('components.header')
<main>
    <div class="container">
        <form class="purchase-form" action="{{ route('purchase.purchase', $item->id) }}" method="post">
            @csrf
            {{-- 入力フォーム --}}
            <div class="purchase__input-item">
                <div class="group purchase__item">
                    {{-- 商品画像 --}}
                    <img src="{{ asset(Storage::url($item->image)) }}" alt="商品画像">
                    {{-- 商品名／販売価格 --}}
                    <div class="purchase__item-detail">
                        <input class="purchase__item-detail--name" type="text" name="name" value="{{ $item->name }}" readonly />
                        <div class="purchase__item-detail--price">
                            <input type="text" name="price" value="￥{{ number_format($item->price) }}" readonly />
                        </div>
                    </div>
                </div>
                {{-- 支払方法 --}}
                <div class="group purchase__payment">
                    <h3 class="section__title">支払い方法</h3>
                    <select id="select" class="purchase__payment_method" name="payment_method">
                        <option value="" hidden>選択してください</option>
                        <option value="konbini">コンビニ支払い</option>
                        <option value="card">カード支払い</option>
                    </select>
                    <div class="error">
                        @error('purchase'){{ $message }}@enderror
                    </div>
                </div>
                {{-- 配送先 --}}
                <div class="group purchase__shipping-address">
                    <div class="purchase__shipping-address--change-btn">
                        <h3 class="section__title">配送先</h3>
                        <a class="link btn--address" href="{{ route('profile.addressEdit', $item->id) }}">変更する</a>
                    </div>
					<input class="purchase__shipping-address--postcode" type="text" name="user_postcode" value="{{ $profile->user_postcode }}" readonly />
					<input type="text" name="user_address" value="{{ $profile->user_address }}" readonly />
					<input type="text" name="user_building" value="{{ $profile->user_building }}" readonly />
                    <div class="error">
						@error('user_postcode'){{ $message }}@enderror
						@error('user_address') {{ $message }}@enderror
                        @error('user_building'){{ $message }}@enderror
                    </div>
                </div>
            </div>
            {{-- 購入フォーム --}}
            <div class="purchase__purchase-btn">
                <table>
                    <tr>
                        <th class="purchase-table__header line">商品代金</th>
                        <td class="purchase-table__data line">
							<div class="purchase-table__product-price">
								<input type="text" name="price" value="￥{{ number_format($item->price) }}" readonly />
							</div>
                        </td>
                    </tr>
                    <tr>
                        <th class="purchase-table__header">支払い方法</th>
                        <td class="purchase-table__data">
                            <div id="display"></div>
                        </td>
                    </tr>
                </table>
                {{-- 購入ボタン --}}
                <button class="btn btn--purchase" type="submit">購入する</button>
            </div>
        </form>
    </div>
</main>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://checkout.stripe.com/checkout.js"></script>
<script src="{{ asset('js/purchase.js') }}"></script>

@endsection