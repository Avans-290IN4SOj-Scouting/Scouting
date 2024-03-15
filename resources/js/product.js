document.getElementById('same-price-all').addEventListener('change', function () {
    var specificSizes = document.getElementById('size-price-inputs');
    specificSizes.classList.toggle('hidden');
    const priceInput = document.getElementById('priceInput');
    const specificSizePrices = document.querySelectorAll('.specific-size-price');
    const priceLabel = document.querySelector('label[for="product-price"]');

    if (this.checked) {
        priceInput.value = ''; // Clear general price input when specific sizes are chosen
        specificSizePrices.forEach(input => {
            input.value = '';
        });
        priceInput.parentNode.parentNode.classList.add('hidden');
        priceLabel.classList.add('hidden');
    } else {
        priceInput.parentNode.parentNode.classList.remove('hidden');
        priceLabel.classList.remove('hidden');
    }
});

function addCustomSizeInput() {
    // Maak een nieuw div-element aan
    var newDiv = document.createElement('div');
    newDiv.classList.add('flex', 'items-center', 'space-x-4');

    // Voeg invoerveld toe voor maat
    var sizeInput = document.createElement('input');
    sizeInput.type = 'text';
    sizeInput.placeholder = 'Maat';
    sizeInput.classList.add('w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-md');

    // Voeg invoerveld toe voor prijs
    var priceInput = document.createElement('input');
    priceInput.type = 'number';
    priceInput.placeholder = 'Prijs';
    priceInput.classList.add('w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-md', 'specific-size-price');

    // Voeg de elementen toe aan de nieuwe div
    newDiv.appendChild(sizeInput);
    newDiv.appendChild(priceInput);

    // Voeg de nieuwe div toe aan #custom-size-inputs
    document.getElementById('custom-size-inputs').appendChild(newDiv);
}
function handleFileSelect(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('file-image');
    const removeBtn = document.getElementById('remove-image');
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();

        reader.onload = function (event) {
            preview.src = reader.result;
            preview.classList.remove('hidden');
            removeBtn.classList.remove('hidden');
        }

        reader.readAsDataURL(file);
        document.getElementById('notimage').classList.add('hidden');
    } else {
        preview.classList.add('hidden');
        removeBtn.classList.add('hidden'); // Hide remove button
        document.getElementById('notimage').classList.remove('hidden');
    }
}

document.getElementById('af-submit-app-upload-images').addEventListener('change', handleFileSelect);

function removeImage(event) {
    event.preventDefault();
    const preview = document.getElementById('file-image');
    const removeBtn = document.getElementById('remove-image');
    const uploadInput = document.getElementById('af-submit-app-upload-images');

    preview.classList.add('hidden');
    removeBtn.classList.add('hidden');
    uploadInput.value = '';
}

document.getElementById('remove-image').addEventListener('click', removeImage);
