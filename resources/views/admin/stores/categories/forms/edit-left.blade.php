<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- name -->
            <div class="col-md-12 col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('name'):</label>
                    <x-input name="name" :value="$category->name" :required="true"
                        :placeholder="__('name')" />
                </div>
            </div>
            <!-- position -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('position'):</label>
                    <x-input type="number" name="position" :value="$category->position" :required="true" />
                </div>
            </div>
        </div>
    </div>
</div>