@extends('layouts.header_functional')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/detail.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
    <div class="container">
        {{-- 左側 --}}
        <div class="detail-section-left">
            {{-- 商品画像 --}}
            <img class="detail__image" src="{{ asset(Storage::url($item['image'])) }}" alt="Item">
        </div>
        {{-- 右側 --}}
        <div class="detail-section-right">
            {{-- 商品名 --}}
            <div class="detail-group">
                <h3 class="detail__name">{{ $item['name'] }}</h3>
                <p class="detail__brand">{{ $item['brand'] }}</p>
            </td>
            {{-- 販売価格 --}}
            <div class="detail-group">
                <span class="detail__yen">￥</span>
                <span class="detail__price">{{ number_format($item['price']) }}</span>
                <span class="detail__tax">(税込)</span>
            </div>
            {{-- いいね --}}
            <form class="like-form" action="{{ route('item.toggleLike', $item->id) }}" method="POST">
                @csrf
                @if(Auth::check())
                    <button class="like-form__button--{{ $item->likes->contains('profile_id', $profile->id) ? 'on' : 'off' }}" type="submit">
                        {!! $item->likes->contains('profile_id', $profile->id) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>' !!}
                        <span class="like-form__count">{{ $item->likes->count($item->id)}}</span>
                    </button>
                @else
                    <button class="like-form__button--off" type="submit" formaction="/login" formmethod="GET">
                        <i class="bi bi-star"></i>
                        <span class="like-form__count">{{ $item->likes->count($item->id)}}</span>
                    </button>
                @endif
                {{-- コメント --}}
                <div class="icon-button--comment">
                    <i class="bi bi-chat"></i>
                    <span class="comment__icon--count">{{ $item->comments->count($item->id)}}</span>
                </div>
            </form>
            {{-- 購入ボタン --}}
            <div class="detail-group__button">
                <a class="detail__button--purchase"  href="{{ route('purchase.create', $item->id) }}">購入手続きへ</a>
            </div>
            {{-- 商品説明 --}}
            <div class="detail-group">
                <h3 class="detail__title">商品説明</h3>
                <p class="detail__description">{{ $item['detail'] }}</p>
            </div>
            {{-- 商品の情報 --}}
            <div class="detail-group">
                <table class="detail-table">
                    <tr class="detail-table__row-title">
                        <th class="detail-table__header">
                            <h3 class="detail-table__title">商品の情報</h3>
                        </th>
                    </tr>
                    {{-- カテゴリー --}}
                    <tr class="detail-table__row">
                        <th class="detail-table__header">
                            <span class="detail-table__heading">カテゴリー</span>
                        </th>
                        <td class="detail-table__category">
                            @foreach($item->Categories as $category)
                                <input class="category" type="button" name="content" value="{{ $category['content'] }}" readonly>
                            @endforeach
                        </td>
                    </tr>
                    {{-- 商品の状態 --}}
                    <tr class="detail-table__row">
                        <th class="detail-table__header">
                            <span class="detail-table__heading">商品の状態</span>
                        </th>
                        <td class="detail-table__condition">
                            @if ($item['condition'] == 1)
                                <div class="condition">良好</div>
                            @elseif ($item['condition'] == 2)
                                <div class="condition">目立った傷や汚れなし</div>
                            @elseif ($item['condition'] == 3)
                                <div class="condition">やや傷や汚れあり</div>
                            @elseif ($item['condition'] == 4)
                                <div class="condition">状態が悪い</div>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            {{-- 商品コメント表示 --}}
            <div class="comment-form__group">
                <h3 class="comment-form__comment-title">コメント
                    <span class="comment-form__comment-count">&#040;&#032;{{ $item->comments->count($item->id)}}&#032;&#041;</span>
                </h3>
            </div>
            <div class="profile-form__flex">
                @foreach($item->comments as $comment)
                    <div class="comment-form__group-log">
                        <div class="comment-form__user">
                            <img class="comment-form__image" src="{{ Storage::url($comment->image) }}" alt="No Image">
                            <div class="comment-form__name">{{ $comment->user_name }}</div>
                        </div>
                        <p class="comment-form__comment">{{ $comment->comments->comment }}</p>
                    </div>
                @endforeach
            </div>
            {{-- 商品コメント投稿 --}}
            <form class="comment-form" action="{{ route('item.comment', $item->id) }}" method="POST">
                @csrf
                <div class="comment-form-group">
                    <label for="comment">商品へのコメント</label>
                    <textarea id="comment" name="comment">{{ old('comment') }}</textarea>
                </div>
                <div class="comment-form__error">
                        @error('comment')
                            {{ $message }}
                        @enderror
                    </div>
                <button class="comment-form__button--comment" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
@endsection