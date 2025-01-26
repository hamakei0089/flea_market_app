@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div>
    <div>
        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}">
        <h2>{{ $item->name }}</h2>
        <p>¥{{ number_format ($item->price) }}</p>
    </div>

    <div>
        <h2>支払い方法</h2>
        <select id="payment_method" class="payment_method" name="payment_method" placeholder="選択して下さい" required>選択して下さい
                <option value="コンビニ支払い">コンビニ支払い</option>
                <option value="カード支払い">カード支払い</option>
            </select>
    </div>

    <div>
        <h2>配送先</h2>
        <a href="{{ route('edit.address' , ['item' => $item->id]) }}">変更する</a>
        <p>{{ $user->post_code }}</p>
        <p>{{ $user->address }}</p>
        <p>{{ $user->building }}</p>
    </div>

    <div>
        <table>
            <tr>
                <td>商品代金</td>
                <td>¥{{ number_format($item->price) }}</td>
            </tr>

            <tr>
                <td>支払い方法</td>
                <td id="payment_method_display">{{ old('payment_method', '選択されていません') }}</td>
            </tr>
        </table>
    </div>

    <button type="submit">購入する</button>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="{{ asset('js/payment.js') }}"></script>
@endsection
