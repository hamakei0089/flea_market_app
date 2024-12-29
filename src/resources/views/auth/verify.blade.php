@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>メールアドレスの確認</h2>

        <p>登録したメールアドレスに確認メールが送信されました。メールに記載されたリンクをクリックして確認を完了してください。</p>

        @if (session('status') == 'verification-link-sent')
            <div>
                新しい確認リンクが送信されました。
            </div>
        @endif

        <p>メールが届かない場合は、下記のボタンをクリックして再送信できます。</p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">確認メールを再送信</button>
        </form>
    </div>
@endsection
