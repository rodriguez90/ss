

var ticketDataMap = new Map();

var ticketEvents = {
    id:'ticketEvents',
    events:[]
};

var minDeliveryDate = moment();

var calendarEventMap = new Map(); // calendar id - key
var currentCalendarEvent = null;

// make custom conten to popover by event
var makePopoverContent = function (event) {
    var result = {
        title:'',
        conten:''
    };

    if(event.type === 'D')
    {
        result.title = 'Cupos disponibles: ' + event.title;
    }
    else if(event.type === 'T20' || event.type === 'T40')
    {
        var tickets = event.tickets;
        result.title = 'Turnos para contenedores de ' +   event.type.replace('T','') + ' toneladas: ' + event.title;
        var containersConten  = '';
        $.each(tickets, function (i) {
            var ticket = ticketDataMap.get(tickets[i]);
            containersConten += "<h5>" + ticket.name + " " + ticket.code + ticket.tonnage + " " + ticket.register_truck + "/"+ ticket.name_driver+"<h5>";
        });

        result.conten = containersConten;
    }

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

var handleCalendarDemo = function () {
    "use strict";

    // calendar
    var buttonSetting = {left: 'today prev,next ', center: 'title', right: 'month,agendaWeek,agendaDay'};

    var calendar = $('#calendar').fullCalendar({
        // locale: 'es',
        height: 300,
        contentHeight:300,
        // aspectRatio:3.0,
        header: buttonSetting,
        selectable: true,
        editable: true,
        selectHelper: true,
        droppable:false,
        defaultView:'agendaWeek',
        views: {
            day: {
                // titleFormat: 'MMM D, YYYY',
                allDaySlot:false,
                // allDayText:'',
            },
            month: {
                // titleFormat: 'MMM D, YYYY'
            },
            agenda: {
                // titleFormat: 'MMM D, YYYY',
                // contentHeight:'auto',       //auto
                allDaySlot: false, //Disable the allDay slot in agenda view
            }
        },
        slotEventOverlap:false,
        eventOverlap: false,
        slotDuration:"00:60:00",
        slotLabelInterval:{hours:1},
        displayEventTime:false,
        displayEventEnd:false,
        // timezone:'UTC',
        eventOrder:'id',
        viewRender:function( view, element ) {
        },
        eventAfterAllRender:function( view ) {
        },
        eventMouseover:function( event, jsEvent, view ) {
            var result = makePopoverContent(event);
            $(this).popover({
                html: true,
                title: result.title,
                content: result.conten,
                // 'container': $(this).parent().parent(),
                container: $('#page-container'),
                // placement:'left',
                placement:'auto',
                selector:true
            });
            $(this).popover('show');
        },
        eventMouseout:function( event, jsEvent, view ) {
            $(this).popover("destroy");
        },
        dayClick: function( date, jsEvent, view, resourceObj ) {
            var view = $('#calendar').fullCalendar('getView');
            if(view.name === 'month')
            {
                // alert('Mostar planificacion del dia');
            }
            return;
        },
        eventClick: function(calEvent, jsEvent, view)
        {
            currentCalendarEvent = calEvent;

            if(!currentCalendarEvent)
            {
                alert("Error buscando calendar");
                return false;
            }

            var table = $('#data-table-modal').DataTable();

            table
                .clear()
                .draw();

            var count = 0;

            if(calEvent.tickets.length)
            {
                for(var i = 0, length = calEvent.tickets.length ; i < length; i++)
                {
                    var ticketId = calEvent.tickets[i];
                    var ticketData = ticketDataMap .get(ticketId);
                    table.row.add(
                        {
                            checkbox:"",
                            name: ticketData.name,
                            type: ticketData.code,
                            tonnage: ticketData.tonnage,
                            deliveryDate:ticketData.delivery_date,
                            agency:ticketData.agencyName,
                            ticketId:ticketId
                        }
                    ).draw();
                }

                $('#select-all')[0].checked = false;
                $("#modalTitle").get(0).textContent = 'Eliminar Cupos';
                $("#modalTicket").get(0).textContent = moment(ticketData.start_datetime).format("dddd, MMMM YYYY H:mm");
                $("#modal-select-containers").modal("show");
            }
        },
        eventRender: function(event, element, calEvent) {
            // var mediaObject = (event.media) ? event.media : '';
            // var description = (event.description) ? event.description : '';
            // element.find(".fc-event-title").after($("<span class=\"fc-event-icons\"></span>").html(mediaObject));
            // element.attr('id', 'eee' + event.id);
        },
        eventAfterRender:function( event, element, view ) {

        },
    });
};

var fetchTickets = function (async)
{
    $.ajax({
        async:async,
        url: homeUrl + "/rd/ticket/shedule",
        type: "get",
        dataType:'json',
        // data: {
        //     receptionId: receptionId,
        // },

        success: function(response) {

            if(response['success'])
            {
                $('#calendar').fullCalendar('removeEventSources', ticketEvents.id);
                ticketEvents.events = [];

                $.each(response['tickets'],function (i) {

                    var ticket = {
                        id: response['tickets'][i].id,
                        calendar_id: response['tickets'][i].calendar_id,
                        name:response['tickets'][i].name,
                        code:response['tickets'][i].code,
                        tonnage:response['tickets'][i].tonnage,
                        start_datetime:response['tickets'][i].start_datetime,
                        end_datetime:response['tickets'][i].end_datetime,
                        register_truck:response['tickets'][i].register_truck,
                        register_driver:response['tickets'][i].register_driver,
                        name_driver:response['tickets'][i].name_driver,
                        delivery_date:response['tickets'][i].delivery_date,
                        agencyName:response['tickets'][i].agencyName,
                        bl:response['tickets'][i].bl,
                    };

                    var className = [];
                    var type = "";
                    var count = 1;
                    var id = "";

                    ticketDataMap.set(ticket.id, ticket);

                    if(ticket.tonnage === "20")
                    {
                        id = ticket.calendar_id + 'T20';
                        className = ['bg-green-darker'];
                        type = "T20";
                    }
                    else if(ticket.tonnage === "40")
                    {
                        id = ticket.calendar_id + 'T40';
                        className = ['bg-purple-darker'];
                        type = "T40";
                    }

                    var result = findTicketEvent(id);

                    if(result.event)
                    {
                        result.event.count = result.event.count + count;
                        result.event.title = result.event.count;
                        ticketEvents[result.index]= result.event;
                        result.event.tickets.push(ticket.id);
                    }
                    else
                    {
                        var event = {
                            id: id,
                            title: count,
                            ticketId:ticket.id,
                            start: ticket.start_datetime,
                            end:  ticket.end_datetime,
                            allDay:false,
                            className : className ,
                            editable: false,
                            type:type,
                            count:count,
                            tickets:[ticket.id],
                            index: -1,
                        };
                        ticketEvents.events.push(event);
                    }
                });

                $('#calendar').fullCalendar('addEventSource',ticketEvents);
                $('#calendar').fullCalendar('refetchEventSources');

                if(response['tickets'].length > 0)
                {
                    minDeliveryDate = response['tickets'][0].start_datetime;
                }

                $('#calendar').fullCalendar('gotoDate', moment(minDeliveryDate) );
            }
            else
            {
                alert(response['msg']);
            }
        },
        error: function(response) {
            console.log(response);
            console.log(response.responseText);
            result = false;
        }
    });
};

var Calendar = function () {
    "use strict";
    return {
        //main function
        init: function () {
            handleCalendarDemo();
        }
    };
}();

var handleModal = function () {

    // select all in modal table
    $('#select-all').on('click', function()
    {
        var table = $('#data-table-modal').DataTable();
        var count = table.rows( ).count();

        if(this.checked)
        {
            table.rows().select();
            return;
        }
        table.rows().deselect();
    });

    $('#aceptBtn').on('click', function(){

        var table = $('#data-table-modal').DataTable();

        var count = table.rows( { selected: true } ).count();

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

                var ticket = ticketDataMap.get(value.ticketId, null);

                if(ticket === null) //  ticket bug error
                {
                    return false;
                }

                if(ticket.id != -1) // delete ticket from db
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
                                var ticketData = ticketDataMap.get(String(response['ticket'].id));

                                var id = ticketData.id;

                                if(String(ticketData.tonnage) === "20")
                                {
                                    id = ticketData.calendar_id + "T20";
                                }
                                else if(String(ticketData.tonnage) === "40")
                                {
                                    id = ticketData.calendar_id + "T40";
                                }
                                var result = findTicketEvent(id);

                                if(result.event) // always
                                {
                                    result.event.count = parseInt(result.event.count) - 1;
                                    result.event.title = String(result.event.count);
                                    var indexTicket = result.event.tickets.indexOf(ticketData.id)
                                    result.event.tickets.splice(indexTicket, 1);

                                    if(result.event.count == 0)
                                    {
                                        ticketEvents.events.splice(result.index, 1);
                                    }
                                    else {
                                        ticketEvents[result.index] = result.event;
                                        // ticketEvents.events[result.index] = result.event; //TODO check this
                                    }
                                    ticketDataMap.delete(ticketData.id);
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

        $('#calendar').fullCalendar('addEventSource',ticketEvents);
        $('#calendar').fullCalendar('refetchEventSources');
        $("#modal-select-containers").modal("hide");
    });
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
    }
};

$(document).ready(function ()
{
    Calendar.init();
    handleModal();
    handleTableInModal();
    fetchTickets();
});