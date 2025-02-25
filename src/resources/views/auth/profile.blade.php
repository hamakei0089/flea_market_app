@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-content">
    <div class="register-heading">
        <h2>プロフィール設定</h2>
    </div>
    <form class="form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <input type="file" id="thumbnail" name="thumbnail" style="display: none;">
            <span id="file-name" style="display: none; margin-top: 10px;">{{ old('thumbnail') }}</span>
            <img id="thumbnail-preview" src="{{ $user->thumbnail ? asset('storage/' . $user->thumbnail) : asset('storage/profiles/default-thumbnail.png')}}" alt="{{ $user->name }}" />
            <label for="thumbnail">
            <button type="button">画像を選択する</button>
            </label>
            <div class="form-error">
                @error('thumbnail')
                {{ $message }}
                @enderror
            </div>
        </div>

        <div class="form-group">
            <h3 class="form-theme">ユーザー名</h3>
            <div class="form-input">
                <input type="text" name="name" value="{{ old('name' , $user->name) }}" />
            </div>
            <div class="form-error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
        </div>

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/profile.js') }}"></script>
@endsection