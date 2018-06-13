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

                if (ui.index == 0) {
                    // check selected transaction > 0
                    //make clone copy to table

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
                                transactionId:tId
                            };
                            table2.row.add(
                                data
                            ).draw();
                        }
                    });

                   return true;

                } else if (ui.index == 1) {
                    //TODO

                    var tickets = [];
                    var table = $('#data-table2').DataTable();
                    var error = false;
                    table
                        .rows( )
                        .data()
                        .each( function ( value, index ) {
                            console.log(value);

                            if(error) return false;

                            if(value.registerTrunk.length == 0 || value.registerDriver.length == 0)
                            {
                                tickets = [];
                                error = true;
                                alert("Debe introducir la placa del carro y la cédual del chofer para todo los contenedores.");
                                return false;
                            }


                            var tId = value.transactionId;
                            var t = transactions.get(tId);
                            var c = containers.get(t.container_id);
                            var ticketData = ticketDataMap.get(tId);

                            if(ticketData)
                            {
                                var data = {
                                    "reception_transaction_id":tId, // FIXME THIS DEFINE BY USER WITH ROLE AGENCY OR IMPORTER/EXPORTER
                                    "calendar_id":ticketData.calendarId,
                                    "status":1,
                                    "active":1,
                                    "registerTruck":value.registerTrunk,
                                    "registerDriver":value.registerDriver,
                                };
                                tickets.push(data);
                            }
                        } );

                    // check that the user fill register trunk and register driver columns

                    // var tickets = [];
                    //
                    // $.each(selectedTransactions, function (i) {
                    //     var tId = selectedTransactions[i];
                    //     var t = transactions.get(tId);
                    //     var c = containers.get(t.container_id);
                    //     var ticketData = ticketDataMap.get(tId);
                    //
                    //     if(ticketData)
                    //     {
                    //         var data = {
                    //             "reception_transaction_id":tId, // FIXME THIS DEFINE BY USER WITH ROLE AGENCY OR IMPORTER/EXPORTER
                    //             "calendar_id":ticketData.calendarId,
                    //             "status":1,
                    //             "active":1,
                    //             "registerTruck":'',
                    //             "registerDriver":'',
                    //         };
                    //         tickets.push(data);
                    //     }
                    // });

                    console.log(tickets);
                    // return;

                    if(tickets.length <= 0) return false;

                    $.ajax({
                        async:false,
                        url: homeUrl + "/rd/ticket/reserve",
                        type: "POST",
                        dataType: "json",
                        data:  {
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

                    return true;

                } else if (ui.index == 2) {

                    return true;
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
