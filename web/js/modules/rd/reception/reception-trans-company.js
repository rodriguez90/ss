/**
 * Created by pedro on 30/05/2018.
 */

var firstRun = true;

var reception = null;
var agency = null;
var transactions = new Map();
var containers = new Map();
var ticketDataMap =  new Map();

var calendarSlotMap = new Map();

var calendarSlotEvents = {
    id:'calendarSlotEvents',
    events:[]
};

var ticketEvents = {
    id:'ticketEvents',
    events:[]
};

var currentCalendarEventIndex = -1;
var currentCalendarEvent = null;

// el calendario se acota x la fecha de devolución de los contenedores relacionados en la recepcion
var minDate = null;
var maxDate = null;

var selectedTransactions = [];
var transactionWithTicket = [];

// functions

var findSlotEvent = function (start, end) {
    var result = {
        index:-1,
        event:null
    };
    var startFormated = start.format("YYYY-MM-dd h:mm");
    var endFormated = end.format("YYYY-MM-dd h:mm");
    $.each(calendarSlotEvents.events,function (i)
    {
        var event = calendarSlotEvents.events[i];
        // if(i== 0)
        // {
        //     console.log(event);
        //     console.log('UTC');
        //     console.log(start.utc() );
        //     console.log(moment(event.start).utc() );
        //     console.log('FORMAT');
        //     console.log(start.format("YYYY-MM-DD h:mm") );
        //     console.log(moment(event.start).format("YYYY-MM-DD h:mm") );
        //     console.log('valueOf');
        //     console.log(start.valueOf());
        //     console.log(moment(event.start).valueOf());
        //     console.log('COMPARE');
        //     console.log(startFormated === moment(event.start).format("YYYY-MM-dd h:mm"));
        // }

        if(event.type === "D" && startFormated === moment(event.start).format("YYYY-MM-dd h:mm") &&
            endFormated === moment(event.end).format("YYYY-MM-dd h:mm"))
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

        var table = $('#data-table-modal').DataTable();
        table.destroy();

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
            responsive: true,
            info: true,
            processing:true,
            lengthMenu: [5, 10, 15],
            pageLength: 5,
            // order: [[ 0, 'asc' ]],
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
                    // "render": function ( data, type, row, meta ) {
                    //     // id="blCode"
                    //     // name="blCode"
                    //     return "<input type=\"text\"  data-parsley-type=\"alphanum\"  data-parsley-length=\"[10, 10]\" placeholder=\"Placa del Carro\"  data-parsley-trigger=\"focusout\" data-parsley-required=\"true\"/>"
                    //
                    // }
                    // editField: "registerTrunk"
                },
                { title: "Cédula del Chofer",
                    "data":"registerDriver",
                    // "render": function ( data, type, row, meta ) {
                    //     // id="blCode"
                    //     // name="blCode"
                    //     return "<input type=\"text\"  data-parsley-type=\"digits\"  data-parsley-length=\"[10, 10]\" placeholder=\"Cédula del Chofer\"  data-parsley-trigger=\"focusout\" data-parsley-required=\"true\"/>"
                    //
                    // }
                }
            ],
            language: {
                "lengthMenu": "Mostrar _MENU_ filas por página",
                "zeroRecords": "No hay datos que mostrat - disculpe",
                "info": "Página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay información que mostrar",
                "infoFiltered": "(encontrados from _MAX_ total records)"
            },
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
            console.log("The new value for the cell is: " + updatedCell.data());
            console.log("The values for each cell in that row are: " + updatedRow.data());
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
                // {
                //     "column":1,
                //     "type": "list",
                //     "options":[
                //         { "value": "1", "display": "Beaty" },
                //         { "value": "2", "display": "Doe" },
                //         { "value": "3", "display": "Dirt" }
                //     ]
                // }
                // ,{
                //     "column": 2,
                //     "type": "datepicker", // requires jQuery UI: http://http://jqueryui.com/download/
                //     "options": {
                //         "icon": "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif" // Optional
                //     }
                // }
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

        // console.log($('#aceptBtn').attr('disabled'));

        if(this.checked)
        {
            if(count <= disponivility)
            {
                table.rows().select();
                // $('#aceptBtn').attr('disabled', false);
            }
            else {
                this.checked = false;
                // $('#aceptBtn').attr('disabled', true);
                alert('Solo hay ' + disponivility + ' cupos disponibles.');
            }
            return;
        }

        table.rows().deselect();
    });

    $('#aceptBtn').on('click', function(){

        var table = $('#data-table-modal').DataTable();

        var count = table.rows( { selected: true } ).count();
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
                // var dateFormated = moment(currentCalendarEvent.star).format("YYYY-MM-DD h:mm");
                if(selectedTransactions.indexOf(value.transactionId) === -1)
                {
                    selectedTransactions.push(value.transactionId);

                    ticketDataMap.set(value.transactionId, {
                        dateTicket:currentCalendarEvent.start,
                        calendarId:currentCalendarEvent.id,
                    });
                }

                currentCalendarEvent.count = currentCalendarEvent.count - 1;

                // create event ticket
                var className = ['bg-blue'];
                var type = "";
                var id = currentCalendarEvent.id;
                if(value.tonnage === 20)
                {
                    id = currentCalendarEvent.id + 1;
                    className = ['bg-green'];
                    type = "T20";
                }
                else if(value.tonnage === 40)
                {
                    id = currentCalendarEvent.id + 2;
                    className = ['bg-purple'];
                    type = "T40";
                }

                var count = 1;
                var result = findTicketEvent(id);

                if(result.event)
                {
                    result.event.count = result.event.count + count;
                    result.event.title = result.event.count;
                    ticketEvents[result.index] = result.event;
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

            currentCalendarEvent.title = currentCalendarEvent.count;
            console.log(ticketEvents);
            // console.log(currentCalendarEvent);
            calendarSlotEvents.events[currentCalendarEventIndex]=currentCalendarEvent;

            $('#calendar').fullCalendar('addEventSource',calendarSlotEvents);
            $('#calendar').fullCalendar('addEventSource',ticketEvents);
            $('#calendar').fullCalendar('refetchEventSources');
            $("#modal-select-containers").modal("hide");
    });
};

