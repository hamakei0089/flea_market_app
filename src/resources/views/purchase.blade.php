@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<form action="{{ route('checkout' , ['item' => $item->id]) }}" method="post">
@csrf
<div class="container">
    <div class="left-content">
        <div class="item-info">
            <img class="item-thumbnail" src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}">
            <div class="item-text">
                <p class="item-name">{{ $item->name }}</p>
                <p class="item-price">¥{{ number_format($item->price) }}</p>
            </div>
        </div>

        <div class="payment-section">
            <h2 class="payment-title">支払い方法</h2>
            <select id="payment-method" class="payment-select" name="payment_method" required>
                <option value="" disabled selected>選択して下さい</option>
                <option value="convenience">コンビニ支払い</option>
                <option value="card">カード支払い</option>
            </select>
        </div>

        <div class="address-section">
            <div class="address-header">
                <h2 class="address-title">配送先</h2>
                <a class="address-edit-link" href="{{ route('edit.address', ['item' => $item->id]) }}">変更する</a>
            </div>
            <p class="address-post-code">〒{{ substr($user->post_code, 0, 3) }}-{{ substr($user->post_code, 3) }}</p>
            <p class="address-text">{{ $user->address }}  {{ $user->building }}</p>
        </div>
    </div>

    <div class="right-content">
        <div class="summary-section">
            <table class="summary-table">
                <tr class="summary-row">
                    <td class="summary-label">商品代金</td>
                    <td class="summary-price">¥{{ number_format($item->price) }}</td>
                </tr>
                <tr class="summary-row">
                    <td class="summary-label">支払い方法</td>
                    <td class="summary-payment-method" id="payment-method-display">{{ old('payment_method', '選択されていません') }}</td>
                </tr>
            </table>
        </div>

        <button type="submit" class="purchase-btn">購入する</button>
    </div>
</div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/payment.js') }}"></script>
@endsection
