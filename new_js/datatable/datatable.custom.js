function startDataTable(table_id, url, config = {}, full_config = false) {
 
    var table;
    var order = [[0, "desc"]];
    var columns = []
    var lengthMenu = [5, 10, 25, 50, 100, 150, 200];
    var length = 10;
    var data = {};
    //['colvis','copy', 'excel', 'pdf']
    var buttons = ['colvis'];
    if (config.columns) {
        columns = config.columns
    }
    if (config.order) {
        order = config.order
    }
    if (config.lengthMenu) {
        lengthMenu = config.lengthMenu
    }
    if (config.length) {
        iDisplayLength = config.length
    }
    if (config.buttons) {
        buttons = config.buttons
    }
    if (config.data) {
        data = config.data
    }

    if (full_config == false) {

        table = $("#" + table_id).DataTable({
            "language": dataTable_lang,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: url,
                data: data,
                pages: 1,
                length:length


            },
            "searching": true,
            "sort": true,
            "pageLength": length,
            "lengthMenu": lengthMenu,

            "columns": columns,
            "order": order,
             "buttons":  buttons
        });
        return table;
}
    else {
    table = $("#" + table_id).DataTable(full_config);
    return table;
}
return table;
}
function reloadDataTable(table_id) {
    $("#" + table_id).DataTable().ajax.reload();
}
$(document).ready(function() {
$('#data-table-one').DataTable({
    "language": dataTable_lang,
    "buttons": ['colvis','copy', 'excel', 'pdf']
});
});