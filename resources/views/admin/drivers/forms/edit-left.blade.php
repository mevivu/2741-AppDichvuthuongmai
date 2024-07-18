<div class="col-12 col-md-9">

    {{--    Information Basic--}}
    <div class="card">
        <div class="card-header fw-bold h3">
            @lang('information_basic')
        </div>
        @include('admin.drivers.partials.information-basic')
    </div>

    {{--    Information plus--}}
    <div class="card mt-3">
        <div class="card-header fw-bold h3">
            @lang('driver_register_information')
        </div>
        @include('admin.drivers.partials.information-plus')
    </div>

    {{-- Image driver--}}
    @include('admin.drivers.partials.information-image')
</div>
