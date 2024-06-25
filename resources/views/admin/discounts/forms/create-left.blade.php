<div class="col-12 col-md-9">
    <div class="row">
        <!-- name -->
        <h2 style="text-align: center; color: red;">Tạo phiếu giảm giá </h2>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @lang('name') & Trạng thái tồn kho
                </div>
                <div class="card-body row">
                    <!-- name -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">@lang('code')</label>
                            <x-input name="code" :value="old('code')" :required="true" :placeholder="__('code')"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">@lang('max_usage')</label>
                            <x-input name="max_usage" :value="old('max_usage')" :required="true"
                                     :placeholder="__('max_usage')"/>
                        </div>
                    </div>
                    <!--Sku-->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">@lang('date_start')</label>
                            <x-input input type="datetime-local" name="date_start" :value="old('date_start')"
                                     :required="true" :placeholder="__('date_start')"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">@lang('date_end')</label>
                            <x-input name="date_end" input type="datetime-local" :value="old('date_end')"
                                     :required="true" :placeholder="__('date_end')"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">@lang('min_order_amount')</label>
                            <x-input-price name="min_order_amount"
                                           id="min_order_amount"
                                           :value="old('min_order_amount')"
                                           :required="true"
                                           :placeholder="__('min_order_amount')"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">@lang('type'):</label>
                            <x-select name="type" :required="true">
                                <x-select-option :value="1" :title="'Tiền'"/>
                                <x-select-option :value="2" :title="'Phần trăm'"/>
                            </x-select>
                        </div>
                    </div>
                    <!-- price_selling -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="control-label">@lang('discount_value')</label>
                            <x-input-price name="discount_value"
                                           id="discount_value"
                                           :value="old('discount_value')"
                                           :required="true"
                                           :placeholder="__('discount_value')"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
