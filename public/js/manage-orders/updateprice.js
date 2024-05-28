document.getElementsByName('product-price').forEach(product => {
    product.addEventListener('change', function () {
        const form = product.parentElement;
        form.submit();
    });
});
