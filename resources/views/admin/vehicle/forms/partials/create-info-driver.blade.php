<div class="row card-body">
    {{-- id_card input --}}
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('id_card'):</label>
            <x-input name="id_card" :value="old('id_card')" :required="true"
                     :placeholder="__('id_card')"/>
        </div>
    </div>
    {{-- license_plate  --}}
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('license_plate'):</label>
            <x-input name="license_plate" :value="old('license_plate')"
                     :placeholder="__('license_plate')"/>
        </div>
    </div>
    {{-- vehicle_company --}}
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('vehicle_company'):</label>
            <x-input name="vehicle_company" :value="old('vehicle_company')"
                     :placeholder="__('vehicle_company')"/>
        </div>
    </div>

    <!-- address -->
    <div class="col-12">
        <div class="mb-3">
            <x-input-pick-address :label="trans('address')"
                                  name="address"
                                  :placeholder="trans('pickAddress')"
                                  :required="true" />
            <x-input type="hidden" name="lat" />
            <x-input type="hidden" name="lng" />
        </div>
    </div>
    {{-- id_card_front --}}
    <div class="col-md-6 col-12">
        <div class="card mb-3">
            <div class="card-header">
                @lang('id_card_front')
            </div>
            <div class="card-body p-2">
                <x-input-image-ckfinder name="id_card_front"
                                        :value="old('id_card_front')"
                                        showImage="featureImageIdCardFront" />
            </div>
        </div>
    </div>
    {{-- id_card_back --}}
    <div class="col-md-6 col-12">
        <div class="card mb-3">
            <div class="card-header">
                @lang('id_card_back')
            </div>
            <div class="card-body p-2">
                <x-input-image-ckfinder
                    name="id_card_back"
                    :value="old('id_card_back')"
                    showImage="featureImageIdCardBack" />
            </div>
        </div>
    </div>
    {{-- vehicle_registration_front --}}
    <div class="col-md-6 col-12">
        <div class="card mb-3">
            <div class="card-header">
                @lang('vehicle_registration_front')
            </div>
            <div class="card-body p-2">
                <x-input-image-ckfinder
                    name="vehicle_registration_front"
                    :value="old('vehicle_registration_front')"
                    showImage="featureImageVehicleRegistrationFront" />
            </div>
        </div>
    </div>
    {{-- vehicle_registration_back --}}
    <div class="col-md-6 col-12">
        <div class="card mb-3">
            <div class="card-header">
                @lang('vehicle_registration_back')
            </div>
            <div class="card-body p-2">
                <x-input-image-ckfinder
                    name="vehicle_registration_back"
                    :value="old('vehicle_registration_back')"
                    showImage="featureImageVehicleRegistrationBack" />
            </div>
        </div>
    </div>
    {{--driver_license_front --}}
    <div class="col-md-6 col-12">
        <div class="card mb-3">
            <div class="card-header">
                @lang('driver_license_front')
            </div>
            <div class="card-body p-2">
                <x-input-image-ckfinder
                    name="driver_license_front"
                    :value="old('driver_license_front')"
                    showImage="featureImageDriverLicenseFront" />
            </div>
        </div>
    </div>
    {{-- driver_license_back --}}
    <div class="col-md-6 col-12">
        <div class="card mb-3">
            <div class="card-header">
                @lang('driver_license_back')
            </div>
            <div class="card-body p-2">
                <x-input-image-ckfinder
                    name="driver_license_back"
                    :value="old('driver_license_back')"
                    showImage="featureImageDriverLicenseBack" />
            </div>
        </div>
    </div>
</div>
