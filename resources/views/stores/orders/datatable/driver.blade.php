@if($driver_name != 'N/A')
    <x-link  :title="$driver_name"/>
@else
    <span class="text-muted">Not Assigned</span>
@endif
