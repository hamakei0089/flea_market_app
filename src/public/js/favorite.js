$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $('.favorite-btn').each(function () {
        var button = $(this);
        var isFavorite = button.data('favorite') === 'true';
        button.html(isFavorite ? '★' : '☆');
        button.toggleClass('bg-red-500 hover:bg-red-700 bg-blue-500 hover:bg-blue-700', isFavorite);
    });

    $('.favorite-btn').click(function() {
        var button = $(this);
        var itemId = button.closest('.item').data('item-id');
        var isFavorite = button.data('favorite') === 'true';

        $.ajax({
            url: '/items/' + itemId + '/favorite',
            method: 'POST',
            data: {
                _token: csrfToken,
            },
            success: function(response) {
                // お気に入り状態を更新
                button.data('favorite', response.isFavorited);
                button.html(response.isFavorited ? '★' : '☆');
                button.toggleClass('bg-red-500 hover:bg-red-700 bg-blue-500 hover:bg-blue-700');

                // 更新したお気に入り数を反映
                button.closest('.item').find('.favorites-count').text(response.favorites_count);
            },
            error: function(xhr) {
                console.error('エラーが発生しました:', xhr.responseText);
            }
        });
    });
});
