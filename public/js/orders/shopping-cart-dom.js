function DOM_removeShoppingCartProduct(id) {
    const toDelete = document.querySelector('#product-' + id);

    removeProductFromShoppingCart(id);

    toDelete.remove();
}

function DOM_shoppingCartProductAmountChange(id) {
    let input = document.querySelector('#input-' + id);

    if (input.value == 0) {
        DOM_removeShoppingCartProduct(id);
    } else {
        setShoppingCartProductAmount(id, Number(input.value));
    }
}

function DOM_shoppingCartProductAdd(id, amount) {
    let input = document.querySelector('#input-' + id);
    input.value = (Number(input.value) + amount);

    DOM_shoppingCartProductAmountChange(id);
}
