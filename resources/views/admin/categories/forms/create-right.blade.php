<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Đăng') }}
        </div>
        <div class="card-body p-2">
            <x-button.submit :title="__('Thêm')" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Avatar') }}
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="avatar" showImage="avatar" />
        </div>
    </div>
    <!-- is active -->
    <div class="col-md-6 col-sm-12">
        <div class="mb-3">
            <label class="control-label">{{ __('Trạng thái') }}:</label>
            <x-select class="select2-bs5" name="is_active" :required="true">
                <x-select-option value="1" :title="__('Hoạt động')" />
                <x-select-option value="0" :title="__('Tạm ngưng')" />
            </x-select>
        </div>
    </div>
</div>
