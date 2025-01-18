$(document).ready(function () {
    // CSRFトークンの取得
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // 初期状態のボタン表示
    $('.favorite-btn').each(function () {
        var button = $(this);
        var isFavorite = button.data('favorite') === 'true';
        button.html(isFavorite ? '★' : '☆');
        button.toggleClass('bg-red-500 hover:bg-red-700 bg-blue-500 hover:bg-blue-700', isFavorite);
    });

    // いいねボタンクリック時の処理
    $('.favorite-btn').click(function() {
        var button = $(this);
        var itemId = button.closest('.item').data('item-id');
        var isFavorite = button.data('favorite') === 'true';

        // AJAXリクエストでサーバーにいいね/取り消し処理を依頼
        $.ajax({
            url: '/items/' + itemId + '/favorite',
            method: 'POST',
            data: {
                _token: csrfToken,
            },
            success: function(response) {
                // サーバーからのレスポンスに基づいてボタンの表示を更新
                button.data('favorite', response.isFavorited);
                button.html(response.isFavorited ? '★' : '☆');
                button.toggleClass('bg-red-500 hover:bg-red-700 bg-blue-500 hover:bg-blue-700');

                // いいね数を更新
                button.closest('.item').find('.favorites-count').text(response.favorites_count);
            },
            error: function(xhr) {
                // エラー処理は必要に応じて
                console.error('エラーが発生しました:', xhr.responseText);
            }
        });
    });
});