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
    <div class="card mb-3">
        <div class="card-header">
            @lang('area')
        </div>
        <div class="card-body p-2 wrap-select2">
            <x-select name="area_id"
                      id="area_id"
                      class="select2-bs5-ajax"
                      data-url="{{ route('admin.search.select.area') }}"
                      :required="true">

            </x-select>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            @lang('storeCategory')
        </div>
        <div class="card-body p-2 wrap-select2">
            <x-select name="category_id"
                      id="category_id"
                      class="select2-bs5-ajax"
                      data-url="{{ route('admin.search.select.store_category') }}"
                      :required="true">

            </x-select>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            @lang('status')
        </div>
        <div class="card-body p-2">
            <x-select name="status" :required="true">
                @foreach ($status as $key => $value)
                    <x-select-option :value="$key" :title="__($value)"/>
                @endforeach
            </x-select>
        </div>
    </div>
{{--    <div class="card mb-3">--}}
{{--        <div class="card-header">--}}
{{--            @lang('priority')--}}
{{--        </div>--}}
{{--        <div class="card-body p-2">--}}
{{--            <x-input type="number" name="priority" value="0" :placeholder="trans('priority')"/>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="card mb-3">
        <div class="card-header">
            {{ __('Ảnh đại diện') }}
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="logo" showImage="logo" />
        </div>
    </div>
</div>
