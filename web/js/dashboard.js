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

var handleWidgetOptions = function() {
	"use strict";

};


var handleTableByOption = function (option) {

    switch (option)
    {
        case 1: // receptions
        {

            break;
        }
    }
};


var tableByOption = function(option)
{
    var table = $('#data-table').DataTable();
    table.destroy();

    var columns;

    switch (option)
    {
        case 1: // reception
        {
            columns = [
                ""
            ];
            break;
        }
        case 2: // dispatch
        {
            break;
        }
        case 3: // report
        {
            break;
        }
    }

    $('#data-table').DataTable({
        "columns": [
            {
                // "title": "Selecionar",
                "data":'checkbox', // FIXME CHECK THIS
            },
            { "title": "Contenedor",
                "data":"name",
            },
            { "title": "Tipo",
            },
            { "title": "Fecha Limite",
                "data":"deliveryDate",
            },
            { "title": "Agencia",
                "data":"agency"
            },
        ],
        processing:true,
        lengthMenu: [5, 10, 15],
        "pageLength": 5,
        "language": {
            "lengthMenu": "Mostrar _MENU_ filas por página",
            "zeroRecords": "No hay datos que mostrat - disculpe",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay información que mostrar",
            // "infoFiltered": "(encontrados from _MAX_ total records)"
        },
        // select: true,
        responsive: true,
        // language: {url: 'web/plugins/DataTables/i18/Spanish.json'
        //
        // },
        columnDefs: [
            {
                orderable: false,
                searchable: false,
                className: 'select-checkbox',
                targets:   [0],
                // data: null,
            },
            {
                targets: [2],
                title:"Tipo",
                data:null,
                render: function ( data, type, full, meta ) {
                    // console.log("In render: " + data);
                    return data.type + data.tonnage;
                },
            },

        ],
        select: {
            // items: 'cells',
            style:    'multi',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]]
    });
}

var Dashboard = function () {
	"use strict";
    return {
        //main function
        init: function () {
            handleWidgetOptions();
        }
    };
}();


$(document).ready(function () {
    Dashboard.init();
});