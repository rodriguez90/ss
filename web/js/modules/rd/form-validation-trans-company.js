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
                   return true;

                } else if (ui.index == 1) {

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
