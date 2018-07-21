/**
 * Created by yopt on 12/05/18.
 */

var currentOption = "" ;
var currentActionUrl = ""

var handleFormPasswordIndicator = function() {
    "use strict";
    $('#password-indicator-default').passwordStrength();
    $('#password-indicator-visible').passwordStrength({targetDiv: '#passwordStrengthDiv2'});
};


var handleJqueryAutocomplete2 = function(op,changeRol) {

    var action = '';
    var option0 = '';
    var min = -1;
    var validator = "";
    switch (op){
        case 1:
            action = "/administracion/user/getagencias";
            option0 = "Seleccione la epmpresa";
            // validator = "data-parsley-type=\'digits\' data-parsley-length=\'[13, 13]\'";
            min = 13;
            break;
        case 2:
            action = "/administracion/user/getdeposito";
            option0 = "Seleccione el depósito";
            break;
        case 3:
            action = "/administracion/user/getagenciastrans";
            option0 = "Seleccione la empresa de transporte";
            min = 5;
            break;
    }

    currentActionUrl = action;
    currentOption = option0;

    var div = $('#select-conten');
    div.empty();
    var aux = $('#aux').val();

    var div = $('#select-conten');
    div.empty();
    var aux = $('#aux').val();

    var conten = "<select id='selectpicker-type' name='type' class='form-control'  data-parsley-required='true'  data-size='10' data-live-search='true' " + validator + "></select>";
    div.append(conten);

    console.log(currentActionUrl);

    var select2 = $("#selectpicker-type").select2(
    {
        language: "es",

        placeholder: currentOption,
        width: '100%',
        minimumInputLength:min,
        // allowClear: true,
        // tags: true,
        closeOnSelect: true,
        ajax: {
            url: homeUrl + currentActionUrl,
            dataType: 'json',
            // delay: 250,
            // cache: true,
            data: function (params) {
                var query = {
                    code: params.term,
                };
                return query;
            },
            processResults: function (response) {
                console.log(response);
                var results  = [];
                $.each(response.objects, function (index, item) {
                    results .push({
                        id: item.id,
                        text: item.name,
                    });
                });
                return {
                    results: results
                };
            },
        },
    }).on('select2:select', function (e) {

            var data = e.params.data;
            console.log(data);
    });

    if(modelAux.name !== null)
    {
        var newOption = new Option(modelAux.name, modelAux.id, true, true);
        select2.append(newOption).trigger('change');
    }
};

var handleSelectpicker = function() {
    var div = $('#select-conten');
    var ini = 0;
    var ini_rol="";

    $('#selectpicker-rol').change(function(){
        var distint = true;
        var label = $("#label-type");
        var input = $('#selectpicker-type');

        if(ini === 0){
            ini_rol = $(this).val();
            ini++;
        }

        if(ini_rol === $(this).val()){
            distint = false;
        }

        input.empty();
        switch ($(this).val()){
            case 'Importador':
            case 'Exportador':
            case 'Importador_Exportador':
            case 'Agencia':
                label.text("Empresa*");
                handleJqueryAutocomplete2(1,distint);
                break;
            case 'Administrador_depósito':
            case 'Depósito':
                label.text("Depósito*");
                handleJqueryAutocomplete2(2,distint);
                break;
            case 'Cia_transporte':
                label.text("Empresa de Transporte*");
                handleJqueryAutocomplete2(3,distint);
                break;

            default :
                label.text("---");
                div.empty();
                break;
        }
    });
};

$(function () {
    console.log(modelAux);

    $('.selectpicker').selectpicker('render');

    //handleFormPasswordIndicator();
    handleSelectpicker();

    if($('#selectpicker-rol').val() != 'Administracion' ){
        $('#selectpicker-rol').change();
    }
    var msg;
    window.Parsley.addValidator(
      'cedula',{
            validateString:function (value) {
             return validarCedula(value);
          },
          requirementType:'integer',
            messages:{
              es:"Cédula incorrecta.",
              required: 'Por favor, escribir c&eacute;dula.',
              minlength: 'La cédula debe tener 10 caracteres.',
              maxlength: 'La cédula debe tener 10 caracteres.',
              digits:'La cédula debe ser caracteres numéricos.'
              //remote:'C&eacute;dula ya existe.'
            }
        }
    );
});
