var selectedReceptionTransaction = [];

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
                allDayText:'',
            },
            month: {
                selectable: false,
                titleFormat: 'MMM D, YYYY'
            },
            agenda: {
                contentHeight:'auto',       //auto
                allDaySlot: false, //Disable the allDay slot in agenda view
                allDayText:'',
                // scrollTime: '00:00:00' //This is to keep the scrollbar on top in the agenda week/day view so that we can see all events.
                // slotEventOverlap: false
            }
        },
        slotEventOverlap:true,
        eventOverlap: false,
        slotDuration:"00:60:00",
		minTime:"07:00:00",
		maxTime:"16:00:00",
        displayEventTime:false,
        displayEventEnd:false,
        timezone:'UTC',
        drop: function(date, allDay) { // this function is called when something is dropped

			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');
			
			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);
			
			// assign it the date that was reported
			copiedEventObject.start = date;
			copiedEventObject.allDay = allDay;
			
			// render the event on the calendar
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

            // if so, remove the element from the "Draggable Events" list
            $(this).remove();
		},
        viewRender:function( view, element ) {
            // handleResize(view);
            // var start = view.start;
            // var end = view.end;
            var startDate = new Date(view.start);
            var endDate = new Date(view.end);
            fetchCalendar(startDate.toISOString(),endDate.toISOString());
		},
        eventAfterAllRender:function( view ) {
            // handleResize(view);
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

            var startDate = new Date(start);// start.format();
            // var startDate = start.format();
            var endDate = end.format();
            // alert(startDate + ' '+ start.format());
            $("#modalTitle").get(0).textContent = start.format();
            $("#modalTicket").get(0).textContent = 'Cupos disponibles: 3';

            $("#modal-select-containers").modal("show");

            // init table on date table
            handleInitTableInModal();
            searchRTByReception();
		},
        eventClick: function(calEvent, jsEvent, view) {

            alert('Event: ' + calEvent.title);
            alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            alert('View: ' + view.name);

            // change the border color just for fun
            // $(this).css('border-color', 'red');

        },
        // windowResize: function(view) {
        //     handleResize(view);
        // },
		eventRender: function(event, element, calEvent) {
				// var mediaObject = (event.media) ? event.media : '';
				// var description = (event.description) ? event.description : '';
            // element.find(".fc-event-title").after($("<span class=\"fc-event-icons\"></span>").html(mediaObject));
            // element.find(".fc-event-title").append('<small>'+ description +'</small>');
        },
        eventAfterRender:function( event, element, view ) {

		},
	});

    var view = $('#calendar').fullCalendar('getView');
    var startDate = new Date(view.start);
    var endDate = new Date(view.end);
    fetchCalendar(startDate.toISOString(),endDate.toISOString());
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