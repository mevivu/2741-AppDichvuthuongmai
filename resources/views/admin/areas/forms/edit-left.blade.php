<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- name -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('name')</label>
                    <x-input name="name" :value="$area->name" :required="true" :placeholder="__('name')" />
                </div>
            </div>
            <!-- address -->
            <div class="col-12">
                <div class="mb-3">
                    <x-input-pick-address :label="trans('address')" name="address" :value="$area->address" :placeholder="trans('pickAddress')" :required="true" />
                    <x-input type="hidden" name="lat" :value="$area->lat" />
                    <x-input type="hidden" name="lng" :value="$area->lng" />
                </div>
            </div>

        </div>
    </div>
</div>
