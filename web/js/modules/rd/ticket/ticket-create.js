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
var ticketEventMap = new Map();

var calendarSlotEvents = {
    id:'calendarSlotEvents',
    events:[]
};

var ticketEvents = {
    id:'ticketEvents',
    events:[]
};

var currentCalendarEvent = null;

// el calendario se acota x la fecha de devolución de los contenedores relacionados en la recepcion
var minDeliveryDate = null;
var maxDeliveryDate = null;

var selectedTransactions = [];
var transactionWithTicket = [];

var mode = null; // create and delete

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
        if(i== 0)
        {
            console.log(event);
            console.log('UTC');
            console.log(start.utc() );
            console.log(event.start.utc());
            console.log('FORMAT');
            console.log(start.format("YYYY-MM-DD HH:mm") );
            console.log(event.start.format("YYYY-MM-DD HH:mm") );
            console.log('valueOf');
            console.log(start.valueOf());
            console.log(event.start.valueOf());
            console.log('COMPARE');
            console.log(startFormated === event.start.format("YYYY-MM-DD HH:mm"));
        }

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
        result.title = 'Cupos para contenedores de ' +   event.type.replace('T','') + ' toneladas: ' + event.title;
        var containersConten  = '';
        $.each(rts, function (i) {
            var t = transactions.get(rts[i]);
            var c = containers.get(t.container_id);
            containersConten += "<h5>" + c.name + " " + c.code + c.tonnage + "<h5>";
        });

        result.conten = containersConten;
    }

    return result;
};

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
                    // "data":null,
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
            // language: {url: '@web/plugins/DataTables/i18/Spanish.json'},
            //
            // },
            columnDefs: [
                {
                    orderable: false,
                    searchable: false,
                    className: 'select-checkbox',
                    targets:   [0],
                    // data: 'checkbox',
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
            //     "Ticket[reception_transaction_id]":1, // FIXME THIS DEFINE BY USER WITH ROLE AGENCY OR IMPORTER/EXPORTER
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


        $('#data-table2').DataTable({
            dom: '<"top"iflp<"clear">>rt',
            pagingType: "full_numbers",
            responsive: true,
            info: true,
            processing:true,
            lengthMenu: [5, 10, 15],
            pageLength: 5,
            order: [[1, "asc"]],
            columns: [
                { title: "Contenedor",
                    "data":"name"
                },
                { title: "Tipo"
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
                }
            ]
            // language: {url: 'web/plugins/DataTables/i18/Spanish.json'
        });

        function  myCallbackFunction(updatedCell, updatedRow, oldValue) {
            var table = $('#data-table2').DataTable();
            // console.log("The new value for the cell is: " + updatedCell.data());
            // console.log(updatedCell);
            // console.log(updatedCell.index().row);
            if(updatedCell.index().column === 6)
            {
                var driverCell = table.cell(updatedCell.index().row, 7);
                driverCell.data("Chico el cojo");
            }


            // var cell = table.cell()
            // console.log("The values for each cell in that row are: " );
            // console.log(updatedRow.data())
            //TODO: valdiar placa y cedula x el servicio y recuperar el nombre del chofe
        }

        var table = $('#data-table2').DataTable();

        table.MakeCellsEditable({
            "onUpdate": myCallbackFunction,
            "inputCss":'form-control',
            "columns": [5,6],
            "allowNulls": {
                "columns": [5, 6],
                "errorClass": 'error'
            },
            "confirmationButton": {
                "confirmCss": 'my-confirm-class',
                "cancelCss": 'my-cancel-class'
            },
            "inputTypes": [
                {
                    "column":5,
                    "type":"text",
                    "options":null
                },
                {
                    "column":6,
                    "type":"text",
                    "options":null
                },
            ]
        });
    }
};

var handleTable3InWizar = function() {
    if ($('#data-table3').length !== 0) {

        // var table = $('#data-table3').DataTable();
        // table.destroy();

        $('#data-table3').DataTable({
            dom: '<"top"iflp<"clear">>rt',
            pagingType: "full_numbers",
            responsive: true,
            info: true,
            processing:true,
            lengthMenu: [5, 10, 15],
            pageLength: 5,
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
                }
            ]
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
                    var className = ['bg-blue'];
                    var type = "";
                    var id = currentCalendarEvent.id;
                    if(value.tonnage === 20)
                    {
                        id = currentCalendarEvent.id + "T20";
                        className = ['bg-green'];
                        type = "T20";
                    }
                    else if(value.tonnage === 40)
                    {
                        id = currentCalendarEvent.id + "T40";
                        className = ['bg-purple'];
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
                        if(value.tonnage === 20)
                        {
                            id = currentCalendarEvent.id + 'T20';
                        }
                        else if(value.tonnage === 40)
                        {
                            id = currentCalendarEvent.id + 'T40';
                        }

                        var result = findTicketEvent(id);
                        if(result.event) // always
                        {
                            result.event.count = result.event.count - 1;
                            result.event.title = result.event.count;
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

                                var calendarEvent = calendarEventMap.get(response['ticket'].calendar_id);

                                var id = calendarEvent.id;

                                if(value.tonnage === 20)
                                {
                                    id = calendarEvent.id + "T20";
                                }
                                else if(value.tonnage === 40)
                                {
                                    id = calendarEvent.id + "T40";
                                }

                                var result = findTicketEvent(id);
                                console.log(result);
                                if(result.event) // always
                                {
                                    result.event.count = result.event.count - 1;
                                    result.event.title = result.event.count;
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
                                    calendarEvent.count = calendarEvent.count + 1;
                                }

                            },
                            error: function(response) {
                                console.log(response);
                                console.log(response['msg']);
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
            // console.log(response);

            $('#calendar').fullCalendar('removeEventSources', calendarSlotEvents.id);
            calendarSlotEvents.events = [];

            $.each(response,function (i) {
                // console.log(response[i].start)
                var startDate = moment(response[i].start);
                 // startDate = moment(startDate);
                var endDate = moment(response[i].end);
                 // endDate = moment(endDate);

                var event = {
                    id: response[i].id,
                    title: response[i].count,
                    count: response[i].count,
                    start: startDate ,
                    end:  endDate  ,
                    allDay:false,
                    className : ['bg-blue'],
                    editable: false,
                    type:'D',
                    calendarId: response[i].id
                }
                // $('#calendar').fullCalendar('renderEvent', event);

                calendarEventMap.set(response[i].id,event);
            });
            // console.log(calendarSlotEvents);
            console.log(calendarEventMap.values());
            calendarSlotEvents.events = Array.from(calendarEventMap.values());

            $('#calendar').fullCalendar('addEventSource', calendarSlotEvents);
            $('#calendar').fullCalendar('refetchEventSources');
        },
        error: function(response) {
            console.log(response);
            console.log(response.responseText);
            result = false;
            // return false;
        }
    });
};

