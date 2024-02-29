// Classes
class Product {
    constructor() {
        this.id;
        this.amount;
    }
}

class ShoppingCart {
    constructor() {
        this.products = [];
    }

    isProductInShoppingCart(id) {
        for (let i = 0; i < this.products.length; i++) {
            if (this.products[i].id === id) {
                return true;
            }
        }

        return false;
    }

    removeProductById(id) {
        for (let i = 0; i < this.products.length; i++) {
            if (this.products[i].id == id) {
                this.products.splice(i, 1);
                return true;
            }
        }

        return false;
    }

    setProductAmount(id, amount) {
        for (let i = 0; i < this.products.length; i++) {
            if (this.products[i].id == id) {
                this.products[i].amount = amount;
                return true;
            }
        }
    }
}

// Code
function addProductToShoppingCart(id, amount) {
    // 1. Get Current
    let shoppingCart = getShoppingCart();

    // 2. Make Changes
    // Check if Product already exists
    if (shoppingCart.isProductInShoppingCart(id) === true) {
        return;
    }

    let newProduct = new Product;
    newProduct.id = id;
    newProduct.amount = amount;

    shoppingCart.products.push(newProduct);

    // 3. Save Changes
    saveShoppingCart(shoppingCart);
}

function removeProductFromShoppingCart(id) {
    // 1. Get Current
    let shoppingCart = getShoppingCart();

    // 2. Make Changes
    // Check if product exists
    if (shoppingCart.removeProductById(id) === false) {
        console.warn("Product could not be removed from shopping cart, product was not present.");
        return;
    }

    // 3. Save Changes
    saveShoppingCart(shoppingCart);
}

function setShoppingCartProductAmount(id, amount) {
    // 1. Get Current
    let shoppingCart = getShoppingCart();

    // 2. Make Changes
    shoppingCart.setProductAmount(id, amount);

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
    document.cookie = `${shoppingCartcookieName}=${JSON.stringify(shoppingCart)}; domain=${shoppingCartcookieDomain}; path=${shoppingCartcookiePath}`;
}

function getShoppingCart() {
    const cookieValue = document.cookie
    .split('; ')
    .find((row) => row.startsWith(`${shoppingCartcookieName}=`))
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
    document.cookie = `${shoppingCartcookieName}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=${shoppingCartcookieDomain}; path=${shoppingCartcookiePath}`;
}
