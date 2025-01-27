@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-content">
  <div class="login-heading">
    <h2>ログイン</h2>
  </div>
  <form class="form" action="{{ route('login') }}" method="post">
    @csrf
    <div class="form-group">
      <div class="form-label">
        <span>メールアドレス</span>
      </div>
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
      <div class="form-label">
        <span>パスワード</span>
      </div>
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
      <button class="form-submit" type="submit">ログイン</button>
    </div>
  </form>
    <a class="register-link" href="/register">会員登録の方はこちら</a>
</div>
@endsection
