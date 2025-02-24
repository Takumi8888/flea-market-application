@extends('layouts.header_functional')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/stripe.css') }}">
@endsection

@section('content')
    <div class="container">
        {{-- ロゴ --}}
        <div class="title-section">
            <h2 class="title__text">Stripe決済</h2>
        </div>
        {{-- Stripe決済 --}}
        <form id="card-form" action="{{ route('purchase.stripeStore', $item->id) }}" method="POST">
            @csrf
            {{-- カード番号 --}}
            <div class="card-form__group">
                <label for="card_number">カード番号</label>
                <div id="card-number" class="card-form__control"></div>
            </div>
            {{-- 有効期限 --}}
            <div class="card-form__group">
                <label for="card_expiry">有効期限</label>
                <div id="card-expiry" class="card-form__control"></div>
            </div>
            {{-- セキュリティコード --}}
            <div class="card-form__group">
                <label for="card-cvc">セキュリティコード</label>
                <div id="card-cvc" class="card-form__control"></div>
            </div>
            {{-- エラー --}}
            <div id="card-errors" class="text-danger"></div>
            {{-- 支払ボタン --}}
            <button id="card-button" class="mt-3 btn btn-primary">支払い</button>
        </form>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('js/item/stripe.js') }}"></script>

@endsection