

const tableCategory = $("#tableCategory").DataTable({
    responsive: true,
    dom:
        "<'row'<'col-lg-9 col-md-9 col-xs-12'f><'col-lg-3 col-md-3 col-xs-12'l>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    "language": {
        "lengthMenu": "_MENU_ ",
        "search": "",
        "searchPlaceholder": "Search",
    },
});

const filterGlobal = () => {
    let filter = document.querySelector('#global_filter');
    if(tableCategory) {
        tableCategory.search(filter.value).draw();
    }
};

const addNewRowCat = (row) => {
    let parent = "";
    if(row.parent && row.parent.uuid) {
        parent = row.parent.name
    }
    const newRow = tableCategory.row.add([row.name, parent, row.action]).draw(false).node();
    $(newRow).find('td:eq(2)').addClass('action-td');
    tableCategory.order([2, 'desc']).draw(false);
}

document.querySelector('#global_filter').addEventListener('input', filterGlobal);