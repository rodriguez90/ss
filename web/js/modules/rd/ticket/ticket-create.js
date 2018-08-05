/**
 * Created by pedro on 30/05/2018.
 */

var lan = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    // select: {
    //     rows: {
    //         _: "You have selected %d rows",
    //         0: "Click a row to select it",
    //         1: "Only 1 row selected"
    //     }
    // }
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};

var firstRun = true;

var reception = null;
var agency = null;
var transactions = new Map();
var containers = new Map();
var ticketDataMap =  new Map(); // transaction id - key
var calendarEventMap = new Map(); // calendar id - key

var transactionDataMap = new Map();

var driverDataMap = new Map();
var dateTicketMap = new Map(); // map key: date ticket, value: array of containers with at date

var calendarSlotEvents = {
    id:'calendarSlotEvents',
    events:[]
};

var ticketEvents = {
    id:'ticketEvents',
    events:[]
};

var currentCalendarEvent = null;

// el calendario se acota x la fecha de devolución d los contenedores relacionados en la recepcion
var minDeliveryDate = null;
var maxDeliveryDate = null;

var selectedTransactions = [];
var transactionWithTicket = [];

var mode = null; // create and delete

var systemMode = 1; // only for testing 0-offline  1-online

// functions

var findSlotEvent = function (start, end) {
    var result = {
        index:-1,
        event:null
    };
    var startFormated = start.format("YYYY-MM-DD H:mm");
    var endFormated = end.format("YYYY-MM-DD H:mm");
    $.each(calendarSlotEvents.events,function (i)
    {
        var event = calendarSlotEvents.events[i];
        // if(i== 0)
        // {
        //     console.log(event);
        //     console.log('UTC');
        //     console.log(start.utc() );
        //     console.log(event.start.utc());
        //     console.log('FORMAT');
        //     console.log(start.format("YYYY-MM-DD HH:mm") );
        //     console.log(event.start.format("YYYY-MM-DD HH:mm") );
        //     console.log('valueOf');
        //     console.log(start.valueOf());
        //     console.log(event.start.valueOf());
        //     console.log('COMPARE');
        //     console.log(startFormated === event.start.format("YYYY-MM-DD HH:mm"));
        // }

        if(event.type === "D" && startFormated === moment(event.start).format("YYYY-MM-DD HH:mm") &&
            endFormated === moment(event.end).format("YYYY-MM-DD HH:mm"))
        {
            result.index = i;
            result.event = event;
            return false;
        }
    });
    return result;
};

var findTicketEvent = function (id) {
    var result = {
        index:-1,
        event:null
    };

    $.each(ticketEvents.events,function (i)
    {
        var event = ticketEvents.events[i];
        if(event.id === id)
        {   result.index = i;
            result.event = event;
            return false;
        }
    });
    return result;
};

// make custom conten to popover by event
var makePopoverContent = function (event) {
    var result = {
        title:'',
        conten:''
    };
    var conten = '';
    if(event.type === 'D')
    {
        result.title = 'Cupos disponibles: ' + event.title;
    }
    else if(event.type === 'T20' || event.type === 'T40')
    {
        var rts = event.rt;
        result.title = 'Turnos para contenedores de ' +   event.type.replace('T','') + ' toneladas: ' + event.title;
        var containersConten  = '';
        $.each(rts, function (i) {
            var t = transactions.get(rts[i]);
            var c = containers.get(t.container_id);
            if(ticketDataMap.has(rts[i]) && ticketDataMap.get(rts[i]).id != -1)
            {
                containersConten += "<h5>" + c.name + " " + c.code + c.tonnage + " " + t.register_truck + "/" + t.name_driver+"<h5>";
            }
            else
                containersConten += "<h5>" + c.name + " " + c.code + c.tonnage + "<h5>";
        });

        result.conten = containersConten;
    }

    return result;
};

function matchCustom(params, data) {
    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
        return data;
    }

    // Do not display the item if there is no 'text' property
    if (typeof data.text === 'undefined') {
        return null;
    }

    // `params.term` should be the term that is used for searching
    // `data.text` is the text that is displayed for the data object
    if (data.text.indexOf(params.term) > -1) {
        var modifiedData = $.extend({}, data, true);
        modifiedData.text += ' (matched)';

        // You can return modified objects from here
        // This includes matching the `children` how you want in nested data sets
        return modifiedData;
    }

    // Return `null` if the term should not be displayed
    return null;
}

