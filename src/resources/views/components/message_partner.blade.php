<div class="message__partner">
	<div class="message-chat message__chat--partner">
		<div class="message-profile message__profile--partner">
			<img src="{{ Storage::url($partner->user_image) }}" alt="プロフィール画像">
			<span>{{ $partner->user_name }}</span>
		</div>
		<div class="message__text--partner">
			<span class="message-text">{{ $message->message }}</span>
		</div>
		@if ($message->image != null)
			<div class="message-img message__img--partner">
				<img src="{{ Storage::url($message->image) }}" alt="チャット画像">
			</div>
			<div id="modal-img" class="modal__img">
				<img id="js-modal-img" class="modal__message__img--partner">
				<div id="caption"></div>
			</div>
		@endif
	</div>
</div>