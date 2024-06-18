<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thêm mã giảm giá') }}</h2>
        </div>
        <div class="row card-body">
            <!-- name -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Tên mã giảm') }}:</label>
                    <x-input name="name" :value="old('name')" :required="true" placeholder="{{ __('Tên mã giảm') }}" />
                </div>
            </div>
            <!-- discount -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Giảm')}}:</label>
                    <div class="input-group">
                        <x-input type="number" name="discount" :value="old('discount')" :required="true" placeholder="VNĐ" />
                        <span class="input-group-text">VNĐ</span>
                    </div>
                </div>
            </div>
            <!-- apply_qty -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Số lượng áp dụng')}}:</label>
                    <x-input type="number" name="apply_qty" :value="old('apply_qty')" :required="true" placeholder="Số lượng áp dụng" />
                </div>
            </div>
            <!-- apply_qty -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Số lượng tối đa')}}:</label>
                    <x-input type="number" name="maximum_qty" :value="old('maximum_qty')" :required="true" placeholder="Số lượng tối đa" />
                </div>
            </div>
            <!-- time_apply -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Ngày áp dụng')}}:</label>
                    <x-input type="date" name="apply_date" :required="true" />
                </div>
            </div>
            <!-- expiration_date -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{__('Ngày hết hạn')}}:</label>
                    <x-input type="date" name="expiration_date" :required="true" />
                </div>
            </div>
            <!-- service_applies -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Dịch vụ được áp dụng') }}:</label>
                    <x-input name="service_applies" :required="true" placeholder="{{ __('Dịch vụ được áp dụng') }}" />
                </div>
            </div>
            <!-- Product -->
            <div class="col-md-6 col-sm-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Sản phẩm được áp dụng') }}:</label>
                    <x-select class="select2-bs5-ajax" name="product_id" :required="true">
                    </x-select>
                </div>
            </div>
            <!-- conditions -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label"><strong>{{ __('Điều kiện') }}:</strong></label>
                    <textarea name="conditions" class="ckeditor visually-hidden">{{ old('conditions') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
