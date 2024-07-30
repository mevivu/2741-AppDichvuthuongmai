@if($order->order_type === App\Enums\Order\OrderType::Booking)
    @include('admin.renting_orders.partials.order-booking')
@endif

@if($order->order_type === App\Enums\Order\OrderType::Renting)
    @include('admin.renting_orders.partials.order-renting')
@endif
