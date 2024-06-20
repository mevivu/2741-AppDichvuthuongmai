@if($customer_name != 'N/A')
    <x-link :href="route('admin.user.edit', $customer_id)" :title="$customer_name"/>
@else
    <span class="text-muted">Not Assigned</span>
@endif
