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
                            // console.log( 'Data in index: '+ index +' is: '+ value.name );
                            // if(value.id === -1 || value.status === 'Pendiente')

                            if(value.id === -1)
                            {
                                table.row.add(
                                    value
                                ).draw();
                            }
                        });
                }
                else if(ui.index == 2)
                {
                    // add to table2 selected containers
                    // var selectedValue = $("input[name='radio_default_inline']:checked").val();
                    //
                    // var trans_company = null;
                    //
                    // var sourceTable = null;
                    //
                    // if(selectedValue === "1")
                    // {
                    //     sourceTable = $('#data-table3').DataTable();
                    // }
                    // else
                    // {
                    //     trans_company =  {
                    //         "id":$("#selectTransCompany option:selected")[0].value,
                    //         "name": $("#selectTransCompany option:selected").text(),
                    //     };
                    //     sourceTable = $('#data-table').DataTable();
                    // }

                    var sourceTable = $('#data-table3').DataTable();

                    var table2 = $('#data-table2').DataTable();
                    table2
                        .clear()
                        .draw();

                    sourceTable
                        .rows( { selected: true } )
                        .data()
                        .each( function ( value, index ) {
                            // console.log( 'Data in index: '+index +' is: '+ value.name );
                            if(value.id === -1)
                            {
                                table2.row.add(
                                    value
                                ).draw();
                            }
                        });

                    // set text value
                    // $("#trans_company").text($("#selectTransCompany option:selected").text());
                }
                else if(ui.index==3)
                {
                    // var btn = $("[role='button']").eq(0);
                    // var aTag = null;
                    //
                    // if(btn) {
                    //     aTag = nextBtn.find("a")
                    // }
                    //
                    // if(aTag)
                    //     aTag.text('');
                    //
                    //  btn = $("[role='button']").eq(1);
                    //
                    // if(btn) {
                    //     aTag = nextBtn.find("a")
                    // }
                    //
                    // if(aTag)
                    //     aTag.text('');
                }
                else
                {
                    // chagen text next button to next
                    // var nextBtn = $("[role='button']").eq(1);
                    // var aTag = null;
                    // if(nextBtn)
                    //     aTag = nextBtn.find("a")
                    //
                    // if(aTag)
                    //     aTag.text('Siguiente');
                }
            },
            validating: function (e, ui) {
                var result = false;

                // back navigation no check validation
                if(ui.index > ui.nextIndex)
                {
                    if(ui.index == 2) // se desmarca el checkbox de confirmacion si c retrocede en el wizard
                        $('#confirming').prop('checked', false);

                    return true;
                }

                if (ui.index == 0) {
                    // step-1 validation

                    return true;
                    var table = $('#data-table').DataTable();

                    // var count = table.rows( { selected: true } ).count();

                    table
                        .rows( { selected: true } )
                        .data()
                        .each( function ( value, index ) {
                            // console.log( 'Data in index: '+index +' is: '+ value.name );
                            // FIXME: It Export -> Booking code -> check delyveryDate it's set
                            if(processType === 2)
                            {
                                var deliveryDate = value.deliveryDate;
                                if(!moment(deliveryDate).isValid())
                                {
                                    table
                                        .clear()
                                        .draw();
                                    alert("Debe definir la Fecha Límite para los contenedores del Booking.");
                                    return false;
                                }
                            }

                            if(value.id === -1 && !result) {
                                result = true;
                                return false;
                            }
                        } );

                    if(!result)
                    {
                        alert("Debe seleccionar contenedores en el paso 1.");
                    }

                    return result;

                } else if (ui.index == 1) {

                    // step-1 validation
                    return true;
                    var transCompany = $("#selectTransCompany option:selected").text();
                    if(transCompany.length) return true;

                    alert("Debe seleccionar la compañia de transporte.");
                    return false;

                } else if (ui.index == 2) {

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
                        // $("#trans_company").text(tran_company_name);

                        var trans_company =  {
                            "id":$("#selectTransCompany option:selected")[0].value,
                            "name":$("#selectTransCompany option:selected").text(),
                        };

                        var process = {
                            "Process[agency_id]": 2, //agency.id, // FIXME THIS DEFINE BY USER WITH ROLE AGENCY OR IMPORTER/EXPORTER
                            "Process[bl]":blCode,
                            "Process[active]":1,
                            "Process[delivery_date]":moment().format("YYYY/MM/DD"),
                            "Process[type]":processType,
                            "containers":containers
                        };

                        // var reception = {
                        //     "agency_id":1, // FIXME THIS DEFINE BY USER WITH ROLE AGENCY OR IMPORTER/EXPORTER
                        //     "bl":blCode,
                        //     "trans_company_id":trans_company.id,
                        //     "active":1,
                        //     "containers":containers
                        // };

                        console.log(process);
                        // console.log(JSON.stringify(reception));

                        $.ajax({
                            async:false,
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
                                // return true;
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
