@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="item-detail">
    <div class="item-image">
        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}" />
    </div>
    <div class="item-info">
        <h2 class="item-name">{{ $item->name }}</h2>
        <h3 class="item-brand">{{ $item->brand_name }}</h3>
        <p class="item-price">
            <span class="price-symbol">¥</span>
            <span class="price-amount">{{ number_format($item->price) }}</span>
            <span class="price-tax">(税込)</span>
        </p>
        <div class="item-actions" data-item-id="{{ $item->id }}">
            <table class="item-stats">
                <tr>
                    <td class="stats-symbol">
                        @auth
                            @if(!$item->isFavoritedBy(auth()->user()))
                                <form action="{{ route('favorite.store', ['item' => $item->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="favorite-btn">☆</button>
                                </form>
                            @else
                                <form action="{{ route('favorite.destroy', ['item' => $item->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="favorite-btn">★</button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="favorite-btn">☆</a>
                        @endauth
                    </td>
                    <td class="stats-symbol">💬</td>
                </tr>
                <tr>
                    <td class="stats-number">
                        <span class="favorites-count">{{ $item->favorites_count }}</span>
                    </td>
                    <td class="stats-number">{{ $item->comments_count }}</td>
                </tr>
            </table>
        </div>
        <a href="{{ route('purchase.form', ['item' => $item->id]) }}" class="purchase-btn">購入手続きへ</a>
        <h2 class="section-title">商品説明</h2>
        <p class="item-description">{{ $item->description }}</p>
        <h2 class="section-title">商品の情報</h2>
        <table class="item-details-table">
            <tr>
                <th class="detail-title">カテゴリ</th>
                <td class="category">
                    @foreach($item->categories as $category)
                        <span class="category-name">{{ $category->name }}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th class="detail-title">商品の状態</th>
                <td class="condition">
                    <span class="condition-name">{{ $item->condition->name }}</span>
                </td>
            </tr>
        </table>

        <h2 class="section-title">コメント({{ $item->comments_count }})</h2>
        <p class="no-comments" @if(!$item->comments->isEmpty()) hidden @endif>コメントはありません。</p>
        <div class="comments-list">
            @foreach($item->comments as $comment)
                <div class="comment-item">
                    <img class="comment-user-thumbnail"
                        src="{{ $comment->user->thumbnail ? asset('storage/' . $comment->user->thumbnail) : asset('storage/profiles/default-thumbnail.png') }}" alt="{{ $comment->user->name }}" />
                    <p class="comment-user-name">{{ $comment->user->name }}</p>
                </div>
                <p class="comment-text">{{ $comment->comment }}</p>
            @endforeach
        </div>
        <form class="form-comment" action="{{ route('comment.store', ['item'=> $item->id]) }}" method="post">
            @csrf
            <div class="comment-form">
                <p class="comment-title">商品へのコメント</p>
                <textarea class="input-comment" name="comment" placeholder="ここにコメントを入力してください">{{ old('comment') }}</textarea>
                @error('comment')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                <button type="submit" class="comment-btn">コメントを送信する</button>
            </div>
        </form>
    </div>
</div>
@endsection
