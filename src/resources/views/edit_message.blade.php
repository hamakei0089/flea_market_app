@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit_message.css') }}">
@endsection

@section('content')
<div class="message-edit-container">
    <h2 class=edit-theme>メッセージ編集</h2>
    <form action="{{ route('message.update', $message->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <textarea name="message"  class="message-area" required>{{ old('message', $message->message) }}</textarea>

        @if ($message->thumbnail)
            <div class="current-thumbnail">
                <p class="thumbnail-theme">現在の画像:</p>
                <img class="message-thumbnail" src="{{ asset('storage/' . $message->thumbnail) }}" alt="{{ $message->sender->name }}" />

            <div class="delete-checkbox">
                <label>
                    <input type="checkbox" name="delete_thumbnail" value="1"> 画像を削除する
                </label>
            </div>
            </div>
        @endif

        <div class="file-upload-section">
            <label class="form-label" for="thumbnail">
                <input type="file" id="thumbnail" name="thumbnail" style="display: none;">
                <span id="file-name" style="display: none; margin-top: 10px;"></span>
                <button type="button" class="file-upload-btn">画像を選択する</button>
            </label>
            <img id="thumbnail-preview" class="file-preview" src=""  />
        </div>
        <div class="form-error">
                @error('message')
                {{ $message }}
                @enderror
                @error('thumbnail')
                {{ $message }}
                @enderror
            </div>

        <button type="submit" class="update-btn">更新する</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/edit_message.js') }}"></script>
@endsection
