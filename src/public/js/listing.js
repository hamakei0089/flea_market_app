
document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('label button');
    const fileInput = document.getElementById('thumbnail');
    const fileNameSpan = document.getElementById('file-name');

    button.addEventListener('click', () => {
    fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            const fileName = fileInput.files[0].name;
            fileNameSpan.textContent = fileName;
            fileNameSpan.style.display = 'inline';
        } else {
            fileNameSpan.style.display = 'none';
        }
    });

    const categoryButtons = document.querySelectorAll('.category-btn');

    categoryButtons.forEach(button => {
    button.addEventListener('click', function () {
        const categoryId = this.dataset.categoryId;
        const hiddenInput = this.nextElementSibling;

        if (hiddenInput.disabled) {
            hiddenInput.disabled = false;
            this.classList.add('selected');
        } else {
            hiddenInput.disabled = true;
            this.classList.remove('selected');
        }
        });
    });
});

document.getElementById('condition').addEventListener('change', function() {
        const select = this;
        const defaultOption = select.querySelector('option[value=""]');

        if (select.value !== "") {
            defaultOption.style.display = 'none';
        } else {
            defaultOption.style.display = '';
        }
});