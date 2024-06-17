<div class="col-12 col-md-3">
    <div class="card">
        <div class="card-header ">
            @lang('action')
        </div>
        <div class="card-body p-2 d-flex justify-content-between">
            <div class="d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save"/>
                <x-button type="submit" name="submitter" value="saveAndExit">
                    @lang('save&exit')
                </x-button>
            </div>
            <x-button.modal-delete data-route="{{ route('admin.driver.delete', $driver->id) }}" :title="__('delete')"/>
        </div>
    </div>
    <!-- order_accepted -->
    <div class="mb-3 card">
        <div class="card-header">
            @lang('status')
        </div>
        <div class="card-body p-2">
            <x-select name="order_accepted" :required="true">
                @foreach ($order_accepted as $key => $value)
                    <x-select-option :option="$driver->order_accepted->value" :value="$key" :title="__($value)"/>
                @endforeach
            </x-select>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            @lang('avatar')
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="user_info[feature_image]" :value="$driver->user->avatar" showImage="featureImage"/>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('autoAccept')
        </div>

        <div class="card-body p-2">
            <x-input-switch label="{{ __('enableAutoAccept') }}"
                            name="auto_accept"
                            :value="\App\Enums\Driver\AutoAccept::Auto->value"
                            :checked="$driver->auto_accept === \App\Enums\Driver\AutoAccept::Auto"/>

        </div>
    </div>
</div>
