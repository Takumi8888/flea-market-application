{{-- 出品商品（購入可能） --}}
@if ($exhibition->status == 1)
	<li class="item-card">
		<form class="item-form" action="{{ route('item.show', $item->id) }}" method="get" onsubmit="return false;">
			<button class="btn btn--item" type="button" onclick="submit();">
				<img src="{{ asset(Storage::url($item->image)) }}" alt="商品画像">
				<span>{{ $item->name }}</span>
			</button>
		</form>
	</li>
{{-- 取引中・購入済商品（購入不可） --}}
@elseif ($exhibition->status == 2 || $exhibition->status == 3)
	<li class="item-card">
		<form class="item-form" action="{{ route('item.buyItem', $item->id) }}" method="get" onsubmit="return false;">
			<button type="button" onclick="submit();"
			@if ($exhibition->status == 2)class="btn btn--item transaction"
			@elseif ($exhibition->status == 3)class="btn btn--item sold"
			@endif>
				<img src="{{ asset(Storage::url($item->image)) }}" alt="商品画像">
				<span>{{ $item->name }}</span>
			</button>
		</form>
	</li>
@endif