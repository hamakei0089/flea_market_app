@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')


<div class="chat-container">

    <h2>「{{ $partner->name }}」 さんとの取引画面</h2>

    <div class="item-container">
        <div class="item-image">
            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}" />
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

    <div class="message-box">
        @foreach ($messages as $message)
        <div class="message-item">
                    <img class="message-user-thumbnail"
                        src="{{ $message->user->thumbnail ? asset('storage/' . $message->user->thumbnail) : asset('storage/profiles/default-thumbnail.png') }}" alt="{{ $message->user->name }}" />
                    <p class="message-user-name">{{ $message->user->name }}</p>
                </div>
            <div class="message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                <p>{{ $message->message }}</p>
            </div>
        @endforeach
    </div>

    <form action="{{ route('message.send', $item->id) }}" method="post">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $partner->id }}">
        <textarea name="message" placeholder="メッセージを入力" required></textarea>
        <button type="submit">送信</button>
    </form>
</div>

@endsection
