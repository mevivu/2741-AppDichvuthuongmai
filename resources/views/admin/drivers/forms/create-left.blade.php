<div class="col-12 col-md-9">
    <div class="card mb-4">
        <div class="card-header fw-bold h3">
            Thông tin cá nhân
        </div>
        <div class="row card-body">

            <!-- Fullname -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('fullname'):</label>
                    <x-input  name="user_info[fullname]" :value="old('user_info[fullname]')" :required="true"
                             :placeholder="__('fullname')" />
                </div>
            </div>
            <!-- email -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('email'):</label>
                    <x-input-email name="user_info[email]" :value="old('user_info[email]')"  />
                </div>
            </div>
            <!-- phone -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('phone'):</label>
                    <x-input-phone name="user_info[phone]" :value="old('user_info[phone]')" :required="true" />
                </div>
            </div>
            <!-- gender -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('gender'):</label>
                    <x-select name="user_info[gender]" :required="true">
                        @foreach ($gender as $key => $value)
                            <x-select-option :value="$key" :title="__($value)" />
                        @endforeach
                    </x-select>
                </div>
            </div>
            <!-- new password -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('password'):</label>
                    <x-input-password name="user_info[password]" :required="true" />
                </div>
            </div>
            <!-- new password confirmation-->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('passwordConfirm'):</label>
                    <x-input-password name="user_info[password_confirmation]" :required="true"
                                      data-parsley-equalto="input[name='user_info[password]']"
                                      data-parsley-equalto-message="{{ __('passwordMismatch') }}" />
                </div>
            </div>

            <!-- birthday -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('birthday'):</label>
                    <x-input type="date" name="user_info[birthday]" :value="old('user_info[birthday]')" :required="true" />
                </div>
            </div>
            <!-- Area -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('area'):</label>
                    <x-select name="user_info[area_id]" :value="old('user_info[area_id]')" :required="true">
                        @foreach ($areas as $area)
                            <x-select-option :value="$area->id" :title="$area->name" />
                        @endforeach
                    </x-select>
                </div>
            </div>


            <!-- address -->
            <div class="col-12">
                <div class="mb-3">
                    <x-input-pick-address :label="trans('pickup_address')"
                                          name="address"
                                          :placeholder="trans('pickup_address')"
                                          :required="true" />
                    <x-input type="hidden" name="lat" />
                    <x-input type="hidden" name="lng" />
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header fw-bold h3">
            @lang('driver_register_information')
        </div>
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
            {{-- bank_name --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('bank_name'):</label>
                    <x-input name="bank_name" :value="old('bank_name')"
                             :placeholder="__('bank_name')"/>
                </div>
            </div>
            {{-- bank_account_name --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('bank_account_name'):</label>
                    <x-input name="bank_account_name" :value="old('bank_account_name')"
                             :placeholder="__('bank_account_name')"/>
                </div>
            </div>
            {{-- bank_account_number --}}
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('bank_account_number'):</label>
                    <x-input name="bank_account_number" :value="old('bank_account_number')"
                             :placeholder="__('bank_account_number')"/>
                </div>
            </div>
            <!-- address -->
            <div class="col-12">
                <div class="mb-3">
                    <x-input-pick-end-address :label="trans('pickup_address')"
                                          name="end_address"
                                          :placeholder="trans('pickup_address')"
                                          :required="true" />
                    <x-input type="hidden" name="end_lat" />
                    <x-input type="hidden" name="end_lng" />
                </div>
            </div>
            {{-- id_card_front --}}
            <div class="col-md-6 col-12">
                <div class="card mb-3">
                    <div class="card-header">
                        @lang('id_card_front')
                    </div>
                    <div class="card-body p-2">
                        <x-input-image-ckfinder name="id_card_front"  :value="old('id_card_front')" showImage="featureImageIdCardFront" />
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
                        <x-input-image-ckfinder name="id_card_back" :value="old('id_card_back')" showImage="featureImageIdCardBack" />
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
                        <x-input-image-ckfinder name="vehicle_registration_front" :value="old('vehicle_registration_front')" showImage="featureImageVehicleRegistrationFront" />
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
                        <x-input-image-ckfinder name="vehicle_registration_back" :value="old('vehicle_registration_back')" showImage="featureImageVehicleRegistrationBack" />
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
                        <x-input-image-ckfinder name="driver_license_front" :value="old('driver_license_front')" showImage="featureImageDriverLicenseFront" />
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
                        <x-input-image-ckfinder name="driver_license_back" :value="old('driver_license_back')" showImage="featureImageDriverLicenseBack" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
