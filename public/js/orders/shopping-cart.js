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
            if (this.products[i].id == id && this.products[i].sizeId == sizeId) {
                return true;
            }
        }

        return false;
    }

    removeProductById(id, sizeId) {
        for (let i = 0; i < this.products.length; i++) {
            if (this.products[i].id == id && this.products[i].sizeId == sizeId) {
                this.products.splice(i, 1);
                return true;
            }
        }

        return false;
    }

    setProductAmount(id, sizeId, amount) {
        for (let i = 0; i < this.products.length; i++) {
            if (this.products[i].id == id && this.products[i].sizeId == sizeId) {
                this.products[i].amount = amount;
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
        createToast('Product is al in uw winkelwagen!', 'warning');
        return;
    }

    let newProduct = new Product;
    newProduct.id = id;
    newProduct.amount = amount;
    newProduct.sizeId = sizeId;

    shoppingCart.products.push(newProduct);

    // 3. Save Changes
    saveShoppingCart(shoppingCart);

    // 4. Show message
    createToast('Product toegevoegd aan winkelwagen!', 'success');
}

function removeProductFromShoppingCart(id, sizeId) {
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
    createToast('Product verwijderd uit uw winkelwagen!', 'success');
}

function setShoppingCartProductAmount(id, sizeId, amount) {
    // 1. Get Current
    let shoppingCart = getShoppingCart();

    // 2. Make Changes
    shoppingCart.setProductAmount(id, sizeId, amount);

    // 3. Save Changes
    saveShoppingCart(shoppingCart);
}

const shoppingCartcookieName = 'shopping-cart';
const shoppingCartcookieDomain = '127.0.0.1';
const shoppingCartcookiePath = '/';

// Cookie
function saveShoppingCart(shoppingCart) {
    const expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + 30);
    const cookie = `${shoppingCartcookieName}=${JSON.stringify(shoppingCart)}; domain=${shoppingCartcookieDomain}; path=${shoppingCartcookiePath}`;
    document.cookie = cookie;
    // createToast(JSON.stringify(cookie), 'warning');
}

function getShoppingCart() {
    const cookieValue = document.cookie
    .split('; ')
    .find((row) => row.startsWith(`${shoppingCartcookieName}=`))
    ?.split('=')[1];

    let shoppingCartData;
    if (cookieValue === undefined) {
        // createToast("Cookie not SET!", 'error');
        return new ShoppingCart;
    } else {
        shoppingCartData = JSON.parse(cookieValue);
        // createToast("Cookie is SET!", 'success');
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
    document.cookie = `${shoppingCartcookieName}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=${shoppingCartcookieDomain}; path=${shoppingCartcookiePath}`;
}
