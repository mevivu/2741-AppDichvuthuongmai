@extends('admin.layouts.master')

@push('libs-css')
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/libs/select2/dist/css/select2-bootstrap-5-theme.min.css') }}">
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.store.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$store->id" />
                <div class="row justify-content-center">
                    @include('admin.stores.forms.edit-left')
                    @include('admin.stores.forms.edit-right')
                </div>
                @include('admin.forms.actions-fixed')
            </x-form>
        </div>
    </div>
@endsection

@push('libs-js')
<!-- button in datatable -->
<script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('/public/libs/select2/dist/js/i18n/'.trans()->getLocale().'.js') }}"></script>
@endpush

@push('custom-js')
    @include('admin.layouts.modal.modal-pick-address')
    @include('admin.scripts.google-map-input')
@endpush
