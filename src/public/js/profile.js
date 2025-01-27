document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('label button');
    const fileInput = document.getElementById('thumbnail');
    const fileNameSpan = document.getElementById('file-name');
    const thumbnailPreview = document.getElementById('thumbnail-preview');

    button.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];

        if (file) {
            fileNameSpan.textContent = file.name;
            fileNameSpan.style.display = 'block';

            const reader = new FileReader();
            reader.onload = function(e) {
                thumbnailPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            thumbnailPreview.src = '';
            fileNameSpan.style.display = 'none';
        }
    });
});