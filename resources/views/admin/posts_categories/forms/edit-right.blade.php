<div class="col-12 col-md-3">
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Đăng') }}
        </div>
        <div class="card-body p-2 d-flex justify-content-between">
            <x-button.submit :title="__('Cập nhật')"/>
            <x-button.modal-delete data-route="{{ route('admin.post_category.delete', $category->id) }}"
                                   :title="__('Xóa')"/>
        </div>
    </div>
    <!-- status -->
    <div class="card mb-3">
        <div class="card-header">
            @lang('status')
        </div>
        <div class="card-body p-2">
            <x-select name="status" :required="true">
                @foreach ($status as $key => $value)
                    <x-select-option :value="$key" :title="$value"/>
                @endforeach
            </x-select>
        </div>
    </div>
    <!-- avatar -->
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                @lang('avatar')
            </div>
            <div class="card-body p-2">
                <x-input-image-ckfinder name="avatar"
                                        showImage="avatar"
                                        :value="$category->avatar"
                                        class="img-fluid"/>
            </div>
        </div>
    </div>
</div>
