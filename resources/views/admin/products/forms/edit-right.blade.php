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
                <x-input-checkbox :depth="$topping->depth" :checked="isset($product->toppings) ? $product->toppings->pluck('id')->toArray() : []"
                    name="toppings_id[]" :label="$topping->name" :value="$topping->id" />
            @endforeach
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Mã giảm giá') }}
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($discounts as $discount)
                <x-input-checkbox :checked="isset($product->discounts) ? $product->discounts->pluck('id')->toArray() : []"
                    name="discount_ids[]" :label="$discount->code" :value="$discount->id" />
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
