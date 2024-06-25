<script>
    function createSelectColumnUniqueDatatableAll(select, options) {
        options.forEach(option => {
            var opt = document.createElement("option");
            opt.value = option;
            opt.text = option;
            select.appendChild(opt);
        });
    }

    function searchColumsDataTable(datatable) {
        datatable.columns([0, 1, 2, 3, 4]).every(function () {
            var column = this;
            var input;

            if (column.index() === 3) {
                input = document.createElement("input");
                input.setAttribute('type', 'date');
                input.setAttribute('class', 'form-control');
            } else if (column.index() === 2) {
                input = document.createElement("select");
                input.setAttribute('class', 'form-control');
                createSelectColumnUniqueDatatableAll(input, @json($status));
            } else {
                input = document.createElement("input");
                input.setAttribute('class', 'form-control');
                input.setAttribute('placeholder', 'Nhập từ khóa');
            }

            $(input).appendTo($(column.footer()).empty())
                .on('change', function () {
                    column.search($(this).val(), false, false, true).draw();
                });
        });
    }

    $(document).ready(function () {
        // Check if the DataTable is initialized and accessible
        if (window.LaravelDataTables && window.LaravelDataTables["storeCatTable"]) {
            var datatable = window.LaravelDataTables["storeCatTable"];

            // Add search inputs to the columns once the table is initialized
            datatable.on('init.dt', function () {
                searchColumsDataTable(datatable);
                toggleColumnsDatatable(datatable.columns());
            });
        } else {
            console.error("DataTable 'storeCatTable' is not defined.");
        }
    });
</script>
