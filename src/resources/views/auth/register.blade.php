@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register">
  <div class="register-heading">
    <h2>会員登録</h2>
  </div>
  <form class="form" action="/register" method="post">
    @csrf

    <div class="form-group">
      <h3 class="form-label">ユーザー名</h3>
      <div class="form-input">
        <input type="text" name="name" value="{{ old('name') }}" />
      </div>
      <div class="form-error">
        @error('name')
        {{ $message }}
        @enderror
      </div>
    </div>

    <div class="form-group">
      <h3 class="form-label">メールアドレス</h3>
      <div class="form-input">
        <input type="email" name="email" value="{{ old('email') }}" />
      </div>
      <div class="form-error">
        @error('email')
        {{ $message }}
        @enderror
      </div>
    </div>

    <div class="form-group">
      <h3 class="form-label">パスワード</h3>
      <div class="form-input">
        <input type="password" name="password" />
      </div>
      <div class="form-error">
        @error('password')
        {{ $message }}
        @enderror
      </div>
    </div>

    <div class="form-group">
      <h3 class="form-label">確認用パスワード</h3>
      <div class="form-input">
        <input type="password" name="password_confirmation" />
      </div>
      <div class="form-error">
        @error('password_confirmation')
        {{ $message }}
        @enderror
      </div>
    </div>
    <button class="form-submit" type="submit">登録する</button>
  </form>
  <a class="login-link" href="/login">ログインの方はこちら</a>
</div>
@endsection
