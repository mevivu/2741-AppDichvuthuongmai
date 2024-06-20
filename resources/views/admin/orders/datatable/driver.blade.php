@if($driver_name != 'N/A')
    <x-link :href="route('admin.driver.edit', $driver_id)" :title="$driver_name"/>
@else
    <span class="text-muted">Not Assigned</span>
@endif
