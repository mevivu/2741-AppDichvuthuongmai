<script>
    function searchColumsDataTable(datatable) {
        datatable.api().columns([1, 2, 3, 4, 5, 6, 7]).every(function() {
            var column = this;
            var input = document.createElement("input");
            input.setAttribute('class', 'form-control');

            if (column.selector.cols == 3) {
                input.setAttribute('type', 'date');
            } else if (column.selector.cols == 4) {
                input.setAttribute('type', 'date');
            }else if (column.selector.cols == 5) {
                input = document.createElement("select");
                createSelectColumnUniqueDatatableAll(input, @json($status));
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
        columns = window.LaravelDataTables["discountCodeTable"].columns();
        toggleColumnsDatatable(columns);
    });
</script>
