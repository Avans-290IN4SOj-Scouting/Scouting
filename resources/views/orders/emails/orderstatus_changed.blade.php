<div>
    <br>
    <table>
        <tbody>
        <tr>
            <td>
                <img src="cid:image1" alt="image not found" width="150" height="100">
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
    <p>{{__('email.general.hello') . __('email.orderstatus-changed.message') . $order->status }}</p>
    <br>
    <table>
        <thead>
        <tr>
            <th>{{ __('manage-orders/orders.order-number') }}</th>
            <th>{{ __('manage-orders/orders.date') }}</th>
            <th>{{ __('orders/orders.lid-name') }}</th>
            <th>{{ __('manage-orders/orders.status') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</td>
            <td>{{ $order->lid_name }}</td>
            <td>{{ $order->status }}</td>
        </tr>
        </tbody>
    </table>
    <br>
    <table>
        <thead>
        <tr>
            <th>{{ __('email.orderstatus-changed.product-name') }}</th>
            <th>{{ __('email.orderstatus-changed.product-type') }}</th>
            <th>{{ __('email.orderstatus-changed.product-size') }}</th>
            <th>{{ __('email.orderstatus-changed.product-price') }}</th>
            <th>{{ __('manage-orders/order.amount') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->orderLines as $orderLine)
            <tr>
                <td>{{ $orderLine->product->name }}</td>
                <td>{{ $productTypes->where('id', $orderLine->product_type_id)->first()->type }}</td>
                <td>{{ $orderLine->product_size }}</td>
                <td>{{ '€' . $orderLine->product_price }}</td>
                <td>{{ $orderLine->amount }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br>
    <p>{{ __('email.general.regards') . config('app.name') }}</p>
</div>
