<script>

    $(document).ready(function() {
        // define columns for the datatables
        columns = window.LaravelDataTables[$("input[name=id_table]").val()].columns();
        toggleColumnsDatatable(columns);
    });
    function searchColumsDataTable(datatable) {
        var columns = datatable.api().columns().header().toArray();

        console.log(columns)
        datatable.api().columns([0, 1]).every(function () {
            var column = this;
            var input = document.createElement("input");
            input.setAttribute('class', 'form-control');
            if (column.selector.cols == 1) {
                input.setAttribute('type', 'date');
            }

            input.setAttribute('placeholder', 'Nhập từ khóa');


            $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val(), false, false, true).draw();
                });
        });
    }


</script>
