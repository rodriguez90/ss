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
            "ajax": homeUrl + "/administracion/user/list",
            // deferRender:true,
            "columns": [
                {
                    "title": "Usuario",
                    "data":'username',
                },
                {   "title":'Nombre',
                    "data":"nombre",
                },
                { "title": "Apellidos",
                    "data":"apellidos",
                },
                { "title": "Email",
                    "data":"email",
                },
                { "title": "Fecha de Creación",
                    "data":"created_at",
                },
                { "title": "Estado",
                    "data":"status",
                },
                { "title": "Rol",
                    "data":"role",
                },
                { "title": "Acciones",
                    "data":null
                },
            ],
            columnDefs: [
                {
                    orderable: true,
                    searchable: true,
                    targets:   [0,1,2,3,4,5,6]
                },
                {
                    targets: [4],
                    data:'created_at',
                    render: function ( data, type, full, meta )
                    {

                        return moment(data).format('DD-MM-YYYY');
                    },
                },
                {
                    targets: [5],
                    title:"Estado",
                    data:'status',
                    render: function ( data, type, full, meta )
                    {
                        if(type == 'display')
                        {
                            var customHtml = data == 1? '<span class="label label-success pull-left f-s-12">Activo</span>' : '<span class="label label-danger f-s-12">Inactivo</span>';

                            return customHtml;
                        }
                        return data == 1 ? 'Activo':'Inactivo';
                    },
                },
                {
                    targets: [7],
                    data:null,
                    render: function ( data, type, full, meta ) {
                        var elementId =  String(full.id);
                        if(type == 'display')
                        {
                            var ticketClass = full.countContainer == full.countTicket ? 'btn-default':'btn-success';

                            var selectHtml = "<div class=\"row row-space-2\">";
                            selectHtml += "<div class=\"col col-md-12\">" ;
                            // selectHtml += "<div class=\"col col-md-3\">";
                            selectHtml += "<a " + "href=\"" + homeUrl + "/administracion/user/view?id=" + elementId + "\" class=\"btn btn-info btn-icon btn-circle btn-sm\" title=\"Ver\"><i class=\"fa fa-eye\"></i></a>";
                            // selectHtml+= "</div>";
                            // selectHtml += "<div class=\"col col-md-3\">";
                            selectHtml += "<a " + "href=\"" + homeUrl + "/administracion/user/update?id=" + elementId + "\" class=\"btn btn-success btn-icon btn-circle btn-sm\" title=\"Editar\"><i class=\"fa fa-edit\"></i></a>";
                            // selectHtml+= "</div>";
                            // selectHtml += "<div class=\"col col-md-3\">";
                            selectHtml += "<a data-confirm=\"¿Está seguro de eliminar este usuario ?\" data-method=\"post\"" + " href=\"" + homeUrl + "/administracion/user/delete?id=" + elementId + "\" class=\"btn btn-danger btn-icon btn-circle btn-sm\" title=\"Eliminar\"><i class=\"fa fa-trash\"></i></a>";
                            // selectHtml+= "</div>";
                            selectHtml+= "</div>";
                            selectHtml+= "</div>";

                            return selectHtml;
                        }
                        return "-";
                    },
                },
            ],
        });

        // table.on('search.dt', function()
        // {
        //     var process = "";
        //     var flag = 0;
        //     var separator = ''
        //     table.rows({filter:'applied'}).data().each( function ( value, index )
        //     {
        //         if(flag == 0) separator = '?';
        //         else separator ='&';
        //         process += separator + "process[]=" + value.id;
        //         flag++;
        //     });
        //
        //     $('#print-process').attr('href', homeUrl + '/site/print' + process);
        //     console.log($('print-process').attr('href'));
        // });
    }
};

$(document).ready(function () {
    handleDataTable();
});