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
    <button onclick="printShoppingCart()">Print Cart</button>
    <button onclick="clearShoppingCart()">Clear Cart</button>
    <script>
        function printShoppingCart() {
            console.log(getShoppingCart());
        }
    </script>
</div>
