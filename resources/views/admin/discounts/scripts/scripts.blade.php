<x-input type="hidden" name="route_search_select_user" :value="route('admin.search.select.user')" />
<x-input type="hidden" name="route_search_select_store" :value="route('admin.search.select.store')" />
<script>
    $(document).ready(function(e) {
        select2LoadData($('input[name="route_search_select_user"]').val());
        select2LoadData($('input[name="route_search_select_store"]').val());

    });
</script>
