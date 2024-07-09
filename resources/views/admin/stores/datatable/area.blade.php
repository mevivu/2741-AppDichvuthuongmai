@if(isset($area['name']) && !empty($area['name']))
    <x-link :href="route('admin.area.edit', $area_id)" :title="$area['name']"/>
@else
    N/A
@endif
