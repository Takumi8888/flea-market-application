@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('title', 'マイページ')

@section('content')
@include('components.header')
<main>
	<div class="container">
		{{-- プロフィール --}}
		<div class="profile-section">
			<img class="profile__img" src="{{ Storage::url($profile->user_image) }}" alt="プロフィール画像">
			<div class="profile-group">
				<div class="profile__name">{{ $profile->user_name }}</div>
				<div class="profile__review">
					@if ($overall_rating != 0)
						<input class="review-input" id="star5" name="review" type="radio" value="5"
						{{$overall_rating == 5 ? 'checked' : '' }}>
						<label class="review-label" for="star5"><i class="bi bi-star-fill"></i></label>

						<input class="review-input" id="star4" name="review" type="radio" value="4"
						{{$overall_rating == 4 ? 'checked' : '' }}>
						<label class="review-label" for="star4"><i class="bi bi-star-fill"></i></label>

						<input class="review-input" id="star3" name="review" type="radio" value="3"
						{{$overall_rating == 3 ? 'checked' : '' }}>
						<label class="review-label" for="star3"><i class="bi bi-star-fill"></i></label>

						<input class="review-input" id="star2" name="review" type="radio" value="2"
						{{$overall_rating == 2 ? 'checked' : '' }}>
						<label class="review-label" for="star2"><i class="bi bi-star-fill"></i></label>

						<input class="review-input" id="star1" name="review" type="radio" value="1"
						{{$overall_rating == 1 ? 'checked' : '' }}>
						<label class="review-label" for="star1"><i class="bi bi-star-fill"></i></label>
					@endif
				</div>
			</div>
			<a class="btn--profile" href="{{ route('profile.edit')}}">プロフィールを編集</a>
		</div>
		{{-- タグ --}}
		<div class="tag-section">
			<form class="tag sell-form" action="{{ route('item.mypage') }}" method="get" onsubmit="return false;">
				<input type="hidden" name="page" value="sell">
				<button class="sell-btn btn--{{ $page == 'sell' ? 'on' : 'off' }}" type="button" onclick="submit();">
					{!! $page == 'sell' ? '出品した商品' : '出品した商品' !!}
				</button>
			</form>
			<form class="tag buy-form" action="{{ route('item.mypage') }}" method="get" onsubmit="return false;">
				<input type="hidden" name="page" value="buy">
				<button class="buy-btn btn--{{ $page == 'buy' ? 'on' : 'off' }}" type="button" onclick="submit();">
					{!! $page == 'sell' ? '購入した商品' : '購入した商品' !!}
				</button>
			</form>
			<form class="tag transaction-form" action="{{ route('item.mypage') }}" method="get" onsubmit="return false;">
				<input type="hidden" name="page" value="transaction">
				<button class="transaction-btn btn--{{ $page == 'transaction' ? 'on' : 'off' }}" type="button" onclick="submit();">
					{!! $page == 'transaction' ? '取引中の商品' : '取引中の商品' !!}
				</button>
				@if ($messages_count >= 1)
					<span class="message message-count">{{$messages_count}}</span>
				@endif
			</form>
		</div>
		{{-- 商品 --}}
		<div class="item-section">
			<ul>
				{{-- 出品した商品 --}}
				@if ($page == 'sell')
					@foreach ($profile->exhibitions as $item)
						<li class="item-card">
							@if($item->exhibitions->status != 3)
								<form class="item-form" action="{{ route('exhibition.edit', $item->id) }}" method="get" onsubmit="return false;">
							@endif
								<button type="button" onclick="submit();"
								@if($item->exhibitions->status == 1) class="btn btn--item"
								@elseif($item->exhibitions->status == 2) class="btn btn--item transaction"
								@elseif($item->exhibitions->status == 3) class="btn btn--item sold"
								@endif>
									<img src="{{ asset(Storage::url($item->image)) }}" alt="商品画像">
									<span class="item-form__name">{{ $item->name }}</span>
								</button>
							@if($item->exhibitions->status != 3)
								</form>
							@endif
						</li>
					@endforeach
				{{-- 購入した商品 --}}
				@elseif ($page == 'buy')
					@foreach ($profile->purchases as $item)
						<li class="item-card">
							<form class="item-form" action="{{ route('item.buyItem', $item->id) }}" method="get" onsubmit="return false;">
								<button type="button" onclick="submit();"
								@if ($item->purchases->status == 1) class="btn btn--item transaction"
								@elseif ($item->purchases->status == 2) class="btn btn--item sold"
								@endif>
									<img src="{{ asset(Storage::url($item->image)) }}" alt="商品画像">
									<span class="item-form__name">{{ $item->name }}</span>
								</button>
							</form>
						</li>
					@endforeach
				{{-- 取引中の商品 --}}
				@elseif ($page == 'transaction')
					@foreach ($transaction_items as $transaction_item)
						@php
							foreach ($profile->transactions as $transactionItem) {
								$transaction_partner = App\Models\Transaction::where('profile_id', '!=', $profile->id)
								->where('item_id', $transaction_item->item_id)->first();

								$message_alerts = App\Models\Message::where('profile_id', '!=', $profile->id)
								->where('item_id', $transaction_partner->item_id)->where('message_alert', 1)->get();
								$message_alerts_count = count($message_alerts);

								$new_transactions = App\Models\Message::where('item_id', $transaction_item->item_id)->get();
								$new_transactions_count = count($new_transactions);

								if ($transaction_item->exhibitor == 1 && $transactionItem->id == $transaction_item->item_id) {
									$item = $transactionItem;
									$exhibitor = 1;
									$purchaser = 0;
								} elseif ($transaction_item->purchaser == 1 && $transactionItem->id == $transaction_item->item_id) {
									$item = $transactionItem;
									$exhibitor = 0;
									$purchaser = 1;
								}
							}
						@endphp
						<li class="item-card">
							<form class="item-form" method="get" onsubmit="return false;"
							@if ($exhibitor == 1) action="{{ route('transaction.create', ['tag'=>'sell', 'item'=>$item]) }}"
							@elseif ($purchaser == 1) action="{{ route('transaction.create', ['tag'=>'buy', 'item'=>$item]) }}"
							@endif>
								<button class="btn btn--item" type="button" onclick="submit();">
									@if ($message_alerts_count >= 1)
										<span class="message message--alert">{{$message_alerts_count}}</span>
									@elseif ($new_transactions_count == 0)
										<span class="message message--new">new</span>
									@endif
									<img src="{{ asset(Storage::url($item->image)) }}" alt="商品画像">
									<span class="item-form__name">{{ $item->name }}</span>
								</button>
							</form>
						</li>
					@endforeach
				@endif
			</ul>
		</div>
	</div>
</main>
@endsection