const SHOPPINGCART_COOKIE_NAME      = 'shopping-cart';
const SHOPPINGCART_COOKIE_PATH      = '/';
function getCookieDomain() {
    return window.location.hostname;
}

// Classes
class Product {
    constructor() {
        this.id;
        this.amount;
        this.sizeId;
    }
}

class ShoppingCart {
    constructor() {
        this.products = [];
    }

    isProductInShoppingCart(id, sizeId) {
        for (let i = 0; i < this.products.length; i++) {
            if (
                parseInt(this.products[i].id) === parseInt(id) &&
                parseInt(this.products[i].sizeId) === parseInt(sizeId)
            ) {
                return true;
            }
        }

        return false;
    }

    removeProductById(id, sizeId) {
        for (let i = 0; i < this.products.length; i++) {
            if (
                parseInt(this.products[i].id) === parseInt(id) &&
                parseInt(this.products[i].sizeId) === parseInt(sizeId)
            ) {
                this.products.splice(i, 1);
                return true;
            }
        }

        return false;
    }

    setProductAmount(id, sizeId, amount) {
        for (let i = 0; i < this.products.length; i++) {
            if (
                parseInt(this.products[i].id) === parseInt(id) &&
                parseInt(this.products[i].sizeId) === parseInt(sizeId)
            ) {
                this.products[i].amount = amount;
                return true;
            }
        }
    }

    addAmountToProduct(id, sizeId, amount) {
        for (let i = 0; i < this.products.length; i++) {
            if (
                parseInt(this.products[i].id) === parseInt(id) &&
                parseInt(this.products[i].sizeId) === parseInt(sizeId)
            ) {
                this.products[i].amount += amount;
                return true;
            }
        }
    }
}

// Code
function addProductToShoppingCart(id, sizeId, amount) {
    // 1. Get Current
    let shoppingCart = getShoppingCart();

    // 2. Make Changes
    // Check if Product already exists
    if (shoppingCart.isProductInShoppingCart(id, sizeId) === true) {
        shoppingCart.addAmountToProduct(id, sizeId, 1);
    } else {
        let newProduct = new Product();
        newProduct.id = parseInt(id);
        newProduct.amount = parseInt(amount);
        newProduct.sizeId = parseInt(sizeId);

        console.log(newProduct);
        shoppingCart.products.push(newProduct);
    }

    // 3. Save Changes
    saveShoppingCart(shoppingCart);

    // 4. Show message
    createToast('success', 'Product toegevoegd aan winkelwagen!' );
}

function removeProductFromShoppingCart(id, sizeId) {
    console.log('Removing product from shopping cart:', id, sizeId);
    // 1. Get Current
    let shoppingCart = getShoppingCart();

    // 2. Make Changes
    // Check if product exists
    if (shoppingCart.removeProductById(id, sizeId) === false) {
        console.warn("Product could not be removed from shopping cart, product was not present.");
        return;
    }

    // 3. Save Changes
    saveShoppingCart(shoppingCart);
    createToast('success', 'Product verwijderd uit uw winkelwagen!');
}

function setShoppingCartProductAmount(id, sizeId, amount) {
    // 1. Get Current
    let shoppingCart = getShoppingCart();

    // 2. Make Changes
    shoppingCart.setProductAmount(id, sizeId, amount);

    // 3. Save Changes
    saveShoppingCart(shoppingCart);
}

// Cookie
function saveShoppingCart(shoppingCart) {
    const expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + 30);
    const cookie = `${SHOPPINGCART_COOKIE_NAME}=${JSON.stringify(shoppingCart)}; domain=${getCookieDomain()}; path=${SHOPPINGCART_COOKIE_PATH}`;
    document.cookie = cookie;
}

function getShoppingCart() {
    const cookieValue = document.cookie
    .split('; ')
    .find((row) => row.startsWith(`${SHOPPINGCART_COOKIE_NAME}=`))
    ?.split('=')[1];

    let shoppingCartData;
    if (cookieValue === undefined) {
        return new ShoppingCart;
    } else {
        shoppingCartData = JSON.parse(cookieValue);
    }

    // Deserialize the JSON string back into a Product instance
    if (shoppingCartData === null) {
        return new ShoppingCart;
    }

    let shoppingCart = new ShoppingCart;
    shoppingCart.products = shoppingCartData.products;

    return shoppingCart;
}

function clearShoppingCart() {
    document.cookie = `${SHOPPINGCART_COOKIE_NAME}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=${getCookieDomain()}; path=${SHOPPINGCART_COOKIE_PATH}`;
}
