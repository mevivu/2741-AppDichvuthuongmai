<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2">
            <div class="d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save"/>
                <x-button type="submit" name="submitter" value="saveAndExit">
                    @lang('save&exit')
                </x-button>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('driverAssignment')
        </div>
        <div class="card-body p-2">
            <x-select id="driver-assignment" class="form-select" name="driver_assignment">
                @foreach ($driver_assignment as $key => $value)
                    <x-select-option :value="$key" :title="$value"/>
                @endforeach
            </x-select>
        </div>
    </div>

    <!-- driver -->
    <div id="driver" class="card mb-3 hidden">
        <div class="card-header">
            @lang('driver')
        </div>
        <div class="card-body p-2">
            <x-select name="driver_id"
                      class="select2-bs5-ajax-many"
                      :data-url="route('admin.search.select.driver')">
            </x-select>
        </div>
    </div>
    <!-- status -->
    <div class="card mb-3">
        <div class="card-header">
            @lang('status')
        </div>
        <div class="card-body p-2">
            <x-select name="status" :required="true">
                @foreach ($status as $key => $value)
                    <x-select-option :value="$key" :title="$value"/>
                @endforeach
            </x-select>
        </div>
    </div>


</div>
