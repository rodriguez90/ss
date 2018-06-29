/**
 * Created by yopt on 12/05/18.
 */


var handleFormPasswordIndicator = function() {
    "use strict";
    $('#password-indicator-default').passwordStrength();
    $('#password-indicator-visible').passwordStrength({targetDiv: '#passwordStrengthDiv2'});
};


var handleJqueryAutocomplete2 = function(op,changeRol) {

    var action = '';
    var option0 = '';
    switch (op){
        case 1:
            action = "/administracion/user/getagencias";
            option0 = "<option value='' selected=''>Seleccione agencia</option>";
            break;
        case 2:
            action = "/administracion/user/getdeposito";
            option0 = "<option value='' selected=''>Seleccione depósito</option>";
            break;
        case 3:
            action = "/administracion/user/getagenciastrans";
            option0 = "<option value='' selected=''>Seleccione agencia de transporte</option>";
            break;
    }
            $.ajax({
                url: homeUrl+ action,
                type: 'get',
                dataType: "json",
                data:{},

                success:function(data){
                    /*
                    response($.map(data,function(item){
                        return item.name
                    }));
                    */
                    var div = $('#select-conten');
                    div.empty();
                    var aux = $('#aux').val();

                    var conten = "<select id='selectpicker-type' name='type' class='form-control'  data-parsley-required='true'  data-size='10' data-live-search='true'>";
                    conten += option0;
                    var selected = '';

                    $.each(data,function(i){

                        if(!changeRol){
                            selected = aux ==  data[i].id ? "selected=''": '';
                        }

                    conten += "<option value='"+ data[i].id+"' "+ selected + ">"+data[i].name +"</option>";
                    })
                    conten+="</select>"
                    div.append(conten);
                    $("#selectpicker-type").selectpicker('render');

                },
                error: function(data) {
                    console.log(data.responseText);
                    alert(textStatus);
                    result = false;
                    // return false;
                }
            });
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
            case 'Agencia':
                label.text("Agencia*");
                handleJqueryAutocomplete2(1,distint);
                break;
            case 'Administrador_depósito':
            case 'Depósito':
                label.text("Depósito*");
                handleJqueryAutocomplete2(2,distint);
                break;
            case 'Cia_transporte':
                label.text("Compañía de Transporte*");
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
    $('.selectpicker').selectpicker('render');

    //handleFormPasswordIndicator();
    handleSelectpicker();

    if($('#selectpicker-rol').val() == 'Importador_Exportador'|| $('#selectpicker-rol').val() == 'Administrador_depósito' || $('#selectpicker-rol').val() == 'Cia_transporte' || $('#selectpicker-rol').val() == 'Agencia' || $('#selectpicker-rol').val() == 'Depósito' ){
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
