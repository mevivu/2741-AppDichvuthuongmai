<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- type -->
            <div class="col-12">
                <div class="mb-3">
                    <label for="">{{ __('Đối tượng') }}</label>
                    <x-select class="notification-type" name="type" :required="true">
                        @foreach ($types as $key => $value)
                            <x-select-option :value="$key" :title="$value" />
                        @endforeach
                    </x-select>
                </div>
            </div>
            <div style="display: none" id="notification-option-select" class="col-12">
                <div class="mb-3">
                    <label for="">{{ __('Loại') }}</label>
                    <x-select class="notification-option-select-value" name="option">
                        <x-select-option value="100" :title="__('Chọn loại thông báo')" selected />
                            @foreach ($options as $key => $value)
                                <x-select-option :value="$key" :title="$value" />
                            @endforeach
                    </x-select>
                </div>
            </div>
            <!-- driver -->
            <div style="display: none" id="notification-driver-select" class="col-12">
                <div class="mb-3">
                    <label for="">{{ __('Tài xế') }}</label>
                    <x-select
                        name="driver_id"
                        class="select2-bs5-ajax"
                        :data-url="route('admin.search.select.driver')"
                        id="driver_id">
                    </x-select>
                </div>
            </div>
            <!-- customer -->
            <div style="display: none" id="notification-customer-select" class="col-12">
                <div class="mb-3">
                    <label for="">{{ __('Khách hàng') }}</label>
                    <x-select
                        name="user_id"
                        class="select2-bs5-ajax"
                        :data-url="route('admin.search.select.customer')"
                        id="user_id">
                    </x-select>
                </div>
            </div>

            <!-- store -->
            <div style="display: none" id="notification-store-select" class="col-12">
                <div class="mb-3">
                    <label for="">{{ __('Cửa hàng') }}</label>
                    <x-select
                        name="store_id"
                        class="select2-bs5-ajax"
                        :data-url="route('admin.search.select.store')"
                        id="store_id">
                    </x-select>
                </div>
            </div>
            <!-- title -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('title')</label>
                    <x-input name="title" :value="old('title')"  :placeholder="__('title')" />
                </div>
            </div>
            <!-- message -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('message')</label>
                    <x-input name="message" :value="old('message')"  :placeholder="__('message')" />
                </div>
            </div>

        </div>
    </div>
</div>

