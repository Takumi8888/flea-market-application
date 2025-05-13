@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('title', '商品詳細情報')

@section('content')
@include('components.header')
<main>
    <div class="container">
		{{-- 商品画像 --}}
        <div class="image-section">
            <img src="{{ asset(Storage::url($item->image)) }}" alt="商品画像">
        </div>
        {{-- 商品情報１ --}}
        <div class="item-section">
            {{-- 商品名 --}}
            <div class="item-group">
                <h2 class="item__name">{{ $item->name }}</h2>
                <p class="item__brand">{{ $item->brand }}</p>
            </td>
            {{-- 販売価格 --}}
            <div class="item-group">
                <span class="item__yen">￥</span>
                <span class="item__price">{{ number_format($item->price) }}</span>
                <span class="item__tax">(税込)</span>
            </div>
            {{-- いいね --}}
			@if( Route::currentRouteName() === 'item.show')
				<form class="like-form">
					@if(Auth::check())
						@csrf
						<button class="like-btn btn--{{ $item->likes->contains('profile_id', $profile->id) ? 'on' : 'off' }}" type="submit" formaction="{{ route('item.toggleLike', $item->id) }}" formmethod="post">
							{!! $item->likes->contains('profile_id', $profile->id) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>' !!}
							<span>{{ $item->likes->count($item->id)}}</span>
						</button>
					@else
						<button class="like-btn btn--off" type="submit" formaction="/login" formmethod="get">
							<i class="bi bi-star"></i>
							<span>{{ $item->likes->count($item->id)}}</span>
						</button>
					@endif
					{{-- コメント --}}
					<div class="icon--comment">
						<i class="bi bi-chat"></i>
						<span>{{ $item->comments->count($item->id)}}</span>
					</div>
				</form>
				{{-- 購入ボタン --}}
				<div class="purchase__btn">
					<a class="link-btn btn--purchase"  href="{{ route('purchase.create', $item->id) }}">購入手続きへ</a>
				</div>
			@endif
            {{-- 商品説明 --}}
            <div class="detail-group">
                <h3 class="detail__title">商品説明</h3>
                <p class="detail__description">{{ $item->detail }}</p>
            </div>
            {{-- 商品情報２ --}}
            <div class="detail-group">
                <table>
                    <tr>
                        <th class="detail-table__header">
                            <h3 class="detail__title">商品の情報</h3>
                        </th>
                    </tr>
                    {{-- カテゴリー --}}
                    <tr>
                        <th class="detail-table__header"><span>カテゴリー</span></th>
                        <td class="detail-table__category">
                            @foreach($item->Categories as $category)
                                <input class="category" type="button" name="content" value="{{ $category->content }}" readonly>
                            @endforeach
                        </td>
                    </tr>
                    {{-- 商品の状態 --}}
                    <tr>
                        <th class="detail-table__header"><span>商品の状態</span></th>
                        <td class="detail-table__condition">
                            @if ($item->condition == 1)
                                <div class="condition">良好</div>
                            @elseif ($item->condition == 2)
                                <div class="condition">目立った傷や汚れなし</div>
                            @elseif ($item->condition == 3)
                                <div class="condition">やや傷や汚れあり</div>
                            @elseif ($item->condition == 4)
                                <div class="condition">状態が悪い</div>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            {{-- コメント履歴 --}}
            <div class="comment__title">
                <h3>コメント<span>&#040;&#032;{{ $item->comments->count($item->id)}}&#032;&#041;</span></h3>
            </div>
			@foreach($item->comments as $comment)
				<div class="comment__log">
					<div class="comment__user">
						<img src="{{ Storage::url($comment->user_image) }}" alt="プロフィール画像">
						<span>{{ $comment->user_name }}</span>
					</div>
					<p>{{ $comment->comments->comment }}</p>
				</div>
			@endforeach
            {{-- コメント投稿 --}}
			@if (Route::currentRouteName() === 'item.show')
				<form class="comment-form" action="{{ route('item.comment', $item->id) }}" method="post">
					@csrf
					<div class="comment-form__text">
						<label for="comment">商品へのコメント</label>
						<textarea id="comment" name="comment">{{ old('comment') }}</textarea>
					</div>
					<div class="error">
						@error('comment'){{ $message }}@enderror
					</div>
					<button class="btn btn--comment" type="submit">コメントを送信する</button>
				</form>
			@endif
        </div>
    </div>
</main>
@endsection