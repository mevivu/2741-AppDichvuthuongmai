<div class="col-12 col-md-3" style="margin-top: 35px;">
    <div class="card mb-3">
        <div class="card-header">
            @lang('user')
        </div>
        <div class="card-body d-flex flex-column p-2 wrap-select2">

            <x-select class="select2-bs5-ajax"
                      name="user_id[]"
                      multiple>
            </x-select>
            <x-link :href="route('admin.user.create')" class="mb-2">
                <span class="ms-1">@lang('add') mới</span>
            </x-link>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('store')
        </div>
        <div class="card-body d-flex flex-column p-2 wrap-select2">
            <x-select name="store_id[]"
                      class="select2-bs5-ajax"
                      multiple="true">
            </x-select>
            <x-link :href="route('admin.store.create')" class="mb-2">
                <span class="ms-1">@lang('add') mới</span>
            </x-link>
        </div>
    </div>
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
</div>
