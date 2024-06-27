<div class="row card-body">
    {{-- id_card input --}}
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('id_card'):</label>
            <x-input name="id_card"
                     :required="true"
                     :value="$vehicle->driver->id_card"
                     :placeholder="__('id_card')"/>
        </div>
    </div>
    {{-- license_plate  --}}
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('license_plate'):</label>
            <x-input name="license_plate"
                     :value="$vehicle->driver->license_plate"
                     :placeholder="__('license_plate')"/>
        </div>
    </div>

    {{-- vehicle_company --}}
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('vehicle_company'):</label>
            <x-input name="vehicle_company"
                     :value="$vehicle->driver->vehicle_company"
                     :placeholder="__('vehicle_company')"/>
        </div>
    </div>

    <!-- price -->
    <div class="col-md-6 col-sm-12">
        <div class="mb-3">
            <label class="control-label">{{ __('price_rent') }}:</label>
            <x-input-price name="price"
                           id="price"
                           :required="true"
                           :value="$vehicle->price"
                           :placeholder="__('price_rent')"/>
        </div>
    </div>
    <!-- address -->
    <div class="col-12">
        <div class="mb-3">
            <x-input-pick-address :label="trans('address')"
                                  name="address"
                                  :value="$vehicle->driver->user->address"
                                  :placeholder="trans('pickAddress')" :required="true"/>
            <x-input type="hidden" name="lat" :value="$vehicle->driver->user->latitude"/>
            <x-input type="hidden" name="lng" :value="$vehicle->driver->user->longitude"/>
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
                                        :value="$vehicle->driver->id_card_front"
                                        showImage="featureImageIdCardFront"/>
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
                        :value="$vehicle->driver->id_card_back"
                        showImage="featureImageIdCardBack"/>
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
                        :value="$vehicle->driver->vehicle_registration_front"
                        showImage="featureImageVehicleRegistrationFront"/>
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
                        :value="$vehicle->driver->vehicle_registration_back"
                        showImage="featureImageVehicleRegistrationBack"/>
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
                        :value="$vehicle->driver->driver_license_front"
                        showImage="featureImageDriverLicenseFront"/>
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
                        :value="$vehicle->driver->driver_license_back"
                    showImage="featureImageDriverLicenseBack" />
            </div>
        </div>
    </div>
</div>
