@extends('admin.layouts.master')

@push('libs-css')

@endpush

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h2 class="mb-0">@lang('income_driver') {{$driver->user->fullname}}</h2>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 p-3">
                        <label for="monthPicker">Chọn tháng</label>
                        <div class="">
                            <x-input type="month" name="monthPicker" class="form-control mb-3"
                                     title="Chọn tháng và năm (mm/yyyy)"/>
                            <span class="w-50 mt-3" id="displayMonth"></span>
                        </div>
                    </div>
                    <div class="form-group col-md-6 p-3">
                        <label for="monthPicker">Tổng thu</label>
                        <div class="mt-3">
                            <span class="income" id="initialIncome">{{ $totalIncome}}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive position-relative">
                        <x-admin.partials.toggle-column-datatable/>
                        {{$dataTable->table(['class' => 'table table-bordered'], true)}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- button in datatable -->
    <script src="{{ asset('/public/vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('public/libs/numeral/numeral.min.js') }}"></script>

@endpush

@push('custom-js')

    {{ $dataTable->scripts() }}

    <script>
        $(document).ready(function () {
            const dataTable = window.LaravelDataTables["{{$dataTable->getTableAttribute('id')}}"];
            const monthNames = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"];
            const currency = 'VND';
            // Format initial totalIncome
            const initialFormattedIncome = numeral($('#initialIncome').text()).format('0,0') + ' ' + currency;
            $('#initialIncome').text(initialFormattedIncome);
            let driverId = {{ $driver->id }};

            $('input[name="monthPicker"]').change(function () {
                const selectedMonth = $(this).val();

                const date = new Date(selectedMonth);
                const formattedMonth = monthNames[date.getMonth()] + ' ' + date.getFullYear();

                const a = {{ $driver->id }};
                $('#displayMonth').text(formattedMonth);
                console.log("driverId: " + a);

                dataTable.ajax.url('{{ route("admin.order.orderDriverIncome", ["id" => $driver->id]) }}?month=' + selectedMonth).load();
                $.get('{{ route("admin.order.income") }}', {
                    driver_id: driverId,
                    month: selectedMonth
                }, function (data) {
                    const formattedIncome = numeral(data).format('0,0') + ' ' + currency;
                    $('.income').text(formattedIncome);
                });
            });
        });
    </script>

    @include('admin.scripts.datatable-toggle-columns', [
        'id_table' => $dataTable->getTableAttribute('id')
    ])

@endpush
