/**
 * Created by PhpStorm.
 * User: yopt
 * Date: 06/06/2018
 * Time: 10:26 AM
 */

var events = [];

var min_date = new Date( new Date().getTime() - 691200000 );
var max_date = new Date( new Date().getTime() + 691200000 );

var fullcalendatInit = false;

$(function (){

    $("#grabar").click(function () {

        $.ajax({
            url: homeUrl + "rd/calendar/create",
            dataType: 'json',
            type: "POST",
            data: {'events':events},

            success: function (response) {
                if(response['status']){
                    $.gritter.add({
                       title: "Grabar cupos",
                       text: response['msg'],
                       time:5000,
                    });


                    $.each(response["events"],function (i) {

                        var response_start = response["events"][i].start.split(' ');
                        var response_end = response["events"][i].end.split(' ');

                        var array_time1 = response_start[1].split(':');
                        var array_time2 = response_end[1].split(':');

                        var time1 = array_time1[0];
                        var time2 = array_time2[0];

                        var array1 = response_start[0].split("-");
                        var array2 = response_end[0].split("-");

                        var start_y = parseInt(array1[0]);
                        var start_m = parseInt(array1[1]);
                        var start_d = parseInt(array1[2]);

                        var end_y = parseInt(array2[0]);
                        var end_m = parseInt(array2[1]);
                        var end_d = parseInt(array2[2]);


                        var start_event_db = new Date(Date.UTC(start_y, start_m - 1, start_d, time1, 0, 0));
                        var end_event_db = new Date(Date.UTC(end_y, end_m - 1, end_d, time2, 0, 0));

                        //esto convertirlo en la función exist
                        for (var j = 0; j < events.length; j++) {
                            var event_start = events[j].start;
                            var event_end = events[j].end;
                            if (event_start.getTime() === start_event_db.getTime() && event_end.getTime() === end_event_db.getTime()) {
                                events[j].title = response["events"][i].title;
                                console.log(" actualizado");
                            }
                        }

                    });



                  $('#calendar').fullCalendar('removeEvents');
                  $('#calendar').fullCalendar('addEventSource',events);
                  $('#calendar').fullCalendar('refetchEvents');

                }else{
                    $.gritter.add({
                        title: "Error",
                        text: response['msg'],
                        time:5000,
                    });
                }
                console.log(response);

            },
            error: function (response) {
                console.log(response.responseText);
                return false;
            }

        });
        return false;
    });


    $("#add-cupos").click(function () {

        var evetsUpdate = false;

        if( $("#start").val() != "" && $("#end").val() != "" &&  $("#selectpicker-desde").val() != "" && $("#selectpicker-hasta").val() != "" && $("#amount").val() ){

            if( parseInt($("#selectpicker-desde").val())  <= parseInt($("#selectpicker-hasta").val()) ){

                var start = $("#start").val().split("-");
                var d_start = start[0];
                var m_start = start[1];
                var y_start = start[2];
                var end = $("#end").val().split("-");
                var d_end = end[0];
                var m_end = end[1];
                var y_end = end[2];
                var desde = $("#selectpicker-desde").val();
                var hasta = $("#selectpicker-hasta").val();
                var amount = $("#amount").val();

                var ini = new Date(y_start + '-' + m_start + '-' + d_start);
                var fin  = new Date(y_end + '-' + m_end + '-' + d_end );

                var hora = 3600000;
                var dia = 86400000;

                ini = new Date(ini.getTime() +  parseInt(desde) * hora );
                fin = new Date(fin.getTime() +  parseInt(desde) * hora );

                while  ( ini <= fin){
                    var h_stard = ini;
                    var h_end = new Date( ini.getTime() - parseInt(desde) * hora+ parseInt(hasta) * hora);

                    while (h_stard < h_end){
                        var h_end_aux =new Date( h_stard.getTime() + hora );
                        var event = {
                            update:false,
                            //pos:-1,
                            id: -1,
                            title:amount+ "",
                            start:h_stard,
                            end:h_end_aux,
                            allDay:false,
                            className : ['event_rd'],
                            editable: false,
                            amount:amount
                        };

                        var pos = -1;
                        for(var i = 0; i<events.length; i++){
                            var event_start = events[i].start;
                            var event_end = events[i].end;
                            if( event_start.getTime() === h_stard.getTime() && event_end.getTime() === h_end_aux.getTime()){
                                //pregnutar antes d grabar
                                pos = i;
                                evetsUpdate = true;
                                break;
                            }
                        }

                        if(pos == -1){
                            events.push( event );
                        }else{
                            events[pos].title = event['title'];
                            events[pos].update = true;
                           }
                        h_stard = new Date( h_stard.getTime() + hora );
                    }
                    var aux = ini.getTime();
                    ini = new Date( (aux + dia) ) ;
                }

                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('addEventSource',events);
                $('#calendar').fullCalendar('refetchEvents');


                console.log("addEvens",events);


            }else{
                alert("!Error. El campo 'Desde' tiene que ser menor que el campo 'Hasta'.")
            }
        }else{
            alert("!Error. Todos los campos son requeridos.")
        }
    });

    $.ajax({
        url: homeUrl+ "/rd/calendar/getcalendar",
        dataType:'json',
        type: "get",
        data: {
            start: min_date.toISOString(),
            end: max_date.toISOString()
        },
        success: function (response) {

            var calendar = $('#calendar').fullCalendar({

                header: {
                    //left: 'prev,next today',
                    left: 'next today',
                    center: 'title',
                    //right: 'month,agendaWeek,agendaDay'
                },
                viewRender:function (view,elemnt) {

                    if(fullcalendatInit){

                        var min =  new Date(view.start);
                        var max = new Date(view.end);

                        $.ajax({
                            url: homeUrl+ "rd/calendar/getcalendar",
                            dataType:'json',
                            type: "get",
                            data: {
                                start: min.toISOString(),
                                end: max.toISOString()
                            },
                            success: function (response) {

                                for(var i = 0; i<events.length; i++){
                                    if( !events[i].update && events[i].id !=-1 ){
                                        events.splice(i,1);
                                        i = i - 1;
                                    }
                                }
                                //actualizando eventos
                                $.each(response,function (i) {

                                    var response_start = response[i].start.split(' ');
                                    var response_end = response[i].end.split(' ');

                                    var time1 = response_start[1].substr(0,2);
                                    var time2 = response_end[1].substr(0,2);

                                    var array1 = response_start[0].split("-");
                                    var array2 = response_end[0].split("-");

                                    var start_y = parseInt(array1[0]);
                                    var start_m = parseInt(array1[1]);
                                    var start_d =parseInt(array1[2]);

                                    var end_y = parseInt(array2[0]);
                                    var end_m = parseInt(array2[1]);
                                    var end_d = parseInt(array2[2]);

                                    var start_event_db = new Date(Date.UTC (start_y,start_m-1,start_d,time1,0,0) );
                                    var end_event_db =  new Date( Date.UTC(end_y,end_m-1,end_d,time2,0,0));

                                    //esto convertirlo en la función exist
                                    var pos = -1;
                                    for(var j = 0; j<events.length; j++){
                                        var event_start = events[j].start;
                                        var event_end = events[j].end;
                                        if( event_start.getTime() === start_event_db.getTime() && event_end.getTime() === end_event_db.getTime()){
                                            pos = j;
                                            break;
                                        }
                                    }
                                    if(pos==-1){
                                        var event = {update: false, id: response[i].id, title: response[i].title,start:start_event_db ,end:end_event_db , url:response[i].url,   allDay:false, className : ['event_rd'], editable: false}
                                        events.push(event);
                                    }

                                });

                                $('#calendar').fullCalendar('removeEvents');
                                $('#calendar').fullCalendar('addEventSource',events);
                                $('#calendar').fullCalendar('refetchEvents');


                                console.log("viewRender: " , events);



                            },
                            error: function(response) {
                                console.log(response.responseText);
                                return false;
                            }
                        });

                    } 
                },
                selectable: false,
                selectHelper: true,
                slotDuration:"00:60:00",
                //contentHeight:'auto',
                height:500,
                locale:"es",
                timezone:"UTC",
                //minTime:"07:00:00",
                //maxTime:"16:00:00",
                defaultView: 'agendaWeek',
                select: function(start, end, allDay) {
                    var title = prompt('Event Title:');
                    if (title) {
                        calendar.fullCalendar('renderEvent',
                            {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            },
                            true // make the event "stick"
                        );
                    }
                    calendar.fullCalendar('unselect');
                },
                eventClick: function(event) {
                    if(confirm("¿Está seguro de eliminar este elemento?")){
                        if(event.id !=-1 ){
                            if (event.url) {

                                $.ajax({
                                    url: event.url,
                                    dataType: 'json',
                                    type: "post",
                                    data: {},
                                    success: function (response) {
                                        if (response['status']) {

                                            for (var i = 0; i<events.length;i++){
                                                if(event.id == events[i].id){
                                                    events.splice(i,1);
                                                }
                                            }
                                            $.gritter.add({
                                                title: "Eliminar Cupos",
                                                text: response['msg'],
                                                time:5000,
                                            });

                                        } else {
                                            $.gritter.add({
                                                title: "Eliminar Cupos",
                                                text: response['msg'],
                                                time:5000,
                                            });
                                        }

                                        $('#calendar').fullCalendar('removeEvents');
                                        $('#calendar').fullCalendar('addEventSource',events);
                                        $('#calendar').fullCalendar('refetchEvents');


                                    },
                                    error: function(response) {
                                        console.log(response.responseText);
                                        return false;
                                    }

                                });
                            }
                        }else{
                            for(var i= 0; i<events.length; i++){
                                var aux_star= new Date(event.start);
                                var aux_end= new Date(event.end);

                                if(aux_star.getTime() == events[i].start.getTime() && aux_end.getTime() == events[i].end.getTime() ){
                                    events.splice(i,1);
                                }
                            }
                            $.gritter.add({
                                title: "Eliminar Cupos",
                                text: "Cupos eliminados: " + event.amount,
                                time:5000,
                            });

                            $('#calendar').fullCalendar('removeEvents');
                            $('#calendar').fullCalendar('addEventSource',events);
                            $('#calendar').fullCalendar('refetchEvents');


                        }
                    }



                    return false;
                },

                editable: true,
                loading: function(bool) {
                    if (bool) {
                        $('#loading').show();
                    }else{
                        $('#loading').hide();
                    }
                },
            });

            $.each(response,function (i) {

                var response_start = response[i].start.split(' ');
                var response_end = response[i].end.split(' ');
                //console.log(response_start)
                var time1 = response_start[1].substr(0,2);
                var time2 = response_end[1].substr(0,2);

                var array1 = response_start[0].split("-");
                var array2 = response_end[0].split("-");

                var start_y = parseInt(array1[0]);
                var start_m = parseInt(array1[1]);
                var start_d =parseInt(array1[2]);

                var end_y = parseInt(array2[0]);
                var end_m = parseInt(array2[1]);
                var end_d = parseInt(array2[2]);

                //console.log( new Date(Date.UTC( start_y,start_m,start_d,time1,0,0)));

                var event = {update:false, id: response[i].id, title: response[i].title,start: new Date(Date.UTC (start_y,start_m-1,start_d,time1,0,0) ),end:  new Date( Date.UTC(end_y,end_m-1,end_d,time2,0,0)), url:response[i].url,   allDay:false, className : ['event_rd'], editable: false}

                events.push(event);

            });
            console.log("InitCalendar :", events);

            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('addEventSource',events);
            $('#calendar').fullCalendar('refetchEvents');



            fullcalendatInit = true;
        },
        error: function(response) {
            console.log(response.responseText);
            result = false;
            // return false;
        }
    });


    $('#range').datepicker({
        todayHighlight: true,
        format:'dd-mm-yyyy',
        language:'en',
    });

    $('.selectpicker').selectpicker('render');


});



