document.getElementById('af-submit-app-upload-images').addEventListener('change', handleFileSelect);
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

document.addEventListener("DOMContentLoaded", function () {
    toggleButtons();
    checkExistingProduct();
});

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
        var existingPriceInputs = document.getElementsByClassName("existing-custom-price");

        if (this.checked) {
            defaultPriceInput.parentNode.parentNode.classList.remove('hidden');
            priceLabel.classList.remove('hidden');
            customSizeInputs.forEach(function (input) {
                input.disabled = false;

            });
            customPriceInputs.forEach(function (input) {
                input.disabled = false;
            });

            for (var i = 0; i < existingPriceInputs.length; i++) {
                existingPriceInputs[i].disabled = false;
            }

        } else {
            customSizeInputs.forEach(function (input) {
                input.disabled = true;
            });
            customPriceInputs.forEach(function (input) {
                input.disabled = true;
            });

            for (var i = 0; i < existingPriceInputs.length; i++) {
                existingPriceInputs[i].disabled = true;
            }
        }
    });
});
