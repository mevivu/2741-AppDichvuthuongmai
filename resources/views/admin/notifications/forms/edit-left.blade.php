<div class="col-12 col-md-9">
    <div class="card">
        <div class="row card-body">
            {{-- @if ($notification->driver_id)
            <!-- driver -->
            <div id="notification-driver-select" class="col-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Tài xế') }}</label>
                    <x-select class="select2-bs5-ajax" name="driver_id" :value="old('driver_id')">
                        <x-select-option value="" :title="__('Chọn tài xế')" selected />
                        @foreach ($drivers as $item)
                            <x-select-option :selected="$item->id == $notification->driver_id" :value="$item->id" :title="$item->user->fullname . ' - ' . $item->user->phone" />
                        @endforeach
                    </x-select>
                </div>
            </div>
            @endif
            @if ($notification->parent_id)
            <!-- parent -->
            <div id="notification-parent-select" class="col-12">
                <div class="mb-3">
                    <label class="control-label">{{ __('Phụ huynh') }}</label>
                    <x-select class="select2-bs5-ajax" name="parent_id" :value="old('parent_id')">
                        <x-select-option value="" :title="__('Chọn phụ huynh')" selected />
                        @foreach ($parents as $item)
                            <x-select-option :selected="$item->id == $notification->parent_id" :value="$item->id" :title="$item->user->fullname . ' - ' . $item->user->phone" />
                        @endforeach
                    </x-select>
                </div>
            </div>
            @endif --}}
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