var fetchReceptionTransactions = function () {

    $.ajax({
        // async:false,
        url: homeUrl + "/rd/process/transactions",
        type: "get",
        dataType: "json",
        data:  {id:modelId,
                actived:1, // 1 or 0 TODO no work
        },
        success: function (response) {
            // console.log(response);

            reception = response['reception'];
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
                    minDeliveryDate = moment(response['transactions'][0].delivery_date).utc();
                    maxDeliveryDate = moment(response['transactions'][count - 1].delivery_date).utc().add(1, 'days');

                    // $('#calendar').fullCalendar({
                    //     visibleRange: {
                    //         start: minDeliveryDate,
                    //         end: maxDeliveryDate
                    //     }
                    // });

                    var view = $('#calendar').fullCalendar('getView');
                    view.start = minDeliveryDate;
                    view.end = maxDeliveryDate;

                    console.log(minDeliveryDate);
                    console.log(maxDeliveryDate);

                    fetchCalendar(minDeliveryDate.format('YYYY-MM-DD'), maxDeliveryDate.format('YYYY-MM-DD'), false);

                    fetchTickets(modelId, false);
                }

                firstRun = false;
            }

            return true;
        },
        error: function(response) {
            console.log(response);
            return false;
        }
    });
};

var fetchTickets = function (receptionId, async) {
    $.ajax({
        async:async,
        url: homeUrl + "/rd/ticket/by-reception",
        type: "get",
        dataType:'json',
        data: {
            receptionId: receptionId,
        },
        success: function(response) {
            // console.log(response);

            $('#calendar').fullCalendar('removeEventSources', ticketEvents.id);
            ticketEvents.events = [];

            $.each(response['tickets'],function (i) {

                var className = [];
                var type = "";
                var count = 1;
                var id = response['tickets'][i].calendar_id ;
                var tId = response['tickets'][i].reception_transaction_id;
                var t = transactions.get(tId);
                var container = containers.get(t.container_id);
                var calendar = calendarEventMap.get(id);

                transactionWithTicket.push(tId);
                ticketDataMap.set(tId, {
                    id:response['tickets'][i].id,
                    dateTicket:calendar.start,
                    dateEndTicket:calendar.end,
                    calendarId:id,
                });


                // console.log(c);

                if(container.tonnage === 20)
                {
                    id = id + 'T20';
                    className = ['bg-green'];
                    type = "T20";
                }
                else if(container.tonnage === 40)
                {
                    id = id + 'T40';
                    className = ['bg-purple'];
                    type = "T40";
                }

                var result = findTicketEvent(id);
                if(result.event)
                {
                    result.event.count = result.event.count + count;
                    result.event.title = result.event.count;
                    ticketEvents[result.index]= result.event;
                    result.event.rt.push(tId);
                    // $('#calendar').fullCalendar( 'updateEvent', oldEvent);
                }
                else
                {
                    var event = {
                        id: id,
                        title: count,
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
            });
            // console.log(calendarSlotEvents);

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
var stop_watch_end = moment(stop_watch_start).subtract({'minutes' : 30});

var handleStopWatch = function()
{
    var c = $("#stop_watch");
    stop_watch_start.subtract({seconds: 1});

    if(stop_watch_start.minutes() < 10 )
    {
        $("#stop_watch_widget").removeClass("bg-green")
        $("#stop_watch_widget").addClass("bg-red")
    }

    if(stop_watch_start === stop_watch_end || stop_watch_start.minutes === 0)
    {
        alert("Ha espirado el tiempo de trabajo");
        window.location.reload();
    }

    c.text("00:" + stop_watch_start.format('mm:ss'));
};

$(document).ready(function () {

    moment.locale('es');
    // init wizar
    FormWizardValidation.init();

    Calendar.init();

    handleModal();
    handleTableInModal();
    handleTableInWizar();
    handleTable3InWizar();
    // fetchReceptionTransactions();

    // stop watch
    setInterval(handleStopWatch, 1000);

});
