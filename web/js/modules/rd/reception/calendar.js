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
	var date = new Date();
	var m = date.getMonth();
	var y = date.getFullYear();

	var calendar = $('#calendar').fullCalendar({
        locale: 'es',
        // height: 1000,
        // contentHeight:auto,
        // aspectRatio:3.0,
		header: buttonSetting,
		selectable: true,
        editable: true,
		selectHelper: true,
		droppable:false,
        defaultView:'agendaWeek',
        contentHeight:'auto',       //auto
        views: {
            day: {
                titleFormat: 'MMM D, YYYY',
                allDaySlot:false,
                // allDayText:'',
            },
            month: {
                selectable: false,
                titleFormat: 'MMM D, YYYY'
            },
            agenda: {
                contentHeight:'auto',       //auto
                allDaySlot: false, //Disable the allDay slot in agenda view
                // allDayText:'',
                // scrollTime: '00:00:00' //This is to keep the scrollbar on top in the agenda week/day view so that we can see all events.
                // slotEventOverlap: false
            }
        },
        slotEventOverlap:false,
        eventOverlap: false,
        slotDuration:"00:60:00",
        // slotLabelInterval:{hours:1},
        slotLabelFormat:'h:mm',
        minTime:"07:00:00",
		maxTime:"16:00:00",
        displayEventTime:false,
        displayEventEnd:false,
        timezone:'UTC',
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

            // <a id='popover' href="#" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover">Toggle popover</a>
            // console.log(popoverHtml);
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
            // console.log(this);
            $(this).popover('show');
            // console.log(this);
            // $('#ppp'+ event.id).popover();
            // $('#ppp' + event.id).popover("show");
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

            var result = findSlotEvent(calEvent.start, calEvent.end);

            console.log('Slot Event Selected: ');
            console.log(result);

            if(result.event)
            {
                currentCalendarEventIndex = result.index;
                currentCalendarEvent = result.event;

                if(currentCalendarEvent.count <=0 )
                {
                    alert("No hay disponibilidad para esta fecha.");
                    return;
                }


                // init table on date table
                handleTableInModal();
                // fetchReceptionTransactions();

                var table = $('#data-table-modal').DataTable();

                var count = 0;
                table
                    .clear()
                    .draw();

                transactions.forEach(function(transaction, key) {

                    var container = containers.get(transaction.container_id);

                    var indexSelected = selectedTransactions.indexOf(transaction.id);
                    var indexTicket = transactionWithTicket.indexOf(transaction.id);

                    if(indexSelected === -1 && indexTicket == -1)
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
                    var startDate = new Date(currentCalendarEvent.start);// start.format();
                    $("#modalTitle").get(0).textContent = moment(currentCalendarEvent.start).format("dddd, MMMM YYYY h:mm");
                    $("#modalTicket").get(0).textContent = 'Cupos disponibles: ' + currentCalendarEvent.title;
                    $("#modal-select-containers").modal("show");
                    $('#select-all')[0].checked = false;
                }
                else {
                    alert('Ya todas los contenedores de esta recepción tienen cupos');
                }
            }

            // alert('Event: ' + calEvent.title);
            // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            // alert('View: ' + view.name);
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


var Calendar = function () {
	"use strict";
    return {
        //main function
        init: function () {
            handleCalendarDemo();
        }
    };
}();

//
// $(document).ready(function () {
//     Calendar.init();
// });