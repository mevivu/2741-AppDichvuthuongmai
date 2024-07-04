@extends('admin.layouts.master')
@push('libs-css')
@endpush
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                class="text-muted">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Sửa Dịch Vụ') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <x-form :action="route('admin.category_system.update')" type="put" :validate="true">
            <x-input type="hidden" name="id" :value="$category_system->id" />
            <div class="row justify-content-center">
                @include('admin.category_systems.forms.edit-left')
                @include('admin.category_systems.forms.edit-right')
            </div>
        </x-form>
    </div>
</div>
@endsection

@push('libs-js')
    <!-- ckfinder js -->
    @include('ckfinder::setup')
@endpush


@push('custom-js')
@endpush