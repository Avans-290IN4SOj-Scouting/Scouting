function handleFileSelect(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('file-image');
    const removeBtn = document.getElementById('remove-image');
    const placeholder = document.getElementById('notimage');
    if (file.type.startsWith('image/') || preview.src.includes('images')) {
        const reader = new FileReader();

        reader.onload = function (event) {
            preview.src = reader.result;
            preview.classList.remove('hidden');
            if (!window.location.href.includes('editProduct')) {
                removeBtn.classList.remove('hidden');
            }
        }

        reader.readAsDataURL(file);
        placeholder.classList.add('hidden');
    } else {
        preview.classList.add('hidden');
        if (!window.location.href.includes('editProduct')) {
            removeBtn.classList.add('hidden');
        }
        placeholder.classList.remove('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const preview = document.getElementById('file-image');
    const removeBtn = document.getElementById('remove-image');
    if (preview.src.includes('images')) {
        removeBtn.classList.remove('hidden');
    }
});

function removeImage(event) {
    event.preventDefault();
    const preview = document.getElementById('file-image');
    const removeBtn = document.getElementById('remove-image');
    const uploadInput = document.getElementById('af-submit-app-upload-images');
    const placeholder = document.getElementById('notimage');
    preview.classList.add('hidden');
    removeBtn.classList.add('hidden');
    placeholder.classList.remove('hidden');

    preview.src = '';

    uploadInput.value = '';
}

const priceSizeTemplate = document.querySelector('#price-size-template');

function addPriceSizeInput() {
    const clone = priceSizeTemplate.content.cloneNode(true);
    document.querySelector('#price-size-inputs').appendChild(clone);
}

function removePriceSize(event) {
    const entry = event.target.closest('.price-size-entry');
    if (document.querySelectorAll('.price-size-entry').length > 1) {
        entry.remove();
    } else {
        createToast('Er moet minstens 1 maat en prijs zijn.', 'warning');
    }
}
