<div class="card">
    <div class="card-header">
        <h4>{{ __('Thông tin Tài xế') }}</h4>
    </div>
    <div class="row card-body">
        <div class="mb-3">
            <label for="">{{ __('Khu vực') }}</label>
            <x-select name="area_id"
            id="area_id"
            class="select2-bs5-ajax"
            data-url="{{ route('admin.search.select.area') }}"
            :required="true">
           </x-select>
        </div>
        <!-- Fullname -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">@lang('fullname'):</label>
                <x-input name="user_info[fullname]" :value="old('user_info[fullname]')" :required="true"
                         :placeholder="__('fullname')"/>
            </div>
        </div>
        <!-- email -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">@lang('email'):</label>
                <x-input-email name="user_info[email]" :value="old('user_info[email]')"/>
            </div>
        </div>
        <!-- phone -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">@lang('phone'):</label>
                <x-input-phone name="user_info[phone]" :value="old('user_info[phone]')" :required="true"/>
            </div>
        </div>
        <!-- gender -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">@lang('gender'):</label>
                <x-select name="user_info[gender]" :required="true">
                    @foreach ($gender as $key => $value)
                        <x-select-option :value="$key" :title="__($value)"/>
                    @endforeach
                </x-select>
            </div>
        </div>
        <!-- birthday -->
        <div class="col-md-6 col-12">
            <div class="mb-3">
                <label class="control-label">@lang('birthday'):</label>
                <x-input type="date" name="user_info[birthday]" :value="old('user_info[birthday]')"
                         :required="true"/>
            </div>
        </div>


        <!-- address -->
        <div class="col-12">
            <div class="mb-3">
                <x-input-pick-address :label="trans('pickup_address')"
                                      name="address"
                                      :placeholder="trans('pickup_address')"
                                      :required="true"/>
                <x-input type="hidden" name="lat"/>
                <x-input type="hidden" name="lng"/>
            </div>
        </div>
        {{-- id_card_front --}}
        <div class="col-md-6 col-12">
            <div class="card mb-3">
                <div class="card-header">
                    @lang('id_card_front')
                </div>
                <div class="card-body p-2">
                    <x-input-image-ckfinder name="id_card_front" :value="old('id_card_front')"
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
                    <x-input-image-ckfinder name="id_card_back" :value="old('id_card_back')"
                                            showImage="featureImageIdCardBack"/>
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
                    <x-input-image-ckfinder name="driver_license_front" :value="old('driver_license_front')"
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
                    <x-input-image-ckfinder name="driver_license_back" :value="old('driver_license_back')"
                                            showImage="featureImageDriverLicenseBack"/>
                </div>
            </div>
        </div>
    </div>
</div>
