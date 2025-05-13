<header class="header">
	<div class="header__logo">
		<a href="/">
			<img src="{{ asset('image/logo/logo.svg') }}" alt="COACHTECH" />
		</a>
	</div>
	@if( !in_array(Route::currentRouteName(), ['register', 'login.create', 'verification.notice', 'transaction.create']) )
		<div class="function-section">
			{{-- 検索機能 --}}
			<div class="search">
				@if (empty($keyword))
					<input id="search-text" name="keyword" type="text" placeholder="なにをお探しですか？" form="my-list-form">
				@elseif (isset($keyword) && $page == 'recommend')
					<input id="search-text" name="keyword" type="text" placeholder="なにをお探しですか？" form="recommend-form" value="{{ $keyword }}">
				@elseif (isset($keyword) && $page == 'mylist')
					<input id="search-text" name="keyword" type="text" placeholder="なにをお探しですか？" form="my-list-form" value="{{ $keyword }}">
				@endif
			</div>
			{{-- ナビ --}}
			<nav class="header__nav">
				<ul>
					<li>
						@if(Auth::check())
							<form class="logout-form" action="/logout" method="post">
								@csrf
								<button class="nav-btn nav-btn--logout">ログアウト</button>
							</form>
						@else
							<a class="nav-btn nav-btn--login" href="/login">ログイン</a>
						@endif
					</li>
					<li><a class="nav-btn nav-btn--mypage" href="/mypage?page=sell">マイページ</a></li>
					<li>
						<div class="nav__btn2">
							<a class="nav-btn2 header-btn--sell" href="/sell">出品</a>
						</div>
					</li>
				</ul>
			</nav>
		</div>
	@endif
</header>