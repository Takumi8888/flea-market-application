<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mail/mail.css') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<title>取引完了通知</title>
</head>

<body>
	<main>
		<div class="container">
			<h3 class="title">下記商品の取引が完了しました。</h3>

			<span class="exhibition-item">取引内容</span>
			<table>
				<tr>
					<th class="exhibition-item__header">商品名</th>
					<td class="exhibition-item__data">{{$item}}</td>
				</tr>
				<tr>
					<th class="exhibition-item__header">販売価格</th>
					<td class="exhibition-item__data">{{$price}} 円</td>
				</tr>
				<tr>
					<th class="exhibition-item__header">販売手数料 10%+税</th>
					<td class="exhibition-item__data">{{$commission_rate}} 円</td>
				</tr>
				<tr>
					<th class="exhibition-item__header">売上金</th>
					<td class="exhibition-item__data">{{$sales_proceeds}} 円</td>
				</tr>
			</table>

			<span class="review">評価</span>
			<table>
				<tr>
					<th class="review__header">購入者</th>
					<td class="review__data">{{$transaction_partner}}</td>
				</tr>
							<tr>
					<th class="review__header">評価</th>
					<td class="review__data">
						<div class="review">
							@if ($review != 0)
								<input class="review-input" id="star5" name="review" type="radio" value="5"
								{{$review == 5 ? 'checked' : '' }}>
								<label class="review-label" for="star5"><i class="bi bi-star-fill"></i></label>

								<input class="review-input" id="star4" name="review" type="radio" value="4"
								{{$review == 4 ? 'checked' : '' }}>
								<label class="review-label" for="star4"><i class="bi bi-star-fill"></i></label>

								<input class="review-input" id="star3" name="review" type="radio" value="3"
								{{$review == 3 ? 'checked' : '' }}>
								<label class="review-label" for="star3"><i class="bi bi-star-fill"></i></label>

								<input class="review-input" id="star2" name="review" type="radio" value="2"
								{{$review == 2 ? 'checked' : '' }}>
								<label class="review-label" for="star2"><i class="bi bi-star-fill"></i></label>

								<input class="review-input" id="star1" name="review" type="radio" value="1"
								{{$review == 1 ? 'checked' : '' }}>
								<label class="review-label" for="star1"><i class="bi bi-star-fill"></i></label>
							@endif
						</div>
					</td>
				</tr>
			</table>
			<p class="text">{{$text}}</p>
		</div>
	</main>
</body>

</html>