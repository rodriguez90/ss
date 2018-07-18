var handleResize = function (view) {
    if(view.name === 'agendaWeek' || view.name === 'agendaDay')
        $('#calendar').find('.fc-time-grid .fc-slats td').css('height', '5.5em');
}

var renderDefaultEvent = function (view, value, total) {
    var eventObject = {
		title: value,
		className: 'bg-grey',
		// media: $(this).attr('data-media'),
		description: 'Cupos disponibles ' + value,
		id:-1,
	};
}

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
	// var buttonSetting = {left: 'today prev,next ', center: 'title', right: 'month,basicWeek,basicDay'};

	var calendar = $('#calendar').fullCalendar({
        // locale: 'es',
        height: 300,
        contentHeight:250,
        // aspectRatio:3.0,
		header: buttonSetting,
		selectable: true,
        editable: true,
		selectHelper: true,
		droppable:false,
        defaultView:'agendaWeek',
        allDaySlot: false,
        // views: {
        //     day: {
        //         // titleFormat: 'MMM D, YYYY',
        //         allDaySlot:false,
        //         // allDayText:'',
        //     },
        //     month: {
        //         // titleFormat: 'MMM D, YYYY'
        //     },
        //     agenda: {
        //         // titleFormat: 'MMM D, YYYY',
        //         // contentHeight:'auto',       //auto
        //         allDaySlot: false, //Disable the allDay slot in agenda view
        //     }
        // },
        firstHour:0,
        slotEventOverlap:false,
        eventOverlap: false,
        slotDuration:"00:60:00",
        slotLabelInterval:{hours:1},
        timeFormat: 'HH:mm',
        slotLabelFormat: 'HH:mm',
        // minTime:"00:00:00",
        // maxTime:"23:0:00",
        displayEventTime:false,
        displayEventEnd:false,
        // timezone:'UTC',
        eventOrder:'id',
        viewRender:function( view, element ) {
            // var start = view.start;
            // var end = view.end;
            var startDate = new Date(view.start);
            var endDate = new Date(view.end);
            // fetchCalendar(startDate.toISOString(),endDate.toISOString());
            // handleResize(view);
		},
        eventAfterAllRender:function( view ) {
            // handleResize(view);
        },
        eventMouseover:function( event, jsEvent, view ) {

            var result = makePopoverContent(event);
            $(this).popover({
                html: true,
                title: result.title,
                content: result.conten,
                container: $('#page-container'),
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
        },
        dayRender:function( date, cell ) {

		},
		select: function(start, end, allDay) {

		},
        eventClick: function(calEvent, jsEvent, view) {

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
                    var count2 = 0;
                    table
                        .clear()
                        .draw();

                    transactions.forEach(function(transaction, key) {

                        var container = containers.get(transaction.container_id);

                        var indexSelected = selectedTransactions.indexOf(transaction.id);
                        var indexTicket = transactionWithTicket.indexOf(transaction.id);
                        var deliveryDate = moment(transaction.delivery_date).format('YYYY/MM/DD');
                        var calendarDeliveryDate = moment(currentCalendarEvent.end).format('YYYY/MM/DD');

                        // var now = moment();
                        // var then = moment(date);

                        // if (compareTo > then) {
                        //     $('.result').text('Date is past');
                        // } else {
                        //     $('.result').text('Date is future');
                        // }

                        var result = moment(calendarDeliveryDate) <= moment(deliveryDate);

                        if(indexSelected === -1 && indexTicket === -1)
                        {
                            if(result)
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
                            else
                            {
                                count2++;
                            }
                        }
                    });

                    if(count > 0)
                    {
                        mode = 'create';
                        $('#select-all')[0].checked = false;
                        $("#modalTitle").get(0).textContent = 'Cupos disponibles: ' + currentCalendarEvent.title;
                        $("#modalTicket").get(0).textContent = moment(currentCalendarEvent.start).format("dddd, MMMM YYYY H:mm");
                        $("#aceptBtn").removeClass("btn-danger").addClass("btn-success");
                        $("#aceptBtn").text("Aceptar");
                        $("#modal-select-containers").modal("show");
                    }
                    else
                    {
                        if(count2)
                        {
                            alert('La fecha seleccionada en el calendario es mayor que la fecha límite de los contenedores');
                            return false;
                        }
                        {
                            alert('Ya todas los contenedores de esta recepción tienen cupos');
                            return false;
                        }
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
                    $("#aceptBtn").removeClass("btn-success").addClass("btn-danger");
                    $("#aceptBtn").text("Eliminar");
                    $("#modal-select-containers").modal("show");
                }
            }
        },
		eventRender: function(event, element, calEvent) {
            element.attr('id', 'eee' + event.id);
        },
        eventAfterRender:function( event, element, view ) {

		},
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
