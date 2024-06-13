<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header">
            <h3>@lang('infoLogin')</h3>
        </div>
        <div class="row card-body">
            <!-- username -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('username'):</label>
                    <x-input name="username" :value="$store->username" :required="true" :placeholder="__('username')" />
                </div>
            </div>
            <!-- new password -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('password'):</label>
                    <x-input-password name="password" />
                </div>
            </div>
            <!-- new password confirmation-->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('passwordConfirm'):</label>
                    <x-input-password name="password_confirmation" 
                        data-parsley-equalto="input[name='password']"
                        data-parsley-equalto-message="{{ __('passwordMismatch') }}" />
                </div>
            </div>
            <!-- taxCode -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('taxCode'):</label>
                    <x-input name="tax_code" :value="$store->tax_code" :required="true"
                        :placeholder="__('taxCode')" />
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h3>@lang('infoStore')</h3>
        </div>
        <div class="row card-body">
            <!-- store_name -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('storeName'):</label>
                    <x-input name="store_name" :value="$store->store_name" :required="true"
                        :placeholder="__('storeName')" />
                </div>
            </div>
            <!-- storePhone -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('storePhone'):</label>
                    <x-input-phone name="store_phone" :value="$store->store_phone" :required="true" />
                </div>
            </div>

            <!-- conactName -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('conactName'):</label>
                    <x-input name="contact_name" :value="$store->contact_name" :required="true"
                        :placeholder="__('conactName')" />
                </div>
            </div>
            <!-- contactPhone -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('contactPhone'):</label>
                    <x-input-phone name="contact_phone" :value="$store->contact_phone" :required="true" />
                </div>
            </div>

            <!-- address -->
            <div class="col-12">
                <div class="mb-3">
                    <x-input-pick-address :label="trans('address')" name="address" :value="$store->address" :placeholder="trans('pickAddress')" :required="true" /> 
                    <x-input type="hidden" name="lat" :value="$store->lat" />
                    <x-input type="hidden" name="lng" :value="$store->lng" />
                </div>
            </div>
            <!-- addressDetail -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('addressDetail'):</label>
                    <x-input name="address_detail" :value="$store->address_detail" :placeholder="__('addressDetail')" />
                </div>
            </div>
            
            <!-- openHour1-->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('openHour') 1:</label>
                    <x-input type="time" name="open_hours_1" :value="$store->open_hours_1" :required="true"
                        :placeholder="__('openHour')" />
                </div>
            </div>

            <!-- closeHour1 -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('closeHour') 1:</label>
                    <x-input type="time" name="close_hours_1" :value="$store->close_hours_1" :required="true"
                        :placeholder="__('closeHour')" />
                </div>
            </div>
            <!-- openHour2-->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('openHour') 2:</label>
                    <x-input type="time" name="open_hours_2" :value="$store->open_hours_2" :placeholder="__('openHour')" />
                </div>
            </div>

            <!-- closeHour2 -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('closeHour') 2:</label>
                    <x-input type="time" name="close_hours_2" :value="$store->close_hours_2" :placeholder="__('closeHour')" />
                </div>
            </div>
        </div>
    </div>
    
</div>