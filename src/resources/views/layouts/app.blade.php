<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Attendance Management</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
  <div class="header-inner">
    <div class="header-utilities">
      <img src="{{ asset('storage/images/logo.svg') }}" alt="Logo">
      <nav class="header-items">
        <ul class="header-nav">
          <li class="header-nav-search">
            <input type="text" id="search-box" class="search-box" placeholder="なにをお探しですか？">
          </li>
          <li class="header-nav-btn">
            @auth
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="header-nav-link">ログアウト</button>
              </form>
            @endauth

            @guest
              <a class="header-nav-link" href="/login">ログイン</a>
            @endguest
          </li>
          <li class="header-nav-btn">
            <a class="header-nav-link" href="/mypage">マイページ</a>
          </li>
          <li class="header-nav-btn">
            <form action="{{ route('listing.form') }}" method="get">
              @csrf
              <button class="listing-btn">出品</button>
            </form>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</header>

  <main>
    @yield('content')
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <script src="{{ asset('js/search.js') }}"></script>
</body>

</html>