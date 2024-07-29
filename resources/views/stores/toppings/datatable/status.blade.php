<span @class([
    'badge', App\Enums\Topping\ToppingStatus::from($status)->badge()
])>{{ App\Enums\Topping\ToppingStatus::from($status)->description() }}</span>
