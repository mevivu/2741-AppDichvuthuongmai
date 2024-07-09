@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.topping.update')" type="put" :validate="true">
                <x-input type="hidden" name="id" :value="$topping->id" />

                <div class="row justify-content-center">
                    @include('stores.toppings.forms.edit-left')
                    @include('stores.toppings.forms.edit-right')
                </div>
                @include('stores.toppings.forms.actions-fixed')
            </x-form>
        </div>
    </div>
@endsection

@push('libs-js')
    @include('ckfinder::setup')
@endpush
