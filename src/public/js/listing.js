document.addEventListener('DOMContentLoaded', () => {
    const label = document.querySelector('.custom-file-upload');
    const fileInput = document.getElementById('thumbnail');
    const fileNameDisplay = document.getElementById('file-name');

    label.addEventListener('click', (e) => {
        e.preventDefault();
        fileInput.click();
    });

    fileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {

            fileNameDisplay.textContent = file.name;
            fileNameDisplay.style.display = 'block';
        }
    });

    const categoryButtons = document.querySelectorAll('.category-btn');
    const selectedCategoriesInput = document.getElementById('selected-categories');

    categoryButtons.forEach(button => {
        button.addEventListener('click', function () {
            const categoryId = this.dataset.categoryId;

            // すでにカテゴリーが選択されているか確認
            let selectedCategories = selectedCategoriesInput.value
                ? selectedCategoriesInput.value.split(',')
                : [];

            if (selectedCategories.includes(categoryId)) {
                // 既存の場合は削除
                selectedCategories = selectedCategories.filter(id => id !== categoryId);
                this.classList.remove('selected'); // ボタンの見た目を更新
            } else {
                // 新規の場合は追加
                selectedCategories.push(categoryId);
                this.classList.add('selected'); // ボタンの見た目を更新
            }

            // hidden input に値を設定
            selectedCategoriesInput.value = selectedCategories.join(',');
        });
    });
});
