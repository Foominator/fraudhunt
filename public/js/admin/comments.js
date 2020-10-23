jQuery(document).ready(function () {
    let table = $('#comments-table').DataTable({
        "order": [[6, "desc"]],
        "pageLength": 15,
        "lengthChange": false,
        'sDom': 'lrtip'
    });

    $('#comments-table-search').on('input', function () {
        table.search(this.value).draw();
    });
});
