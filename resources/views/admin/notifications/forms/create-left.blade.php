<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- user_id -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('name')</label>
                    <x-select name="user_id[]" class="select2-bs5-ajax my-select2" :data-url="route('admin.search.select.user')" multiple>
                    </x-select>
                </div>
            </div>
            <!-- title -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('title')</label>
                    <x-input name="title" :value="old('title')"  :placeholder="__('title')" />
                </div>
            </div>
            <!-- message -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('message')</label>
                    <x-input name="message" :value="old('message')"  :placeholder="__('message')" />
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <x-input-checkbox onchange="onShowSelect2(this)" class="cb_sendAll" name="sendAll" label="Gửi tất cả"  />
                </div>
            </div>
        </div>
    </div>
</div>

