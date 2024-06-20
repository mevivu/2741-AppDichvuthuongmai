<div class="modal modal-blur fade" id="modalDestinationAddress" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('pickDestinationAddress')</h5>
                <button type="button" class="btn-close cancel-destination-address" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="destinationPlace" class="form-label">@lang('pickAddress')</label>
                    <x-input name="destinationPlace" id="destinationPlace"/>
                </div>
                <div id="pickedDestinationAddress" class="mb-3">
                    <span><strong>@lang('pickedAddress')</strong></span>:
                    <span class="show-text"></span>
                </div>
                <div class="mb-3">
                    <label for="destinationAddressDetail" class="control-label">
                        <strong>@lang('addressDetail')</strong>
                        @lang('(Hãy nhập thêm địa chỉ bên dưới nếu địa chỉ đã chọn không đúng với địa chỉ của quán)')
                    </label>
                    <x-input name="destination_address_detail" id="destinationAddressDetail" :placeholder="trans('Tên thôn, thị xã, tên đường, tòa nhà, số nhà')"/>
                </div>
                <div id="showDestinationMap" class="w-100" style="height: 400px"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto cancel-destination-address"
                        data-bs-dismiss="modal">@lang('cancel')</button>
                <button type="button" id="confirmDestinationAddress" class="btn btn-danger" data-bs-dismiss="modal">@lang('oke')</button>
            </div>
        </div>
    </div>
</div>
