jQuery(document).ready(function () {
    let table = $('#cards-table').DataTable({
        "order": [[$('th.created_at').index(), "desc"]],
        "pageLength": 15,
        "lengthChange": false,
        'sDom': 'lrtip'
    });
    $('#cards-table').show();
    $('#loader').hide();

    $('#cards-table-search').on('input', function () {
        table.search(this.value).draw();
    });
});
