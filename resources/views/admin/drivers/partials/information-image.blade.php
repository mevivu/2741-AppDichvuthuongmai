<div class="card mt-3">
    <div class="card-header fw-bold d-flex align-items-center justify-content-between">
    </div>
    <div class="row card-body">
        {{-- id_card_front --}}
        <div class="col-md-6 col-12">
            <div class="card mb-3">
                <div class="card-header">
                    @lang('id_card_front')
                </div>
                <div class="card-body p-2">
                    <x-input-image-ckfinder name="id_card_front" :value="$driver->id_card_front"
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
                    <x-input-image-ckfinder name="id_card_back" :value="$driver->id_card_back"
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
                        :value="$driver->vehicle->vehicle_registration_front"
                        showImage="featureImageVehicleRegistrationFront"
                    />
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
                        :value="$driver->vehicle->vehicle_registration_back"
                        showImage="featureImageVehicleRegistrationBack"
                    />
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
                        :value="$driver->driver_license_front"
                        showImage="featureImageDriverLicenseFront"
                    />
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
                        :value="$driver->driver_license_back"
                        showImage="featureImageDriverLicenseBack"
                        class="img-fluid"
                    />
                </div>
            </div>
        </div>
    </div>
</div>
