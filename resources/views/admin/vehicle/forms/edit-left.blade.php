<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin Chủ xe') }}</h2>
        </div>
        <div class="row card-body">
            <!-- Fullname -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('fullname'):</label>
                    <x-input name="user_info[fullname]"
                             :value="$vehicle->driver->user->fullname"
                             :required="true"
                             :placeholder="__('fullname')"/>
                </div>
            </div>
            <!-- phone -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('phone'):</label>
                    <x-input-phone name="user_info[phone]"
                                   :value="$vehicle->driver->user->phone"
                                   :required="true"/>
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
            <div class="card-header fw-bold h3">
                @lang('driver_register_information')
            </div>
            @include('admin.vehicle.forms.partials.edit-info-driver')

            <div class="card-header justify-content-center">
                <h2 class="mb-0">{{ __('Sửa phương tiện') }}</h2>
            </div>
            <!-- name -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Tên phương tiện') }}:</label>
                    <x-input name="name" :value="$vehicle->name" :required="true"
                             placeholder="{{ __('Tên phương tiện') }}"/>
                </div>
            </div>
            <!-- brand -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Hãng')}}:</label>
                    <div class="input-group">
                        <x-input name="brand" :value="$vehicle->brand" :required="true" placeholder="{{ __('Hãng') }}"/>
                    </div>
                </div>
            </div>
            <!-- color -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Màu sắc')}}:</label>
                    <x-input name="color" :value="$vehicle->color" :required="true" placeholder="{{__('Màu sắc')}}"/>
                </div>
            </div>
            <!-- type -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Loại xe')}}:</label>
                    <x-select name="type" :required="true">
                        @foreach ($type as $key => $value)
                            <x-select-option :option="$vehicle->type->value" :value="$key" :title="$value"/>
                        @endforeach
                    </x-select>
                </div>
            </div>
            <!-- seat_number -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Số chổ ngồi') }}:</label>
                    <x-input type="number"
                             name="seat_number"
                             :value="$vehicle->seat_number"
                             :required="true" placeholder="{{ __('Số chổ ngồi') }}"/>
                </div>
            </div>
            <!-- amenities -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><strong>{{ __('amenities') }}:</strong></label>
                    <textarea name="amenities"
                              class="ckeditor visually-hidden">{{ $vehicle->amenities }}
                    </textarea>
                </div>
            </div>
            <!-- description -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><strong>{{ __('description') }}:</strong></label>
                    <textarea name="description"
                              class="ckeditor visually-hidden">{{ $vehicle->description }}
                    </textarea>
                </div>
            </div>
        </div>
    </div>
</div>
