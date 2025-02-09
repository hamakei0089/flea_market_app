$(document).ready(function () {
    $('#search-box').keypress(function (event) {
        if (event.which === 13) {
            event.preventDefault();
            let searchQuery = $(this).val();
            let currentTab = $('.tabs-menu .active a').attr('href');

            let url = new URL(currentTab, window.location.origin);
            url.searchParams.set('search', searchQuery);

            window.location.href = url.toString();
        }
    });
});
