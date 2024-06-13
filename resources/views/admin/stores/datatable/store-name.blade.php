@if(!empty($store_name))
    <x-link :href="route('admin.store.edit', $id)" :title="$store_name"/>
@else
    <span class="text-muted">No Store Assigned</span>
@endif
