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

                // alert("UI index: " + ui.index);

                if(ui.index == 2)
                {
                    // add to table2 selected containers
                    var table = $('#data-table').DataTable();

                    var table2 = $('#data-table2').DataTable();

                    table2
                        .clear()
                        .draw();

                    var rows = table.rows( { selected: true } );
                    // console.log("Selected Rows:");
                    // console.log(rows);

                    table
                        .rows( { selected: true } )
                        .data()
                        .each( function ( value, index ) {
                            // console.log( 'Data in index: '+index +' is: '+ value.name );
                            table2.row.add(
                                value
                            ).draw();
                        } );

                    // set text value
                    $("#trans_company").text($("#select-agency option:selected").text());


                    // // chagen text next button to finish
                    // var nextBtn = $("[role='button']").eq(1 );
                    // var aTag = null;
                    //
                    // if(nextBtn) {
                    //     nextBtn.removeClass('disabled');
                    //     aTag = nextBtn.find("a")
                    // }
                    //
                    // if(aTag)
                    //     aTag.text('Finalizar');
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

                // back navigation no check validation
                if(ui.index > ui.nextIndex)
                {
                    if(ui.index == 2)
                        $('#confirming').prop('checked', false);

                    return true;
                }

                if (ui.index == 0) {
                    // step-1 validation

                    // return true;
                    var table = $('#data-table').DataTable();

                    var count = table.rows( { selected: true } ).count();

                    var result = false;
                    if(count > 0)
                        result = true;
                    else {
                        alert("Debe seleccionar contenedores en el paso 1.");
                    }

                    return result;

                } else if (ui.index == 1) {

                    // step-1 validation
                    var transCompany = $("#select-agency option:selected").text();
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

                        var tran_company_name =   $("#select-agency option:selected").text()

                        // set label text
                        $("#trans_company").text(tran_company_name);

                        var trans_company =  {
                            "id":$("#select-agency option:selected")[0].value,
                            "name": tran_company_name,
                        };



                        var reception = {
                            agency_id:1, // FIXME THIS DEFINE BY USER WITH ROLE AGENCY OR IMPORTER/EXPORTER
                            bl:blCode,
                            trans_company_id:trans_company.id,
                            active:true,
                            containers:containers,
                        };


                        console.log(reception);

                        console.log(JSON.stringify(reception));

                        $.ajax({
                            async:false,
                            url: homeUrl + "rd/api-reception/create",
                            type: "POST",
                            dataType: "json",
                            data:  reception,
                            contentType: "application/json; charset=utf-8",
                            success: function (response) {
                                // you will get response from your php page (what you echo or print)
                                console.log(response)
                                result = true;
                                // return true;
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                                alert(textStatus);
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
            // show: function (e, ui) {
            //     if(ui.index == 2)
            //     {
            //         $('#confirming').prop('checked', false);
            //
            //     }
            // },
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
