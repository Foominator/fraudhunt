jQuery(document).ready(function () {
    let table = $('#phones-table').DataTable({
        "order": [[$('th.created_at').index(), "desc"]],
        "pageLength": 15,
        "lengthChange": false,
        'sDom': 'lrtip'
    });
    $('#phones-table').show();
    $('#loader').hide();

    $('#phones-table-search').on('input', function () {
        table.search(this.value).draw();
    });
});
