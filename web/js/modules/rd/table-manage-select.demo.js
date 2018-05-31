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
                    "data":"type",
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
            columnDefs: [ {
                orderable: false,
                searchable: false,
                className: 'select-checkbox',
                targets:   0,
                // data: null,
            },],
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
            select: true,
            responsive: true
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


