@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__content">
  <div class="register-form__heading">
    <h2>会員登録</h2>
  </div>
  <form class="form" action="/register" method="post">
    @csrf

      <div class="form__group">
        <h3 class="form__theme">ユーザー名</h3>
        <div class="form__input--text">
          <input type="text" name="name" value="{{ old('name') }}" />
        </div>
        <div class="form__error">
          @error('name')
          {{ $message }}
          @enderror
        </div>
      </div>

      <div class="form__group">
        <h3 class="form__theme">メールアドレス</h3>
        <div class="form__input--text">
          <input type="email" name="email" value="{{ old('email') }}" />
        </div>
        <div class="form__error">
          @error('email')
          {{ $message }}
          @enderror
        </div>
      </div>

    <div class="form__group">
      <h3 class="form__theme">パスワード</h3>
      <div class="form__input--text">
        <input type="password" name="password" />
      </div>
      <div class="form__error">
        @error('password')
        {{ $message }}
        @enderror
      </div>
    </div>

    <div class="form__group">
      <h3 class="form__theme">確認用パスワード</h3>
      <div class="form__input--text">
        <input type="password" name="password_confirmation" />
      </div>
      <div class="form__error">
        @error('password')
        {{ $message }}
        @enderror
      </div>
    </div>

      <button class="form__button-submit" type="submit">登録する</button>

  </form>

    <a class="login__button-submit" href="/login">ログインの方はこちら</a>

</div>
@endsection