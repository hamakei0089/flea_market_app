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
                            <button class="favorite-btn" data-item-id="{{ $item->id }}" data-favorite="{{ $isFavorited ? 'true' : 'false' }}">
                                {!! $isFavorited ? '★' : '☆' !!}
                            </button>
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
                <td class="detail-values">
                    @foreach($item->categories as $category)
                        <span class="category-name">{{ $category->name }}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th class="detail-title">商品の状態</th>
                <td class="detail-values">
                    <span class="condition-name">{{ $item->condition->name }}</span>
                </td>
            </tr>
        </table>

        <h2 class="section-title">コメント({{ $item->comments_count }})</h2>
        <p class="no-comments" @if(!$item->comments->isEmpty()) hidden @endif>コメントはありません。</p>
        <div class="comments-list">
            @foreach($item->comments as $comment)
                <div class="comment-item">
                    <img class="comment-user-thumbnail" src="{{ $comment->user->thumbnail ? asset('storage/' . $comment->user->thumbnail) : asset('storage/profiles/default-thumbnail.png') }}" alt="{{ $comment->user->name }}" />

                    <p class="comment-user-name">{{ $comment->user->name }}</p>
                </div>
                    <p class="comment-text">{{ $comment->comment }}</p>
            @endforeach
        </div>
        <form class="form-comment" action="{{ route('comment.store', ['item'=> $item->id]) }}" method="post">
            @csrf
            <div class="comment-form">
                <p class="comment-title">商品へのコメント</p>
                    <textarea class="input-comment" name="comment" placeholder="ここにコメントを入力してください"></textarea>
                <button type="submit" class="comment-btn">コメントを送信する</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/favorite.js') }}"></script>

@endsection