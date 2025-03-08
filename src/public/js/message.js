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
});
