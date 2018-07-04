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
            deferRender: false,
            rowCallback: function( row, data, index ) {
                    console.log("rowCallback to: " + data.name);
            },
            createdRow: function( row, data, dataIndex ) {
                console.log('init select2: ' + data.name);
                if (!data.selectable ) {
                    $('td', row).eq(0).removeClass('select-checkbox');
                    $(row).addClass('bg-silver-darker');
                }
                else {
                    var elementId =  String(data.name).replace(' ','');
                    if(processType === "2")
                    {
                        var  html = '<input type=\"text\" class=\"form-control\" id=\"' + elementId +  '\" placeholder=\"Seleccionar\"' + 'value=\"' + moment(data.deliveryDate).format('DD/MM/YYYY') + '\" >';

                        $('td', row).eq(3).html(html)

                        $('td:eq(3)', row).datepicker({
                            title:"Seleccione la Fecha Límite",
                            language: 'es',
                            // format: 'dd/mm/yyyy',
                            // todayHighlight: true,
                            autoclose: true,
                            immediateUpdates:true,
                            // startDate: '-3d',
                            // zIndexOffset:20
                            // container:"#data-table"
                            // toggleActive:true
                        }).on('changeDate', function(event){
                            // var dateValue = moment(event.date).format('DD/MM/YYYY');
                            var dateValue = moment(event.date).format('YYYY/MM/DD');
                            // console.log(row);
                            // console.log($(row));
                            // console.log(data);
                            // console.log(index);
                            // console.log(dateValue);
                            data.deliveryDate = dateValue;
                            table.row(index).data(data)
                        });
                    }
                    // $('td:eq(2)', row).select2(
                    // $('td', row).eq(2).select2(
                    $('select', row).select2(
                    {
                        language: "es",
                        placeholder: 'Seleccione Tipo de Contenedor',
                        width: '100%',
                        closeOnSelect: true,
                        data:containerTypeArray,
                        }).on('select2:select', function (e) {
                            var type = e.params.data;
                            var containerType = {
                                id:type.id,
                                name:type.text
                            };
                            containertDataMap.set(data.name,containerType);

                            // $('#mySelect2').val(type.id); // Select the option with a value of '1'
                            // $('#mySelect2').trigger('change:select2'); // Notify any JS components that the value changed
                            // table.row(dataIndex).data(data); -- esto prococa que la fila se repinte de nuevo y x tango perdemos la inicializacion del select
                            // return true;
                    });
                }
            },
            columns: [
                {
                    // "title": "Selecionar",
                   "data":'checkbox', // FIXME CHECK THIS
                },
                { "title": "Contenedor",
                   "data":"name",
                },
                { "title": "Tipo/Tamaño",
                    "data":"type",
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
                },
                {
                    targets: [2],
                    data:'type',
                    render: function ( data, type, full, meta ) {
                        var elementId =  String(full.name).trim();
                        console.log("render: " + elementId + " " + type);
                        if(type == 'display' && full.selectable)
                        {
                            // var api =  new $.fn.dataTable.Api(meta.settings);
                             // api.cell({row: meta.row, column:2}).data(trunk.id);
                             // var row = api.row({row:meta.row});
                             var selectHtml = "<select class=\"form-control\" id=\"selectType" +elementId + "\"></select>";
                            // setTimeout(function() {
                            //     $('select', row).select2(
                            //         // $('td', row).eq(2).select2(
                            //         {
                            //             language: "es",
                            //             placeholder: 'Seleccione Tipo de Contenedor',
                            //             width: '100%',
                            //             closeOnSelect: true,
                            //             data:containerTypeArray,
                            //         }).on('select2:select', function (e) {
                            //             var type = e.params.data;
                            //             data.type = {
                            //                 id:type.id,
                            //                 name:type.text
                            //             };
                            //
                            //
                            //             //table.row(index).data(data); // esto prococa que la fila se repinte de nuevo y x tango perdemos la inicializacion del select
                            //             api.cell({row: meta.row, column:2}).data(data);
                            //             return true;
                            //         });
                            //     $('select', row).val(data.id); // Select the option with a value of '1'
                            //     $('select', row).trigger('change:select2'); // Notify any JS components that the value changed
                            // }, 200);
                            return selectHtml;
                        }
                        return data.name;
                    },
                },
                {
                    targets: [3],
                    data:'deliveryDate',
                    render: function ( data, type, full, meta ) {
                        return moment(data).format("DD/MM/YYYY");
                    },
                },
            ],
        });

        table.on( 'user-select', function ( e, dt, type, cell, originalEvent ) {
            // alert('user-select');
            var index = cell.index();
            // console.log(index);
            // console.log(dt.row(index.row, index.column).data());
            // var id = dt.row(index.row, index.column).data().id;
            // var name = dt.row(index.row, index.column).data().name;
            // var status = dt.row(index.row, index.column).data().status;
            // if(status !== 'PENDIENTE' && !moment(status).isValid())
            if(dt.row(index.row, index.column).data().selectable == false)
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
            "data":"type",
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
                    title:"Tipo",
                    data:"type",
                    render: function ( data, type, full, meta ) {
                        return data.name;
                    },
                },
                {
                    targets: [2],
                    data:'deliveryDate',
                    render: function ( data, type, full, meta ) {
                        return moment(data).format("DD/MM/YYYY");
                    },
                },
                {
                    targets: [4],
                    data:null,
                    render: function ( data, type, full, meta ) {
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
                    "data":"type"
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
                    data:"type",
                    render: function ( data, type, full, meta ) {
                        console.log("RENDER TYPE TABLE 3");
                        console.log(data);
                        return data.name;
                    },
                },
                {
                    targets: [3],
                    data:'deliveryDate',
                    render: function ( data, type, full, meta ) {
                        return moment(data).format("DD/MM/YYYY");
                    },
                },
                {
                    targets: [5],
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


