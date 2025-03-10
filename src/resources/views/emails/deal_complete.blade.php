<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>取引完了通知</title>
</head>
<body>
    <p>出品された「{{ $item->name }}」の取引が完了しました。</p>
    <p>ご確認をお願いいたします。</p>
    <p>詳細はマイページより取引中の商品をクリックするとご確認いただけます。</p>
    <p><a href="{{ route('mypage.index') }}">マイページへ</a></p>
</body>
</html>
