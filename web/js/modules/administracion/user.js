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



var handleJqueryAutocomplete2 = function() {

    $('#input-type').autocomplete({
        source: function(request,response){
            $.ajax({

                url: homeUrl+ "administracion/user/getagencias",
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
    handleJqueryAutocomplete2();

    $('#jquery-autocomplete').change(function(event){
        var label = $("#label-type");
        switch ($(this).val()){
            case 'Importador_Exportador':
                label.text("Agencia*");

                break;
            case 'Administrador_depósito':

                label.text("Depósito*");
                break;
            case 'Cia_transporte':

                label.text("Compañía de Transporte*");
                break;

        }


    });





});
