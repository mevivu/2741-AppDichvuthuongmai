<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin Chủ xe và Phương tiện') }}</h2>
        </div>
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active"
                            id="driver-info-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#driverInfo"
                            type="button"
                            role="tab"
                            aria-controls="driverInfo"
                            aria-selected="true">
                        {{ __('Thông tin Chủ xe') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link"
                            id="vehicle-info-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#vehicleInfo"
                            type="button" role="tab"
                            aria-controls="vehicleInfo"
                            aria-selected="false">
                        {{ __('Thông tin Phương tiện') }}
                    </button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade show active"
                     id="driverInfo"
                     role="tabpanel"
                     aria-labelledby="driver-info-tab">
                    @include('admin.vehicle.forms.partials.edit-info-driver')
                </div>
                <div class="tab-pane fade"
                     id="vehicleInfo"
                     role="tabpanel"
                     aria-labelledby="vehicle-info-tab">
                    <div id="vehicleFormsContainer">
                        @include('admin.vehicle.forms.partials.edit-vehicle')
                    </div>
                    <button id="addVehicle"
                            type="button"
                            class="btn btn-primary">
                        {{ __('Thêm phương tiện') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

