@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/message.css') }}">
@endsection

@section('content')
<div class="message-edit-container">
    <h2>メッセージ編集</h2>
    <form action="{{ route('message.update', $message->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <textarea name="message" required>{{ old('message', $message->message) }}</textarea>

        @if ($message->thumbnail)
            <div class="current-thumbnail">
                <p>現在の画像:</p>
                <img class="message-thumbnail" src="{{ asset('storage/' . $message->thumbnail) }}" alt="{{ $message->sender->name }}" />

                <label>
                    <input type="checkbox" name="delete_thumbnail" value="1"> 画像を削除する
                </label>
            </div>
        @endif

        <div class="file-upload-section">
            <label class="form-label" for="thumbnail">
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                <button type="button" class="file-upload-btn">画像を選択する</button>
            </label>
            <span id="file-name"></span>
        </div>

        <button type="submit">更新する</button>
    </form>
</div>
@endsection
