<div>
    <br>

    <!-- Logo with contact information -->
    <table>
        <tbody>
        <tr>
            <td>
                <img src="cid:image1" alt="{{ __('email.general.logo-scouting') . config('app.name') }}" width="150"
                     height="100">
            </td>
            <td>
                <table>
                    <tbody>
                    <tr>
                        <strong>{{ __('email.general.name') }}</strong>
                    </tr>
                    <tr>
                        <td><a href="{{ __('email.general.url') }}">{{ __('email.general.website') }}</a></td>
                    </tr>
                    <tr>
                        <td><a href="mailto:{{ __('email.general.email') }}">{{ __('email.general.email') }}</a></td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Greeting -->
    <p>
        {{__('email.general.hello') }}
    </p>
    <p>
        {{ __('email.orderstatus-changed.message') . $order->status }}
    </p>

    <!-- Order information -->
    <table>
        <tbody>
        <tr>
            <td><strong>{{ __('manage-orders/orders.order-number') }}</strong>&nbsp;</td>
            <td><strong>{{ __('manage-orders/orders.date') }}</strong>&nbsp;</td>
            <td><strong>{{ __('orders/orders.lid-name') }}</strong>&nbsp;</td>
            <td><strong>{{ __('manage-orders/orders.status') }}</strong>&nbsp;</td>
        </tr>
        <tr>
            <td>{{ $order->id }}&nbsp;</td>
            <td>{{ Carbon\Carbon::parse($order->order_date)->format(__('common.date')) }}&nbsp;</td>
            <td>{{ $order->lid_name }}&nbsp;</td>
            <td>{{ $order->status }}&nbsp;</td>
        </tr>
        </tbody>
    </table>
    <br>
    <table>
        <tbody>
        <tr>
            <td><strong>{{ __('email.orderstatus-changed.product-name') }}</strong>&nbsp;</td>
            <td><strong>{{ __('email.orderstatus-changed.product-type') }}</strong>&nbsp;</td>
            <td><strong>{{ __('email.orderstatus-changed.product-size') }}</strong>&nbsp;</td>
            <td><strong>{{ __('email.orderstatus-changed.product-price') }}</strong>&nbsp;</td>
            <td><strong>{{ __('manage-orders/order.amount') }}</strong></td>
        </tr>
        @foreach($order->orderLines as $orderLine)
            <tr>
                <td>{{ $orderLine->product->name }}&nbsp;</td>
                <td>{{ $productTypes->where('id', $orderLine->product_type_id)->first()->type }}&nbsp;</td>
                <td>{{ $orderLine->product_size }}&nbsp;</td>
                <td>{{ '€' . $orderLine->product_price }}&nbsp;</td>
                <td>{{ $orderLine->amount }}&nbsp;</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Regards -->
    <br>
    <br>
    <p>
        {{ __('email.general.regards') }}
    </p>
    <p>
        {{ config('app.name') }}
    </p>
</div>
