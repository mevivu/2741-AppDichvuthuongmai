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
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Thêm Dịch Vụ') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <x-form :action="route('admin.category_system.store')" type="post" :validate="true">
            <div class="row justify-content-center">
                @include('admin.category_systems.forms.create-left')
                @include('admin.category_systems.forms.create-right')
            </div>
        </x-form>
    </div>
</div>
@endsection

@push('libs-js')
    <!-- ckfinder js -->
    @include('ckfinder::setup')
    {{--
    <script src="{{ asset('/public/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('/public/libs/select2/dist/js/i18n/vi.js') }}"></script> --}}
@endpush

@push('custom-js')

@endpush