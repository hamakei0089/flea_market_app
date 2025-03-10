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

$(document).ready(function () {
    $("#deal-done-btn").on("click", function () {
        $("#review-modal").removeClass("hidden");
    });

    $("#close-modal").on("click", function () {
        $("#review-modal").addClass("hidden");
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star');
    let selectedRating = 0;

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            const value = star.getAttribute('data-value');
            highlightStars(value);
        });

        star.addEventListener('mouseout', () => {
            if (selectedRating === 0) {
                resetStars();
            } else {
                highlightStars(selectedRating);
            }
        });

        star.addEventListener('click', () => {
            selectedRating = star.getAttribute('data-value');
            highlightStars(selectedRating);
            updateRadioButton(selectedRating);
        });
    });

    function highlightStars(rating) {
        stars.forEach(star => {
            const value = star.getAttribute('data-value');
            if (value <= rating) {
                star.classList.add('hover');
            } else {
                star.classList.remove('hover');
            }
        });
    }

    function resetStars() {
        stars.forEach(star => {
            star.classList.remove('hover');
        });
    }

    function updateRadioButton(rating) {
        const radioButton = document.querySelector(`input[name="rating"][value="${rating}"]`);
        if (radioButton) {
            radioButton.checked = true;
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {

    const textarea = document.querySelector(".message-text");
    const storageKey = "chat_message_{{ $item->id }}_{{ auth()->id() }}";

    if (localStorage.getItem(storageKey)) {
        textarea.value = localStorage.getItem(storageKey);
    }

    textarea.addEventListener("input", function() {
        localStorage.setItem(storageKey, textarea.value);
    });

    const form = document.getElementById("messageForm");
    form.addEventListener("submit", function() {
        localStorage.removeItem(storageKey);
    });
});


