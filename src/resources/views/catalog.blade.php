@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/catalog.css') }}">
@endsection

@section('title', '商品一覧')

@section('content')
@include('components.header')
<main>
    <div class="container">
        {{-- タグ --}}
        <div class="tag-section">
            <div class="tag recommend-group">
                <a class="tag-link btn--{{ $page == 'recommend' ? 'on' : 'off' }}" href="/">
                    {!! $page == 'recommend' ? 'おすすめ' : 'おすすめ' !!}
                </a>
            </div>
            <form id="my-list-form" class="tag my-list-form" action="/" method="get" onsubmit="return false;">
                    <input type="hidden" name="page" value="mylist">
                    <button class="tag-btn btn--{{ $page == 'mylist' ? 'on' : 'off' }}" type="button" onclick="submit();">
                        {!! $page == 'mylist' ? 'マイリスト' : 'マイリスト' !!}
                    </button>
            </form>
        </div>
        {{-- 商品 --}}
        <div class="item-section">
            <ul>
                @if (auth()->check())
                    {{-- ログイン時：おすすめ --}}
                    @if ($page == 'recommend')
                        @for ($i = 0; $i < $count; $i++)
                            @php
								$exhibition = $exhibitions[$i];
								$item =  App\Models\Item::where('id', $exhibition->item_id)->first();
                            @endphp
							@include('components.item_card')
                        @endfor
                    {{-- ログイン時：マイリスト --}}
                    @elseif ($page == 'mylist')
						@for ($i = 0; $i < $count; $i++)
							@php
								$like = $likes[$i];
								$item =  App\Models\Item::where('id', $like->item_id)->first();
								$exhibition = App\Models\Exhibition::where('item_id', $item->id)->first();
							@endphp
                            @include('components.item_card')
                        @endfor
                    @endif
                @else
                    {{-- ログアウト時：おすすめ --}}
                    @if ($page == 'recommend')
						@for ($i = 0; $i < $count; $i++)
							@php
								$exhibition = $exhibitions[$i];
								$item =  App\Models\Item::where('id', $exhibition->item_id)->first();
							@endphp
							@include('components.item_card')
                        @endfor
                    {{-- ログアウト時：マイリスト --}}
                    @elseif ($page == 'mylist')
                    @endif
                @endif
            </ul>
        </div>
    </div>
</main>
@endsection

<script src="{{ asset('js/catalog.js') }}"></script>