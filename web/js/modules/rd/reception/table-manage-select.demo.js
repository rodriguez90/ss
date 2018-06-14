/*   
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 1.9.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v1.9/admin/
*/

var handleDataTableSelect = function() {
	"use strict";
    
    if ($('#data-table').length !== 0) {
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
                    // "data":"type_formate",
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
            "language": lan,
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

    if ($('#data-table2').length !== 0) {
        $('#data-table2').DataTable({
            "columns": [
                { "title": "Contenedor",
                    "data":"name",
                },
                { "title": "Tipo",
                    // "data":"type_formate",
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
            "language": lan,
            responsive: true,
            columnDefs: [
                {
                    targets: [1],
                    title:"Tipo",
                    data:null,
                    render: function ( data, type, full, meta ) {
                        // console.log("In render: " + data);
                        return data.type + data.tonnage;
                    },
                },

            ],
            // language: {url: 'web/plugins/DataTables/i18/Spanish.json'
        });
    }
};

var TableManageTableSelect = function () {
	"use strict";
    return {
        //main function
        init: function () {
            handleDataTableSelect();
        }
    };
}();


