class PHPPriceChange {
    constructor(amount, total) {
        this.amount = amount;
        this.total = total;
    }
}

function DOM_removeShoppingCartProduct(id, sizeId) {
    const toDelete = document.querySelector('#product-' + id + 'size-' + sizeId);
    console.log(toDelete);

    removeProductFromShoppingCart(id, sizeId);
    shoppingCartChanged();

    toDelete.remove();
}

function DOM_shoppingCartProductAmountChange(id, sizeId) {
    let input = document.querySelector('#input-' + id + 'size-' + sizeId);

    const regex = /^[0-9]{0,3}$/;
    if (!regex.test(input.value)) {
        setShoppingCartProductAmount(id, sizeId, 1);
        input.value = 1;
    }

    if (parseInt(input.value) === 0) {
        DOM_removeShoppingCartProduct(id, sizeId);
        return;
    }

    setShoppingCartProductAmount(id, sizeId, Number(input.value));
    shoppingCartChanged();
}

function DOM_shoppingCartProductAdd(id, sizeId, amount) {
    let input = document.querySelector('#input-' + id + 'size-' + sizeId);
    input.value = (Number(input.value) + amount);

    DOM_shoppingCartProductAmountChange(id, sizeId);
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
        let sizeId;

        if (!sizeElement) {
            sizeId = 1; // Default size (nvt)
        }
        else {
            sizeId = sizeElement.options[sizeElement.selectedIndex].id;
        }

        const amount = 1;
        addProductToShoppingCart(productId, sizeId, amount);
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

