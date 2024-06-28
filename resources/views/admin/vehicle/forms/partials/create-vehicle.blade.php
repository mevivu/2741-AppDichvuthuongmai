<div class="card">
    <div class="card-header">
        <h4>{{ __('Thông tin Phương tiện') }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- license_plate --}}
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
            {{-- Tên phương tiện --}}
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Tên phương tiện') }}:</label>
                    <x-input name="name"
                             :value="old('name')"
                             :required="true"
                             placeholder="{{ __('Tên phương tiện') }}"/>
                </div>
            </div>
            {{-- Hãng --}}
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Hãng')}}:</label>
                    <div class="input-group">
                        <x-input name="brand"
                                 :value="old('brand')"
                                 :required="true"
                                 placeholder="{{ __('Hãng') }}"/>
                    </div>
                </div>
            </div>
            {{-- Màu sắc --}}
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Màu sắc')}}:</label>
                    <x-input name="color" :value="old('color')"
                             :required="true"
                             placeholder="{{__('Màu sắc')}}"/>
                </div>
            </div>
            {{-- Loại xe --}}
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Loại xe')}}:</label>
                    <x-select name="type" :required="true">
                        @foreach ($type as $key => $value)
                            <x-select-option :value="$key" :title="$value"/>
                        @endforeach
                    </x-select>
                </div>
            </div>
            {{-- Số chổ ngồi --}}
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Số chổ ngồi') }}:</label>
                    <x-input type="number" name="seat_number"
                             :value="old('seat_number')"
                             :required="true"
                             placeholder="{{ __('Số chổ ngồi') }}"/>
                </div>
            </div>
            {{-- price --}}
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('price_rent') }}:</label>
                    <x-input-price name="price"
                                   id="price"
                                   :value="old('price')"
                                   :required="true"
                                   :placeholder="__('price_rent')"/>
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
                            :value="old('vehicle_registration_back')"
                            showImage="featureImageVehicleRegistrationBack"/>
                    </div>
                </div>
            </div>

            {{-- amenities --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><strong>{{ __('amenities') }}:</strong></label>
                    <textarea name="amenities"
                              class="ckeditor visually-hidden">
                        {{ old('amenities') }}
                    </textarea>
                </div>
            </div>
            {{-- description --}}
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><strong>{{ __('description') }}:</strong></label>
                    <textarea name="description"
                              class="ckeditor visually-hidden">
                          {{ old('description') }}
                    </textarea>
                </div>
            </div>
        </div>
    </div>
</div>
