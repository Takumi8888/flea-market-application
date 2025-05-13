@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/transaction.css') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('title', '取引チャット')

@section('content')
@include('components.header')
<main>
    <div class="container">
		{{-- その他の取引 --}}
		<div class="select-item">
			<p>その他の取引</p>
			<ul>
				@if (isset($other_items))
					@foreach ($other_items as $other_item)
						@php
							foreach ($profile->transactions as $transactionItem) {
								if ($other_item->exhibitor == 1 && $transactionItem->id == $other_item->item_id) {
									$select_item = $transactionItem;
									$exhibitor = 1;
									$purchaser = null;
									$message_alert = $other_item->message_alert;
								} elseif ($other_item->purchaser == 1 && $transactionItem->id == $other_item->item_id) {
									$select_item = $transactionItem;
									$exhibitor = null;
									$purchaser = 1;
									$message_alert = $other_item->message_alert;
								}
							}
						@endphp
						<li>
							<form class="item-form" method="get"
							@if ($exhibitor == 1) action="{{ route('transaction.create', ['tag'=>'sell', 'item'=>$select_item]) }}"
							@elseif ($purchaser == 1) action="{{ route('transaction.create', ['tag'=>'buy', 'item'=>$select_item]) }}"
							@endif>
								<button class="btn--item">{{ $select_item->name }}</button>
							</form>
						</li>
					@endforeach
                @endif
            </ul>
		</div>
		{{-- 取引チャット --}}
		<div class="transaction-chat">
			<div class="transaction__partner">
				<img src="{{ Storage::url($partner->user_image) }}" alt="プロフィール画像">
				<span>「{{ $partner->user_name }}」さんとの取引画面</span>
				{{-- モーダル：出品者 --}}
				@if ($tag == 'sell')
					@if ($user_transaction->status == 1 && $partner_transaction->status == 2)
						<div class="modal modal-sell" id="myModal">
							@include('components.modal')
						</div>
					@endif
				{{-- モーダル：購入者 --}}
				@elseif ($tag == 'buy')
					@if ($user_transaction->status == 1)
						<form class="transaction-form" action="#{{$user_transaction->id}}" method="get">
							<button class="btn--transaction">取引を完了する</button>
						</form>
						<div class="modal modal-buy" id="{{$user_transaction->id}}">
							<a href="#!" ></a>
								@include('components.modal')
						</div>
					@endif
				@endif
			</div>
			{{-- 取引商品 --}}
			<div class="transaction__item">
				<img src="{{ asset(Storage::url($item->image)) }}" alt="Item">
				<div class="transaction__item-detail">
					<h3>{{ $item->name }}</h3>
					<div class="transaction__item--price">
						<span class="item__yen">￥</span>
						<span class="item__price">{{ number_format($item->price) }}</span>
						<span class="item__tax">(税込)</span>
					</div>
				</div>
			</div>
			{{-- 取引メッセージ --}}
			<div class="transaction__message">
				@foreach ($messages as $message)
					{{-- ユーザー：出品者、取引相手：購入者 --}}
					@if ($tag == 'sell')
						@if ($message->transaction->exhibitor == 1)
							@include('components.message_user')
						@elseif ($message->transaction->purchaser == 1)
							@include('components.message_partner')
						@endif
					{{-- ユーザー：購入者、取引相手：出品者 --}}
					@elseif ($tag == 'buy')
						@if ($message->transaction->purchaser == 1)
							@include('components.message_user')
						@elseif ($message->transaction->exhibitor == 1)
							@include('components.message_partner')
						@endif
					@endif
				@endforeach
			</div>
			{{-- 新規メッセージ送信 --}}
			<form class="new-message-form" method="post" enctype="multipart/form-data"
			@if ($tag == 'sell') action="{{ route('transaction.message', ['tag'=>$tag, 'item'=>$item]) }}"
			@elseif ($tag == 'buy') action="{{ route('transaction.message', ['tag'=>$tag, 'item'=>$item]) }}"
			@endif>
				@csrf
					@error('message')
						<div class="error">{{ $message }}</div>
					@enderror
					@error('image')
						<div class="error">{{ $message }}</div>
					@enderror
				<div class="new-message__send">
					<input name="message" type="text" value="{{ old("message") }}" placeholder="取引メッセージを記入してください"></input>
					<div class="new-message__btn">
						<div class="new-message__file">
							<input id="file" name="image" type="file" accept=".png, .jpg" value="{{ old("image") }}">
							<button id="image-button" type="button">画像を追加</button>
						</div>
						<button class="btn--send"><i class="bi bi-send"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</main>

<script src="{{ asset('js/transaction.js') }}"></script>
@if ($tag == 'sell')
	@if ($user_transaction->status == 1 && $partner_transaction->status == 2)
		{{-- レビュー画面表示（モーダル：出品者） --}}
		<script>
			var modal = document.getElementById("myModal");
			window.onload = function() {
				setTimeout(function() {
					modal.style.display = "block";
				}, 777);
			}
		</script>
	@endif
@endif
@endsection