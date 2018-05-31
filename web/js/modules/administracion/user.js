/**
 * Created by yopt on 12/05/18.
 */

var handleFormPasswordIndicator = function() {
    "use strict";
    $('#password-indicator-default').passwordStrength();
    $('#password-indicator-visible').passwordStrength({targetDiv: '#passwordStrengthDiv2'});
};


var handleJqueryAutocomplete = function() {
    var availableTags = [
        'ActionScript',
        'AppleScript',
        'Asp',
        'BASIC',
        'C',
        'C++',
        'Clojure',
        'COBOL',
        'ColdFusion',
        'Erlang',
        'Fortran',
        'Groovy',
        'Haskell',
        'Java',
        'JavaScript',
        'Lisp',
        'Perl',
        'PHP',
        'Python',
        'Ruby',
        'Scala',
        'Scheme'
    ];
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

        },minLength:5
    });
};

$(function () {
    handleFormPasswordIndicator();
    handleJqueryAutocomplete();
});
