<div class="row card-body">
    {{-- id_card input --}}
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('id_card'):</label>
            <x-input name="id_card" :value="$driver->id_card ?? old('id_card')" :required="true"
                     :placeholder="__('id_card')"/>
        </div>
    </div>
    {{-- bank_name input --}}
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('bank_name'):</label>
            <x-input name="bank_name" :value="$driver->bank_name ?? old('bank_name')"
                     :placeholder="__('bank_name')"/>
        </div>
    </div>
    {{-- bank_account_name input --}}
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('bank_account_name'):</label>
            <x-input name="bank_account_name" :value="$driver->bank_account_name ?? old('bank_account_name')"
                     :placeholder="__('bank_account_name')"/>
        </div>
    </div>
    {{-- bank_account_number input --}}
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('bank_account_number'):</label>
            <x-input name="bank_account_number"
                     :value="$driver->bank_account_number ?? old('bank_account_number')"
                     :placeholder="__('bank_account_number')"/>
        </div>
    </div>
    {{-- license_plate input --}}
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('license_plate'):</label>
            <x-input name="license_plate" :value="$driver->license_plate ?? old('license_plate')"
                     :placeholder="__('license_plate')"/>
        </div>
    </div>
    {{-- vehicle_company input --}}
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('vehicle_company'):</label>
            <x-input name="vehicle_company" :value="$driver->vehicle_company ?? old('vehicle_company')"
                     :placeholder="__('vehicle_company')"/>
        </div>
    </div>

    <div class="col-12">
        <div class="mb-3">
            <x-input-pick-end-address :label="trans('pickup_address')"
                                      name="end_address"
                                      :placeholder="trans('pickAddress')"
                                      :value="$driver->current_address"
                                      :required="true"/>
            <x-input type="hidden" name="end_lat" :value="$driver->current_lat"/>
            <x-input type="hidden" name="end_lng" :value="$driver->current_lng"/>
        </div>
    </div>
</div>
