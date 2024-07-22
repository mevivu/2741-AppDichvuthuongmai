<!-- <a type="button" class="btn btn-info" href="{{ route('store.product.draft', $id) }}">
    draft
</a> -->
<x-button.modal-delete class="btn-icon" data-route="{{ route('store.product.delete', $id) }}">
    <i class="ti ti-trash"></i>
</x-button.modal-delete>
