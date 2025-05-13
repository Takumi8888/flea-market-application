@extends('layouts.default')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/exhibition.css') }}">
@endsection

@if(Route::currentRouteName() === 'exhibition.create')
	@section('title', '出品')
@elseif(Route::currentRouteName() === 'exhibition.edit')
	@section('title', '出品商品編集')
@endif

@section('content')
@include('components.header')
<main>
    <div class="container">
		{{-- 更新メッセージ --}}
        @if(Route::currentRouteName() === 'exhibition.edit')
			@if (session('message'))
				<div class="message alert--success">
					{{ session('message') }}
				</div>
			@elseif ($errors->any())
				<div class="message alert--danger">更新できませんでした</div>
			@endif
        @endif
		{{-- ページタイトル --}}
		<h1 class="page__title">商品の出品</h1>
		@if(Route::currentRouteName() === 'exhibition.create')
			<form class="exhibition-form" action="{{ route('exhibition.store') }}" method="post" enctype="multipart/form-data">
		@elseif(Route::currentRouteName() === 'exhibition.edit')
			<form class="exhibition-form" action="{{ route('exhibition.update', $item->id) }}" method="post" enctype="multipart/form-data">
				@method('put')
		@endif
            @csrf
            {{-- 商品画像 --}}
			<div class="group exhibition-item__img">
				<label for="file">商品画像</label>
				<div class="exhibition-item__file">
					@if(Route::currentRouteName() === 'exhibition.create')
						<img id="img">
						<input id="file" name="image" type="file" accept=".png, .jpg" value="{{ old("image") }}">
					@elseif(Route::currentRouteName() === 'exhibition.edit')
						<img id="img" src="{{ Storage::url($item->image) }}" alt="商品画像">
						<input id="file" name="image" type="file" accept=".png, .jpg">
					@endif
					<button id="btn--img" type="button">画像を選択する</button>
                </div>
				<div class="error">
					@error('image'){{ $message }}@enderror
				</div>
            </div>
            {{-- 商品の詳細 --}}
			<div class="exhibition-item__detail">
				<h3 class="section__title">商品の詳細</h3>
                {{-- 商品の詳細：カテゴリー --}}
				<div class="group exhibition-item__category">
					<label for="name">カテゴリー</label>
					<div class="exhibition-item__checkbox">
                        @foreach($categories as $category)
							@if(Route::currentRouteName() === 'exhibition.create')
								<input class="checkbox" type="checkbox" name="category[]" value="{{ $category->id }}"
									{{ !empty(old("category")) && in_array((string)$category->id, old("category"), true) ? 'checked' : ''}}>
								<input class="btn--category" type="button" value="{{ $category->content }}">
							@elseif(Route::currentRouteName() === 'exhibition.edit')
								@php
									foreach($item->Categories as $selectCategory) {
										if($category->id == $selectCategory->id) {
											$category = $selectCategory;
										}
									}
								@endphp
								@if(isset($category->pivot->category_id))
									<input class="checkbox" type="checkbox" name="category[]" value="{{ $category->id }}" checked>
									<input class="btn--category" type="button" value="{{ $category->content }}">
								@elseif(empty($category->pivot->category_id))
									<input class="checkbox" type="checkbox" name="category[]" value="{{ $category->id }}"
										{{ !empty(old("category")) && in_array((string)$category->id, old("category"), true) ? 'checked' : ''}}>
									<input class="btn--category" type="button" value="{{ $category->content }}">
								@endif
							@endif
                        @endforeach
                    </div>
					<div class="error">
						@error('category'){{ $message }}@enderror
					</div>
                </div>
                {{-- 商品の詳細：商品の状態 --}}
				<div class="group exhibition-item__condition">
					<label for="condition">商品の状態</label>
					<div class="exhibition-item__triangle">
                        <select class="exhibition-item__select" name="condition">
                            <option value="" hidden>選択してください</option>
							@if(Route::currentRouteName() === 'exhibition.create')
								<option value="1" @if (1 === (int)old('condition')) selected @endif>良好</option>
								<option value="2" @if (2 === (int)old('condition')) selected @endif>目立った傷や汚れなし</option>
								<option value="3" @if (3 === (int)old('condition')) selected @endif>やや傷や汚れあり</option>
								<option value="4" @if (4 === (int)old('condition')) selected @endif>状態が悪い</option>
							@elseif(Route::currentRouteName() === 'exhibition.edit')
								<option value="1" @if(1 == $item->condition ) selected @endif>良好</option>
								<option value="2" @if(2 == $item->condition ) selected @endif>目立った傷や汚れなし</option>
								<option value="3" @if(3 == $item->condition ) selected @endif>やや傷や汚れあり</option>
								<option value="4" @if(4 == $item->condition ) selected @endif>状態が悪い</option>
							@endif
                        </select>
                    </div>
					<div class="error">
						@error('condition'){{ $message }}@enderror
					</div>
                </div>
            </div>
            {{-- 商品名と説明 --}}
			<div class="exhibition-item__detail">
				<h3 class="section__title">商品名と説明</h3>
                {{-- 商品名と説明：商品名 --}}
				<div class="group exhibition-item__name">
                    <label for="name">商品名</label>
					@if(Route::currentRouteName() === 'exhibition.create')
						<input id="name" name="name" type="text" value="{{ old('name') }}">
					@elseif(Route::currentRouteName() === 'exhibition.edit')
						<input id="name" name="name" type="text" value="{{ $item->name }}">
					@endif
					<div class="error">
						@error('name'){{ $message }}@enderror
					</div>
                </div>
                {{-- 商品名と説明：ブランド名 --}}
				<div class="group exhibition-item__brand">
					<label for="brand">ブランド名</label>
					@if(Route::currentRouteName() === 'exhibition.create')
						<input id="brand" name="brand" type="text" value="{{ old('brand') }}">
					@elseif(Route::currentRouteName() === 'exhibition.edit')
						<input id="brand" name="brand" type="text" value="{{ $item->brand }}">
					@endif
					<div class="error">
						@error('brand'){{ $message }}@enderror
					</div>
                </div>
                {{-- 商品名と説明：商品の説明 --}}
				<div class="group exhibition-item__textarea">
					<label for="detail">商品の説明</label>
					@if(Route::currentRouteName() === 'exhibition.create')
						<textarea id="detail" name="detail">{{ old('detail') }}</textarea>
					@elseif(Route::currentRouteName() === 'exhibition.edit')
						<textarea id="detail" name="detail">{{ $item->detail }}</textarea>
					@endif
					<div class="error">
						@error('detail'){{ $message }}@enderror
					</div>
                </div>
                {{-- 商品名と説明：販売価格 --}}
				<div class="group exhibition-item__price">
					<label for="price">販売価格</label>
					<div class="exhibition-item__price-input">
						<span>￥</span>
						@if(Route::currentRouteName() === 'exhibition.create')
							<input id="price" name="price" type="text" value="{{ old('price') }}">
						@elseif(Route::currentRouteName() === 'exhibition.edit')
							<input id="price" name="price" type="text" value="{{ $item->price }}">
						@endif
					</div>
					<div class="error">
						@error('price'){{ $message }}@enderror
					</div>
                </div>
            </div>
            {{-- 変更ボタン --}}
			@if(Route::currentRouteName() === 'exhibition.create')
				<button class="btn btn--exhibition-update" type="submit">出品する</button>
			@elseif(Route::currentRouteName() === 'exhibition.edit')
				<input type="hidden" name="id" value="{{ $item->id }}">
				<button id="exhibition-button" class="btn btn--exhibition-update" type="submit">更新する</button>
			@endif
        </form>
    </div>
</main>

<script src="{{ asset('js/exhibition.js') }}"></script>

{{-- バリデーションエラー時のJavaScript --}}
<script>
    function loadFinished(){
        const categoryButton = document.getElementsByClassName("btn--category");
        const checkbox = document.getElementsByClassName("checkbox");
        for (let i = 0; i < categoryButton.length; i++) {
            if (checkbox[i].checked) {
                categoryButton[i].style.backgroundColor = '#FF5555';
                categoryButton[i].style.color = '#FFFFFF';
            }
        }
    }
</script>

@endsection