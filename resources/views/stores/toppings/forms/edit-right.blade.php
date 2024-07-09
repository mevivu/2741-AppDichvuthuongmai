<div class="col-12 col-md-3">
    <div class="card">
        <div class="card-header">
            {{ __('Đăng') }}
        </div>
        <div class="card-body p-2 d-flex justify-content-between">
            <x-button.submit :title="__('Cập nhật')" />
            <x-button.modal-delete data-route="{{ route('admin.topping.delete', $topping->id) }}" :title="__('Xóa')" />
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            {{ __('Trạng thái') }}
        </div>
        <div class="card-body p-2">
            <x-select class="form-select" name="status" :required="true">
                <x-select-option value="1" :title="__('Còn món')" />
                <x-select-option :option="$topping->status ?: '0'" value="0" :title="__('Hết món')" />
            </x-select>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            {{ __('Ảnh đại diện') }}
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="avatar" showImage="avatar" :value="$topping->avatar"/>
        </div>
    </div>

</div>
