<div class="col-12 col-md-9">
    <div class="row">
        <!-- name -->
        <h2 style="text-align: center; color: red;">Thông tin món ăn</h2>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @lang('name') & Trạng thái tồn kho
                </div>
                <div class="card-body row">
                    <input type="hidden" name="store_id" value="{{$store_id->id}}"/>
                    <!-- name -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">@lang('name')</label>
                            <x-input name="name" :value="old('name')" :required="true" :placeholder="__('name')"/>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">@lang('category2'):</label>
                            <x-select name="category_id" :required="true">
                                @foreach ($store_categories as $store_category)
                                    <x-select-option :value="$store_category->id" :title="$store_category->name"/>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                    <!--Sku-->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">Đơn vị</label>
                            <x-input name="sku" :value="old('sku')" :required="true" :placeholder="__('Đơn vị')"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="control-label">Trạng thái tồn kho:</label>
                            <x-select name="in_stock" :required="true">
                                @foreach ($stocks as $key => $value)
                                    <x-select-option :value="$key" :title="__($value)"/>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    @lang('Giá')
                </div>
                <div class="card-body row">
                    <!-- price -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">@lang('price')</label>
                            <x-input-price type="number"
                                           id="price"
                                           name="price"
                                           :value="old('price', 0)"/>
                        </div>
                    </div>
                    <!-- price_selling -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">@lang('priceSelling')</label>
                            <x-input-price type="number"
                                           name="price_selling"
                                           id="price_selling"
                                           :value="old('price_selling', 0)"/>
                        </div>
                    </div>
                    <!-- price_promotion -->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">@lang('pricePromotion')</label>
                            <x-input-price type="number"
                                           id="price_promotion"
                                           name="price_promotion"
                                           :value="old('price_promotion', 0)"/>
                        </div>
                    </div>
                    <!--qty-->
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="control-label">@lang('qty'):</label>
                            <x-input type="number" name="qty" :value="old('qty', 0)" :required="true"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    Mô tả
                </div>
                <div class="card-body row">
                    <!-- description -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="control-label">@lang('description')</label>
                            <textarea class="ckeditor visually-hidden"
                                      name="desc">
                                {{ old('desc') }}
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    Thư viện ảnh
                </div>
                <div class="card-body row">
                    <input type="file" onchange="showPreviewMultiImage()" multiple class="form-control mb-4" name="gallery[]" id="gallery-image" />

                    <div class="portfolio-item row" id="wrap-multi-image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-js')
    <script>
        function showPreviewMultiImage() {
            const fileInput = document.getElementById("gallery-image");
            const selectedFiles = fileInput.files;

            let images = '';

            for (let i = 0; i < selectedFiles.length; i++) {

                images += `
                    <div class="item gts col-lg-3 col-md-4 col-6 col-sm">
                            <a href="${URL.createObjectURL(selectedFiles[i])}" class="fancylight popup-btn" data-fancybox-group="light">
                                <img class="img-fluid" src="${URL.createObjectURL(selectedFiles[i])}" alt="">
                            </a>
                    </div>
                    `

            }
            console.log(images)
            $("#wrap-multi-image").append(images);
        }
    </script>
@endpush
