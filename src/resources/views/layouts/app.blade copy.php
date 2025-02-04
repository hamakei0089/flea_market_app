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
      <a href="/" class="header-logo">
      <img src="{{ asset('storage/images/logo.svg') }}" alt="Logo">
      </a>
      <nav class="header-items">
        <ul class="header-nav">
          <li class="header-nav-search">
            <input type="text" id="search-box" class="search-box" placeholder="なにをお探しですか？" value="{{ request()->query('search', '') }}">
          </li>
          <li class="header-nav-btn">
            @auth
              <form action="{{ route('logout') }}" method="POST">
              @csrf
                <button type="submit" class="header-nav-link logout-btn">ログアウト</button>
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
  <div class="tabs-container">
    <div class="tab">
        <ul class="tabs-menu">
            <li class="tab-item {{ $viewTypes === 'all' ? 'active' : '' }}">
                <a href="{{ route('items.index', ['search' => request()->query('search', '')]) }}">おすすめ</a>
            </li>
            <li class="tab-item {{ $viewTypes === 'mylist' ? 'active' : '' }}">
                <a href="{{ route('items.index', ['page' => 'mylist', 'search' => request()->query('search', '')]) }}">マイリスト</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        @if ($viewTypes === 'all')
        <div class="items-grid">
            @foreach ($Items as $item)
            <div class="item-card">
                <div class="item-thumbnail">
                    <a href="{{ route('item.detail', ['item' => $item->id, 'search' => request()->query('search', '')]) }}">
                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}">
                    </a>
                </div>
                <p class="item-name">{{ $item->name }}</p>
            </div>
            @endforeach
        </div>
        @elseif ($viewTypes === 'mylist')
        @auth
        <div class="items-grid">
            @foreach ($myLists as $favorite)
            <div class="item-card">
                <div class="item-thumbnail">
                    <a href="{{ route('item.detail', ['item' => $favorite->item->id, 'search' => request()->query('search', '')]) }}">
                    <img src="{{ asset('storage/' . $favorite->item->thumbnail) }}" alt="{{ $favorite->item->name }}">
                    </a>
                </div>
                <p class="item-name">{{ $favorite->item->name }}</p>
            </div>
            @endforeach
        </div>
        @endauth
        @endif
    </div>
</div>

</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ asset('js/search.js') }}"></script>
</body>

</html>