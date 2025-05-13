<div class="modal__inner">
	<div class="modal__content">
		<form class="review-form" method="post"
		@if ($user_transaction->status == 1 &&  $partner_transaction->status == 2)
			action="{{ route('transaction.review', ['tag'=>$tag, 'item'=>$item]) }}"
		@elseif ($user_transaction->status == 1)
			action="{{ route('transaction.store', ['tag'=>$tag, 'item'=>$item]) }}"
		@endif>
			@csrf
			<div class="modal__message line">
				<h2>取引が完了しました。</h2>
			</div>
			<div class="modal__review line">
				<h3>今回の取引相手はどうでしたか？</h3>
				<div class="modal__review-star">
					<input class="review-input" id="star5" name="review" type="radio" value="5">
					<label class="review-label" for="star5"><i class="bi bi-star-fill"></i></label>

					<input class="review-input" id="star4" name="review" type="radio" value="4">
					<label class="review-label" for="star4"><i class="bi bi-star-fill"></i></label>

					<input class="review-input" id="star3" name="review" type="radio" value="3">
					<label class="review-label" for="star3"><i class="bi bi-star-fill"></i></label>

					<input class="review-input" id="star2" name="review" type="radio" value="2">
					<label class="review-label" for="star2"><i class="bi bi-star-fill"></i></label>

					<input class="review-input" id="star1" name="review" type="radio" value="1">
					<label class="review-label" for="star1"><i class="bi bi-star-fill"></i></label>
				</div>
			</div>
			<div class="modal__review-btn">
				<button class="btn--review">送信する</button>
			</div>
		</form>
	</div>
</div>