@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')

<div class="item-container">
    <div>
        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}" />
    </div>
    <div>
        <h2>{{ $item->name }}</h2>
        <h3>{{ $item->brand_name }}</h3>
        <p>{{ number_format($item->price) }}円 (税込)</p>
        <div class="item" data-item-id="{{ $item->id }}">
            <table>
                <thead>
                    <tr>
                        <td>
                            <button type="button" class="favorite-btn {{ $isFavorited ? 'bg-red-500 hover:bg-red-700' : 'bg-blue-500 hover:bg-blue-700' }} text-white font-bold py-2 px-4 rounded" data-item-id="{{ $item->id }}">
                                {{ $isFavorited ? '★' : '☆' }}
                            </button>
                            </button>
                        </button>
                        </td>
                        <td>💬</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="favorites-count">{{ $item->favorites_count }}</span>
                        </td>
                        <td>{{ $item->comments_count }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a href="{{ route('item.purchase', ['item_id' => $item->id]) }}">購入手続きへ</a>
        <h2>商品説明</h2>
        <p>{{ $item->description }}</p>
        <h2>商品の情報</h2>
        @foreach($item->categories as $category)
            <p>{{ $category->name }}</p>
        @endforeach
        <p>{{ $item->condition->name }}</p>
        <h2>コメント</h2>
        <p>{{ $item->comment }}</p>
        <h3>商品へのコメント</h3>
        @if($item->comments->isEmpty())
            <p>コメントはありません。</p>
        @else
            @foreach($item->comments as $comment)
                <img src="{{ asset('storage/' . $comment->user->thumbnail) }}" alt="{{ $comment->user->name }}" />
                <p>{{ $comment->user->name }}</p>
                <p>{{ $comment->comment }}</p>
            @endforeach
        @endif
        <form action="{{ route('comment.store', ['item_id'=> $item->id]) }}" method="post">
            @csrf
            <input type="text" name="comment">
            <button type="submit">コメントを送信する</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/favorite.js') }}"></script>
@endsection
