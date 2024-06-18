<x-input type="hidden" name="route_search_select_user" :value="route('admin.search.select.user')" />
<script>
    $(document).ready(function(e) {
        select2LoadData($('input[name="route_search_select_user"]').val());
    });
</script>