var fetchCalendar = function (start, end) {
    $.ajax({
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

                var event = {
                    id: response[i].id,
                    title: response[i].count,
                    count: response[i].count,
                    start: response[i].start ,
                    end:  response[i].end ,
                    allDay:false,
                    className : ['bg-blue'],
                    editable: false,
                    type:'D',
                    calendarId: response[i].id
                }
                // $('#calendar').fullCalendar('renderEvent', event);

                calendarSlotEvents.events.push(event);
                calendarSlotMap.set(response[i].id, {
                    id:response[i].id,
                    amount:response[i].count,
                    start:response[i].start,
                    end:response[i].end,
                });
            });
            // console.log(calendarSlotEvents);

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
        url: homeUrl + "/rd/reception/transactions",
        type: "get",
        dataType: "json",
        data:  {id:modelId,
            actived:1,// 1 or 0 TODO no work
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
                    minDate = response['transactions'][0].delivery_date;
                    maxDate =  response['transactions'][count - 1].delivery_date;

                    var endDate = moment(maxDate).add(1, 'days');
                    fetchCalendar(minDate, endDate.format('YYYY-MM-DD'));
                }

                fetchTickets(modelId);

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

var fetchTickets = function (receptionId) {
    $.ajax({
        url: homeUrl + "/rd/ticket/by-reception",
        type: "get",
        dataType:'json',
        data: {
            receptionId: receptionId,
        },
        success: function(response) {
            console.log(response);

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
                var calendar = calendarSlotMap.get(id);

                transactionWithTicket.push(tId);

                // console.log(c);

                if(container.tonnage === 20)
                {
                    id = id + 1;
                    className = ['bg-green'];
                    type = "T20";
                }
                else if(container.tonnage === 40)
                {
                    id = id + 2;
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
                        rt:[tId]
                    };
                    ticketEvents.events.push(event);
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

$(document).ready(function () {

    moment.locale('es');
    // init wizar
    FormWizardValidation.init();

    Calendar.init();

    handleModal();

    handleTableInWizar();

    fetchReceptionTransactions();

    // acotar el calendario

    // cronometer
    setInterval(function () {
        var m = $("#minutes");
        var s = $("#seconds");
        var currentMinutes = parseInt(m.text());
        var currentSeconds = parseInt(s.text());
        currentSeconds--;

        if(currentSeconds === 0) {
            currentMinutes--;
            currentSeconds = 59;
        }

        if(currentMinutes === 0)
        {
            currentSeconds = 0;
            alert("Ha espirado el tiempo de trabajo");
            window.location.reload();
        }

        m.text(currentMinutes);
        s.text(currentSeconds);

    }, 1000);

});
