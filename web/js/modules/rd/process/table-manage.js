/*   
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 1.9.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v1.9/admin/
*/

var handleDataTable = function() {
	"use strict";
    
    if ($('#data-table').length !== 0) {

        var  table = $('#data-table').DataTable({
            // dom: '<"top"iflp<"clear">>rt',
            dom: '<"top"ip<"clear">>t',
            processing:true,
            lengthMenu: [5, 10, 15],
            pageLength: 3,
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
                { "title": "Tipo/Tamaño",
                    // "data":"type_formate",
                },
                { "title": "Fecha Limite",
                  "data":"deliveryDate",
                },
                { "title": "Cliente",
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
            var status = dt.row(index.row, index.column).data().status;
            if(status !== 'PENDIENTE' && !moment(status).isValid())
            {
                alert('Este contenedor no puede ser seleccionado su estado es: ' + status);
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
};

var handleDataTable2 = function () {
    var columns = [
        { "title": "Contenedor",
            "data":"name",
        },
        { "title": "Tipo/Tamaño",
            // "data":"type_formate",
        },
        { "title": "Fecha Limite",
            "data":"deliveryDate",
        },
        { "title": "Cliente",
            "data":"agency"
        },
        { "title": "Empresa de Transporte",
            // "data":"transCompany"
        }
    ];
    // var multiple = $('#yesRadio').val();
    // if(multiple)
    // {
    //     columns.push({ "title": "Empresa de Transporte",
    //         "data":"transCompany"
    //     });
    // }

    if ($('#data-table2').length !== 0) {

        $('#data-table2').DataTable({
            // dom: '<"top"iflp<"clear">>rt',
            dom: '<"top"ip<"clear">>t',
            "columns": columns,
            processing:true,
            lengthMenu: [5, 10, 15],
            "pageLength": 3,
            "language": lan,
            responsive: true,
            columnDefs: [
                {
                    targets: [1],
                    // title:"Tipo",
                    data:null,
                    render: function ( data, type, full, meta ) {
                        // console.log("In render: " + data);
                        return data.type + data.tonnage;
                    },
                },
                {
                    targets: [4],
                    // title:"Tipo",
                    data:null,
                    render: function ( data, type, full, meta ) {
                        // console.log("In render: " + data);
                        return data.transCompany.name
                    },
                },

            ],
            // language: {url: 'web/plugins/DataTables/i18/Spanish.json'
        });
    }
};

var handleDataTable3 = function () {
    "use strict";
    // <th>Seleccione <input type="checkbox" name="select_all2" value="1" id="select-all"></th>
    // <th>Contenedores</th>
    // <th>Tipo/Tamaño</th>
    // <th>Fecha Límite</th>
    // <th>Cliente</th>
    // <th>Empresa de Transporte</th>
    if ($('#data-table3').length !== 0) {
        $('#data-table3').DataTable({
            dom: '<"top"ip<"clear">>t',
            processing:true,
            lengthMenu: [5, 10, 15],
            "pageLength": 3,
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
                    // "title": "Seleccione",
                    "data":'checkbox', // FIXME CHECK THIS
                },
                { "title": "Contenedor",
                    "data":"name",
                },
                { "title": "Tipo/Tamaño",
                },
                { "title": "Fecha Límite",
                    "data":"deliveryDate",
                },
                { "title": "Cliente",
                    "data":"agency"
                },
                { "title": "Empresa de Transporte",
                    "data":"transCompany"
                },
            ],
            columnDefs: [
                {
                    orderable: false,
                    searchable: false,
                    className: 'select-checkbox',
                    targets:   [0],
                    visible:false
                    // data: null,
                },
                {
                    targets: [2],
                    title:"Tipo",
                    data:null,
                    render: function ( data, type, full, meta ) {
                        return data.type + data.tonnage;
                    },
                },
                {
                    targets: [5],
                    // data:null,
                    render: function ( data, type, full, meta ) {
                        return data.name
                    },
                },
            ],
        });
    }

    var table3 = $('#data-table3').DataTable();
    table3.column(0).visible(false);
};

var TableManageTableSelect = function () {
	"use strict";
    return {
        //main function
        init: function () {
            handleDataTable();
            handleDataTable2();
            handleDataTable3();
        }
    };
}();


