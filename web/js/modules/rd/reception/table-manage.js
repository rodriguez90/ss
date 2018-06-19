/*   
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 1.9.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v1.9/admin/
*/

var handleDataTableSelect = function() {
	"use strict";
    
    if ($('#data-table').length !== 0) {

        var  table = $('#data-table').DataTable({
            dom: '<"top"iflp<"clear">>rt',
            processing:true,
            lengthMenu: [5, 10, 15],
            pageLength: 5,
            language: lan,
            select: {
                // items: 'cells',
                style:    'multi',
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]],
            responsive: true,
            // rowCallback: function( row, data, index ) {
            //     // console.log(data);
            //     if ( data.id !== -1) {
            //         // console.log(row);
            //         // /table.row(':eq(0)', { page: 'current' }).deselect();
            //         // row().select();
            //         // $('td:eq(0)', row).html( '<b>A</b>' );
            //     }
            // },
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
        });

        table.on( 'user-select', function ( e, dt, type, cell, originalEvent ) {
            // alert('user-select');
            var index = cell.index();
            // console.log(index);
            // console.log(dt.row(index.row, index.column).data());
            var id = dt.row(index.row, index.column).data().id;
            var name = dt.row(index.row, index.column).data().name;

            if(id !== -1 )
            {
                alert('Este contenedor ya fue seleccionado en uan recepción previa.')
                e.preventDefault();
                return false;
            }

            // var index = selectedContainers.indexOf(name);
            // if(index === -1) // seleccionando
            //     selectedContainers.push(name);
            // else // quitando selección
            // {
            //     selectedContainers.splice(name, 1);
            // }
            //
            // console.log(selectedContainers);

        } );

    }

    if ($('#data-table2').length !== 0) {
        $('#data-table2').DataTable({
            dom: '<"top"iflp<"clear">>rt',
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


