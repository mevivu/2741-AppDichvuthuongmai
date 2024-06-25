<span @class([
    'badge',
    \App\Enums\Driver\DriverStatus::from($status)->badge(),

])>
      {{ \App\Enums\Driver\DriverStatus::getDescription($status) }}
</span>
