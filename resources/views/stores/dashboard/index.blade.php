@extends('stores.layouts.master')
@push('custom-css')
    <style>
        .draw-chart {
            width: 100%;
            height: 500px;
        }
    </style>
@endpush
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <!-- <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="row row-cards">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-green text-white avatar">
                                                <i class="ti ti-user"></i>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="fw-bold text-primary">
                                                {{ $total_user }}
                                            </div>
                                            <div class="text-secondary">
                                                @lang('user')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> -->
            <div class="row mt-3">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">{{ __('Biểu đồ doanh thu 7 ngày gần đây') }}</h3>
                            <div id="showChartOrder" class="draw-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">{{ __('Biểu đồ khách hàng trong 7 ngày ') }}</h3>
                            <div id="showChartUser" class="draw-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('libs-js')
    <!-- Resources -->
@endpush

@push('custom-js')
    <!-- Chart code -->
    @include('stores.scripts.amchart')
    <x-input id="dataChartOrder" type="hidden" :value="$chart_order" />
    <x-input id="dataChartUser" type="hidden" :value="$chart_product_sold" />
<!-- Chart code -->
<script>
    $(document).ready(function(){
        makeAmchart('showChartOrder', $('#dataChartOrder').val(), 'order_date', 'order_total');
        makeAmchart('showChartUser', $('#dataChartUser').val(), 'sell_date', 'user');
        console.log(JSON.parse($('#dataChartUser').val()));
    })
</script>
@endpush
