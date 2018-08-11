

/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 1.9.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v1.9/admin/
*/

var colHeaderContainer = processType == 1 ? 'Contenedor' : 'Booking/Contenedor' ;

var handleDataTable = function() {
	"use strict";
    
    if ($('#data-table').length !== 0) {

        var  table = $('#data-table').DataTable({
            // dom: '<"top"iflp<"clear">>rt',
            dom: '<"top"ip<"clear">>t',
            processing:true,
            lengthMenu: [5, 10, 15],
            pageLength: 10,
            language: lan,
            select: {
                // items: 'cells',
                style:    'multi',
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]],
            responsive: true,
            deferRender: true,
            rowCallback: function( row, data, index ) {
                    // console.log("rowCallback to: " + data.name);
            },
            createdRow: function( row, data, dataIndex ) {
                // console.log('init select2: ' + data.name);
                if (!data.selectable ) {
                    $('td', row).eq(0).removeClass('select-checkbox');
                    $(row).addClass('text-danger');
                }
                else {
                    // var elementId =  String(data.name).replace(' ','');
                    // if(processType == 2)
                    // {
                    //     // var  html = '<input type=\"text\" class=\"form-control\" id=\"' + elementId +  '\" placeholder=\"Seleccionar\"' + 'value=\"' + moment(data.deliveryDate).format('DD/MM/YYYY') + '\" >';
                    //
                    //     // $('td', row).eq(3).html(html)
                    //
                    //     $('td:eq(3)', row).datepicker({
                    //         title:"Seleccione la Fecha Límite",
                    //         language: 'es',
                    //         autoclose: true,
                    //         immediateUpdates:true,
                    //         format:'dd-mm-yyyy'
                    //     }).on('changeDate', function(event){
                    //         // console.log(event.date);
                    //         // console.log(dateValue);
                    //         var dateValue = moment(event.date).utc().format('DD-MM-YYYY');
                    //         var mDateValue = moment(event.date)
                    //         var mProcessDD = moment(processDeliveryDate)
                    //         console.log("Container deliveryDate: " + dateValue);
                    //         console.log("Current deliveryDate: " + processDeliveryDate);
                    //         var result = mDateValue.isAfter(mProcessDD);
                    //         console.log(result);
                    //         if(result)
                    //         {
                    //             console.log("Change processDeliveryDate: " + dateValue);
                    //             processDeliveryDate = dateValue;
                    //         }
                    //         // data.deliveryDate = dateValue;
                    //         table.cell(dataIndex, 3).data(dateValue)
                    //     });
                    // }
                    if(processType == 1)
                    {
                        // $('td:eq(2)', row).select2(
                        // $('td', row).eq(2).select2(
                        // console.log(data);
                        // console.log(data.type);
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
							// console.log(containerType);
                            containertDataMap.set(data.name,containerType);

                            // $('#mySelect2').val(type.id); // Select the option with a value of '1'
                            // $('#mySelect2').trigger('change:select2'); // Notify any JS components that the value changed
                            // table.row(dataIndex).data(data); -- esto prococa que la fila se repinte de nuevo y x tango perdemos la inicializacion del select
                            // return true;
                        }).val(data.type.id).trigger('change');
                        // $('select', row).val(data.type.id); // Select the option with a value of '1'
                        // $('select', row).trigger('change:select2'); // Notify any JS components that the value changed
                    }
                }
            },
            columns: [
                {
                    // "title": "Selecionar",
                   "data":'checkbox', // FIXME CHECK THIS
                },
                {
                    "title":colHeaderContainer,
                   "data":"name",
                },
                { "title": "Tipo/Tamaño",
                    "data":"type",
                },
                { "title": "Fecha Límite",
                  "data":"deliveryDate",
                },
                { "title": "Estado",
                    "data":"status"
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
                    render: function ( data, type, full, meta )
                    {
                        var elementId =  String(full.name).trim();
                        // console.log("render: " + elementId + " " + type);
                        if(type == 'display' && full.selectable && processType == 1)
                        {
                            var selectHtml = "<select class=\"form-control\" id=\"selectType" +elementId + "\"></select>";
                            return selectHtml;
                        }
                        return data.name;
                    },
                },
                // {
                //     targets: [3],
                //     data:'deliveryDate',
                //     render: function ( data, type, full, meta )
                //     {
                //         var elementId =  String(full.name).trim();
                //         // console.log("render: " + elementId + " " + type);
                //         // console.log("data: ");
                //         // console.log(data);
                //         if(type == 'display' && full.selectable && processType == 2)
                //         {
                //             var  html = '<input type=\"text\" class=\"form-control\" id=\"' + elementId +  '\" placeholder=\"Seleccionar\"' + ' value=\"' + data + '\"' + ' data-date=\"' +  data + '\" >';
                //             console.log(html)
                //             return html;
                //         }
                //
                //         return data;
                //     },
                // },
            ],
        });

        table.on( 'user-select', function ( e, dt, type, cell, originalEvent ) {
            // alert('user-select');
            var index = cell.index();
            // console.log(index);
            // console.log(dt.row(index.row, index.column).data());
            // var id = dt.row(index.row, index.column).data().id;
            // var name = dt.row(index.row, index.column).data().name;
            var status = dt.row(index.row, index.column).data().status;
            var errCode = dt.row(index.row, index.column).data().errCode;
            // if(status !== 'PENDIENTE' && !moment(status).isValid())
            var msg = '';
            if(errCode == 0)
            {
                msg = 'Este contenedor no puede ser seleccionado su estado es: ' + status
            }
            else if(dt.row(index.row, index.column).data().expired == 1)
            {
                msg = 'Este contenedor no puede ser seleccionado: ha expirado su fecha límite.';
            }
            else {
                msg = 'Este contenedor no puede ser seleccionado pendiente de facturación o crédito';
            }

            if(dt.row(index.row, index.column).data().selectable == false)
            {
                alert(msg);
                e.preventDefault();
                return false;
            }
        } );
    }
};

var handleDataTable2 = function () {
    var columns = [
        {  "title":colHeaderContainer,
            "data":"name",
        },
        { "title": "Tipo/Tamaño",
            "data":"type",
        },
        { "title": "Fecha Límite",
            "data":"deliveryDate",
        },
        { "title": "Estado",
            "data":"status"
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
            pageLength: 10,
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
                    render: function ( data, type, full, meta )
                    {
                        // console.log(data);
                        // return moment(data).format("DD/MM/YYYY");
                        return data;
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
                    // "title": "Seleccione",
                    "data":'checkbox', // FIXME CHECK THIS
                },
                {   "title":colHeaderContainer,
                    "data":"name",
                },
                { "title": "Tipo/Tamaño",
                    "data":"type"
                },
                { "title": "Fecha Límite",
                    "data":"deliveryDate",
                },
                { "title": "Estado",
                    "data":"status"
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
                        return data.name;
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


