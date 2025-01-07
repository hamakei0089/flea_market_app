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
                <p>#{{ $item->price }} (税込)</p>
                <table>
                    <thead>
                        <tr>
                            <td>⭐️</td>
                            <td>💬</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $item ->favorites_count }}</td>
                            <td>{{ $item ->comments_count }}</td>
                        </tr>
                    </tbody>
                </table>
                <a href="{{ route('item.purchase' , ['id' => $item->id ] ) }}">購入手続きへ</a>
            <h2>商品説明</h2>
                <p>{{ $item->detail}}</p>
            <h2>商品の情報</h2>
                <p>{{ $item->category->name }}</p>
                <p>{{ $item->condition->name }}</p>
            <h2>コメント</h2>
                <p>{{ $item->comment }}</p>
            <h3>商品へのコメント</h3>
            @foreach( $item->$comments as $comment)
                <img src="{{ asset('storage/' . $user->thumbnail) }}" alt="{{ $user->name }}" />
                <p>{{ $comment->user->name }}</p>
                <p>{{ $comment->content }}</p>
            @endforeach
                <form action="{{ route(item.comment.store , ['id'=> $item->id] ) }}"  method="post">
                @csrf
                    <input type="text" name="comment">
                    <button type="submit">コメントを送信する</button>
                </form>
        </div>
    </div>


@endsection