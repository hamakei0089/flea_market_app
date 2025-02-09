@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@if(session('success'))
    <p class="registration-success">{{ session('success') }}</p>
@endif

<div class="tabs-container">
    <div class="tab">
        <ul class="tabs-menu">
            <li class="tab-item {{ $viewTypes === 'all' ? 'active' : '' }}">
                <a href="{{ route('items.index', ['search' => request()->query('search', '')]) }}">おすすめ</a>
            </li>
            <li class="tab-item {{ $viewTypes === 'mylist' ? 'active' : '' }}">
                <a href="{{ route('items.index', ['page' => 'mylist', 'search' => request()->query('search', '')]) }}">マイリスト</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        @if ($viewTypes === 'all')
        <div class="items-grid">
            @foreach ($items as $item)
            <div class="item-card">
                <div class="item-thumbnail">
                    <a href="{{ route('item.detail', ['item' => $item->id, 'search' => request()->query('search', '')]) }}">
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
                    <a href="{{ route('item.detail', ['item' => $favorite->item->id, 'search' => request()->query('search', '')]) }}">
                    <img src="{{ asset('storage/' . $favorite->item->thumbnail) }}" alt="{{ $favorite->item->name }}">
                    </a>
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
