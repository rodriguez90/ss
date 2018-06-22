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
            "columns": [
                { "title": "Contenedor",
                    "data":"name",
                },
                { "title": "Tipo/Tamaño",
                },
                { "title": "Fecha Limite",
                    "data":"deliveryDate",
                },
                { "title": "Cliente",
                    "data":"agency"
                },
                { "title": "Empresa de Transporte",
                    "data":"transCompany"
                },
            ],
            processing:true,
            lengthMenu: [5, 10, 15],
            "pageLength": 3,
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
            // "drawCallback": function( settings ) {
            //     // alert( 'DataTables has redrawn the table' );
            //     // $('.dt-select2').select2({
            //     //     language: "es",
            //     //     placeholder: 'Seleccione la compañia de transporte',
            //     //     width: 'auto',
            //     //     minimumInputLength:5,
            //     //     // allowClear: true,
            //     //     // tags: true,
            //     //     closeOnSelect: false,
            //     //     ajax: {
            //     //         url: homeUrl + '/rd/api-trans-company',
            //     //         dataType: 'json',
            //     //         delay: 250,
            //     //         processResults: function (data) {
            //     //             // console.log(data);
            //     //             var myResults  = [];
            //     //             $.each(data, function (index, item) {
            //     //                 // console.log(item);
            //     //                 myResults .push({
            //     //                     id: item.id,
            //     //                     text: item.name
            //     //                 });
            //     //             });
            //     //             return {
            //     //                 results: myResults
            //     //             };
            //     //         },
            //     //         cache: true,
            //     //     },
            //     // });
            // },
            // rows: {
            //     callback: function(row, data, index) {
            //         var id  = "selectTransCompany" + String(data.name).replace(" ","");
            //         var html = "<select class=\"dt-select2\" id=\"" + id + "\"></select>";
            //         console.log(data.name);
            //         console.log(index);
            //         console.log(row);
            //         console.log(id);
            //         console.log(html)
            //     },
            // },
            "rowCallback": function ( row, data, index ) {

                var id  = "selectTransCompany" + String(data.name).replace(" ","");
                var html= null;
                // console.log(data.name);
                // console.log(index);
                // console.log(row);
                // console.log(id);

                // $('td', row).eq(5).html(html);
                var html = "<select id=\"" + id + "\"></select>";
                console.log(html);
                $('td:eq(4)', row).html( html);
                console.log($('td:eq(4)', row).html());


                $("#"+id).select2(
                    {
                        language: "es",
                        placeholder: 'Seleccione la compañia de transporte',
                        width: 'auto',
                        minimumInputLength:5,
                        // allowClear: true,
                        // tags: true,
                        closeOnSelect: true,
                        ajax: {
                            url: homeUrl + '/rd/api-trans-company',
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                // console.log(data);
                                var myResults  = [];
                                $.each(data, function (index, item) {
                                    // console.log(item);
                                    myResults .push({
                                        id: item.id,
                                        text: item.name
                                    });
                                });
                                return {
                                    results: myResults
                                };
                            },
                            cache: true,
                        },
                    });

                // if ($("#"+id).hasClass("select2-hidden-accessible")) {
                //     // html = $("#"+id).html();
                //     // html = $("#"+id).html();
                //     console.log("Select2 :" + id + "has been initialized")
                // }
                // else
                // {
                //     html = "<select class=\"form-control\" id=\"" + id + "\"/>";
                //
                // }
            }
            // rowCallback: function( row, data, index ) {
            //
            //     var id  = "selectTransCompany" + String(data.name).replace(" ","");
            //     var html = "<select class=\"dt-select2\" id=\"" + id + "\"></select>";
            //     console.log(data.name);
            //     console.log(index);
            //     console.log(row);
            //     console.log(id);
            //     console.log(html)
            //
            //     $('td:eq(4)', row).html( html);
            //
            //     // $("#"+id).select2(
            //     //     {
            //     //         language: "es",
            //     //         placeholder: 'Seleccione la compañia de transporte',
            //     //         width: 'auto',
            //     //         minimumInputLength:5,
            //     //         // allowClear: true,
            //     //         // tags: true,
            //     //         closeOnSelect: false,
            //     //         ajax: {
            //     //             url: homeUrl + '/rd/api-trans-company',
            //     //             dataType: 'json',
            //     //             delay: 250,
            //     //             processResults: function (data) {
            //     //                 // console.log(data);
            //     //                 var myResults  = [];
            //     //                 $.each(data, function (index, item) {
            //     //                     // console.log(item);
            //     //                     myResults .push({
            //     //                         id: item.id,
            //     //                         text: item.name
            //     //                     });
            //     //                 });
            //     //                 return {
            //     //                     results: myResults
            //     //                 };
            //     //             },
            //     //             cache: true,
            //     //         },
            //     //     });
            // }
        });
    }
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


