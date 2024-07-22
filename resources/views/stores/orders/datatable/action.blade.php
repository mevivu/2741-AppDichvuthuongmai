<?php
$store_id = auth('store')->user()->id;
$orders = App\Models\Order::where('status', '1')->where('store_id', $store_id)->get();
?>
@foreach($orders as $item)
        @if($item->id == $id)
        <a  class="btn btn-primary" href="{{ route('store.order.accept', $id) }}">
            Duyệt
        </a>
        <a class="btn btn-danger" href="{{ route('store.order.refuse', $id) }}">
            Từ Chối
        </a>
        @endif
@endforeach