// init table in modal dialog
var handleTableInModal = function () {

    if ($('#data-table-modal').length !== 0) {

        $('#data-table-modal').DataTable({
            "columns": [
                {
                    // "title": "Selecionar",
                    "data":'checkbox', // FIXME CHECK THIS
                },
                { "title": "Contenedor",
                    "data":"name",
                },
                { "title": "Tipo",
                    // "data":"type",
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
            "pageLength": 10,
            "language": lan,
            // select: true,
            responsive: true,
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
                    data:null,
                    render: function ( data, type, full, meta ) {
                        return data.type+ data.tonnage;
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
            select: {
                // items: 'cells',
                style:    'multi',
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]]
        });

        var table = $('#data-table-modal').DataTable();

        table.on( 'user-select', function ( e, dt, type, cell, originalEvent ) {
            // alert('user-select');
            var count = dt.rows( { selected: true } ).count();
            // alert('Select : ' + type + ' selected: ' + indexes + ' count ' + count);
            var disponivility = currentCalendarEvent.count;
            // console.log($this);
            // console.log(e.target);
            // console.log(originalEvent.currentTarget);
            // console.log(originalEvent);
            // console.log(cell[0]);
            // var row = dt.row(cell[0]);
            // console.log(row.find());
            // console.log(row.node());
            // console.log(row.node().hasClass('selected'));
            //
            // if(currentCalendarEvent && (count + 1) > disponivility)
            // {
            //     alert('Solo hay ' + disponivility + ' cupos disponibles');
            //
            //     e.preventDefault();
            // }

            // if(count > 0)
            // {
            //     $('#aceptBtn').attr('disabled', false);
            // }
            // else
            // {
            //     $('#aceptBtn').attr('disabled', true);
            // }

            // var ticket = {
            //     "Ticket[process_transaction_id]":1, // FIXME THIS DEFINE BY USER WITH ROLE AGENCY OR IMPORTER/EXPORTER
            //     "Ticket[calendar_id]":1,
            //     "Ticket[status]":1,
            //     "Ticket[active]":1,
            // };

//             $.ajax({
//                 async:false,
//                 url: homeUrl + "/rd/api-ticket/prebooking",
//                 type: "POST",
//                 dataType: "json",
//                 data:  ticket,
// //                            contentType: "application/json; charset=utf-8",
//                 success: function (response) {
//                     // you will get response from your php page (what you echo or print)
//                     var obj = JSON.parse(response);
//                     console.log(obj);
//
//                     if(obj.success)
//                     {
//                         result = true;
//                         window.location.href = obj.url;
//                     }
//                     else
//                     {
//                         alert(obj.msg);
//                     }
//                     // return true;
//                 },
//                 error: function(data) {
//                     console.log(data.responseText);
//                     alert(responseText);
//                     result = false;
//                     // return false;
//                 }
//             });

        } );

//         table.on( 'select', function ( e, dt, type, indexes ) {
//
//         } );

        // table.on( 'select', function ( e, dt, type, indexes ) {
        //     // var rowData = table.rows( indexes ).data().toArray();
        //     // events.prepend( '<div><b>'+type+' <i>de</i>selection</b> - '+JSON.stringify( rowData )+'</div>' );
        // } );
    }
};

var handleTableInWizar = function() {
    if ($('#data-table2').length !== 0) {


    var  table = $('#data-table2').DataTable({
            dom: '<"top"iflp<"clear">>rt',
            pagingType: "full_numbers",
            responsive: true,
            info: true,
            processing:true,
            lengthMenu: [5, 10, 15],
            pageLength: 10,
            order: [[1, "asc"]],
            columns: [
                { title: "Contenedor",
                    "data":"name"
                },
                { title: "Tipo",
                    // data:"type",
                },
                { title: "Fecha Límite",
                    data:"deliveryDate"
                },
                { title: "Agencia",
                    data:"agency"
                },
                { title: "Fecha del Cupo",
                    "data":"dateTicket"
                },
                { title: "Placa del Carro",
                    "data":"registerTrunk",
                },
                { title: "Nombre del Chofer",
                    "data":"nameDriver"
                },
                { title: "Cédula del Chofer",
                    "data":"registerDriver",
                },
            ],
            "language": lan,
            "createdRow": function( row, data, dataIndex ) {
                // console.log('init select2: ' + data.name);

                $('td select', row).eq(0).select2(
                {
                    language: "es",
                    placeholder: 'Seleccione la Placa',
                    // allowClear: true,
                    width: '100%',
                    closeOnSelect: true,
                    ajax:{
                        url: homeUrl + '/rd/trans-company/trunks',
                        type: "GET",
                        dataType: "json",
                        cache: true,
                        data: function (params) {
                            var query = {
                                term: params.term,
                                code: transCompanyRuc,
                                mode:systemMode
                            }
                            return query;
                        },
                        processResults: function (response) {
                            // console.log(response);
                            var results  = [];
                            $.each(response.trunks, function (index, item) {
                                // console.log(item);
                                // [err_code], [err_msg], [placa], [rfid]
                                results.push({
                                    id: item.placa,
                                    text: item.placa,
                                    err_code: item.err_code,
                                    err_msg: item.err_msg,
                                    rfid: item.rfid,
                                });
                            });
                            return {
                                results: results
                            };
                        },
                    },
                }).on('select2:select', function (e) {
                    // alert(e.params.data);
                    var trunk = e.params.data;
                    var transactionData = transactionDataMap.get(data.name);

                    if(trunk.err_code !== "0")
                    {
                        e.preventDefault();
                        transactionData.registerTrunk = "";
                        alert("Esta placa no puede ser seleccionada: " + trunk.err_msg);
                        $('td select', row).eq(0).val('').trigger("change.select2");
                    }
                    else
                    {
                        var valid = true;
                        var msg = '';
                        var containersArray = dateTicketMap.get(data.calendarId);
                        var containersByTrunk20= 0;
                        var containersByTrunk40 = 0;

                        for(var i=0, count = containersArray.length; i < count; i++)
                        {
                            var container = containers.get(containersArray[i]);
                            var cTransactionData = transactionDataMap.get(container.name);

                            if(cTransactionData.registerTrunk == trunk.id)
                            {
                                if(container.tonnage == 20)
                                {
                                    containersByTrunk20++;
                                }
                                else if(container.tonnage == 40)
                                {
                                    containersByTrunk40++;
                                }
                            }
                        }

                        if(containersByTrunk40 == 1) // ya la placa esta asignada en un contenedor de 40 para la misma fecha
                        {
                            valid = false;
                            msg = 'Esta placa esta asiganda a un contenedor de 40 toneladas en esta fecha.'
                        }
                        else if(containersByTrunk20 == 2) // ya la placa esta asignada a 2 contenedores de 20 para la misma fecha
                        {
                            valid = false;
                            msg = 'Esta placa esta asiganda a dos contenedores de 20 toneladas en esta fecha.'
                        }
                        else if(containersByTrunk20 == 1 && data.tonnage == 40) // no puede asiganr un contenedor de 40 toneladas
                        {
                            valid = false;
                            msg = 'Esta placa esta asiganda a un contenedor de 20 toneladas en esta fecha.'
                        }

                        if(valid)
                            transactionData.registerTrunk = trunk.id;
                        else
                        {
                            transactionData.registerTrunk = "";
                            alert(msg);
                            $('td select', row).eq(0).val('').trigger("change.select2");
                        }
                    }

                    transactionDataMap.set(data.name, transactionData);
                    // api.cell({row: meta.row, column: 5}).data(trunk.id);
                    // table.row(index).data(data)
                });

                $('td select', row).eq(1).select2(
                    {
                        language: "es",
                        placeholder: 'Seleccione el Chofer',
                        width: '100%',
                        closeOnSelect: true,
                        matcher: matchCustom,
                        ajax:{
                            url: homeUrl + '/rd/trans-company/drivers',
                            type: "GET",
                            dataType: "json",
                            cache: true,
                            data: function (params) {
                                var query = {
                                    term: params.term,
                                    code: transCompanyRuc,
                                    mode:systemMode
                                }
                                return query;
                            },
                            processResults: function (response) {
                                // console.log(response);
                                var results  = [];
                                $.each(response.drivers, function (index, item) {
                                    results.push({
                                        id: item.chofer_ruc,
                                        text: item.chofer_nombre,
                                        err_code: item.err_code,
                                        err_msg: item.err_msg,
                                        chofer_ruc: item.chofer_ruc,
                                    });
                                });
                                return {
                                    results: results
                                };
                            },
                        },
                    }).on('select2:select', function (e) {
                        var driver = e.params.data;
                        var transactionData = transactionDataMap.get(data.name);
                        if(driver.err_code !== "0")
                        {
                            e.preventDefault();
                            alert("Este Chofer no puede ser seleccionado: " + driver.err_msg);
                            transactionData.registerDriver = "";
                            transactionData.nameDriver = "";
                            table.cell({row: dataIndex, column: 7}).data("");
                            $('td select', row).eq(1).val('').trigger("change.select2");
                        }
                        else
                        {
                            var valid = true;
                            var msg = '';
                            var containersArray = dateTicketMap.get(data.calendarId);
                            var containersByTrunk20= 0;
                            var containersByTrunk40 = 0;
                            for(var i=0, count = containersArray.length; i < count; i++)
                            {
                                var container = containers.get(containersArray[i]);
                                var cTransactionData = transactionDataMap.get(container.name);

                                if(cTransactionData.registerDriver == driver.id)
                                {
                                    if(container.tonnage == 20)
                                    {
                                        containersByTrunk20++;
                                    }
                                    else if(container.tonnage == 40)
                                    {
                                        containersByTrunk40++;
                                    }
                                }
                            }

                            if(containersByTrunk40 == 1) // ya el chofer esta asociado a un contenedor de 40 para la misma fecha
                            {
                                valid = false;
                                msg = 'Esta chofer esta asociado a un contenedor de 40 toneladas en esta fecha.'
                            }
                            else if(containersByTrunk20 == 2) // ya la placa esta asignada a 2 contenedores de 20 para la misma fecha
                            {
                                valid = false;
                                msg = 'Este chofer esta asociado a dos contenedores de 20 toneladas en esta fecha.'
                            }
                            else if(containersByTrunk20 == 1 && data.tonnage == 40) // no puede asiganr un contenedor de 40 toneladas
                            {
                                valid = false;
                                msg = 'Este chofer ya esta asociado a un contenedor de 20 toneladas en esta fecha.'
                            }

                            if(valid)
                            {
                                transactionData.registerDriver = driver.id;
                                transactionData.nameDriver = driver.text;
                                table.cell({row: dataIndex, column: 7}).data(driver.id);
                            }
                            else
                            {
                                transactionData.registerDriver = "";
                                transactionData.nameDriver = "";
                                alert(msg);
                                $('td select', row).eq(1).val('').trigger("change.select2");
                                table.cell({row: dataIndex, column: 7}).data("");
                            }
                        }
                        transactionDataMap.set(data.name,transactionData);
                });
            },
            columnDefs: [
                {
                    targets: [1],
                    title:"Tipo",
                    data:null,
                    render: function ( data, type, full, meta ) {
                        return data.type+ data.tonnage;
                    }
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
                    data:'dateTicket',
                    render: function ( data, type, full, meta ) {
                        var dateFormated =  moment(data).format("DD/MM/YYYY HH:mm");
                        return dateFormated;
                    },
                },
                {
                    targets: [5],
                    data:'registerTrunk',
                    render: function ( data, type, full, meta ) {
                        var elementId =  String(full.name).trim();
                        if(type == 'display')
                        {
                            var selectHtml = "";

                            if($("#selectTrunk"+elementId).length === 0)
                            {
                                selectHtml = "<select class=\"form-control\" id=\"selectTrunk" +elementId + "\"></select>";
                            }
                            return selectHtml;
                        }
                        return data;
                    },
                },
                {
                    targets: [6],
                    data:'nameDriver',
                    render: function ( data, type, full, meta ) {
                        var elementId =  String(full.name).trim();
                        if(type == 'display')
                        {
                            var selectHtml = "<select class=\"form-control\" id=\"selectDriver" +elementId + "\"></select>";

                            return selectHtml;
                        }
                        return data;
                    },
                },
            ],
        });
    }
};

var handleTable3InWizar = function() {
    if ($('#data-table3').length !== 0) {

        $('#data-table3').DataTable({
            dom: '<"top"iflp<"clear">>rt',
            pagingType: "full_numbers",
            responsive: true,
            info: true,
            // processing:true,
            lengthMenu: [5, 10, 15],
            pageLength: 10,
            order: [[1, "asc"]],
            columns: [
                { title: "Contenedor",
                    "data":"name"
                },
                { title: "Tipo"
                },
                { title: "Fecha Límite",
                    data:"deliveryDate"
                },
                { title: "Agencia",
                    data:"agency"
                },
                { title: "Fecha del Cupo",
                    "data":"dateTicket"
                },
                { title: "Placa del Carro",
                    "data":"registerTrunk",
                },
                { title: "Cédula del Chofer",
                    "data":"registerDriver",
                },
                { title: "Nombre del Chofer",
                    "data":"nameDriver"
                }
            ],
            "language": lan,
            columnDefs: [
                {
                    targets: [1],
                    title:"Tipo",
                    data:null,
                    render: function ( data, type, full, meta ) {
                        return data.type + data.tonnage;
                    }
                },
                {
                    targets: [2],
                    data:'deliveryDate',
                    render: function ( data, type, full, meta ) {
                        // console.log("In render: " + data);
                        var dateFormated =  moment(data).format("DD/MM/YYYY");
                        return dateFormated;
                    },
                },
                {
                    targets: [4],
                    data:'dateTicket',
                    render: function ( data, type, full, meta ) {
                        var dateFormated =  moment(data).format("DD/MM/YYYY HH:mm");
                        return dateFormated;
                    },
                },
            ],
        });
    }
};

var handleModal = function () {

    // select all in modal table
    $('#select-all').on('click', function(){

        var table = $('#data-table-modal').DataTable();
        var count = table.rows( ).count();
        var disponivility = currentCalendarEvent.count;

        if(this.checked)
        {
            if(mode == 'create')
            {
                if(count <= disponivility)
                {
                    table.rows().select();
                }
                else {
                    this.checked = false;
                    alert('Solo hay ' + disponivility + ' cupos disponibles.');
                }
            }
            else if(mode == 'delete')
            {
                table.rows().select();
            }
            return;
        }
        table.rows().deselect();
    });

    $('#aceptBtn').on('click', function(){

        var table = $('#data-table-modal').DataTable();

        var count = table.rows( { selected: true } ).count();

        if(mode == 'create')
        {
            var disponivility = currentCalendarEvent.count;

            if(count > disponivility)
            {
                alert('La cantidad de contenedores seleccionados es superior a la disponibilidad: ' + count + ' de' + disponivility) ;
                return;
            }

            $('#calendar').fullCalendar('removeEventSources');

            table
                .rows( { selected: true } )
                .data()
                .each( function ( value, index ) {

                    if(selectedTransactions.indexOf(value.transactionId) === -1)
                    {
                        selectedTransactions.push(value.transactionId);

                        ticketDataMap.set(value.transactionId, {
                            id:-1,
                            dateTicket:currentCalendarEvent.start,
                            calendarId:currentCalendarEvent.id,
                        });
                    }

                    currentCalendarEvent.count = currentCalendarEvent.count - 1;
                    currentCalendarEvent.title = String(currentCalendarEvent.count);

                    // create event ticket
                    var className = ['bg-blue-darker'];
                    var type = "";
                    var id = currentCalendarEvent.id;
                    if(String(value.tonnage) === "20")
                    {
                        id = currentCalendarEvent.id + "T20";
                        className = ['bg-green-darker'];
                        type = "T20";
                    }
                    else if(String(value.tonnage) === "40")
                    {
                        id = currentCalendarEvent.id + "T40";
                        className = ['bg-purple-darker'];
                        type = "T40";
                    }

                    var count = 1;
                    var result = findTicketEvent(id);

                    if(result.event)
                    {
                        result.event.count = result.event.count + count;
                        result.event.title = result.event.count;
                        ticketEvents[result.index] = result.event; // TODO CHECK THIS
                        result.event.rt.push(value.transactionId);
                        // $('#calendar').fullCalendar('updateEvent', oldEvent);
                    }
                    else
                    {
                        var event = {
                            id: id,
                            title: count,
                            ticketId:-1,
                            start: currentCalendarEvent.start,//moment(currentCalendarEvent.start).utc() ,
                            end: currentCalendarEvent.end,//moment( currentCalendarEvent.end).utc() ,
                            allDay:false,
                            className : className ,
                            editable: false,
                            type:type,
                            count:count,
                            calendarId:currentCalendarEvent.id,
                            rt:[value.transactionId]
                        };
                        ticketEvents.events.push(event);
                    }
                });

            calendarEventMap.set(currentCalendarEvent.id, currentCalendarEvent);

            calendarSlotEvents.events = Array.from(calendarEventMap.values());
        }
        else if(mode === 'delete')
        {
            var disponivility = currentCalendarEvent.count;

            if(count === 0)
            {
                alert('Debe seleccionar los cupos que desea eliminar.') ;
                return;
            }

            $('#calendar').fullCalendar('removeEventSources');

            table
                .rows( { selected: true } )
                .data()
                .each( function ( value, index ) {

                    var ticket = ticketDataMap.get(value.transactionId, null);

                    if(ticket === null) //  ticket bug error
                    {
                        return false;
                    }

                    if(ticket.id === -1)
                    {
                        var id = currentCalendarEvent.id;
                        if(String(value.tonnage) === "20")
                        {
                            id = currentCalendarEvent.id + 'T20';
                        }
                        else if(String(value.tonnage) === "40")
                        {
                            id = currentCalendarEvent.id + 'T40';
                        }

                        var result = findTicketEvent(id);
                        if(result.event) // always
                        {
                            result.event.count = result.event.count - 1;
                            result.event.title = String(result.event.count);
                            var indexRT = result.event.rt.indexOf(value.transactionId)
                            result.event.rt.splice(indexRT, 1);

                            if(result.event.count == 0)
                            {
                                ticketEvents.events.splice(result.index, 1);
                            }
                            else {
                                ticketEvents[result.index] = result.event;
                                // ticketEvents.events[result.index] = result.event; //TODO check this
                            }
                            var indexSelected = selectedTransactions.indexOf(value.transactionId);
                            selectedTransactions.splice(indexSelected,1);

                            ticketDataMap.delete(value.transactionId);
                            currentCalendarEvent.count = currentCalendarEvent.count + 1;
                        }
                    }
                    else // delete ticket from db
                    {
                        $.ajax({
                            async:false,  // FIXME: CHECK THIS
                            url: homeUrl + "/rd/ticket/delete/?id=" + ticket.id,
                            type: "post",
                            dataType:'json',
                            success: function(response) {
                                console.log(response);

                                if(response.success)
                                {
                                    var calendarEvent = calendarEventMap.get(response['ticket'].calendar_id);

                                    var id = calendarEvent.id;

                                    if(String(value.tonnage) === "20")
                                    {
                                        id = calendarEvent.id + "T20";
                                    }
                                    else if(String(value.tonnage) === "40")
                                    {
                                        id = calendarEvent.id + "T40";
                                    }

                                    var result = findTicketEvent(id);
                                    console.log(result);
                                    if(result.event) // always
                                    {
                                        result.event.count = parseInt(result.event.count) - 1;
                                        result.event.title = String(result.event.count);
                                        var indexRT = result.event.rt.indexOf(value.transactionId)
                                        result.event.rt.splice(indexRT, 1);

                                        if(result.event.count == 0)
                                        {
                                            ticketEvents.events.splice(result.index, 1);
                                        }
                                        else {
                                            ticketEvents[result.index] = result.event;
                                            // ticketEvents.events[result.index] = result.event; //TODO check this
                                        }
                                        var indexTWT = transactionWithTicket.indexOf(value.transactionId);
                                        transactionWithTicket.splice(indexTWT, 1);
                                        ticketDataMap.delete(value.transactionId);
                                        calendarEvent.count = parseInt(calendarEvent.count) + 1;
                                    }
                                }
                                else {
                                    alert(response.msg);
                                }
                            },
                            error: function(response) {
                                console.log(response);
                                result = false;
                            }
                        });
                    }
                });

            // currentCalendarEvent.title = currentCalendarEvent.count;
            currentCalendarEvent.title = String(currentCalendarEvent.count);
            calendarEventMap.set(currentCalendarEvent.id, currentCalendarEvent);
            calendarSlotEvents.events = Array.from(calendarEventMap.values());
        }

        // console.log(ticketEvents);
        // console.log(currentCalendarEvent);

        $('#calendar').fullCalendar('addEventSource',calendarSlotEvents);
        $('#calendar').fullCalendar('addEventSource',ticketEvents);
        $('#calendar').fullCalendar('refetchEventSources');
        $("#modal-select-containers").modal("hide");
        mode = null;
    });
};

var fetchCalendar = function (start, end, async) {

    $.ajax({
        async:async,
        url: homeUrl + "/rd/calendar/getcalendar",
        type: "get",
        dataType:'json',
        data: {
            start: start,
            end: end
        },
        success: function(response) {
            console.log(response);

            $('#calendar').fullCalendar('removeEventSources', calendarSlotEvents.id);
            calendarSlotEvents.events = [];

            $.each(response,function (i) {
                var startDate = moment(response[i].start);
                var endDate = moment(response[i].end);
                // var startDate = response[i].start; // moment(response[i].start).toDate();
                // var endDate = response[i].end;//moment(response[i].end).toDate();

                var event = {
                    id: response[i].id,
                    title: String(response[i].count),
                    count: response[i].count,
                    start: startDate ,
                    end:  endDate  ,
                    allDay:false,
                    className : ['bg-blue-darker'],
                    editable: false,
                    type:'D',
                    calendarId: response[i].id
                }
                // $('#calendar').fullCalendar('renderEvent', event);

                calendarEventMap.set(response[i].id,event);
            });
            // console.log(calendarSlotEvents);
            // console.log(calendarEventMap.values());
            calendarSlotEvents.events = Array.from(calendarEventMap.values());

            $('#calendar').fullCalendar('addEventSource', calendarSlotEvents);
            $('#calendar').fullCalendar('refetchEventSources');
            $('#calendar').fullCalendar('gotoDate', moment(minDeliveryDate) );
        },
        error: function(response) {
            //console.log(response);
            //console.log(response.responseText);
            alert("Ah ocurrido un error.");
            result = false;
            // return false;
        }
    });
};

var fetchProcessTransactions = function () {

    $.ajax({
        // async:false,
        url: homeUrl + "/rd/process/transactions",
        type: "get",
        dataType: "json",
        data:  {
            id:modelId,
            transCompanyId:transCompanyId,
        },
        success: function (response) {
            // console.log(response);

            reception = response['process'];
            agency = response['angecy'];

            $.each( response['transactions'], function (i) {

                var t =  response['transactions'][i];
                var c =  response['containers'][i];
                transactions.set(t.id, t);
                containers.set(c.id, c);
            } );

            if(firstRun)
            {
                var count =  response['transactions'].length;
                if(count > 0)
                {
                    minDeliveryDate = moment();
                    maxDeliveryDate = moment(reception.delivery_date).utc().set({'hours': 23, 'minutes': 59, 'seconds':59});

                    // $('#calendar').fullCalendar({
                    //     visibleRange: {
                    //         start: minDeliveryDate,
                    //         end: maxDeliveryDate
                    //     }
                    // });

                    console.log(minDeliveryDate.format('YYYY-MM-DD HH:mm:ss'));
                    console.log(maxDeliveryDate.format('YYYY-MM-DD HH:mm:ss'));

                    fetchCalendar(minDeliveryDate.format('YYYY-MM-DD HH:mm:ss'), maxDeliveryDate.format('YYYY-MM-DD HH:mm:ss'), false);
                    fetchTickets(modelId, false);
                }

                firstRun = false;
            }

            return true;
        },
        error: function(response) {
            console.log(response);
            alert("Ah ocurrido un error");
            return false;
        }
    });
};

var fetchTickets = function (processId, async) {
    $.ajax({
        async:async,
        url: homeUrl + "/rd/ticket/by-process",
        type: "get",
        dataType:'json',
        data: {
            processId: processId,
        },
        success: function(response) {

            $('#calendar').fullCalendar('removeEventSources', ticketEvents.id);
            ticketEvents.events = [];

            $.each(response['tickets'],function (i) {

                var className = [];
                var type = "";
                var count = 1;
                var id = response['tickets'][i].calendar_id ;
                var tId = response['tickets'][i].process_transaction_id;
                var t = transactions.get(tId);

                if(t)
                {
                    var container = containers.get(t.container_id);
                    var calendar = calendarEventMap.get(id);

                    transactionWithTicket.push(tId);

                    if(calendar)
                    {
                        ticketDataMap.set(tId, {
                            id:response['tickets'][i].id,
                            dateTicket:calendar.start,
                            dateEndTicket:calendar.end,
                            calendarId:id,
                        });

                        if(String(container.tonnage) === "20")
                        {
                            id = id + 'T20';
                            className = ['bg-green-darker'];
                            type = "T20";
                        }
                        else if(String(container.tonnage) === "40")
                        {
                            id = id + 'T40';
                            className = ['bg-purple-darker'];
                            type = "T40";
                        }

                        var result = findTicketEvent(id);
                        if(result.event)
                        {
                            result.event.count = result.event.count + count;
                            result.event.title = String(result.event.count);
                            ticketEvents[result.index]= result.event;
                            result.event.rt.push(tId);
                        }
                        else
                        {
                            var event = {
                                id: id,
                                title: String(count),
                                start: calendar.start,
                                end:  calendar.end ,
                                allDay:false,
                                className : className ,
                                editable: false,
                                type:type,
                                count:count,
                                calendarId:calendar.id,
                                rt:[tId],
                                index: -1
                            };
                            ticketEvents.events.push(event);
                            event.index = ticketEvents.events.length - 1;
                        }
                    }
                }
            });

            $('#calendar').fullCalendar('addEventSource',ticketEvents);
            $('#calendar').fullCalendar('refetchEventSources');
        },
        error: function(response) {
            console.log(response);
            console.log(response.responseText);
            result = false;
        }
    });
};

var stop_watch_start = moment().hour(0).minute(29).second(59);
var timerId = null;

var handleStopWatch = function()
{
    var sw = $("#stop_watch");
    stop_watch_start.subtract({seconds: 1});
    sw.text("00:" + stop_watch_start.format('mm:ss'));

    if(stop_watch_start.format('mm:ss') === "00:00")
    {
        clearTimeout(timerId);
        alert("Ha espirado el tiempo de trabajo");
        window.location.reload();
        return;
    }

    if(stop_watch_start.minutes() < 10 &&  !$("#stop_watch_widget").hasClass("bg-red") )
    {
        $("#stop_watch_widget").removeClass("bg-green")
        $("#stop_watch_widget").addClass("bg-red")
    }

};

var handleCheckSwitcher = function()
{
    // console.log($('[data-click="check-switchery-state"]'));
    //
    // $('[data-click="check-switchery-state"]').live('click', function() {
    //     alert("click");
    //     if ($('[data-id="switchery-state"]').prop('checked')) {
    //         $("#confLabel").removeClass('label-default').addClass('label-success');
    //     }
    //     else {
    //         $("#confLabel").removeClass('label-success').addClass('label-default');
    //
    //     }
    // });
};

$(document).ready(function () {

    // console.log(modelId);
    // console.log(transCompanyId);
    // console.log(transCompanyRuc);
    // moment.locale('es');
    // init wizar
    FormWizardValidation.init();

    Calendar.init();

    handleModal();
    handleTableInModal();
    handleTableInWizar();
    handleTable3InWizar();
    handleCheckSwitcher();
    fetchProcessTransactions();
    


    // stop watch
    timerId = setInterval(handleStopWatch, 1000);

});
