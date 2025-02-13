@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="done-container">
    <h1 class="theme">購入完了</h1>
    <p class="passage">ご購入ありがとうございました。</p>
    <a  class="home-btn" href="/">ホームに戻る</a>
</div>
@endsection
