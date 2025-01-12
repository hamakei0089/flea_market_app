@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/listing.css') }}">
@endsection

@section('content')

<div>
    <h2>商品の出品</h2>
        <form action="{{ route('listing.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <label for='thumbnail'class="custom-file-upload">画像を選択する</label>
            <input type="file" name="thumbnail" id="thumbnail" class="form-control-file" style ="display: none;" />
            <span id="file-name" style="display: none; margin-top: 10px;"></span>
        </div>
        <div>
            <h3>商品の詳細</h3>
                <label for='category'>カテゴリー</label>
                    @foreach ($categories as $category)
                    <button type="button" class="category-btn" data-category-id="{{ $category->id }}"> {{ $category->name }}
                    </button>
                    @endforeach
                    <input type="hidden" name="categories[]" id="selected-categories">
                <label for='condition'>商品の状態</label>
                    <select id="condition" name="condition"  required>
            <option value="" disabled selected>選択してください</option>
                @foreach($conditions as $condition)
                    <option value="{{ $condition->name }}" {{ old('condition') == $condition->name ? 'selected' : '' }}>{{ $condition->name }}</option>
                @endforeach
        </select>
            <h3>商品名と説明</h3>
                <label for='name'>商品名</label>
                    <input type="text" name='name'value="{{ old('name') }}">
                <label for='brand_name'>ブランド名</label>
                    <input type="text" name='brand_name' value="{{ old('brand_name') }}">
                <label for='description'>商品の説明</label>
                    <textarea name="description" class="form-control" rows="10" value="{{ old('description') }}"></textarea>
                <label for='price'>販売価格</label>
                    <input type="number" name='price' value="{{ old('price') }}">
            <button type="submit">出品する</button>
        </form>
        </div>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/listing.js') }}"></script>
@endsection