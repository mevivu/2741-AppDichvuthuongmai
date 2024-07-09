<x-input type="hidden" id="userRoute" name="route_search_select_user" :value="route('admin.search.select.user')" />

<script>
    $(document).ready(function() {
        select2LoadData($('#userRoute').val(), '.select2-bs5-ajax[name="user_id[]"]');
    });
</script>
