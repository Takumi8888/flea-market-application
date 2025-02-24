<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts/header_functional.css') }}">
    @yield('css')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <title>FleaMarketApplication</title>
</head>

<body  onload = loadFinished()>
    <header class="header">
        <div class="header-title-section">
            <a class="header-title__link" href="/">
                <h1><img class="header-title__image" src="{{ asset('image/logo/logo.svg') }}" alt="COACHTECH" /></h1>
            </a>
        </div>
        <div class="function-section">
            {{-- 検索機能 --}}
            <div class="search-group">
                @if (empty($keyword))
                    <input id="search-text" name="keyword" type="text" placeholder="なにをお探しですか？" form="my-list-form">
                @elseif (isset($keyword) && $page == 'recommend')
                    <input id="search-text" name="keyword" type="text" placeholder="なにをお探しですか？" form="recommend-form" value="{{ $keyword }}">
                @elseif (isset($keyword) && $page == 'mylist')
                    <input id="search-text" name="keyword" type="text" placeholder="なにをお探しですか？" form="my-list-form" value="{{ $keyword }}">
                @endif
            </div>
            <nav class="nav-group">
                <ul class="nav-group__flex">
                    {{-- ログイン／ログアウト --}}
                    <li class="nav-list">
                        @if(Auth::check())
                            <form class="logout-form">
                                @csrf
                                <button class="logout-form__button--logout" formaction="/logout" formmethod="POST">ログアウト</button>
                            </form>
                        @else
                            <a class="nav-list__button--login" href="/login">ログイン</a>
                        @endif
                    </li>
                    {{-- マイページ --}}
                    <li class="nav-list">
                        @if(Auth::check())
                            <a class="nav-list__button--mypage" href="/mypage">マイページ</a>
                        @else
                            <a class="nav-list__button--mypage" href="/login">マイページ</a>
                        @endif
                    </li>
                    {{-- 出品 --}}
                    <li class="nav-list">
                        <div class="nav-list__button">
                            @if(Auth::check())
                                <a class="nav-list__button--sell" href="/sell">出品</a>
                            @else
                                <a class="nav-list__button--sell" href="/login">出品</a>
                            @endif
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
        <script src="{{ asset('js/layouts/header_functional.js') }}"></script>
    </main>
</body>

</html>