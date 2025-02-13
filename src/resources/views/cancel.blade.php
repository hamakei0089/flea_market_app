@extends('layouts.app_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="cancel-container">
    <h1 class="theme">購入キャンセル</h1>
    <p class="passage">購入手続きがキャンセルされました。</p>
    <a  class="home-btn" href="/">ホームに戻る</a>
</div>
@endsection
