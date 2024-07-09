<div class="container">
    <div class="row">
        <!-- Fullname -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="control-label">@lang('fullname'):</label>
                <x-input name="user_info[fullname]"
                         :value="old('user_info[fullname]')"
                         :required="true"
                         :placeholder="__('fullname')"/>
            </div>
        </div>
        <!-- Phone -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="control-label">@lang('phone'):</label>
                <x-input-phone name="user_info[phone]"
                               :value="old('user_info[phone]')"
                               :required="true"/>
            </div>
        </div>
        <!-- Gender -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="control-label">@lang('gender'):</label>
                <x-select name="user_info[gender]" :required="true">
                    @foreach ($gender as $key => $value)
                        <x-select-option :value="$key" :title="__($value)"/>
                    @endforeach
                </x-select>
            </div>
        </div>
        <!-- ID Card -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="control-label">@lang('id_card'):</label>
                <x-input name="id_card" :value="old('id_card')" :required="true"
                         :placeholder="__('id_card')"/>
            </div>
        </div>
        <!-- Address -->
        <div class="col-12">
            <div class="mb-3">
                <x-input-pick-address :label="trans('address')"
                                      name="address"
                                      :placeholder="trans('pickAddress')"
                                      :required="true"/>
                <x-input type="hidden" name="lat"/>
                <x-input type="hidden" name="lng"/>
            </div>
        </div>
        <!-- ID Card Front -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    @lang('id_card_front')
                </div>
                <div class="card-body p-2">
                    <x-input-image-ckfinder name="id_card_front"
                                            :value="old('id_card_front')"
                                            showImage="featureImageIdCardFront"/>
                </div>
            </div>
        </div>
        <!-- ID Card Back -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    @lang('id_card_back')
                </div>
                <div class="card-body p-2">
                    <x-input-image-ckfinder
                        name="id_card_back"
                        :value="old('id_card_back')"
                        showImage="featureImageIdCardBack"/>
                </div>
            </div>
        </div>
    </div>
</div>
