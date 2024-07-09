<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thêm topping') }}</h2>
        </div>
        <div class="row card-body">
            <!-- link -->
            <div class="col-6">
                <div class="mb-3">
                    <label class="control-label">@lang('name')</label>
                    <x-input name="name" :value="old('name')" :required="true" :placeholder="__('name')" />
                </div>
            </div>
            {{--      Price      --}}
            <div class="col-6">
                <div class="mb-3">
                    <label class="control-label">@lang('price')</label>
                    <x-input name="price" :value="old('price')" :required="true" :placeholder="__('price')" />
                </div>
            </div>
            <!-- position -->
{{--            <div class="col-md-12 col-12">--}}
{{--                <div class="mb-3">--}}
{{--                    <label class="control-label">{{ __('Bắt buộc') }}:</label></br>--}}
{{--                    <input type="checkbox" name="obligatory" value="1" checked style="transform: scale(1.5);">--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
</div>
