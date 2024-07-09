<span @class([
    'badge',
    App\Enums\Store\StoreStatus::from($status)->badge(),
])>{{ \App\Enums\Store\StoreStatus::getDescription($status) }}</span>