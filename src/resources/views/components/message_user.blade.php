<div class="message__user">
	<div class="message-chat message__chat--user">
		<div class="message-profile message__profile--user">
			<span>{{ $profile->user_name }}</span>
			<img src="{{ Storage::url($profile->user_image) }}" alt="プロフィール画像">
		</div>
		<div class="message__text--user">
			<span class="message-text">{{ $message->message }}</span>
		</div>
		@if ($message->image != null)
			<div class="message-img message__img--user">
				<img src="{{ Storage::url($message->image) }}" alt="チャット画像">
			</div>
			<div id="modal-img" class="modal__img">
				<span class="close">x</span>
				<img id="js-modal-img" class="modal__message__img--partner">
				<div id="caption"></div>
			</div>
		@endif
		<div class="message__btn">
			<form class="message-form" action="{{ route('transaction.update',
			['tag'=>$tag, 'item'=>$item, 'message'=>$message->id]) }}" method="post">
				@method('put')
				@csrf
				<input class="message__text--update" type="text" name="message" />
				<button class="btn btn--message-update">編集</button>
			</form>
			<form class="message-form" action="{{ route('transaction.destroy',
			['tag'=>$tag, 'item'=>$item, 'message'=>$message->id]) }}" method="post">
				@method('delete')
				@csrf
				<button class="btn btn--message-destroy">削除</button>
			</form>
		</div>
		@if (session('message'))
			<div class="error message-alert">
				{{ session('message') }}
			</div>
		@endif
	</div>
</div>