@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/message.css') }}">
@endsection

@section('content')

<div class="message-box">

    <div class="other-deals">
        <h2 class="deal-theme">その他の取引</h2>
            @foreach ($otherDealItems as $messageItem)
            <div class="item-card">
                <a href="{{ route('item.deal', ['item' => $messageItem->item->id]) }}" class="item-btn">
                <p class="other-item-name">{{ $messageItem->item->name }}</p>
                </a>
            </div>
            @endforeach
    </div>

    <div class="deal-container">
        <div class="partner-container">
            <img class="partner-thumbnail" src="{{ $partner->thumbnail ? asset('storage/' . $partner->thumbnail) : asset('storage/profiles/default-thumbnail.png') }}" alt="{{ $partner->name }}" />
            <h2 class="partner-name">「{{ $partner->name }}」 さんとの取引画面</h2>
            @if(auth()->id() !== $item->user_id)
                <div class="deal-done">
                    <form action="{{ route('deal.done', [$item->id]) }}" method="post">
                    @csrf
                    <button class="deal-done-btn" type="submit" id="deal-done-btn">取引を完了する</button>
                    </form>
                </div>
            @endif

                <div id="review-modal" class="modal {{ $evaluation_modal ? '' : 'hidden' }}">
                    <div class="modal-container">
                        <div class="modal-theme">
                            <p class="theme1">取引が完了しました。</p>
                        </div>
                        <p class="theme2">今回の取引相手はどうでしたか？</p>
                            <form action="{{ route('evaluation.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label for="star{{ $i }}">
                                            <input type="radio" id="star{{ $i }}" name="score" value="{{ $i }}" required>
                                            <span class="star" data-value="{{ $i }}">★</span>
                                        </label>
                                    @endfor
                                </div>
                                <div class="btn">
                                    <button type="submit" class="evaluation-btn">送信する</button>
                                </div>
                            </form>
                    </div>
                </div>
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
                    <p class="message-body">{{ $message->message }}</p>
                </div>
                <div class="message-thumbnail-wrapper {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                    @if ($message->thumbnail)
                    <img class="message-thumbnail-img" src="{{ asset('storage/' . $message->thumbnail) }}" alt="{{ $message->sender->name }}" />
                    @endif
                </div>

                @if($message->sender_id === auth()->id())
                <div class="message-actions">
                    <form  action="{{ route('message.edit' , ['message' => $message->id]) }}" method="get">
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

        <form id="messageForm" action="{{ route('message.send', [$item->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="form-error">
                @error('message')
                {{ $message }}
                @enderror
                @error('thumbnail')
                {{ $message }}
                @enderror
            </div>

            <div class="send-form">
                <input type="hidden" name="receiver_id" value="{{ $partner->id }}">
                <textarea  class="message-text" name="message" placeholder="取引メッセージを記入してください" ></textarea>
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
