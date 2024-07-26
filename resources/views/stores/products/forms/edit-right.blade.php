<div class="col-12 col-md-3" style="margin-top: 35px;">
    <div class="card mb-3">
        <div class="card-body p-2 d-flex justify-content-between">
            <div class="d-flex align-items-center h-100 gap-2">
                <x-button.submit :title="__('save')" name="submitter" value="save"/>
                <x-button type="submit" name="submitter" value="saveAndExit">
                    @lang('save&exit')
                </x-button>
            </div>
            <x-button.modal-delete data-route="{{ route('store.product.delete', $page->id) }}" :title="__('delete')"/>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            @lang('status')
        </div>
        <div class="card-body p-2">
            <x-select class="form-select" name="status" :required="true">
                @foreach ($status as $key => $value )
                    <x-select-option :value="$key" :title="$value"/>
                @endforeach
            </x-select>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('Topping')
        </div>
        <div class="card-body d-flex flex-column p-2 wrap-select2">
            <x-select name="topping_ids[]"
                      class="select2-bs5-ajax-many"
                      :data-url="route('store.search.select.topping')"
                      :multiple="true">
                @foreach($toppings as $topping)
                    <x-select-option :option="$topping->id" :value="$topping->id"
                                     :title="$topping->name"/>
                @endforeach

            </x-select>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            @lang('discount')
        </div>
        <div class="card-body d-flex flex-column p-2 wrap-select2">
            <x-select name="discount_ids[]"
                      class="select2-bs5-ajax-many"
                      :data-url="route('store.search.select.discount')"
                      :multiple="true">
                @foreach($discounts as $discount)
                    <x-select-option :option="$discount->id" :value="$discount->id"
                                     :title="$discount->code"/>
                @endforeach

            </x-select>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('avatar')
        </div>
        <div class="card-body p-2">
            <input type="file" onchange="showPreviewImage()" class="form-control" name="feature_image" id="customFile" />
            <div class="preview-image">
                <image id="preview-image" src="{{env('APP_URL')."/".$page->feature_image}}"></image>
            </div>
        </div>
    </div>

</div>
@push('custom-js')
    <script>
        function showPreviewImage() {
            const fileInput = document.getElementById("customFile");
            let image = $("#preview-image");
            const selectedFiles = fileInput.files;
            image.attr('src', URL.createObjectURL(selectedFiles[0]))
        }
    </script>
@endpush
