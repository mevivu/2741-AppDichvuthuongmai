@if(isset($category['name']) && !empty($category['name']))
    <x-link :href="route('admin.store.category.edit', $category_id)" :title="$category['name']"/>
@else
    N/A
@endif
