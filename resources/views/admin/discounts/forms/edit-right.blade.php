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
                      class="select2-bs5-ajax"
                      :data-url="route('admin.search.select.user')"
                      multiple="true">
                @foreach($discount->users as $user)
                    <x-select-option :option="$user->id"
                                     :value="$user->id"
                                     :title="$user->fullname . ' - ' . $user->phone"/>
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
                      class="select2-bs5-ajax"
                      :data-url="route('admin.search.select.store')"
                      multiple="true">
                @foreach($discount->stores as $store)
                    <x-select-option :option="$store->id"
                                     :value="$store->id"
                                     :title="$store->store_name . ' - ' . $store->store_phone"/>
                @endforeach
            </x-select>
            <x-link :href="route('admin.store.create')" class="mb-2">
                <span class="ms-1">@lang('add') mới</span>
            </x-link>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('product')
        </div>
        <div class="card-body d-flex flex-column p-2 wrap-select2">
            <x-select name="product_ids[]"
                      id="product_id"
                      class="select2-bs5-ajax"
                      :data-url="route('admin.search.select.product')"
                      multiple="true">
                @foreach($discount->products as $product)
                    <x-select-option :option="$product->id"
                                     :value="$product->id"
                                     :title="$product->name . ' - ' . $product->price"/>
                @endforeach
            </x-select>
            <x-link :href="route('admin.product.create')" class="mb-2">
                <span class="ms-1">@lang('add') mới</span>
            </x-link>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('driver')
        </div>
        <div class="card-body d-flex flex-column p-2 wrap-select2">
            <x-select name="driver_ids[]"
                      id="driver_id"
                      class="select2-bs5-ajax"
                      :data-url="route('admin.search.select.driver')"
                      multiple="true">
                @foreach($discount->drivers as $driver)
                    <x-select-option :option="$driver->id"
                                     :value="$driver->id"
                                     :title="$driver->user->fullname .' - '. $driver->user->phone"/>
                @endforeach
            </x-select>
            <x-link :href="route('admin.driver.create')" class="mb-2">
                <span class="ms-1">@lang('add') mới</span>
            </x-link>
        </div>
    </div>

</div>
