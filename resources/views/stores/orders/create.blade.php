@extends('admin.layouts.master')
@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.order.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('admin.orders.forms.create-left')
                    @include('admin.orders.forms.create-right')
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
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/'.trans()->getLocale().'.js') }}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&libraries=places&language=vi&callback=initMaps" async defer></script>
@endpush

@push('custom-js')
    @include('admin.layouts.modal.modal-pick-address')
    @include('admin.layouts.modal.modal-destination-address')
    @include('admin.scripts.google-map-input')
    @include('admin.scripts.google-map-input-destination')
    @include('admin.orders.scripts.distance-address')
    <script>
        function initMaps() {
            initMap();
            initDestinationMap();
        }
    </script>
@endpush


