@if($customer_name != 'N/A')
    <x-link  :title="$customer_name"/>
@else
    <span class="text-muted">Not Assigned</span>
@endif
