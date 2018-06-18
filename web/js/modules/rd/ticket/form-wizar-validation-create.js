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
            clickableSteps: true,
            activeIndexChanged:  function (e, ui) {

                // alert("UI index: " + ui.index);

                if(ui.index == 1)
                {
                    return true
                }
                else if(ui.index==2)
                {

                }
                else
                {

                }
            },
            validating: function (e, ui) {

                var result = false;

                // back navigation no check validation
                if(ui.index > ui.nextIndex)
                {
                    if(ui.index == 2)
                        $('#confirming').prop('checked', false);

                    return true;
                }

                if (ui.index == 0) { // paso 1 reserva de cupos
                    // check selected transaction > 0
                    //make clone copy to table2

                    if(selectedTransactions.length <= 0)
                    {
                        alert("Debe reservar cupos para los contenedores en el paso 1.");
                        return false
                    }

                    // hace prereservas
                    var table2 = $('#data-table2').DataTable();

                    table2
                        .clear()
                        .draw();

                    //clone to table 2

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
                                transactionId:tId
                            };
                            table2.row.add(
                                data
                            ).draw();
                        }
                    });

                   return true;

                }
                else if (ui.index == 1) { // paso 2: cedula, nombre del chofer, placa del carro


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

                            if(error) return false;

                            if(value.registerTrunk.length === 0 || value.registerDriver.length === 0 || value.nameDriver.length === 0)
                            {
                                table3
                                    .clear()
                                    .draw();
                                error = true;
                                alert("Debe introducir la placa del carro y la cédual y nombre chofer para todo los contenedores.");
                                return false;
                            }

                            var tId = value.transactionId;
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
                                    registerTrunk: value.registerTrunk,
                                    registerDriver: value.registerDriver,
                                    nameDriver: value.nameDriver,
                                    transactionId:tId
                                };

                                table3.row.add(
                                    data
                                ).draw();
                            }
                        } );
                        // console.log('Paso 1 error: ' + error);

                        return !error;
                }
                else if (ui.index == 2) {

                    if($("#confirming").prop('checked'))
                    {
                        var table = $('#data-table3').DataTable();

                        var tickets = [];
                        error = false;
                        table
                            .rows( )
                            .data()
                            .each( function ( value, index ) {
                                // console.log(value);

                                if(error) return false;

                                if(value.registerTrunk.length == 0 || value.registerDriver.length == 0 || value.nameDriver.length === 0)
                                {
                                    tickets = [];
                                    error = true;
                                    alert("Debe introducir la placa del carro y la cédula del chofer para todo los contenedores.");
                                    return false;
                                }


                                var tId = value.transactionId;
                                var t = transactions.get(tId);
                                var c = containers.get(t.container_id);
                                var ticketData = ticketDataMap.get(tId);

                                if(ticketData)
                                {
                                    var data = {
                                        "reception_transaction_id":tId,
                                        "calendar_id":ticketData.calendarId,
                                        "status":1,
                                        "active":1,
                                        "registerTruck":value.registerTrunk,
                                        "registerDriver":value.registerDriver,
                                        "nameDriver":value.nameDriver,
                                    };
                                    console.log(data);
                                    tickets.push(data);
                                }
                            } );

                        if(error) return false;

                        console.log("Ticket to reserve: ");
                        console.log(tickets);

                        $.ajax({
                            async:false,
                            url: homeUrl + "/rd/ticket/reserve",
                            type: "POST",
                            dataType: "json",
                            data:  {
                                reception:reception,
                                tickets:tickets
                            },
                            success: function (response) {
                                // you will get response from your php page (what you echo or print)
                                var obj = JSON.parse(response);
                                console.log(obj);

                                if(obj.success)
                                {
                                    result = true;
                                    window.location.href = obj.url;
                                }
                                else
                                {
                                    alert(obj.msg);
                                }
                                // return true;
                            },
                            error: function(data) {
                                console.log(data);
                                alert(data['msg']);
                                result = false;
                                // return false;
                            }
                        });

                        return result;
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
