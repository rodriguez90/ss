/**
 * Created by pedro on 03/08/2018.
 */

var handleDataTable = function ()
{
    if ($('#data-table').length !== 0)
    {
        var table = $('#data-table').DataTable({
            dom: '<"top"i>flpt<"bottom"p><"clear">',
            pagingType: "full_numbers",
            processing:true,
            lengthMenu: [5, 10, 15],
            "pageLength": 10,
            "language": lan,
            responsive: true,
            rowId: 'id',
            // "processing": true,
            // "serverSide": true,
            "ajax": homeUrl + "/rd/ticket/list",
            // deferRender:true,
            "columns": [
                {
                    "title": "Número",
                    "data":'id',
                },
                {   "title":'Contenedor',
                    "data":"containerName",
                },
                { "title": "Typo",
                    "data":"containerType",
                },
                { "title": "Fecha del Turno",
                    "data":"ticketDate",
                },
                { "title": "Placa del Carro",
                    "data":"registerTruck",
                },
                { "title": "Chofer",
                    "data":"nameDriver",
                },
                { "title": "Cédula",
                    "data":"registerDriver",
                },
                { "title": "Estado",
                    "data":"status",
                },
                { "title": "Proceso",
                    "data":"processType",
                },
                // { "title": "Acciones",
                //     "data":null
                // },
            ],
            columnDefs: [
                {
                    orderable: true,
                    searchable: true,
                    targets:   [0,1,2,3,4,5,6,7,8]
                },
                {
                    targets: [3],
                    data:'ticketDate',
                    render: function ( data, type, full, meta )
                    {

                        return moment(data).format('DD-MM-YYYY');
                    },
                },
                {
                    targets: [7],
                    title:"Estado",
                    data:'status',
                    render: function ( data, type, full, meta )
                    {
                        if(type == 'display')
                        {
                            var customHtml = data == 1? '<span class="label label-success pull-left f-s-12">Emitido</span>' : '<span class="label label-danger f-s-12">Consumido</span>';

                            return customHtml;
                        }
                        return data == 1 ? 'Emitido':'Consumido';
                    },
                },
                {
                    targets: [8],
                    data:'processType',
                    render: function ( data, type, full, meta )
                    {
                        return data == 1 ? 'Importación':'Exportación';
                    },
                },
                // {
                //     targets: [9],
                //     data:null,
                //     render: function ( data, type, full, meta ) {
                //         var elementId =  String(full.id);
                //         if(type == 'display')
                //         {
                //             var ticketClass = full.countContainer == full.countTicket ? 'btn-default':'btn-success';
                //
                //             var selectHtml = "<div class=\"row row-space-2\">";
                //             selectHtml += "<div class=\"col col-md-12\">" ;
                //             selectHtml += "<a " + "href=\"" + homeUrl + "/rd/ticket/view?id=" + elementId + "\" class=\"btn btn-info btn-icon btn-circle btn-sm\" title=\"Ver\"><i class=\"fa fa-eye\"></i></a>";
                //             selectHtml += "<a " + "href=\"" + homeUrl + "/rd/ticket/update?id=" + elementId + "\" class=\"btn btn-success btn-icon btn-circle btn-sm\" title=\"Editar\"><i class=\"fa fa-edit\"></i></a>";
                //             selectHtml += "<a data-confirm=\"¿Está seguro de eliminar este turno ?\" data-method=\"post\"" + " href=\"" + homeUrl + "/rd/ticket/delete?id=" + elementId + "\" class=\"btn btn-danger btn-icon btn-circle btn-sm\" title=\"Eliminar\"><i class=\"fa fa-trash\"></i></a>";
                //             selectHtml += "</div>";
                //             selectHtml += "</div>";
                //
                //             return selectHtml;
                //         }
                //         return "-";
                //     },
                // },
            ],
        });
    }
};

$(document).ready(function () {
    handleDataTable();
});