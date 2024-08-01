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
                    <x-input name="name" :value="old('name')" :required="true" :placeholder="__('name')"/>
                </div>
            </div>
            {{-- Price --}}
            <div class="col-6">
                <div class="mb-3">
                    <label class="control-label">@lang('price')</label>
                    <x-input-price name="price"
                                   id="price"
                                   :value="old('price')"
                                   :required="true"
                                   :placeholder="__('price')"/>
                </div>
            </div>

        </div>
    </div>
</div>
