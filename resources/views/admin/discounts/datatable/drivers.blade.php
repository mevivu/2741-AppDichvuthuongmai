@if(isset($drivers) && $drivers->count() > 0)
    @foreach($drivers as $driver)
        <div class="d-flex flex-column">
            <x-link :href="route('admin.driver.edit', $driver->id)" :title="$driver->user->fullname" />
        </div>
    @endforeach
@else
    <div>N/A</div>
@endif
