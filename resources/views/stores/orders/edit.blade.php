@extends('stores.layouts.master')
<style>
    #getCurrentLocation span.cursor-pointer {
        display: none;
    }
</style>
@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.order.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$order->id"/>
                <x-input type="hidden" name="editPage" value="true"/>
                <div class="row justify-content-center">
                    @include('stores.orders.forms.edit-left')
                    @include('stores.orders.forms.edit-right')
                </div>
                @include('admin.forms.actions-fixed')
            </x-form>
        </div>
    </div>
@endsection
@push('libs-js')
    <script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
    @include('ckfinder::setup')
    <!-- button in datatable -->
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/'.trans()->getLocale().'.js') }}"></script>

@endpush
@push('custom-js')
    @include('stores.layouts.modal.modal-pick-address')
    @include('stores.layouts.modal.modal-destination-address')
    @include('stores.scripts.google-map-input')
    @include('stores.scripts.google-map-input-destination')
    @include('admin.orders.scripts.distance-address')

@endpush
