@extends('admin.layouts.master')
@push('libs-css')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.topping.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('stores.toppings.forms.create-left')
                    @include('stores.toppings.forms.create-right')
                </div>
                @include('stores.toppings.forms.actions-fixed')
            </x-form>
        </div>
    </div>
@endsection

@push('libs-js')
<script src="{{ asset('public/libs/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('public/libs/ckeditor/adapters/jquery.js') }}"></script>
@include('ckfinder::setup')
@endpush


@push('custom-js')

@endpush
