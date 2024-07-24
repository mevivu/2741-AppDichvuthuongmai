@extends('stores.layouts.master')

@push('libs-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.2/css/select.bootstrap5.min.css">
@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header justify-content-between">
                    
                    <h2 class="mb-0">{{ __('Danh sách chi tiết đơn hàng') }}</h2>
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive position-relative">
                        <x-admin.partials.toggle-column-datatable />
                        <strong><label>Thông tin khách hàng  
                        </label></strong></br>
                        <strong><label>Thời gian đặt hàng: {{$order->created_at}}</label></strong></br>
                        <strong><label>Mã đơn hàng: {{$order->code}}</label></strong></br>
                        <strong><label>Họ tên khách hàng:  {{$user->fullname}}</label></strong></br>
                        <strong><label>Số ĐT khách hàng:  {{$user->phone}}</label></strong></br>
                        <strong><label>ĐC giao hàng: {{$order->shipping_address}}</label></strong></br>
                        <strong><label>Thời gian đặt hàng: {{$order->created_at}}</label></strong></br>
                        <strong><label>Ghi chú: </label></strong></br>
                        {{ $dataTable->table(['class' => 'table table-bordered', 'style' => 'min-width: 900px;'], true) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- button in datatable -->
    <script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

@push('custom-js')
    {{ $dataTable->scripts() }}

    @include('stores.scripts.datatable-toggle-columns', [
        'id_table' => $dataTable->getTableAttribute('id'),
    ])
@endpush
