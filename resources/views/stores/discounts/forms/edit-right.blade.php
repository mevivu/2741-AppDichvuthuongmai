<div class="col-12 col-md-3" style="margin-top: 35px;">
    <div class="card mb-3">
        <div class="card-header">
            @lang('product')
        </div>
        <div class="card-body d-flex flex-column p-2 wrap-select2">
            <x-select name="product_id[]" class="select2-bs5-ajax-many"
                      :data-url="route('store.search.select.product')"
                      multiple="true">
                @foreach($products as $product)
                    <x-select-option :option="$product->id"
                                     :value="$product->id"
                                     :title="$product->name"/>
                @endforeach
            </x-select>
            <x-link :href="route('store.product.create')" class="mb-2">
                <span class="ms-1">@lang('add') mới</span>
            </x-link>
        </div>
    </div>
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
            <x-button.modal-delete data-route="{{ route('store.discount.delete', $discount->id) }}" :title="__('delete')"/>
        </div>
    </div>
</div>
