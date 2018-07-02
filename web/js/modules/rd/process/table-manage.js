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
            "createdRow": function ( row, data, index, cells ) {
                if (!data.selectable ) {
                    $('td', row).eq(0).removeClass('select-checkbox');
                    // console.log(row);
                    $(row).addClass('bg-silver-darker');
                }
                else {
                    var elementId =  String(data.name).replace(' ','');
                    if(processType === "2")
                    {
                        // console.log("Element Id: " + elementId)
                        // console.log("element length " + $('#' + elementId).length);
                        // console.log($('#' + elementId));

                        if($('#' + elementId).length === 0)
                        {
                            console.log($('td:eq(3)', row).html());

                            var  html = '<input type=\"text\" class=\"form-control\" id=\"' + elementId +  '\" placeholder=\"Seleccionar\"' + 'value=\"' + moment(data.deliveryDate).format('DD/MM/YYYY') + '\" >';
                            console.log("Generate HTML: ")
                            console.log(html);

                            $('td', row).eq(3).html(html)
                            // $('td:eq(3)', row).html(html);

                            // console.log($('td:eq(3)', row).html());

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
                    }

                    if($("#select"+elementId).length === 0)
                    {
                        var selectHtml = "<select class=\"form-control\" id=\"select" +elementId + "\"></select>";

                        // for(var i = 0, count = containerTypeArray.length; i< count; i++)
                        // {
                        //     selectHtml +=  "<option value=\"" + containerTypeArray[i].id+ "\">" + containerTypeArray[i].name + "</option>"
                        // }
                        //     selectHtml += "</select>"

                        console.log("Generate HTML: ")
                        console.log(selectHtml);
                        console.log(row);
                        $('td', row).eq(2).html(selectHtml);
                        // console.log($('td:eq(2)', row));

                        // $('td:eq(2)', row).select2(
                        // $('select', row).select2
                        // row.child('td').eq(2).find('select')
                        // $('select', row).eq(2).select2(
                        console.log($('td', row).eq(2));
                        console.log(row);
                        $('select', row).select2(
                        {
                            language: "es",
                            placeholder: 'Seleccione Tipo de Contenedor',
                            // allowClear: true,
                            width: '100%',
                            closeOnSelect: true,
                            // data:{ results: containerTypeArray, text: "name"},
                            data:containerTypeArray,
                            // ajax:{
                            //     async:false,
                            //     url: homeUrl + '/rd/container-type/types',
                            //     type: "GET",
                            //     dataType: "json",
                            //     cache: true,
                            //     processResults: function (data) {
                            //         // console.log(data);
                            //         var results  = [];
                            //         $.each(data.types, function (index, item) {
                            //             // console.log(item);
                            //             results.push({
                            //                 id: item.id,
                            //                 text: item.name,
                            //             });
                            //         });
                            //         return {
                            //             results: results
                            //         };
                            //     },
                            // },
                        }).on('select2:select', function (e) {
                            // console.log(containerTypeMap);
                            var selectedType = e.params.data;
                            // console.log(selectedType);
                            // console.log(selectedType.id);
                            // var type = containerTypeMap.get(selectedType.id, null);
                            var type = {
                                id:selectedType.id,
                                name:selectedType.text,
                            };
                            // console.log(type);
                            data.type = type;

                            // console.log(data);
                            // $('#mySelect2').val(type.id); // Select the option with a value of '1'
                            // $('#mySelect2').trigger('change'); // Notify any JS components that the value changed
                            table.row(index).data(data);
                            // $('td:eq(2)', row).val(''); // Change the value or make some change to the internal state
                            // $('td:eq(2)', row).trigger('change.select2'); // Notify only Select2 of changes
                            return true;
                        });
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
                    title:"Tipo",
                    data:"type",
                    render: function ( data, type, full, meta ) {
                        //
                        // console.log("TYPE COLUMN RENDER:")
                        // console.log("TYPE: " + type);
                        // console.log(full);
                        // console.log(meta);
                        // console.log(data);
                        var row = meta.row;
                        var col = meta.col;
                        var selector = "td:eq("+col+")";
                        var cell = $(this).cell();
                        // console.log($('td:eq()', row).eq(2).html);
                        if(data !== null)
                        {
                            return data.name;
                        }
                        return "";
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


