@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/message.css') }}">
@endsection

@section('content')

<div class="message-box">

    <div class="other-deals">
        <h2>その他の取引</h2>
    </div>

    <div class="deal-container">
        <div class="partner-container">
            <img class="partner-thumbnail" src="{{ $partner->thumbnail ? asset('storage/' . $partner->thumbnail) : asset('storage/profiles/default-thumbnail.png') }}" alt="{{ $partner->name }}" />
            <h2 class="partner-name">「{{ $partner->name }}」 さんとの取引画面</h2>
            @if($firstMessageSenderId === auth()->id())
            <div class="deal-done">
                <button class="deal-done-btn" type=submit>取引を完了する</button>
            </div>
            @endif
        </div>

        <div class="item-container">
            <div class="item-image">
                <img  class="item-thumbnail" src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}" />
            </div>
            <div class="item-info">
                <h2 class="item-name">{{ $item->name }}</h2>
                <p class="item-price">
                    <span class="price-symbol">¥</span>
                    <span class="price-amount">{{ number_format($item->price) }}</span>
                    <span class="price-tax">(税込)</span>
                </p>
            </div>
        </div>

        <div class="message-container">
            @foreach ($messages as $message)
            <div class="message-wrapper {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                <div class="message-item">
                    <img class="message-user-thumbnail"src="{{ $message->sender->thumbnail ? asset('storage/' . $message->sender->thumbnail) : asset('storage/profiles/default-thumbnail.png') }}" alt="{{ $message->sender->name }}" />
                    <p class="message-sender-name">{{ $message->sender->name }}</p>
                </div>
                <div class="message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                    <p class="message">{{ $message->message }}</p>
                </div>
                <div class="message-thumbnail {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                    @if ($message->thumbnail)
                    <img class="message-thumbnail" src="{{ asset('storage/' . $message->thumbnail) }}" alt="{{ $message->sender->name }}" />
                    @endif
                </div>

                @if($message->sender_id === auth()->id())
                <div class="message-actions">
                    <form  action="{{ route('message.edit', $message->id) }}" method="get" class="edit-button">
                        <button type="submit" class="edit-btn">編集</button>
                    </form>
                    <form action="{{ route('message.destroy', $message->id) }}" method="post" class="delete-form" onsubmit="return confirm('このメッセージを削除してよろしいですか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">削除</button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <form action="{{ route('message.send', $item->id) }}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="send-form">
                <input type="hidden" name="receiver_id" value="{{ $partner->id }}">
                <textarea  class="message-text" name="message" placeholder="取引メッセージを記入してください" required></textarea>
                <div class="file-upload-section">
                    <label class="form-label" for="thumbnail">
                        <input type="file" id="thumbnail" name="thumbnail" style="display: none;">
                        <button type="button" class="file-upload-btn">画像を追加　</button>
                    </label>
                    <span id="file-name" style="display: none; margin-top: 10px;"></span>
                </div>
                <button type="submit" class="send-btn">
                    <img src="{{ asset('storage/images/send.png') }}" alt="送信">
                </button>
            </div>
        </form>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/message.js') }}"></script>
@endsection
