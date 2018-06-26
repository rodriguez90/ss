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
            //     if ( data.selectable) {
            //         console.log("Seletectable");
            //         // /table.row(':eq(0)', { page: 'current' }).deselect();
            //         // row().select();
            //         // $('td:eq(0)', row).html( '<b>A</b>' );
            //         if(processType === "2")
            //         {
            //             var elementId =  String(data.name).replace(' ','');
            //
            //             console.log("element length " + $('#' + elementId).length);
            //             console.log($('#' + elementId));
            //
            //             if($('#' + elementId).length <= 0)
            //             {
            //
            //                 console.log("Element Id: " + elementId)
            //                 console.log($('td:eq(3)', row).html());
            //
            //                 var  html = '<input type=\"text\" class=\"form-control\" id=\"' + elementId +  '\" placeholder=\"Fecha Límite\"' + 'data-date-format=\"dd/mm/yyyy\"' + '/>';
            //
            //                 console.log(html);
            //
            //                 $('td', row).eq(3).html(html)
            //                 // $('td:eq(3)', row).html(html);
            //
            //                 console.log($('td:eq(3)', row).html());
            //
            //                 $('#' + elementId).datepicker({
            //                     title:"Seleccione la Fecha Límite",
            //                     language: 'es',
            //                     todayHighlight: true,
            //                     autoclose: true,
            //                     toggleActive:true
            //                 });
            //             }
            //         }
            //     }
            // },
            "createdRow": function ( row, data, index, cells ) {
                if (!data.selectable ) {
                    // $('td', row).eq(5).addClass('bg-silver-darker');
                    $('td', row).eq(0).removeClass('select-checkbox');
                    // console.log(row);
                    $(row).addClass('bg-silver-darker');
                }
                else {
                    console.log("Seletectable");
                    // /table.row(':eq(0)', { page: 'current' }).deselect();
                    // row().select();
                    // $('td:eq(0)', row).html( '<b>A</b>' );
                    if(processType === "2")
                    {
                        var elementId =  String(data.name).replace(' ','');

                        console.log("Element Id: " + elementId)
                        console.log("element length " + $('#' + elementId).length);
                        console.log($('#' + elementId));

                        if($('#' + elementId).length === 0)
                        {
                            console.log($('td:eq(3)', row).html());

                            // var  html = '<input type=\"text\" class=\"form-control\" id=\"' + elementId +  '\" placeholder=\"Fecha Límite\"' + ' data-provide=\"datepicker-inline\"' + '/>';
                            var  html = '<input type=\"text\" class=\"form-control\" id=\"' + elementId +  '\" placeholder=\"Seleccionar\"' + 'value=\"' + data.deliveryDate + '\" >';
                            console.log("Generate HTML: ")
                            console.log(html);

                            $('td', row).eq(3).html(html)
                            // $('td:eq(3)', row).html(html);

                            console.log($('td:eq(3)', row).html());

                            // $('#' + elementId).datepicker({
                            //     title:"Seleccione la Fecha Límite",
                            //     language: 'es',
                            //     format: 'dd/mm/yyyy',
                            //     // todayHighlight: true,
                            //     autoclose: true,
                            //     startDate: '-3d',
                            //     // zIndexOffset:20
                            //     container:"#data-table"
                            //     // toggleActive:true
                            // });

                            $('td:eq(3)', row).datepicker({
                                title:"Seleccione la Fecha Límite",
                                language: 'es',
                                format: 'dd/mm/yyyy',
                                // todayHighlight: true,
                                autoclose: true,
                                immediateUpdates:true,
                                // startDate: '-3d',
                                // zIndexOffset:20
                                // container:"#data-table"
                                // toggleActive:true
                            });

                            console.log("After Initialized: ")
                            console.log($('#' + elementId));
                        }
                    }
                }
            },
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


