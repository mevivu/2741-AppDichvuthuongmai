<div class="col-12 col-md-3">
    <div class="card">
        <div class="card-header">
            {{ __('Đăng') }}
        </div>
        <div class="card-body p-2 d-flex justify-content-between">
            <x-button.submit :title="__('Cập nhật')" />
            <x-button.modal-delete data-route="{{ route('admin.product.delete', $product->id) }}" :title="__('Xóa')" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Danh mục') }}
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($categories as $category)
                <x-input-checkbox :depth="$category->depth" :checked="$product->categories->pluck('id')->toArray()"
                    name="categories_id[]" :label="$category->name" :value="$category->id" />
            @endforeach
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Topping') }}
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($toppings as $topping)
<<<<<<< HEAD
                <x-input-checkbox :depth="$topping->depth" :checked="isset($product->toppings) ? $product->toppings : []"
                    name="toppings_id[]" :label="$topping->name" :value="$topping->id" />
=======
                <x-input-checkbox :depth="$topping->depth" name="toppings_id[]" :label="$topping->name"
                    :value="$topping->id" />
>>>>>>> 4b56050f4255d0d88105c67cfbc5436467f668fc
            @endforeach
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Trạng thái') }}
        </div>
        <div class="card-body p-2">
            <x-select class="form-select" name="product[is_active]" :required="true">
                <x-select-option value="1" :title="__('Hoạt động')" />
                <x-select-option :option="$product->is_active ?: '0'" value="0" :title="__('Tạm ngưng')" />
            </x-select>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Chiếc khẩu cho thành viên') }}
        </div>
        <div class="card-body p-2">
            <x-select class="form-select" name="product[is_user_discount]" :required="true">
                <x-select-option value="0" :title="__('Không')" />
                <x-select-option :option="$product->is_user_discount ? '1' : '0'" value="1" :title="__('Có')" />
            </x-select>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Tích điểm') }}
        </div>
        <div class="card-body p-2">
            <x-select class="form-select" name="product[is_earning_point]" :required="true">
                <x-select-option value="0" :title="__('Không')" />
                <x-select-option :option="$product->is_earning_point ? '1' : '0'" value="1" :title="__('Có')" />
            </x-select>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Ảnh đại diện') }}
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="product[avatar]" showImage="avatar" :value="$product->avatar" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Thư viện ảnh') }}
        </div>
        <div class="card-body p-2">
            <x-input-gallery-ckfinder name="product[gallery]" type="multiple" :value="$product->gallery" />
        </div>
    </div>
</div>