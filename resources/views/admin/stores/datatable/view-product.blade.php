@if(!empty($store_name))
    <x-link :href="route('admin.store.product.index', $id)" title="Xem sản phẩm"/>
@else
    <span class="text-muted">No Store Assigned</span>
@endif
