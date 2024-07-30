<button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalAddProduct">
    <i class="ti ti-plus"></i> {{ __('Thêm sản phẩm') }}
</button>
<table id="tableProduct" class="table table-transparent table-responsive mb-0">
    <thead>
        <tr>
            <th class="text-center" style="width: 1%"></th>
            <th>{{ __('Sản phẩm') }}</th>
            <th class="text-center" style="width: 15%">{{ __('Số lượng') }}</th>
            <th class="text-end" style="width: 1%">{{ __('Đơn giá') }}</th>
            <th class="text-end" style="width: 1%">{{ __('Tổng tiền') }}</th>
        </tr>
    </thead>
    <tbody>
        @each('admin.renting_orders.partials.item-product', $order->orderDetails ?? [], 'order_detail', 'admin.renting_orders.partials.no-item-product')
    </tbody>
</table>
@include('admin.renting_orders.partials.total', [
    'total' => $order->total ?? 0
])
