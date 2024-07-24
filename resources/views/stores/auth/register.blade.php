@extends('admin.layouts.guest.master')

@push('custom-css')
<link href="{{ asset('public/admins/assets/css/style.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="page">
        <div class="container-tight py-4">
            <x-form :action="route('store.register.post')" class="card card-md" type="post" :validate="true">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset($logo) }}" width="200" alt="">
                    </div>
                    <h2 class="card-title text-center mb-4">@lang('registerStore')</h2>
                    <div class="mb-3">
                        <label class="form-label">@lang('category2'):</label>
                        <x-select name="category_id" :required="true">
                            @foreach ($store_categories as $store_category)
                                <x-select-option :value="$store_category->id" :title="$store_category->name" />
                            @endforeach
                        </x-select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">@lang('username'):</label>
                        <x-input name="username" :required="true" :value="old('username')" :placeholder="trans('username')" />
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">@lang('password'):</label>
                            <x-input-password name="password" :required="true" />
                        </div>
                        <div class="col-6">
                            <label class="form-label">@lang('passwordConfirm'):</label>
                            <x-input-password name="password_confirmation" :required="true"
                                data-parsley-equalto="input[name='password']"
                                data-parsley-equalto-message="{{ __('passwordMismatch') }}" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">@lang('taxCode'):</label>
                        <x-input name="tax_code" :value="old('tax_code')" :required="true"
                            :placeholder="__('taxCode')" />
                    </div>
                    <div class="row">
                        <!-- store_name -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('storeName'):</label>
                                <x-input name="store_name" :value="old('store_name')" :required="true"
                                    :placeholder="__('storeName')" />
                            </div>
                        </div>
                        <!-- storePhone -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('storePhone'):</label>
                                <x-input-phone name="store_phone" :value="old('store_phone')" :required="true" />
                            </div>
                        </div>

                        <!-- conactName -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('conactName'):</label>
                                <x-input name="contact_name" :value="old('contact_name')" :required="true"
                                    :placeholder="__('conactName')" />
                            </div>
                        </div>
                        <!-- contactPhone -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">@lang('contactPhone'):</label>
                                <x-input-phone name="contact_phone" :value="old('contact_phone')" :required="true" />
                            </div>
                        </div>
                        {{-- area --}}
                        <div class="mb-3">
                            <label class="form-label">@lang('area'):</label>
                            <x-select name="area_id" :required="true">
                                @foreach ($areas as $area)
                                    <x-select-option :value="$area->id" :title="$area->name" />
                                @endforeach
                            </x-select>
                        </div>
                        <!-- address -->
                        <div class="col-12">
                            <div class="mb-3">
                                <x-input-pick-address :label="trans('address')" name="address" :placeholder="trans('pickAddress')" :required="true" /> 
                                <x-input type="hidden" name="lat" />
                                <x-input type="hidden" name="lng" />
                            </div>
                        </div>
                        <!-- addressDetail -->
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="control-label">@lang('addressDetail'):</label>
                                <x-input name="address_detail" :value="old('address_detail')" :placeholder="__('addressDetail')" />
                            </div>
                        </div>
                        
                        <!-- openHour1-->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="control-label">@lang('openHour') 1:</label>
                                <x-input type="time" name="open_hours_1" :value="old('open_hours_1')" :required="true"
                                    :placeholder="__('openHour')" />
                            </div>
                        </div>

                        <!-- closeHour1 -->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="control-label">@lang('closeHour') 1:</label>
                                <x-input type="time" name="close_hours_1" :value="old('close_hours_1')" :required="true"
                                    :placeholder="__('closeHour')" />
                            </div>
                        </div>
                        <!-- openHour2-->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="control-label">@lang('openHour') 2:</label>
                                <x-input type="time" name="open_hours_2" :value="old('open_hours_2')" :placeholder="__('openHour')" />
                            </div>
                        </div>

                        <!-- closeHour2 -->
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="control-label">@lang('closeHour') 2:</label>
                                <x-input type="time" name="close_hours_2" :value="old('close_hours_2')" :placeholder="__('closeHour')" />
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">@lang('register')</button>
                    </div>
                    <p class="text-center mt-3">
                        <span>@lang('alreadyAccount')?</span> 
                        <x-link :href="route('store.login.index')">@lang('loginNow')</x-link>
                    </p>
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