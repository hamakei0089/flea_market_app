@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@if(session('success'))
    <p class="registration__success">{{ session('success') }}</p>
@endif

@auth
<div>
    <img src="{{ asset('storage/' . $user->thumbnail) }}" alt="{{ $user->name }}">
    <p>{{Auth::user()->name}}</p>
    <form action="{{ route ('profile.form') }}" method="get">
        <button type="submit">プロフィールを編集</button>
    </form>
</div>
@endauth

<div class="tabs-container">
    <ul class="tabs-menu">
        <li class="tab-item {{ $viewTypes === 'all' ? 'active' : '' }}">
            <a href="{{ route('items.index') }}">おすすめ</a>
        </li>
        <li class="tab-item {{ $viewTypes === 'mylist' ? 'active' : '' }}">
            <a href="{{ route('items.index', ['page' => 'mylist']) }}">マイリスト</a>
        </li>
    </ul>

    <div class="tab-content">
        @if ($viewTypes === 'all')
        <div class="items-grid">
            @foreach ($Items as $item)
            <div class="item-card">
                <div class="item-thumbnail">
                    <a href="{{ route('item.detail', ['item_id' => $item->id]) }}">
                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->name }}">
                    </a>
                </div>
                <p class="item-name">{{ $item->name }}</p>
            </div>
            @endforeach
        </div>
        @elseif ($viewTypes === 'mylist')
        @auth
        <div class="items-grid">
            @foreach ($myLists as $favorite)
            <div class="item-card">
                <div class="item-thumbnail">
                    <img src="{{ asset('storage/' . $favorite->item->thumbnail) }}" alt="{{ $favorite->item->name }}">
                </div>
                <p class="item-name">{{ $favorite->item->name }}</p>
            </div>
            @endforeach
        </div>
        @endauth
        @endif
    </div>
</div>
@endsection