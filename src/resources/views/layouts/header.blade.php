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
    <link rel="stylesheet" href="{{ asset('css/layouts/header.css') }}">
    @yield('css')
    <title>FleaMarketApplication</title>
</head>

<body>
    <header class="header">
        <div class="header-title-section">
            <a class="header-title__link" href="/">
                <h1><img class="header-title__image" src="{{ asset('image/logo/logo.svg') }}" alt="COACHTECH" /></h1>
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>