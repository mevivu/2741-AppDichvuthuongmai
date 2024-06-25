<div class="col-12 col-md-3" style="margin-top: 35px;">
    <div class="card mb-3">
        <div class="card-header">
            @lang('action')
        </div>
        <div class="card-body p-2 d-flex justify-content-between">
            <div class="d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save"/>
                <x-button type="submit" name="submitter" value="saveAndExit">
                    @lang('save&exit')
                </x-button>
            </div>
            <x-button.modal-delete data-route="{{ route('admin.discount.delete', $discount->id) }}"
                                   :title="__('delete')"/>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('user')
        </div>
        <div class="card-body d-flex flex-column p-2 wrap-select2">
            <x-select name="user_ids[]"
                      id="user_id"
                      class="select2-bs5-ajax-many"
                      :data-url="route('admin.search.select.user')"
                      multiple="true">
                @foreach($discount->users as $user)
                    <x-select-option :option="$user->id"
                                     :value="$user->id"
                                     :title="$user->fullname"/>
                @endforeach
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
            <x-select name="store_ids[]"
                      id="store_id"
                      class="select2-bs5-ajax-many"
                      :data-url="route('admin.search.select.store')"
                      multiple="true">
                @foreach($discount->stores as $store)
                    <x-select-option :option="$store->id"
                                     :value="$store->id"
                                     :title="$store->store_name"/>
                @endforeach
            </x-select>
            <x-link :href="route('admin.store.create')" class="mb-2">
                <span class="ms-1">@lang('add') mới</span>
            </x-link>
        </div>
    </div>

</div>
