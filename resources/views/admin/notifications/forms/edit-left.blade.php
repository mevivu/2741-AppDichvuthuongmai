<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            <!-- user_id -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('name')</label>
                    <x-select name="user_id" class="select2-bs5-ajax-many" :data-url="route('admin.search.select.user')"
                              :required="true">
                        <x-select-option :option="$notification->user_id" :value="$notification->user_id"
                                         :title="$notification->user->fullname"/>
                    </x-select>
                </div>
            </div>
            <!-- title -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('title')</label>
                    <x-input :value="$notification->title" name="title"  :required="true" :placeholder="__('title')" />
                </div>
            </div>
            <!-- message -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="control-label">@lang('message')</label>
                    <x-input :value="$notification->message" name="message"  :required="true" :placeholder="__('message')" />
                </div>
            </div>

        </div>
    </div>
</div>
