document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('label button');
    const fileInput = document.getElementById('thumbnail');
    const fileNameSpan = document.getElementById('file-name');
    const fileUploadSection = document.querySelector('.file-upload-section');

    button.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const fileName = file.name;
            fileNameSpan.textContent = fileName;
            fileNameSpan.style.display = 'inline';

            const reader = new FileReader();
            reader.onload = function(e) {
                fileUploadSection.style.backgroundImage = `url(${e.target.result})`;
                fileUploadSection.style.backgroundSize = 'contain';
                fileUploadSection.style.backgroundPosition = 'left';
                fileUploadSection.style.backgroundRepeat = 'no-repeat';
            };
            reader.readAsDataURL(file);
        } else {
            fileNameSpan.style.display = 'none';
            fileUploadSection.style.backgroundImage = 'none';
        }
    });

    const categoryButtons = document.querySelectorAll('.category-btn');
    categoryButtons.forEach(button => {
        button.addEventListener('click', function () {
            const hiddenInput = this.nextElementSibling;
            // toggle the disabled attribute
            if (hiddenInput.disabled) {
                hiddenInput.disabled = false;
                this.classList.add('selected');
            } else {
                hiddenInput.disabled = true;
                this.classList.remove('selected');
            }
        });
    });

    // 追加: フォーム送信時に全てのカテゴリーの hidden input の disabled 属性を解除
    const form = document.querySelector('.listing-form');
    form.addEventListener('submit', function() {
        const categoryInputs = document.querySelectorAll('input[name="categories[]"]');
        categoryInputs.forEach(input => {
            input.disabled = false;
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
});
