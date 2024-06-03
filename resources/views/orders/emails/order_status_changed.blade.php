<p>{{ __('manage-orders/email.orderstatus-changed.message') . $order->status }}</p>
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
        <th>{{ __('manage-orders/email.orderstatus-changed.product-name') }}</th>
        <th>{{ __('manage-orders/email.orderstatus-changed.product-type') }}</th>
        <th>{{ __('manage-orders/email.orderstatus-changed.product-size') }}</th>
        <th>{{ __('manage-orders/email.orderstatus-changed.product-price') }}</th>
        <th>{{ __('manage-orders/order.amount') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->orderLines as $orderLine)
        <tr>
            <td>{{ $orderLine->product->name }}</td>
            <td>{{ $productTypes->where('id', $orderLine->product_type_id)->first()->type }}</td>
            <td>{{ $orderLine->product_size }}</td>
            <td>{{ $orderLine->product_price }}</td>
            <td>{{ $orderLine->amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
