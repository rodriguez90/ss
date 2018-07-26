/*
 Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
 Version: 1.9.0
 Author: Sean Ngu
 Website: http://www.seantheme.com/color-admin-v1.9/admin/
 */

var handleBootstrapWizardsValidation = function() {
    "use strict";
    $("#wizard").bwizard(
        {
            clickableSteps: false,
            activeIndexChanged:  function (e, ui) {

                if(ui.index == 0)
                {
                    $('ul.bwizard-buttons li.next a').text('Siguiente');
                }
                else if(ui.index == 1)
                {
                    $('ul.bwizard-buttons li.next a').text('Siguiente');

                    // hace prereservas
                    var table2 = $('#data-table2').DataTable();

                    table2
                        .clear()
                        .draw();
                    transactionDataMap.clear();
                    dateTicketMap.clear();

                    $.each(selectedTransactions, function (i) {

                        var tId = selectedTransactions[i];
                        var t = transactions.get(tId);
                        var c = containers.get(t.container_id);
                        var ticketData = ticketDataMap.get(tId);

                        if(ticketData)
                        {
                            var data = {
                                name: c.name,
                                type: c.code,
                                tonnage: c.tonnage,
                                deliveryDate: t.delivery_date,
                                agency: agency.name,
                                dateTicket:ticketData.dateTicket,
                                registerTrunk: '',
                                registerDriver: '',
                                nameDriver: '',
                                transactionId:tId,
                                id:c.id
                            };

                            transactionDataMap.set(c.name, {
                                registerTrunk: '',
                                registerDriver: '',
                                nameDriver: '',
                            });

                            var containersArray = [];

                            if(dateTicketMap.has(ticketData.dateTicket))
                            {
                                containersArray = dateTicketMap.get(ticketData.dateTicket);
                            }

                            containersArray.push(c.id);
                            dateTicketMap.set(ticketData.dateTicket, containersArray);

                            table2.row.add(
                                data
                            ).draw();
                        }
                    });

                    // FIXME: validation server side
                    // add dateTicket map the ticket that exist
                    // ticketDataMap.forEach(function(valor, clave) {
                    //
                    //     var transaction =  transactions.get(clave);
                    //     var container = containers.get(transaction.container_id);
                    //     var containersArray = dateTicketMap.get(transaction.delivery_date);
                    //     containersArray.push(container.name);
                    //     dateTicketMap.set(transaction.delivery_date, containersArray);
                    // });

                    // console.log(dateTicketMap);
                }
                else if(ui.index==2)
                {
                    $('ul.bwizard-buttons li.next a').text('Finalizar');

                    var table = $('#data-table2').DataTable();
                    var table3 = $('#data-table3').DataTable();
                    var error = false;

                    table3
                        .clear()
                        .draw();

                    table
                        .rows( )
                        .data()
                        .each( function ( value, index ) {

                            var tId = value.transactionId;
                            var t = transactions.get(tId);
                            var c = containers.get(t.container_id);
                            var ticketData = ticketDataMap.get(tId);

                            var transactionData = transactionDataMap.get(value.name);

                            if(ticketData)
                            {
                                var data = {
                                    name: c.name,
                                    type: c.code,
                                    tonnage: c.tonnage,
                                    deliveryDate: t.delivery_date,
                                    agency: agency.name,
                                    dateTicket:ticketData.dateTicket,
                                    registerTrunk: transactionData.registerTrunk,
                                    registerDriver: transactionData.registerDriver,
                                    nameDriver: transactionData.nameDriver,
                                    transactionId:tId
                                };

                                table3.row.add(
                                    data
                                ).draw();
                            }
                        });
                }
            },
            validating: function (e, ui) {

                var valid = true;

                // back navigation no check validation
                if(ui.index > ui.nextIndex)
                {
                    if(ui.index == 2)
                        $('#confirming').prop('checked', false);

                    return true;
                }

                if (ui.index == 0) { // paso 1 reserva de cupos

                    if(selectedTransactions.length <= 0)
                    {
                        alert("Debe reservar cupos para los contenedores en el paso 1.");
                        return false
                    }

                   return true;
                }
                else if (ui.index == 1) { // paso 2: cedula, nombre del chofer, placa del carro


                    var table = $('#data-table2').DataTable();

                    table
                        .rows( )
                        .data()
                        .each( function ( value, index ) {

                            if(!valid) return false;

                            var transactionData = transactionDataMap.get(value.name);

                            if(!transactionData ||
                                (transactionData.registerTrunk.length === 0 ||
                                transactionData.registerDriver.length === 0 ||
                                transactionData.nameDriver.length === 0))
                            {
                                valid = false;
                                alert("Debe introducir la \"Placa del Carro\", \"Cédula\" y \"Nombre del Chofer\" para todo los contenedores.");
                                return false;
                            }
                        });

                    return valid;
                }
                else if (ui.index == 2) {

                    if($("#confirming").prop('checked'))
                    {
                        var table = $('#data-table3').DataTable();

                        var tickets = [];
                        table
                            .rows( )
                            .data()
                            .each( function ( value, index ) {

                                var tId = value.transactionId;
                                var t = transactions.get(tId);
                                var c = containers.get(t.container_id);
                                var ticketData = ticketDataMap.get(tId);

                                if(ticketData)
                                {
                                    var data = {
                                        "process_transaction_id":tId,
                                        "calendar_id":ticketData.calendarId,
                                        "status":1,
                                        "active":1,
                                        "registerTruck":value.registerTrunk,
                                        "registerDriver":value.registerDriver,
                                        "nameDriver":value.nameDriver,
                                    };
                                    tickets.push(data);
                                }
                            } );

                        console.log("Ticket to reserve: ");
                        console.log(tickets);

                        $.ajax({
                            url: homeUrl + "/rd/ticket/reserve",
                            type: "POST",
                            dataType: "json",
                            data:  {
                                reception:reception,
                                tickets:tickets
                            },
                            beforeSend:function () {
                                $("#modal-select-bussy").modal("show");
                            },
                            success: function (response) {
                                $("#modal-select-bussy").modal("hide");
                                // you will get response from your php page (what you echo or print)
                                console.log(response);
                                // var obj = response;
                                // console.log(obj);

                                if(response.success)
                                {
                                    valid = true;
                                    window.location.href = response.url;
                                }
                                else
                                {
                                    valid  = false;
                                    alert(response.msg);
                                }
                                return valid;
                            },
                            error: function(data) {
                                $("#modal-select-bussy").modal("hide");
                                console.log(data);
                                alert(data['msg']);
                                valid = false;
                                return valid;
                            }
                        });

                        return valid;
                    }

                    alert("Debe confirmar que la información es valida.");
                    return false;
                }
            },
            backBtnText:'Anterior',
            nextBtnText: "Siguiente"
        }
    );


};

var FormWizardValidation = function () {
    "use strict";
    return {
        //main function
        init: function () {
            handleBootstrapWizardsValidation();
        }
    };
}();
