<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Attendance Management</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-utilities">
        <img src="{{ asset('storage/images/logo.svg') }}" alt="Logo">
        <nav>
          <ul class="header-nav">
            <li class="header-nav__item">

              @auth
              <form action="{{ route('logout') }}" method="POST">
              @csrf
                <button type="submit" class="header-nav__link" >ログアウト</button>
              </form>
              @endauth

              @guest
              <a class="header-nav__link" href="/login">ログイン</a>
              @endguest

            </li>
            <li class="header-nav__item">
              <a class="header-nav__link" href="/mypage">マイページ</a>
            </li>
            <li class="header-nav__item">
              <form action="{{ route('listing.form') }}" method="get">
                @csrf
                <button class="header-nav__button">出品</button>
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
</body>

</html>