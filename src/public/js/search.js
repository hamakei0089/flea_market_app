document.addEventListener('DOMContentLoaded', () => {
    const searchBox = document.getElementById('search-box');
    const itemsGrid = document.querySelector('.items-grid');
    const itemCards = itemsGrid.querySelectorAll('.item-card');

    function getSearchParam() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('search') || '';
    }

    searchBox.value = getSearchParam();

    searchBox.addEventListener('input', (e) => {
        const searchText = e.target.value.toLowerCase();

        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('search', searchText);

        if (!urlParams.has('page')) {
            urlParams.set('page', 'all');
        }

        window.history.replaceState(null, '', '?' + urlParams.toString());

        itemCards.forEach((card) => {
            const itemName = card.querySelector('.item-name').textContent.toLowerCase();
            if (itemName.includes(searchText)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
