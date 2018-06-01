/**
 * Created by yopt on 12/05/18.
 */


var handleFormPasswordIndicator = function() {
    "use strict";
    $('#password-indicator-default').passwordStrength();
    $('#password-indicator-visible').passwordStrength({targetDiv: '#passwordStrengthDiv2'});
};


var handleJqueryAutocomplete = function() {

    $('#jquery-autocomplete').autocomplete({
        source: function(request,response){
            $.ajax({
                url: homeUrl+ "administracion/item/getroles",
                dataType:'json',
                data:{
                    term:request.term
                },
                success:function(data){
                   response($.map(data,function(item){

                       return item.name
                   }));


                }
            });

        },minLength:2
    });
};



var handleJqueryAutocomplete2 = function(op) {

    var action = '';
    switch (op){
        case 1:
            action = "administracion/user/getagencias";
            break;
        case 2:
            action = "administracion/user/getdeposito";
            break;
        case 3:
            action = "administracion/user/getagenciastrans";
            break;
    }


    $('#input-type').autocomplete({
        source: function(request,response){
            $.ajax({
                url: homeUrl+ action,
                dataType:'json',
                data:{
                    term:request.term
                },
                success:function(data){
                    response($.map(data,function(item){

                        return item.name
                    }));
                }
            });

        },minLength:2
    });
};

$(function () {

    handleFormPasswordIndicator();
    handleJqueryAutocomplete();

    $('#jquery-autocomplete').change(function(event){
        var label = $("#label-type");
        var input = $('#input-type');
        switch ($(this).val()){
            case 'Importador_Exportador':
                label.text("Agencia*");
                handleJqueryAutocomplete2(1);
                input.removeAttr('disabled');
                break;
            case 'Administrador_depósito':
                label.text("Depósito*");
                handleJqueryAutocomplete2(2);
                input.removeAttr('disabled');

                break;
            case 'Cia_transporte':
                label.text("Compañía de Transporte*");
                handleJqueryAutocomplete2(3);
                input.removeAttr('disabled');
                break;

            default :
                label.text("---");
                input.attr('disabled','disabled');
                break;
        }


    });





});
