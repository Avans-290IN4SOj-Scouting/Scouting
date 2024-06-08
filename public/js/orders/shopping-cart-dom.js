class PHPPriceChange {
    constructor(amount, total) {
        this.amount = amount;
        this.total = total;
    }
}

function DOM_removeShoppingCartProduct(id, sizeId, typeId) {
    const toDelete = document.querySelector('#product-' + id + 'size-' + sizeId + 'type-' + typeId);
    console.log(toDelete);

    removeProductFromShoppingCart(id, sizeId, typeId);
    shoppingCartChanged();

    toDelete.remove();
}

function DOM_shoppingCartProductAmountChange(id, sizeId, typeId) {
    let input = document.querySelector('#input-' + id + 'size-' + sizeId + 'type-' + typeId);

    const regex = /^[0-9]{0,3}$/;
    if (!regex.test(input.value)) {
        setShoppingCartProductAmount(id, sizeId, typeId, 1);
        input.value = 1;
    }

    if (parseInt(input.value) === 0) {
        DOM_removeShoppingCartProduct(id, sizeId, typeId);
        return;
    }

    setShoppingCartProductAmount(id, sizeId, typeId, Number(input.value));
    shoppingCartChanged();
}

function DOM_shoppingCartProductAdd(id, sizeId, typeId, amount) {
    let input = document.querySelector('#input-' + id + 'size-' + sizeId + 'type-' + typeId);
    input.value = (Number(input.value) + amount);

    DOM_shoppingCartProductAmountChange(id, sizeId, typeId);
}

function shoppingCartChanged() {
    updateShoppingCartPrices();
}

function updateShoppingCartPrices() {
    const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
    const route = document.querySelector('#shoppingcartUpdate').value;

    // Send POST request using Fetch API
    fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken, // Include the CSRF token
        },
        body: JSON.stringify({ new_text: 'New text value' }),
    })
    .then(response => response.json())
    .then(data => {
        if (data === null || data.priceChange === null)
        {
            return;
        }

        let priceChangeData = JSON.parse(data.priceChange);
        let priceChange = new PHPPriceChange(priceChangeData.amount, priceChangeData.total);

        const amountText = document.querySelector('#productCount');
        const totalText = document.querySelector('#shoppingCartTotal');
        if (amountText === null || totalText === null)
        {
            return;
        }

        amountText.textContent = priceChange.amount;
        totalText.textContent = formatPrice(priceChange.total);

        const noProductsText = document.querySelector('#empty-shopping-cart-text');
        noProductsText.hidden = priceChange.amount !== 0;
    })
    .catch(error => {
        console.error('Error updating text field:', error);
    });
}

function formatPrice(price) {
    return price.toFixed(2).replace('.', ',');
}

function DOM_addProductFromProductPage(productId) {
    try
    {
        const sizeElement = document.querySelector('#product-sizes');
        const sizeId = sizeElement.options[sizeElement.selectedIndex].id;

        const typeElement = document.querySelector('#product-types');
        // TODO: Hardcoded type id naar unisex
        const typeId = 2;

        const amount = 1;
        addProductToShoppingCart(productId, sizeId, typeId, amount);
    }
    catch (e)
    {
        console.error('Error adding product to shopping cart:', e);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const productSizes = document.querySelector('#product-sizes');
    if (productSizes === null) {
        return;
    }

    productSizes.addEventListener('change', (event) => {
        const price = event.target.options[event.target.selectedIndex].dataset.price;
        document.querySelector('#product-price').textContent = price.replace('.', ',');
    });
})

