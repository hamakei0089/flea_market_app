@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/listing.css') }}">
@endsection

@section('content')

<div class="form-container">
    <h1 class="listing-heading">商品の出品</h1>
    <form class="listing-form" action="{{ route('listing.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <h3 class="form-subheading">商品の画像</h3>
        <div class="file-upload-section">
            <label class="form-label" for="thumbnail">
                <input type="file" id="thumbnail" name="thumbnail" style="display: none;">
                <button type="button" class="file-upload-btn">画像を選択する</button>
            </label>
            <span id="file-name" style="display: none; margin-top: 10px;"></span>
        </div>
        <div class="form-error">
            @error('thumbnail')
            {{ $message }}
            @enderror
        </div>

        <div class="form-details-section">

            <h2 class="form-heading">商品の詳細</h2>
                <label class="form-label" for='category'>カテゴリー</label><br>
                    @foreach ($categories as $category)
                    <button type="button" class="category-btn" data-category-id="{{ $category->id }}"> {{ $category->name }}
                    </button>
                    <input type="hidden" name="categories[]" value="{{ $category->id }}" disabled>
                    @endforeach
                    <div class="form-error">
                        @error('category')
                        {{ $message }}
                        @enderror
                    </div>

            <div class="condition-section">
                <label class="form-label" for="condition">商品の状態</label>
                <select class="form-select" id="condition" name="condition" required>
                        <option value="" disabled selected>選択してください</option>
                        @foreach ($conditions as $condition)
                        <option value="{{ $condition->name }}" {{ old('condition') == $condition->name ? 'selected' : '' }}>
                            {{ $condition->name }}
                        </option>
                    @endforeach
                </select>
                <div class="form-error">
                    @error('condition')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <h3 class="form-heading">商品名と説明</h3>
            <label class="form-label" for="name">商品名</label>
            <input class="form-input" type="text" id="name" name="name" value="{{ old('name') }}">
            <div class="form-error">
                @error('name')
                {{ $message }}
                @enderror
            </div>

            <label class="form-label" for="brand-name">ブランド名</label>
            <input class="form-input" type="text" id="brand-name" name="brand_name" value="{{ old('brand_name') }}">

            <label class="form-label" for="description">商品の説明</label>
            <textarea class="form-textarea" id="description" name="description" rows="10">{{ old('description') }}</textarea>
            <div class="form-error">
                @error('description')
                {{ $message }}
                @enderror
            </div>


            <label class="form-label" for="price">販売価格</label>
            <input class="form-input" type="number" id="price" name="price" placeholder="￥" value="{{ old('price') }}">
            <div class="form-error">
                @error('price')
                {{ $message }}
                @enderror
            </div>

            <button class="submit-btn" type="submit">出品する</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/listing.js') }}"></script>
@endsection
