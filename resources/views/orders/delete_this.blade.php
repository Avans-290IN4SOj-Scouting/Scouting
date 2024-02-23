<style>
    .my-options {
        display: flex;
        align-items: center;
        gap: 1rem;

        background-color: darkcyan;
    }

    .my-options > a {
        height: 2rem;
        background-color: purple;
        margin: 1rem;
    }
</style>

<div class="my-options">
    Temporary Navbar :D
    <a href="{{ route('orders.overview') }}">To Products</a>
    <a href="{{ route('shoppingcart.index') }}">To Shopping Cart</a>
    <a href="{{ route('orders.product', [ 'id' => 'Appel']) }}">To Bestellen</a>
</div>
