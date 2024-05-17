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
            removeBtn.classList.remove('hidden');
        }

        reader.readAsDataURL(file);
        placeholder.classList.add('hidden');
    } else {
        preview.classList.add('hidden');
        removeBtn.classList.add('hidden');
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

function addCustomSizeInput(maat = '', prijs = '') {

    let newDiv = document.createElement('div');
    newDiv.classList.add('flex', 'items-center', 'space-x-4');
    newDiv.style.marginTop = '16px';
    let sizeInput = document.createElement('input');
    sizeInput.type = 'text';
    sizeInput.name = 'custom_sizes[]';
    sizeInput.placeholder = 'Maat';
    sizeInput.value = maat;
    sizeInput.classList.add('w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-md',
        'specific-size-price');
    let priceInput = document.createElement('input');
    priceInput.type = 'number';
    priceInput.step = '0.01';
    priceInput.name = 'custom_prices[]';
    priceInput.value = prijs;
    priceInput.placeholder = 'Prijs';
    priceInput.classList.add('w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-md',
        'specific-size-price');
    newDiv.appendChild(sizeInput);
    newDiv.appendChild(priceInput);
    document.getElementById('custom-size-inputs').appendChild(newDiv);
}

function toggleButtons() {
    const screenWidth = window.innerWidth; // Get the current screen width
    const smallBtn = document.getElementById('small-screen');
    const bigBtn = document.getElementById('big-screen');

    if (screenWidth <= 768) {
        smallBtn.classList.remove('hidden');
        bigBtn.classList.add('hidden');
    } else {
        smallBtn.classList.add('hidden');
        bigBtn.classList.remove('hidden');
    }
}

function checkExistingProduct() {
    const checkbox = document.getElementById("same-price-all");
    const inputField = document.getElementById("priceForSize[Default]");
    const sizePriceInputs = document.getElementById("size-price-inputs");
    if (checkbox.checked) {
        inputField.disabled = true;
        inputField.classList.add('bg-gray-200');
        inputField.classList.add('cursor-not-allowed');
        sizePriceInputs.classList.remove('hidden');
    } else {
        inputField.disabled = false;
        inputField.classList.remove('bg-gray-200');
        inputField.classList.remove('cursor-not-allowed');
        sizePriceInputs.classList.add('hidden');
    }
}
