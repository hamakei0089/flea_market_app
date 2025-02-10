@extends('layouts.app_auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="verify-email-container">
    <h2 class="theme">メールアドレスの確認</h2>

    @if (session('status') == 'verification-link-sent')
        <div class="status-message">
            新しい確認リンクが登録されたメールアドレスに送信されました。
        </div>
    @endif

    <p class="instruction">
        続行する前に、送信されたメールで確認リンクをクリックしてください。
        もしメールを受け取っていない場合は、以下のボタンで再送信することができます。
    </p>

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn resend-btn">認証メールを再送する</button>
    </form>
</div>
@endsection