<script>
    function searchColumsDataTable(datatable) {
        datatable.api().columns([0, 1, 2, 3, 4, 5, 6]).every(function() {
            var column = this;
            var input = document.createElement("input");
            input.setAttribute('class', 'form-control');

            if (column.selector.cols == 5) {
                input = document.createElement("select");
                createSelectColumnUniqueDatatableAll(input, @json($type));
            }

            input.setAttribute('placeholder', 'Nhập từ khóa');

            $(input).appendTo($(column.footer()).empty())
                .on('change', function() {
                    column.search($(this).val(), false, false, true).draw();
                });
        });
    }
    $(document).ready(function() {
        // define columns for the datatables
        columns = window.LaravelDataTables["vehicleTable"].columns();
        toggleColumnsDatatable(columns);
    });
</script>
