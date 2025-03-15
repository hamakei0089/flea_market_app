document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('.file-upload-btn');
    const fileInput = document.getElementById('thumbnail');
    const previewImage = document.getElementById('thumbnail-preview');

    button.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            };

            reader.readAsDataURL(file);
        } else {
            previewImage.style.display = 'none';
        }
    });
});
