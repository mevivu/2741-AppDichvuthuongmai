<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thêm phương tiện') }}</h2>
        </div>
        <div class="row card-body">
            <!-- name -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Tên phương tiện') }}:</label>
                    <x-input name="name" :value="old('name')" :required="true" placeholder="{{ __('Tên phương tiện') }}" />
                </div>
            </div>
            <!-- brand -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Hãng')}}:</label>
                    <div class="input-group">
                        <x-input name="brand" :value="old('brand')" :required="true" placeholder="{{ __('Hãng') }}" />
                    </div>
                </div>
            </div>
            <!-- color -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Màu sắc')}}:</label>
                    <x-input name="color" :value="old('color')" :required="true" placeholder="{{__('Màu sắc')}}" />
                </div>
            </div>
            <!-- type -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Loại xe')}}:</label>
                    <x-select name="type" :required="true">
                        @foreach ($type as $key => $value)
                        <x-select-option :value="$key" :title="$value" />
                        @endforeach
                    </x-select>
                </div>
            </div>
            <!-- seat_number -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Số chổ ngồi') }}:</label>
                    <x-input type="number" name="seat_number" :value="old('seat_number')" :required="true" placeholder="{{ __('Số chổ ngồi') }}" />
                </div>
            </div>
            <!-- user_id (owner) -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Chủ xe') }}:</label>
                    <x-select class="select2-bs5-ajax" name="user_id" :required="true">
                    </x-select>
                </div>
            </div>
            <!-- license_plate -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><strong>{{ __('Biển số xe') }}:</strong></label>
                    <textarea name="license_plate" class="ckeditor visually-hidden">{{ old('license_plate') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>