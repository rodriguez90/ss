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

var handleDataTable = function () {

    if ($('#data-table').length !== 0)
    {
        $('#data-table').DataTable({
            dom: '<"top"ip<"clear">>t',
            processing:true,
            lengthMenu: [5, 10, 15],
            "pageLength": 10,
            "language": lan,
            responsive: true,
            rowId: 'name',
            select: {
                // items: 'cells',
                style:    'multi',
                selector: 'td:first-child'
            },
            "columns": [
                {
                    "title": "Número del proceso",
                    "data":'id', // FIXME CHECK THIS
                },
                {   "title":'BL o Booking',
                    "data":"bl",
                },
                { "title": "Cliente",
                    "data":"agency"
                },
                { "title": "Fecha Límite",
                    "data":"deliveryDate",
                },
                { "title": "Contenedores",
                    "data":"containerAmount",
                },
                { "title": "Tipo",
                    "data":"type"
                },
                { "title": "Acciones",
                    // "data":"transCompany"
                },
            ],
            columnDefs: [
                {
                    orderable: true,
                    searchable: true,
                    targets:   [0,1,2,3,4,5],
                },
                {
                    targets: [2],
                    title:"Tipo",
                    data:"type",
                    render: function ( data, type, full, meta ) {
                        return data;
                    },
                },
                {
                    targets: [3],
                    data:'deliveryDate',
                    render: function ( data, type, full, meta ) {
                        return data;
                    },
                },
                {
                    targets: [5],
                    render: function ( data, type, full, meta ) {
                        return data
                    },
                },
            ],
        });
    }
};


$(document).ready(function () {
    Dashboard.init();

    handleDataTable();

});