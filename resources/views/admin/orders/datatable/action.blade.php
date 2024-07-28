<div class="d-flex">
    @if ($status == App\Enums\Order\OrderStatus::Pending->value)
        <a href="{{ route('admin.order.confirm', $id) }}" class="ml-2">
            <x-button type="button" class="btn-info btn-icon">
                <i class="ti ti-bookmark"></i>
            </x-button>
        </a>
    @endif
    @if($status != App\Enums\Order\OrderStatus::Cancelled->value)
        <a style="margin-left: 0.3rem" href="{{ route('admin.order.cancel', $id) }}" class="ml-2">
            <x-button type="button" class="btn-danger btn-icon">
                <i class="ti ti-arrow-down"></i>
            </x-button>
        </a>
    @endif
    <x-button.modal-delete style="margin-left: 0.3rem" class="btn-icon" data-route="{{ route('admin.order.delete', $id) }}">
        <i class="ti ti-trash"></i>
    </x-button.modal-delete>
</div>
