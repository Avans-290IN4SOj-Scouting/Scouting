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
                        <td><a href="mailto:{{ __('email.general.email') }}">{{ __('email.general.email') }}</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Greeting -->
    <p>
        {{ __('email.general.hello') }}
    </p>
    <p>
        {{__('email.order-cancelled.message') . ' ('. __('manage-orders/orders.order-number') .' #'. $order->id . ')'}}
    </p>

    <!-- Regards -->
    <br>
    <p>
        {{ __('email.general.regards') }}
    </p>
    <p>
        {{ config('app.name') }}
    </p>
</div>
