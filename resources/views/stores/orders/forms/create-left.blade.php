<style>
    .hidden {
        display: none !important;
    }
</style>
<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
        </div>
        <div class="row card-body">
            <!-- pickup_address -->
            <div class="col-12">
                <div class="mb-3">
                    <x-input-pick-address :label="trans('startAddress')"
                                          name="pickup_address"
                                          readonly
                                          :placeholder="trans('startAddress')"
                    />
                    <x-input type="hidden" name="lat"/>
                    <x-input type="hidden" name="lng"/>
                </div>
            </div>
            <!-- store -->
            <div class="col-md-12 col-12 mt-3">
                <div class="mb-3">
                    <label class="control-label">@lang('store'):</label>
                    <x-select id="store-select" name="store_id" class="select2-bs5-ajax-many"
                              :data-url="route('admin.search.select.store')">

                    </x-select>
                </div>
            </div>
            <!-- destination_address -->
            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('pickDestinationAddress'):</label>
                    <x-input readonly id="destination_address" type="text"
                             name="destination_address"
                             :value="old('destination_address')"
                             :required="true"/>
                </div>
            </div>
            {{--            <div class="col-12">--}}
            {{--                <div class="mb-3">--}}
            {{--                    <x-input-destination-address :label="trans('pickDestinationAddress')"--}}
            {{--                                                 name="destination_address"--}}
            {{--                                                 :placeholder="trans('pickDestinationAddress')"--}}
            {{--                                                 readonly--}}
            {{--                    />--}}
            {{--                    <x-input type="hidden" name="destination_lat"/>--}}
            {{--                    <x-input type="hidden" name="destination_lng"/>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <!-- show map -->
            <div id="resultMap" class="w-100 hidden" style="height: 400px"></div>
            <!-- detail map-->
            <div id="directions-panel"></div>
            <div class="col-md-6 col-12 mt-3">
                <div class="mb-3">
                    <label class="control-label">@lang('customer'):</label>
                    <x-select name="customer_id" class="select2-bs5-ajax-many"
                              :data-url="route('admin.search.select.user')">

                    </x-select>
                </div>
            </div>


            <!-- shipping_method -->
            <div class="col-md-6 col-12 mt-3">
                <div class="mb-3">
                    <label class="control-label">@lang('shipping'):</label>
                    <x-select id="shipping_method" name="shipping_method" :required="true">
                        @foreach ($shipping as $key => $value)
                            <x-select-option :value="$key" :title="__($value)"/>
                        @endforeach
                    </x-select>
                </div>
            </div>
            <!-- payment_method -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('payment'):</label>
                    <x-select id="payment_method" name="payment_method" :required="true">
                        @foreach ($payment as $key => $value)
                            <x-select-option :value="$key" :title="__($value)"/>
                        @endforeach
                    </x-select>
                </div>
            </div>
            <!-- sub_total -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('sub_total'):</label>
                    <x-input id="sub_total" type="number" name="sub_total" :value="old('sub_total')"
                             :required="true"/>
                </div>
            </div>
            <!-- transport_fee -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('transport_fee'):</label>
                    <x-input id="transport_fee" type="number" name="transport_fee" :value="old('transport_fee')"
                             :required="true"/>
                </div>
            </div>
            <!-- system_revenue -->
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('system_revenue'):</label>
                    <x-input id="system_revenue" type="number" name="system_revenue" :value="old('system_revenue')"
                             :required="true"/>
                </div>
            </div>
            <!-- total -->
            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('total'):</label>
                    <x-input id="total" type="number" name="total" :value="old('total')"
                             :required="true"/>
                </div>
            </div>

        </div>
    </div>
</div>

