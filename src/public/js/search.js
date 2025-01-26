document.addEventListener('DOMContentLoaded', () => {
    const searchBox = document.getElementById('search-box');
    const itemsGrid = document.querySelector('.items-grid');
    const itemCards = itemsGrid.querySelectorAll('.item-card');

    searchBox.addEventListener('input', (e) => {
        const searchText = e.target.value.toLowerCase();

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
