<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin Thành viên') }}</h2>

        </div>
        <div class="row card-body">
            <!-- Fullname -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Họ và tên') }}:</label>
                    <x-input name="fullname" :value="$user->fullname" :required="true"
                        placeholder="{{ __('Họ và tên') }}" />
                </div>
            </div>
            <!-- email -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Email') }}:</label>
                    <x-input-email name="email" :value="$user->email" :required="true" />
                </div>
            </div>
            <!-- phone -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Số điện thoại') }}:</label>
                    <x-input-phone name="phone" :value="$user->phone" :required="true" />
                </div>
            </div>
            <!-- address -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <x-input-pick-address :label="trans('address')" name="address" :value="$user->address"
                                          :placeholder="trans('address')" :required="true" />
                    <x-input type="hidden" name="lat" :value="$user->lat" />
                    <x-input type="hidden" name="lng" :value="$user->lng" />
                </div>
            </div>
            <!-- birthday -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('birthday'):</label>
                    <x-input type="date" name="birthday" :value="format_date($user->birthday, 'Y-m-d')"
                             :required="true"/>
                </div>
            </div>
            <!-- new password -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Mật khẩu') }}:</label>
                    <x-input-password name="password" />
                </div>
            </div>
            <!-- new password confirmation-->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Xác nhận mật khẩu') }}:</label>
                    <x-input-password name="password_confirmation"
                        data-parsley-equalto="input[name='password']"
                        data-parsley-equalto-message="{{ __('Mật khẩu không khớp.') }}" />
                </div>
            </div>
            <!-- gender -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Giới tính') }}:</label>
                    <x-select name="gender" :required="true">
                        <x-select-option value="" :title="__('Chọn Giới tính')" />
                        @foreach ($gender as $key => $value)
                            <x-select-option :option="$user->gender->value" :value="$key" :title="__($value)" />
                        @endforeach
                    </x-select>
                </div>
            </div>
            <!-- vip -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Vip') }}:</label>
                    <x-select name="vip" :required="true">
                        <x-select-option value="" :title="__('Chọn Vip')" />
                        @foreach ($vip as $key => $value)
                            <x-select-option :option="$user->vip->value" :value="$key" :title="__($value)" />
                        @endforeach
                    </x-select>
                </div>
            </div>
        </div>
    </div>
</div>
