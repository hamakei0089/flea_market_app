@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__content">
  <div class="register-form__heading">
    <h2>住所の変更</h2>
  </div>
  <form class="form" action="{{ route('update.address)') }}" method="post">
    @csrf

      <div class="form__group">
        <h3 class="form__theme">郵便番号</h3>
        <div class="form__input--text">
          <input type="text" name="post_code" value="{{ old('post_code', $user->post_code) }}" />
        </div>
        <div class="form__error">
          @error('post_code')
          {{ $message }}
          @enderror
        </div>
      </div>

    <div class="form__group">
      <h3 class="form__theme">住所</h3>
      <div class="form__input--text">
        <input type="text" name="address" value="{{ old('address' , $user->address) }}"/>
      </div>
      <div class="form__error">
        @error('address')
        {{ $message }}
        @enderror
      </div>
    </div>

    <div class="form__group">
      <h3 class="form__theme">建物名</h3>
      <div class="form__input--text">
        <input type="text" name="building" value="{{ old('building' , $user->building) }}"/>
      </div>
      <div class="form__error">
        @error('building')
        {{ $message }}
        @enderror
      </div>
    </div>
      <button class="form__button-submit" type="submit">更新する</button>
  </form>

</div>
@endsection