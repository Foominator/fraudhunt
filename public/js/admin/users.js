jQuery(document).ready(function () {
    let table = $('#users-table').DataTable({
        "order": [[$('th.created_at').index(), "desc"]],
        "pageLength": 15,
        "lengthChange": false,
        'sDom': 'lrtip'
    });
    $('#users-table').show();
    $('#loader').hide();

    $('#users-table-search').on('input', function () {
        table.search(this.value).draw();
    });
});
