<p><strong>@lang('openHour') 1</strong>: {{ $store->operatingTime1() }}</p>
@if($store->operatingTime2())
    <p><strong>@lang('openHour') 2</strong>: {{ $store->operatingTime2() }}</p>
@endif