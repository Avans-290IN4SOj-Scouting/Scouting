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
                            <td><a href="mailto:{{ __('email.general.email') }}">{{ __('email.general.email') }}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <p>{{ __('email.general.hello') . __('email.order-cancelled.message') . ' ('. __('manage-orders/orders.order-number') .' #'. $order->id . ')'}}</p>
    <p>{{ __('email.general.regards') . config('app.name') }}</p>
</div>
