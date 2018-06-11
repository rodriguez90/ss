/**
 * Created by pedro on 30/05/2018.
 */

var currentCalendarSlot = null;

var handleInitTableInModal = function () {

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
            alert('user-select');

            var count = dt.rows( { selected: true } ).count() + 1;
            // alert('Select : ' + type + ' selected: ' + indexes + ' count ' + count);
            console.log(e);

            if(count > 0)
            {
                alert('Solo hay 5 cupos disponibles');
                // console.log(indexes[0]);
                // var row = table.row(indexes[0]);
                // console.log(row);
                // row.deselect();
                e.preventDefault();
                // if ( $(originalEvent.target).index() === 0 ) {
                //
                // }
            }

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

        // table.on( 'deselect', function ( e, dt, type, indexes ) {
        //     // var rowData = table.rows( indexes ).data().toArray();
        //     // events.prepend( '<div><b>'+type+' <i>de</i>selection</b> - '+JSON.stringify( rowData )+'</div>' );
        // } );
    }
};

var handleInitTableInWizar = function() {
    if ($('#data-table2').length !== 0) {
        $('#data-table2').DataTable({
            "columns": [
                { "title": "Contenedor",
                    "data":"name",
                },
                { "title": "Tipo",
                    // "data":"type_formate",
                },
                { "title": "Fecha Limite",
                    "data":"deliveryDate",
                },
                { "title": "Agencia",
                    "data":"agency"
                },
                { "title": "Fecha del Cupo",
                    "data":"agency"
                },
                { "title": "Placa del Carro",
                    "data":"registerTrunk"
                },
                { "title": "Cédula del Chofer",
                    "data":"registerDriver"
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
            // language: {url: 'web/plugins/DataTables/i18/Spanish.json'
        });
    }
};

var handleModal = function () {
    $("#modal-select-containers").on("hide.bs.modal", function () {
        alert('Modal Close');
    });

    // select all in modal table
    $('#select-all').on('click', function(){

        var table = $('#data-table-moda').DataTable();

        // FIXME validar que solo se pueden selecionar una cantida <= que la cantida de cupos disponibles
        if(this.checked)
        {
            table.rows().select();
            return;
        }

        table.rows().deselect();
    });
}

var searchRTByReception = function () {

    var table = $('#data-table-modal').DataTable();

    table
        .clear()
        .draw();

    $.ajax({
        async:true,
        url: homeUrl + "/rd/reception/transactions",
        type: "get",
        dataType: "json",
        data:  {id:modelId},
        success: function (response) {
            // you will get response from your php page (what you echo or print)
            // var obj = JSON.parse(response);
            console.log(response);

            var types = ["DRY", "RRF"];
            var tonnages = [20, 40];

            var reception = response['reception'];
            var transactions = response['transactions'];
            var containers = response['containers'];
            var agency = response['angecy'];

            for (var i = 0; i < transactions.length; i++)
            {
                var transaction = transactions[i];
                var container = containers[i];
                table.row.add(
                    {
                        checkbox:"",
                        name: container.name,
                        type: container.code,
                        tonnage: container.tonnage,
                        deliveryDate:new Date(transaction.delivery_date),
                        agency:agency.name,
                    }
                ).draw();
            }

            // return true;
        },
        error: function(response) {

            console.log(data.responseText);
            result = false;
            // return false;
        }
    });
};

var calendarSlotEvents = {
    id:'calendarSlotEvents',
    events:[],
};

var celendarTicketEvents = {
    id:'calendarTicketEvents',
    events:[],
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
            // console.log(response);
            calendarSlotEvents.events = [];
            $('#calendar').fullCalendar('removeEvents');

            $.each(response,function (i) {
                var event = {
                    id: response[i].id,
                    title: response[i].count,
                    start: response[i].start ,
                    end:  response[i].end ,
                    allDay:false,
                    className : ['bg-grey'],
                    editable: false
                }
                // $('#calendar').fullCalendar('renderEvent', event);

                calendarSlotEvents.events.push(event);
            });
            // console.log(calendarSlotEvents);

            $('#calendar').fullCalendar('removeEventSources');
            $('#calendar').fullCalendar('addEventSource',calendarSlotEvents);
            // $('#calendar').fullCalendar('refetchEvents');
        },
        error: function(response) {
            console.log(response);
            console.log(response.responseText);
            result = false;
            // return false;
        }
    });
}

$(document).ready(function () {

    moment.locale('es');
    // init wizar
    FormWizardValidation.init();

    Calendar.init();

    handleModal();

    $('#search-container').click( function() {
        // ajax resquest service for container
        // alert("// ajax resquest service for container");
    });

    // cronometer
    setInterval(function () {
        var m = $("#minutes");
        var s = $("#seconds");
        var currentMinutes = parseInt(m.text());
        var currentSeconds = parseInt(s.text());
        currentSeconds--;

        if(currentSeconds == 0) {
            currentMinutes--;
            currentSeconds = 59;
        }

        if(currentMinutes==0)
        {
            currentSeconds = 0;
            alert("Ha espirado el tiempo de trabajo");
            window.location.reload();
        }

        m.text(currentMinutes);
        s.text(currentSeconds);

    }, 1000);

});
