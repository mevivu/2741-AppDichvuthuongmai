<x-input type="hidden"
         name="route_search_select_store_category"
         :value="route('admin.search.select.store_category')" />

<x-input type="hidden"
         name="route_search_select_area"
         :value="route('admin.search.select.area')" />
<script>
    $(document).ready(function(e) {
        select2LoadData($('input[name="route_search_select_store_category"]').val());
        select2LoadData($('input[name="route_search_select_area"]').val());
    });
</script>
