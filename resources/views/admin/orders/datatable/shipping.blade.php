<span @class([
    'badge',
    App\Enums\Shipping\ShippingMethod::from($shipping_method)->badge(),
])>{{ \App\Enums\Shipping\ShippingMethod::getDescription($shipping_method) }}</span>
