class PHPPriceChange {
    constructor(amount, total, sale) {
        this.amount = amount;
        this.total = total;
        this.sale = sale;
    }
}

function DOM_removeShoppingCartProduct(id, size) {
    const toDelete = document.querySelector('#product-' + id + 'size-' + size);

    removeProductFromShoppingCart(id, size);
    shoppingCartChanged();

    toDelete.remove();
}

function DOM_shoppingCartProductAmountChange(id, size) {
    let input = document.querySelector('#input-' + id + 'size-' + size);
    console.log(input.value);

    const regex = /^[0-9]{0,3}$/;
    if (!regex.test(input.value)) {
        setShoppingCartProductAmount(id, size, 1);
        input.value = 1;
    }

    if (input.value == 0) {
        DOM_removeShoppingCartProduct(id, size);
        return;
    }

    setShoppingCartProductAmount(id, size, Number(input.value));
    shoppingCartChanged();
}

function DOM_shoppingCartProductAdd(id, size, amount) {
    let input = document.querySelector('#input-' + id + 'size-' + size);
    input.value = (Number(input.value) + amount);

    DOM_shoppingCartProductAmountChange(id, size);
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
            console.log("oofies1");
            return;
        }

        let priceChangeData = JSON.parse(data.priceChange);
        let priceChange = new PHPPriceChange(priceChangeData.amount, priceChangeData.total, priceChangeData.sale);

        const amountText = document.querySelector('#productCount');
        const totalText = document.querySelector('#shoppingCartTotal');
        const saleText = document.querySelector('#shoppingCartSale');
        if (amountText === null || totalText === null || saleText === null)
        {
            // TODO: Maybe an error
            console.log("oofies2");
            return;
        }

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
