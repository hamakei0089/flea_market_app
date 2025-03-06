@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@if(session('success'))
    <p class="registration-success">{{ session('success') }}</p>
@endif

<div class="profile-info">
    <img class="profile-thumbnail" src="{{ $user->thumbnail ? asset('storage/' . $user->thumbnail) : asset('storage/profiles/default-thumbnail.png') }}" alt="{{ $user->name }}" />
    <p class="profile-name">{{Auth::user()->name}}</p>
    <form action="{{ route('profile.form') }}" method="get">
        <button type="submit" class="profile-edit-btn">プロフィールを編集</button>
    </form>
</div>

<div class="tabs-container">
    <div class="tab">
        <ul class="tabs-menu">
            <li class="tab-item {{ $viewTypes === 'sell' ? 'active' : '' }}">
                <a class="tab-title" href="{{ route('mypage.index' , ['page' => 'sell']) }}">出品した商品</a>
            </li>
            <li class="tab-item {{ $viewTypes === 'buy' ? 'active' : '' }}">
                <a class="tab-title" href="{{ route('mypage.index', ['page' => 'buy']) }}">購入した商品</a>
            </li>
            <li class="tab-item {{ $viewTypes === 'dealing' ? 'active' : '' }}">
                <a class="tab-title" href="{{ route('mypage.index', ['page' => 'dealing']) }}">取引中の商品</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        @if ($viewTypes === 'sell')
        <div class="items-grid">
            @foreach ($sellItems as $sellItem)
            <div class="item-card">
                <div class="item-thumbnail">
                    <a href="{{ route('item.detail', ['item' => $sellItem->id]) }}">
                    <img src="{{ asset('storage/' . $sellItem->thumbnail) }}" alt="{{ $sellItem->name }}">
                    </a>
                </div>
                <p class="item-name">{{ $sellItem->name }}</p>
            </div>
            @endforeach
        </div>

        @elseif ($viewTypes === 'buy')
        <div class="items-grid">
            @foreach ($buyItems as $buyItem)
            <div class="item-card">
                <div class="item-thumbnail">
                    <a href="{{ route('item.detail', ['item' => $buyItem->id]) }}">
                    <img src="{{ asset('storage/' . $buyItem->item->thumbnail) }}" alt="{{ $buyItem->item->name }}">
                    </a>
                </div>
                <p class="item-name">{{ $buyItem->item->name }}</p>
            </div>
            @endforeach
        </div>
        @endif

        @else ($viewTypes === 'dealing')
        <div class="items-grid">
            @foreach ($chatItems as $chatItem)
            <div class="item-card">
                <div class="item-thumbnail">
                    <a href="{{ route('item.dealing', ['item' => $chatItem->id]) }}">
                    <img src="{{ asset('storage/' . $chatItem->item->thumbnail) }}" alt="{{ $chatItem->item->name }}">
                    </a>
                </div>
                <p class="item-name">{{ $chatItem->item->name }}</p>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>
@endsection