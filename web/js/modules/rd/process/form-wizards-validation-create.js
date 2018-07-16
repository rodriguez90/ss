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

                if(ui.index == 1)
                {
                    var sourceTable = $('#data-table').DataTable();
                    var table = $('#data-table3').DataTable();

                    table
                        .clear()
                        .draw();

                    sourceTable
                        .rows( { selected: true } )
                        .data()
                        .each( function ( value, index ) {

                            if(value.selectable)
                            {
                                if(processType == 1)
								{
                                    value.type = containertDataMap.get(value.name);
									console.log(value.type);
								}

                                table.row.add(
                                    value
                                ).draw();
                            }
                        });
                }
                else if(ui.index == 2)
                {
                    // var wizard = $(this).bwizard();
                    // console.log(wizard);
                    // wizard.nextBtnText = "Finalizar";

                    $('#confirming').prop('checked', false);

                    var sourceTable = $('#data-table3').DataTable();

                    var table2 = $('#data-table2').DataTable();

                    table2
                        .clear()
                        .draw();

                    sourceTable
                        .rows( )
                        .data()
                        .each( function ( value, index ) {
                            table2.row.add(
                                value
                            ).draw();
                        });
                }
            },
            validating: function (e, ui) {
                var result = true;

                // back navigation no check validation
                if(ui.index > ui.nextIndex)
                {
                    return result;
                }

                if (ui.index == 0) { // step-1 validation

                    var table = $('#data-table').DataTable();

                    var count = table.rows( { selected: true } ).count();

                    if(count <= 0)
                    {
                        alert("Debe seleccionar al menos un contenedor en el paso 1.");
                        return false;
                    }

                    table
                        .rows( { selected: true } )
                        .data()
                        .each( function ( value, index ) {
                            // console.log( 'Data in index: '+index +' is: '+ value.name );
                            if(result && value.selectable) {
                                // FIXME: It Export -> Booking code -> check delyveryDate it's set
                                if(processType == 2)
                                {
                                    var deliveryDate = value.deliveryDate;
                                    if(!moment(deliveryDate, 'DD-MM-YYYY').isValid())
                                    {
                                        result = false;
                                        alert("Debe definir la Fecha Límite para los contenedores del Booking.");
                                        return false;
                                    }
                                }

                                if(processType == 1)
                                {
                                    var type =  value.type = containertDataMap.get(value.name, null);

                                    if(!type)
                                    {
                                        result = false;
                                        alert("Debe asignar un tipo para los contenedores seleccionados.");
                                        return false;
                                    }
                                }
                            }
                        } );

                    return result;

                }
                else if (ui.index == 1) {

                    // step-1 validation
                    var table = $('#data-table3').DataTable();

                    table
                        .rows( )
                        .data()
                        .each( function ( value, index ) {

                            if(result && value.transCompany.id == -1){
                                result = false;
                                alert("Debe asignarle a todos los contenedores la empresa de transporte .");
                            }
                        });
                    return result
                }
                else if (ui.index == 2) {

                    // step-2 validation
                    // alert($("#confirming").prop('checked'));

                    if($("#confirming").prop('checked'))
                    {
                        // send info to server
                        var containers = [];

                        var table = $('#data-table2').DataTable();

                        table
                            .rows( )
                            .data()
                            .each( function ( value, index ) {
                                containers.push(value);
                            } );

                        var blCode = $("#blCode").val();

                        // set label text

                        var process = {
                            "Process[agency_id]": agency.id, // FIXME THIS DEFINE BY USER WITH ROLE IMPORTER/EXPORTER
                            "Process[bl]":blCode,
                            "Process[active]":1,
                            "Process[delivery_date]":processDeliveryDate,
                            "Process[type]":processType,
                            "Process[line_id]":lineNav.id,
                            "containers":containers
                        };

                        console.log(process);

                        $.ajax({
                            // async:false,
                            url: homeUrl + "/rd/process/create?type="+processType,
                            type: "POST",
                            dataType: "json",
                            data:  process,
//                            contentType: "application/json; charset=utf-8",
                            success: function (response) {
                                // you will get response from your php page (what you echo or print)
                                console.log(response);

                                if(response['success'])
                                {
                                    result = true;
                                    window.location.href = response['url'];
                                }
                                else
                                {
                                    alert(response['msg']);
                                }
                                result = false;
                            },
                            error: function(data) {
                                // console.log(data);
                                console.log(data.responseText);
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
