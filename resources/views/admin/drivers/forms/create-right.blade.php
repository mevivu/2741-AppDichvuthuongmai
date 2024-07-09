<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2">
            <div class="d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save"/>
                <x-button type="submit" name="submitter" value="saveAndExit">
                    @lang('save&exit')
                </x-button>
            </div>
        </div>
    </div>
{{--    <div class="card mb-3">--}}
{{--        <div class="card-header">--}}
{{--            @lang('customer')--}}
{{--        </div>--}}
{{--        <div class="card-body d-flex flex-column p-2 wrap-select2">--}}
{{--            <x-select name="user_id" class="select2-bs5-ajax-many" :data-url="route('admin.search.select.user')"--}}
{{--                      :required="true">--}}
{{--            </x-select>--}}
{{--            <x-link :href="route('admin.user.create')" class="mb-2">--}}
{{--                <span class="ms-1">@lang('add') mới</span>--}}
{{--            </x-link>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="card mb-3">
        <div class="card-header">
            @lang('avatar')
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="user_info[avatar]" showImage="avatar" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('autoAccept')
        </div>
        <div class="card-body p-2">
            <x-input-switch label="{{ __('enableAutoAccept') }}" name="auto_accept"
                            :value="\App\Enums\Driver\AutoAccept::Auto->value" :checked="old('auto_accept', 1)" />
        </div>
    </div>


</div>
