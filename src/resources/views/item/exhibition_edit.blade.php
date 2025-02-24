@extends('layouts.header_functional')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/exhibition_edit.css') }}">
@endsection

@section('content')
    <div class="container">
        {{-- ロゴ --}}
        <div class="title-section">
            <h2 class="title__text">商品の出品</h2>
        </div>
        <form class="exhibition-form" action="{{ route('exhibition.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            {{-- 商品画像 --}}
            <div class="exhibition-form-group">
                <label for="file">商品画像</label>
                <div class="exhibition-form__file">
                    <img id="image" class="exhibition-form__image" src="{{ asset(Storage::url($item['image'])) }}" alt="item">
                    <input id="file" name="image" type="file" accept=".png, .jpg" value="{{ $item['image'] }}">
                    <button id="image-button" type="button">画像を選択する</button>
                </div>
                <div class="exhibition-form__error--image">
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            {{-- 商品の詳細 --}}
            <div class="exhibition-form-section">
                <div class="section-title-group">
                    <h3 class="section-title__text">商品の詳細</h3>
                </div>
                {{-- 商品の詳細：カテゴリー --}}
                <div class="exhibition-form-group">
                    <label for="name">カテゴリー</label>
                    <div class="exhibition-form__checkbox">
                        @foreach($categories as $category)
                            <input class="checkbox" type="checkbox" name="category[]" value="{{ $category->id }}"
                                {{ !empty(old("category")) && in_array((string)$category->id, old("category"), true) ? 'checked' : ''}}>
                            <input class="category-button" type="button" value="{{ $category['content'] }}">
                        @endforeach
                    </div>
                    <div class="exhibition-form__error--category">
                        @error('category')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                {{-- 商品の詳細：商品の状態 --}}
                <div class="exhibition-form-group">
                    <label for="condition">商品の状態</label>
                    <div class="exhibition-form__triangle">
                        <select class="exhibition-form__select" name="condition">
                            <option value="" hidden>選択してください</option>
                            <option value="1" @if(1 == $item['condition'] ) selected @endif>良好</option>
                            <option value="2" @if(2 == $item['condition'] ) selected @endif>目立った傷や汚れなし</option>
                            <option value="3" @if(3 == $item['condition'] ) selected @endif>やや傷や汚れあり</option>
                            <option value="4" @if(4 == $item['condition'] ) selected @endif>状態が悪い</option>
                        </select>
                    </div>
                    <div class="exhibition-form__error">
                        @error('condition')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            {{-- 商品名と説明 --}}
            <div class="exhibition-form-section">
                <div class="section-title-group">
                    <h3 class="section-title__text">商品名と説明</h3>
                </div>
                {{-- 商品名と説明：商品名 --}}
                <div class="exhibition-form-group">
                    <div class="exhibition-form__input--name">
                        <label for="name">商品名</label>
                        <input id="name" name="name" type="text" value="{{ $item['name'] }}">
                    </div>
                    <div class="exhibition-form__error">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                {{-- 商品名と説明：ブランド名 --}}
                <div class="exhibition-form-group">
                    <div class="exhibition-form__input--brand">
                        <label for="brand">ブランド名</label>
                        <input id="brand" name="brand" type="text" value="{{ $item['brand'] }}">
                    </div>
                    <div class="exhibition-form__error">
                        @error('brand')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                {{-- 商品名と説明：商品の説明 --}}
                <div class="exhibition-form-group">
                    <div class="exhibition-form__textarea">
                        <label for="detail">商品の説明</label>
                        <textarea id="detail" name="detail">{{ $item['detail'] }}</textarea>
                    </div>
                    <div class="exhibition-form__error">
                        @error('detail')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                {{-- 商品名と説明：販売価格 --}}
                <div class="exhibition-form-group">
                    <div class="exhibition-form__price">
                        <label for="price">販売価格</label>
                        <div class="exhibition-form__input--price">
                            <span class="exhibition-form__input--symbol">￥</span>
                            <input id="price" name="price" type="text" value="{{ $item['price'] }}">
                        </div>
                    </div>
                    <div class="exhibition-form__error">
                        @error('price')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            {{-- ボタン --}}
            <input type="hidden" name="id" value="{{ $item['id'] }}">
            <button id="exhibition-button" class="exhibition-form__button--exhibition" type="submit">更新する</button>
        </form>
    </div>

<script src="{{ asset('js/item/exhibition_edit.js') }}"></script>
<script>
    // バリデーションエラー時のJavaScript
    function loadFinished(){
        // 画像ボタン
        const imageButton = document.getElementById("image-button");
        const file = document.getElementById("file");
        if (file.value) {
            imageButton.style.backgroundColor = '#FF5555';
            imageButton.style.color = '#FFFFFF';
        }

        // カテゴリボタン
        const categoryButton = document.getElementsByClassName("category-button");
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