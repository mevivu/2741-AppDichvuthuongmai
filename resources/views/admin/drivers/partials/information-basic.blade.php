<div class="row card-body">
    <!-- Fullname -->
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('fullname'):</label>
            <x-input name="user_info[fullname]" :value="$driver->user->fullname" :required="true"
                     placeholder="{{ __('Họ và tên') }}"/>
        </div>
    </div>

    <!-- email -->
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('email'):</label>
            <x-input-email name="user_info[email]" :value="$driver->user->email" :required="true"/>
        </div>
    </div>

    <!-- phone -->
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('phone'):</label>
            <x-input-phone name="user_info[phone]" :value="$driver->user->phone" :required="true"/>
        </div>
    </div>

    <!-- gender -->
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('gender'):</label>
            <x-select name="user_info[gender]" :required="true">
                @foreach ($gender as $key => $value)
                    <x-select-option :option="$driver->user->gender->value" :value="$key" :title="__($value)"/>
                @endforeach
            </x-select>
        </div>
    </div>
   <!-- new password -->
   <div class="col-md-6 col-12">
       <div class="mb-3">
           <label class="control-label">@lang('password'):</label>
           <x-input-password name="user_info[password]"/>
       </div>
   </div>
   <!-- new password confirmation-->
   <div class="col-md-6 col-12">
       <div class="mb-3">
           <label class="control-label">@lang('passwordConfirm'):</label>
           <x-input-password name="user_info[password_confirmation]"
                             data-parsley-equalto="input[name='user_info[password]']"
                             data-parsley-equalto-message="{{ __('passwordMismatch') }}"/>
       </div>
   </div>
    <!-- birthday -->
    <div class="col-md-6 col-12">
        <div class="mb-3">
            <label class="control-label">@lang('birthday'):</label>
            <x-input type="date" name="user_info[birthday]"
                     :value="isset($driver->user->birthday) ? format_date($driver->user->birthday, 'Y-m-d') : null"
                     required="true"/>
        </div>
    </div>

    <!-- address -->
    <div class="col-12">
        <div class="mb-3">
            <x-input-pick-address :label="trans('address')" name="address"
                                  :value="$driver->user->address"
                                  :placeholder="trans('pickAddress')" :required="true"/>
            <input type="hidden" name="lat" value="{{$driver->user->latitude}}"/>
            <input type="hidden" name="lng" value="{{$driver->user->longitude}}"/>
        </div>
    </div>

</div>
