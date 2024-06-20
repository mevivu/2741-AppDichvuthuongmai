{{--<div class="d-flex justify-content-between align-items-center">--}}
{{--    <label class="form-label">{{ $label }}</label>--}}
{{--    <div id="getCurrentDestinationLocation" class="text-danger d-flex align-items-center">--}}
{{--        <div class="spinner-border text-danger me-1" role="status" style="display: none;">--}}
{{--            <span class="visually-hidden">Loading...</span>--}}
{{--        </div>--}}
{{--        <span class="cursor-pointer">@lang('useCurrentLocation')</span>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="input-group mb-2">
    <input type="text" {{ $attributes->class(['form-control'])->merge($isRequired()) }} name="{{ $name }}"
           readonly data-parsley-errors-container="#error{{ $name }}" />
    <button type="button" id="openModalDestinationAddress" class="btn text-danger fw-normal"
            disabled
            data-input="input[name={{ $name }}]" data-lat="input[name=destination_lat]"
            data-lng="input[name=destination_lng]" data-address-detail="input[name=destination_address_detail]"
            data-bs-toggle="modal"
            data-bs-target="#modalDestinationAddress">@lang('pickAddress')</button>
</div>
<div id="error{{ $name }}"></div>
