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
            {{ __('Danh mục') }}
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($categories as $category)
                <x-input-checkbox :depth="$category->depth" name="categories_id[]" :label="$category->name"
                    :value="$category->id" />
            @endforeach
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Topping') }}
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($toppings as $topping)
                <x-input-checkbox :depth="$topping->depth" name="toppings_id[]" :label="$topping->name"
                    :value="$topping->id" />
            @endforeach
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Mã giảm giá') }}
        </div>
        <div class="card-body p-2 wrap-list-checkbox">
            @foreach ($discounts as $discount)
                <x-input-checkbox name="discount_ids[]" :label="$discount->code" :value="$discount->id" />
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
                <x-select-option value="0" :title="__('Tạm ngưng')" />
            </x-select>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Ảnh đại diện') }}
        </div>
        <div class="card-body p-2">
            <x-input-image-ckfinder name="product[avatar]" showImage="avatar" />
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            {{ __('Thư viện ảnh') }}
        </div>
        <div class="card-body p-2">
            <x-input-gallery-ckfinder name="product[gallery]" type="multiple" />
        </div>
    </div>
</div>
