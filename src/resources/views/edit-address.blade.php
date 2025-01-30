@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-content">
  <div class="register-heading">
    <h2>住所の変更</h2>
  </div>
  <form class="form" action="{{ route('update.address' , ['item' => $item->id]) }}" method="post">
    @csrf

      <div class="form-group">
        <h3 class="form-theme">郵便番号</h3>
        <div class="form-input">
          <input type="text" name="post_code" value="{{ old('post_code', $user->post_code) }}" />
        </div>
        <div class="form-error">
          @error('post_code')
          {{ $message }}
          @enderror
        </div>
      </div>

    <div class="form-group">
      <h3 class="form-theme">住所</h3>
      <div class="form-input">
        <input type="text" name="address" value="{{ old('address' , $user->address) }}"/>
      </div>
      <div class="form-error">
        @error('address')
        {{ $message }}
        @enderror
      </div>
    </div>

    <div class="form-group">
      <h3 class="form-theme">建物名</h3>
      <div class="form-input">
        <input type="text" name="building" value="{{ old('building' , $user->building) }}"/>
      </div>
      <div class="form-error">
        @error('building')
        {{ $message }}
        @enderror
      </div>
    </div>
      <button class="form-submit" type="submit">更新する</button>
  </form>

</div>
@endsection