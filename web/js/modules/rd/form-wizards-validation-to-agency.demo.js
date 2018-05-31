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
            activeIndexChanged:  function (e, ui) {
                // alert("UI index: " + ui.index);

                if(ui.index == 2)
                {
                    // chagen text next button to finish
                    var nextBtn = $("[role='button']").eq(1);
                    var aTag = null;

                    if(nextBtn) {
                        nextBtn.removeClass('disabled');
                        aTag = nextBtn.find("a")
                    }

                    if(aTag)
                        aTag.text('Finalizar');
                }
                else
                {
                    // chagen text next button to next
                    var nextBtn = $("[role='button']").eq(1);
                    var aTag = null;
                    if(nextBtn)
                        aTag = nextBtn.find("a")

                    if(aTag)
                        aTag.text('Siguiente');
                }
            },

            validating: function (e, ui) {

                if (ui.index == 0) {
                    // step-1 validation
                    alert("Validando paso 1");
                    // return true;
                    var table = $('#data-table').DataTable();


                    if (false === $('form[name="form-wizard"]').parsley().validate('wizard-step-1')) {
                        return false;
                    }
                } else if (ui.index == 1) {
                    // step-2 validation
                    // return true;
                    if (false === $('form[name="form-wizard"]').parsley().validate('wizard-step-2')) {
                        return false;
                    }
                } else if (ui.index == 2) {
                    // step-3 validation
                    // return true;
                    if (false === $('form[name="form-wizard"]').parsley().validate('wizard-step-3')) {
                        return false;
                    }
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
