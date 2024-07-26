@extends('stores.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('store.profile.update')" type="put" enctype="multipart/form-data" :validate="true">
            <div class="row justify-content-center">
                <div class="col-12 col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('infoStore')</h3>
                            <span @class([
                                'ms-auto badge', $auth->status->badge()
                            ])>{{ $auth->status->description() }}</span>
                        </div>
                        <div class="card-body p-4 text-center">
                            <img id="storeLogo" class="avatar avatar-xl mb-3 rounded input-image" data-input-target="input[name=logo]" src="{{ asset($auth->logo) }}" alt="">
                            <x-input type="file" class="d-none" name="logo" data-preview="#storeLogo" onchange="imagePreview(this)"/>
                            <h3 class="m-0 mb-1">{{ $auth->store_name }}</h3>
                            <div class="text-secondary">{{ $auth->fullAddress() }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <!-- store_name -->
                                    <div class="mb-3">
                                        <label class="form-label">@lang('storeName')</label>
                                        <x-input name="store_name" :value="$auth->store_name" :required="true" placeholder="{{ __('storeName') }}"/>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <!-- store_phone -->
                                    <div class="mb-3">
                                        <label class="form-label">@lang('phone')</label>
                                        <x-input-phone name="store_phone" :value="$auth->store_phone" :required="true" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- tax_code -->
                                    <div class="mb-3">
                                        <label class="form-label">@lang('taxCode')</label>
                                        <x-input name="tax_code" :value="$auth->tax_code" placeholder="{{ __('taxCode') }}" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    {{-- area --}}
                                    <div class="mb-3">
                                        <label for="" class="form-label">@lang('area')</label>
                                        <x-input name="area" :value="$auth->area->name" disabled />
                                    </div>
                                </div>
                                <!-- address -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <x-input-pick-address :label="trans('address')" name="address" :value="$auth->address" :placeholder="trans('pickAddress')" :required="true" /> 
                                        <x-input type="hidden" name="lat" :value="$auth->lat" />
                                        <x-input type="hidden" name="lng" :value="$auth->lng" />
                                    </div>
                                </div>
                                <!-- addressDetail -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">@lang('addressDetail')</label>
                                        <x-input name="address_detail" :value="$auth->address_detail" :placeholder="__('addressDetail')" />
                                    </div>
                                </div>
                                <!-- openHour1-->
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">@lang('openHour') 1</label>
                                        <x-input type="time" name="open_hours_1" :value="$auth->open_hours_1" :required="true"
                                            :placeholder="__('openHour')" />
                                    </div>
                                </div>

                                <!-- closeHour1 -->
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">@lang('closeHour') 1</label>
                                        <x-input type="time" name="close_hours_1" :value="$auth->close_hours_1" :required="true"
                                            :placeholder="__('closeHour')" />
                                    </div>
                                </div>
                                <!-- openHour2-->
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">@lang('openHour') 2</label>
                                        <x-input type="time" name="open_hours_2" :value="$auth->open_hours_2" :placeholder="__('openHour')" />
                                    </div>
                                </div>

                                <!-- closeHour2 -->
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">@lang('closeHour') 2</label>
                                        <x-input type="time" name="close_hours_2" :value="$auth->close_hours_2" :placeholder="__('closeHour')" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">@lang('status')</label>
                                        <x-select name="status" :required="true">
                                            @foreach ($status as $key => $value)
                                                <x-select-option :option="$auth->status->value" :value="$key" :title="$value" />
                                            @endforeach
                                        </x-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent mt-auto">
                            <div class="btn-list justify-content-center">
                                <x-button.submit :title="__('save')" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-form>
        </div>
    </div>
@endsection
@push('libs-js')
<!-- button in datatable -->
<script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('/public/libs/select2/dist/js/i18n/'.trans()->getLocale().'.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places&language=vi&callback=initMaps" async defer></script>

@endpush
@push('custom-js')
    @include('admin.layouts.modal.modal-pick-address')
    @include('admin.scripts.google-map-input')
    <script>
        function initMaps() {
            initMap();
        }
    </script>
@endpush