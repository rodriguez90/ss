/**
 * Created by yopt on 13/05/18.
 */



/**
 * Created by yopt on 12/05/18.
 */

var handleFormPasswordIndicator = function() {
    "use strict";
    $('#password-indicator-default').passwordStrength();
    $('#password-indicator-visible').passwordStrength({targetDiv: '#passwordStrengthDiv2'});
};


var handleJqueryAutocomplete = function() {

    $('#authitemchild-child').autocomplete({
        source: function(request,response){
            $.ajax({
                url: homeUrl+ "administracion/authitemchild/permisos",
                dataType:'json',
                data:{
                    term:request.term,
                    rol:$("#authitemchild-parent").val()
                },
                success:function(data){
                    //return data;

                    response($.map(data,function(item){
                        return item.name
                    }));

                }
            });

        },minLength:2
    });
};

$(function () {

    handleJqueryAutocomplete();
});
