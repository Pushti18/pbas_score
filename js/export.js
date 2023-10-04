// $(document).ready(function () {
//     $(".dataExport").click(function () {
//         var exportType = $(this).data('type');
//         $('#dataTable').tableExport({
//             type: exportType,
//             escape: 'false',
//             ignoreColumn: []
//         });
//     });
// });

$("#rp_details_table").table2excel({
    filename: "excel_sheet-name.xls"
});