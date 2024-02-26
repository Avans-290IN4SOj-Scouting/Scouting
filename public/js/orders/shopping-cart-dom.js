class PHPPriceChange {
    constructor(amount, total, sale) {
        this.amount = amount;
        this.total = total;
        this.sale = sale;
    }
}

function DOM_removeShoppingCartProduct(id) {
    const toDelete = document.querySelector('#product-' + id);

    removeProductFromShoppingCart(id);
    shoppingCartChanged();

    toDelete.remove();
}

function DOM_shoppingCartProductAmountChange(id) {
    let input = document.querySelector('#input-' + id);

    if (input.value == 0) {
        DOM_removeShoppingCartProduct(id);
        return;
    }

    setShoppingCartProductAmount(id, Number(input.value));
    shoppingCartChanged();
}

function DOM_shoppingCartProductAdd(id, amount) {
    let input = document.querySelector('#input-' + id);
    input.value = (Number(input.value) + amount);

    DOM_shoppingCartProductAmountChange(id);
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
        let priceChangeData = JSON.parse(data.priceChange);
        let priceChange = new PHPPriceChange(priceChangeData.amount, priceChangeData.total, priceChangeData.sale);

        const amountText = document.querySelector('#productCount');
        const totalText = document.querySelector('#shoppingCartTotal');
        const saleText = document.querySelector('#shoppingCartSale');

        amountText.textContent = priceChange.amount;
        totalText.textContent = priceChange.total;
        saleText.textContent = priceChange.sale;
    })
    .catch(error => {
        console.error('Error updating text field:', error);
    });
}

document.addEventListener('DOMContentLoaded', function () {

});
