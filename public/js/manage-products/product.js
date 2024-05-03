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
document.addEventListener("DOMContentLoaded", function () {
    var checkbox = document.getElementById("same-price-all");
    var inputField = document.getElementById("priceForSize[Default]");
    checkbox.addEventListener("change", function () {
        if (checkbox.checked) {
            inputField.disabled = true;
            inputField.classList.add('bg-gray-200');
            inputField.classList.add('cursor-not-allowed');

        } else {
            inputField.disabled = false;
            inputField.classList.remove('bg-gray-200');
            inputField.classList.remove('cursor-not-allowed');
        }
    });
});

function addCustomSizeInput() {
    var newDiv = document.createElement('div');
    newDiv.classList.add('flex', 'items-center', 'space-x-4');
    newDiv.style.marginTop = '16px';
    var sizeInput = document.createElement('input');
    sizeInput.type = 'text';
    sizeInput.name = 'custom_sizes[]';
    sizeInput.placeholder = 'Maat';
    sizeInput.classList.add('w-full', 'px-4', 'py-2', 'border', 'border-gray-300', 'rounded-md',
        'specific-size-price');
    var priceInput = document.createElement('input');
    priceInput.type = 'number';
    priceInput.name = 'custom_prices[]';
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

toggleButtons();
window.addEventListener('resize', toggleButtons);

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('same-price-all').addEventListener('change', function () {
        var specificSizes = document.getElementById('specific-size-prices');
        var labels = specificSizes.getElementsByTagName('label');
        var labelValues = [];
        for (var i = 0; i < labels.length; i++) {
            labelValues.push(labels[i].textContent);
        }

        document.getElementById('size-price-inputs').classList.toggle('hidden');

        const priceLabel = document.querySelector('label[for="priceForSize[Default]"]');
        const defaultPriceInput = document.getElementById('priceForSize[Default]');
        var customSizeInputs = document.querySelectorAll('#custom-size-inputs input[type="text"]');
        var customPriceInputs = document.querySelectorAll('#custom-size-inputs input[type="number"]');

        if (this.checked) {
            defaultPriceInput.parentNode.parentNode.classList.remove('hidden');
            priceLabel.classList.remove('hidden');
            customSizeInputs.forEach(function(input) {
                input.disabled = false;
            });
            customPriceInputs.forEach(function(input) {
                input.disabled = false;
            });

        } else {
                customSizeInputs.forEach(function(input) {
                    input.disabled = true;
                });
                customPriceInputs.forEach(function(input) {
                    input.disabled = true;
                });
        }
    });
});
