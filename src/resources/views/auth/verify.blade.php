@extends('layouts.app_auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="verification-mail-container">

        <p class="status-message">登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。</p>

        <p class="verification-tag">認証はこちらから</p>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="resend-btn">認証メールを再送する</button>
        </form>
    </div>
@endsection
