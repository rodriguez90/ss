/**
 * Created by yopt on 13/05/18.
 */



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
    $('.selectpicker').selectpicker('render');
});
