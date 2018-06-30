

var ticketDataMap = new Map();

var ticketEvents = {
    id:'ticketEvents',
    events:[]
};

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
        result.title = 'Cupos para contenedores de ' +   event.type.replace('T','') + ' toneladas: ' + event.title;
        var containersConten  = '';
        $.each(tickets, function (i) {
            var ticket = ticketDataMap.get(tickets[i]);
            containersConten += "<h5>" + ticket.name + " " + ticket.code + ticket.tonnage + "<h5>";
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

    // $('#select-all-event').on('click', function(){
    //
    // var selectAll = this;
    //     $('#external-events .external-event').each(function() {
    //     	var id = '#checkBox' + $(this).attr('data-id');
    //         $('#checkBox' + $(this).attr('data-id')).get(0).checked = selectAll.checked;
    //     });
    // });

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
                alert('Mostar planificacion del dia');
            }


            // alert('Clicked on: ' + date.format());
            //
            // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            //
            // alert('Current view: ' + view.name);
        },
        dayRender:function( date, cell ) {
            // alert('Day Render');
        },
        select: function(start, end, allDay) {

            // $("#modalTitle").prop('text', new Date(start));
            // if($("#modalTitle").length > 0)
            // {
            //     console.log($("#modalTitle"));
            // }
            // $("#modalTitle").prop('title', new Date(start));
            // $("#modalTitle").get(0).title = new Date(start);
            // $("#modalTitle").val('title', new Date(start));

            // var startDate = new Date(start);// start.format();
            // // var startDate = start.format();
            // // var endDate = end.format();
            // // alert(startDate + ' '+ start.format());
            // $("#modalTitle").get(0).textContent = start.format();
            // $("#modalTicket").get(0).textContent = 'Cupos disponibles: 3';
            //
            // $("#modal-select-containers").modal("show");
            //
            // // init table on date table
            // handleTableInModal();
            // fetchReceptionTransactions();
        },
        eventClick: function(calEvent, jsEvent, view) {

            // var result = findSlotEvent(calEvent.start, calEvent.end);
            //
            // currentCalendarEventIndex = result.index;
            // currentCalendarEvent = result.event;

            if(calEvent.type === 'D')
            {
                // var result = findSlotEvent(calEvent.start, calEvent.end);
                var calendar = calendarEventMap.get(calEvent.id);
                currentCalendarEvent = calEvent;
                if(currentCalendarEvent)
                {
                    if(currentCalendarEvent.count <= 0 )
                    {
                        alert("No hay disponibilidad para esta fecha.");
                        return;
                    }

                    var table = $('#data-table-modal').DataTable();

                    var count = 0;
                    table
                        .clear()
                        .draw();

                    transactions.forEach(function(transaction, key) {

                        var container = containers.get(transaction.container_id);

                        var indexSelected = selectedTransactions.indexOf(transaction.id);
                        var indexTicket = transactionWithTicket.indexOf(transaction.id);

                        if(indexSelected === -1 && indexTicket === -1)
                        {
                            table.row.add(
                                {
                                    checkbox:"",
                                    name: container.name,
                                    type: container.code,
                                    tonnage: container.tonnage,
                                    deliveryDate:transaction.delivery_date,
                                    agency:agency.name,
                                    transactionId:transaction.id
                                }
                            ).draw();
                            count++;
                        }
                    });

                    if(count > 0)
                    {
                        mode = 'create';
                        $('#select-all')[0].checked = false;
                        $("#modalTitle").get(0).textContent = 'Cupos disponibles: ' + currentCalendarEvent.title;
                        $("#modalTicket").get(0).textContent = moment(currentCalendarEvent.start).format("dddd, MMMM YYYY H:mm");
                        $("#modal-select-containers").modal("show");
                    }
                    else {
                        alert('Ya todas los contenedores de esta recepción tienen cupos');
                        return false;
                    }
                }
                else {
                    alert("Error buscando calendar event");
                    return false;
                }
            }
            else {
                var id = calEvent.calendarId; //calEvent.type === "T20"  ? calEvent.calendarId + "T20" : calEvent.calendarId + "T40" ;
                console.log(id);
                currentCalendarEvent = calendarEventMap.get(id) ;

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


                for(var i = 0, length = calEvent.rt.length ; i < length; i++) {

                    var tId = calEvent.rt[i];
                    var transaction = transactions.get(tId);
                    var container = containers.get(transaction.container_id);

                    var indexSelected = selectedTransactions.indexOf(transaction.id);
                    var indexTicket = transactionWithTicket.indexOf(transaction.id);

                    if(indexSelected !== -1 || indexTicket !== -1)
                    {
                        table.row.add(
                            {
                                checkbox:"",
                                name: container.name,
                                type: container.code,
                                tonnage: container.tonnage,
                                deliveryDate:transaction.delivery_date,
                                agency:agency.name,
                                transactionId:transaction.id
                            }
                        ).draw();
                        count++;
                    }
                }

                if(count > 0)
                {
                    mode = 'delete';
                    $('#select-all')[0].checked = false;
                    $("#modalTitle").get(0).textContent = 'Eliminar Cupos';
                    $("#modalTicket").get(0).textContent = moment(currentCalendarEvent.start).format("dddd, MMMM YYYY H:mm");
                    $("#modal-select-containers").modal("show");
                }
            }
        },
        eventRender: function(event, element, calEvent) {
            // var mediaObject = (event.media) ? event.media : '';
            // var description = (event.description) ? event.description : '';
            // element.find(".fc-event-title").after($("<span class=\"fc-event-icons\"></span>").html(mediaObject));
            element.attr('id', 'eee' + event.id);
        },
        eventAfterRender:function( event, element, view ) {

        },
    });
    // var view = $('#calendar').fullCalendar('getView');
    // var startDate = new Date(view.start);
    // var endDate = new Date(view.end);
    // fetchCalendar(startDate.toISOString(),endDate.toISOString());
};

var fetchTickets = function (async) {
    $.ajax({
        async:async,
        url: homeUrl + "/rd/ticket/shedule",
        type: "get",
        dataType:'json',
        // data: {
        //     receptionId: receptionId,
        // },
        success: function(response) {
            console.log(response);

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
                    end_datetime:response['tickets'][i].end_datetime
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
                        start: ticket.start_datetime,
                        end:  ticket.end_datetime,
                        allDay:false,
                        className : className ,
                        editable: false,
                        type:type,
                        count:count,
                        tickets:[ticket.id],
                        index: -1
                    };
                    ticketEvents.events.push(event);
                    event.index = ticketEvents.events.length - 1;
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

var Calendar = function () {
    "use strict";
    return {
        //main function
        init: function () {
            handleCalendarDemo();
        }
    };
}();



$(document).ready(function () {
    Calendar.init();

    fetchTickets();
});