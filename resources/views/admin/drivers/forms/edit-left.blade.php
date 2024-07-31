<div class="col-12 col-md-9">
    <div class="card">
        <div class="card-header justify-content-center">
            <h2 class="mb-0">{{ __('Thông tin Tài xế và Thông tin đăng ký xe') }}</h2>
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
                            id="registration-info-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#registrationInfo"
                            type="button" role="tab"
                            aria-controls="registrationInfo"
                            aria-selected="false">
                        {{ __('Thông tin Đăng ký xe') }}
                    </button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane fade show active"
                     id="driverInfo"
                     role="tabpanel"
                     aria-labelledby="driver-info-tab">
                    @include('admin.drivers.partials.edit-info-driver')
                </div>
                <div class="tab-pane fade"
                     id="registrationInfo"
                     role="tabpanel"
                     aria-labelledby="registration-info-tab">
                    <div id="vehicleFormsContainer">
                        @include('admin.drivers.partials.edit-registration')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

