/*   
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 1.9.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v1.9/admin/
*/

var blue		= '#348fe2',
    blueLight	= '#5da5e8',
    blueDark	= '#1993E4',
    aqua		= '#49b6d6',
    aquaLight	= '#6dc5de',
    aquaDark	= '#3a92ab',
    green		= '#00acac',
    greenLight	= '#33bdbd',
    greenDark	= '#008a8a',
    orange		= '#f59c1a',
    orangeLight	= '#f7b048',
    orangeDark	= '#c47d15',
    dark		= '#2d353c',
    grey		= '#b6c2c9',
    purple		= '#727cb6',
    purpleLight	= '#8e96c5',
    purpleDark	= '#5b6392',
    red         = '#ff5b57';

var handleWidgetOptions = function()
{
	"use strict";

    // element.style.display = 'none';           // Hide
    // element.style.display = 'block';          // Show
    // element.style.display = 'inline';         // Show
    // element.style.display = 'inline-block';   // Show

    // element.style.visibility = 'hidden';      // Hide
    // element.style.visibility = 'visible';     // Show

    console.log(role);

	if(role === 'Agencia')
    {
        document.getElementById('import').style.display = 'inline';
        document.getElementById('export').style.display = 'inline';
        document.getElementById('report').style.display = 'inline';
    }
    else if(role === 'Importador')
    {
        document.getElementById('import').style.display = 'inline';
        // document.getElementById('export').style.display = 'inline';
        document.getElementById('report').style.display = 'inline';
    }
    else if( role === 'Exportador')
    {
        // document.getElementById('import').style.display = 'inline';
        document.getElementById('export').style.display = 'inline';
        document.getElementById('report').style.display = 'inline';
    }
    else if( role === 'Importador_Exportador')
    {
        document.getElementById('import').style.display = 'inline';
        document.getElementById('export').style.display = 'inline';
        document.getElementById('report').style.display = 'inline';
    }
    else if(role === 'Cia_transporte')
    {
        document.getElementById('report').style.display = 'inline';
    }
    else if(role === 'Administrador_deposito' || role === 'Deposito')
    {
        document.getElementById('ticket').style.display = 'inline';
        document.getElementById('report').style.display = 'inline';
    }
    else if(role === 'Administracion')
    {
        document.getElementById('ticket').style.display = 'inline';
        document.getElementById('import').style.display = 'inline';
        document.getElementById('export').style.display = 'inline';
        document.getElementById('report').style.display = 'inline';
    }
};

var Dashboard = function () {
	"use strict";
    return {
        //main function
        init: function () {
            handleWidgetOptions();
        }
    };
}();

var fetchProcess = function () {
    $.ajax({
        url: containerFetchUrl,
        type: "get",
        dataType:'json',
        data: {
            'bl': bl,
            'type': processType,
        },
        success: function(response) {

        },
        error: function(response) {
            console.log(response);
            console.log(response.responseText);
            result = false;
        }
    });
};

var handleDataTable = function () {

    if ($('#data-table').length !== 0)
    {
        var table = $('#data-table').DataTable({
            // dom: '<"top"ip<"clear">>t',
            // dom: '<"top"ip<"clear">>t',
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
            "ajax": homeUrl + "/site/dashboardata",
            "dataSrc": function ( json )
            {
                for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
                    json.data[i][6] = '<a href="/message/'+json.data[i][0]+'>View message</a>';
                }
                return json.results;
            },
            "createdRow": function( row, data, dataIndex ) {

            },
            // deferRender:true,
            "columns": [
                {
                    "title": "Número del proceso",
                    "data":'id', // FIXME CHECK THIS
                },
                {   "title":'BL o Booking',
                    "data":"bl",
                },
                { "title": "Cliente",
                    "data":"agency_name"
                },
                { "title": "Fecha Límite",
                    "data":"delivery_date",
                },
                { "title": "Contenedores",
                    "data":"countContainer",
                },
                { "title": "Tipo",
                    "data":"type"
                },
                { "title": "Acciones",
                    "data":null
                },
            ],
            "order": [[ 3, 'des'], [ 0, 'des'] ],
            columnDefs: [
                {
                    orderable: true,
                    searchable: true,
                    targets:   [0,1,2,3,4,5]
                },
                {
                    targets: [3],
                    data:'delivery_date',
                    render: function ( data, type, full, meta ) {
                        return moment(data).format('DD-MM-YYYY');
                    },
                },
                {
                    targets: [5],
                    title:"Tipo",
                    data:"type",
                    render: function ( data, type, full, meta ) {
                        return data == 1 ?'Importación':'Exportación';
                    },
                },
                {
                    targets: [6],
                    // title:"Tipo",
                    data:null,
                    render: function ( data, type, full, meta ) {
                        var elementId =  String(full.id);
                        if(type == 'display')
                        {
                            var ticketClass = full.countContainer == full.countTicket ? 'btn-default':'btn-success';

                            var selectHtml = "<div class=\"row\">";
                            selectHtml += "<div class=\"col col-md-12\">" ;
                            selectHtml += "<div class=\"col col-md-5\">";

                            if(role == 'Importador_Exportador' || role == 'Administracion')
                            {
                                selectHtml += "<a " + "href=\"" + homeUrl + "/rd/process/view?id=" + elementId + "\" class=\"btn btn-info btn-xs\">Ver</a>";
                            }
                            selectHtml+= "</div>";
                            selectHtml += "<div class=\"col col-md-5\">";
                            if(role == 'Cia_transporte' || role == 'Administracion')
                            {
                                selectHtml += "<a " + "href=\"" + homeUrl + "/rd/ticket/create?id=" + elementId + "\" class=\"btn " + ticketClass + " btn-xs\">Turnos</a>";
                            }
                            selectHtml+= "</div>";
                            selectHtml+= "</div>";
                            selectHtml+= "</div>";

                            return selectHtml;
                        }
                        return "-";
                    },
                },
            ],
        });
        table.on('search.dt', function()
        {
            var process = "";
            var flag = 0;
            var separator = ''
            table.rows({filter:'applied'}).data().each( function ( value, index )
            {
                if(flag == 0) separator = '?';
                else separator ='&';
                process += separator + "process[]=" + value.id;
                flag++;
            });

            $('#print-process').attr('href', homeUrl + '/site/print' + process);
            console.log($('print-process').attr('href'));
        });
    }
};

$(document).ready(function () {
    Dashboard.init();
    handleDataTable();
});