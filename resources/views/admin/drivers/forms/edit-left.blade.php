<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">

            <!-- Fullname -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('fullname'):</label>
                    <x-input name="user_info[fullname]" :value="$driver->user->fullname" :required="true"
                             placeholder="{{ __('Họ và tên') }}"/>
                </div>
            </div>
            <!-- email -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('email'):</label>
                    <x-input-email name="user_info[email]" :value="$driver->user->email" :required="true"/>
                </div>
            </div>
            <!-- phone -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('phone'):</label>
                    <x-input-phone name="user_info[phone]" :value="$driver->user->phone" :required="true"/>
                </div>
            </div>
            <!-- gender -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('gender'):</label>
                    <x-select name="user_info[gender]" :required="true">
                        @foreach ($gender as $key => $value)
                            <x-select-option :option="$driver->user->gender->value" :value="$key" :title="__($value)"/>
                        @endforeach
                    </x-select>
                </div>
            </div>


            <!-- birthday -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('birthday'):</label>
                    <x-input type="date" name="user_info[birthday]"
                             :value="isset($driver->user->birthday) ? format_date($driver->user->birthday, 'Y-m-d') : null"
                             required="true"/>
                </div>
            </div>


            <!-- address -->
            <div class="col-12">
                <div class="mb-3">
                    <x-input-pick-address :label="trans('address')" name="address"
                                          :value="$driver->user->address"
                                          :placeholder="trans('pickAddress')" :required="true"/>
                    <input type="hidden" name="lat" value="{{$driver->user->latitude}}"/>
                    <input type="hidden" name="lng" value="{{$driver->user->longitude}}"/>
                </div>
            </div>

        </div>

    </div>
    <div class="card mt-3">
        <div class="card-header fw-bold h3">
            @lang('driver_register_information')
        </div>
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
    </div>

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
                            :value="$driver->vehicle_registration_front"
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
                            :value="$driver->vehicle_registration_back"
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
            {{-- driver_license_back --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('driver_license_back')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder
                            name="driver_license_back"
                            :value="$driver->vehicle_front_image"
                            showImage="featureImageDriverLicenseBack"
                            class="img-fluid"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
