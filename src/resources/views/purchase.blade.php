@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

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
            <select id="payment_method" class="payment-select" name="payment_method" required>
                <option value="" disabled selected>選択してください</option>
                        @foreach ($paymentMethods as $paymentMethod)
                        <option value="{{ $paymentMethod->name }}" {{ old('paymentMethod') == $paymentMethod->name ? 'selected' : '' }}>
                            {{ $paymentMethod->name }}
                        </option>
                        @endforeach
            </select>
            <div class="form-error">
                @error('payment_method')
                {{ $message }}
                @enderror
            </div>
        </div>


        <div class="address-section">
            <div class="address-header">
                <h2 class="address-title">配送先</h2>
                <a class="address-edit-link" href="{{ route('edit.address', ['item' => $item->id]) }}">変更する</a>
            </div>
            <p class="address-post-code">〒{{ ($user->post_code) }}</p>
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

        <form action="{{ route('purchase.checkout' , ['item'  => $item->id]) }}" method="post">
        @csrf
            <input type="hidden" name="name" value="{{ $item->name }}">
            <input type="hidden" name="price" value="{{ $item->price }}">
            <input type="hidden" name="post_code" value="{{ $user->post_code }}">
            <input type="hidden" name="address" value="{{ $user->address }}">
            <input type="hidden" name="payment_method" id="hidden-payment-method" value="{{ old('payment_method') }}">
            <button type="submit" class="purchase-btn">購入する</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/purchase.js') }}"></script>
@endsection
