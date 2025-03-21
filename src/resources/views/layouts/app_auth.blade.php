<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>coachtech-flea-market</title>
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
      </div>
    </div>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>