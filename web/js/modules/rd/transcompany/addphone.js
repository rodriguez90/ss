/**
 * Created by yopt on 01/07/2018.
 */

$(function (){

    var nphone = $(".phone").length +1;
    var div = $("#colum2");
   $("#add-phone").click(function () {

       var newphone = $("<div id='group-"+ nphone+"' class='form-group phone' >" +
           " <label class='col-md-3 col-sm-3 control-label'>Teléfono</label>" +
           "<div class='col-md-7 col-sm-7'>" +
           "<input name='telefono-"+nphone+"' type='text'  class='form-control' data-parsley-required='true' data-parsley-type='number' data-parsley-maxlength='10' data-parsley-minlength='9'/>" +
           " </div> " +
           "<div class='col-md-2 col-sm-2'>" +
           " <a id='btn-"+nphone+"' class='btn btn-danger'  title='Eliminar Teléfono' > " +
           "<i class='fa fa-minus'></i></a> " +
           "</div> </div>");
        div.append(newphone);
        nphone++;
   });

    div.on( 'click','.btn-danger', function () {
        var id = $(this).attr('id');
        var i = id.split('-')[1];
        $( ("#group-"+i) ).remove();



        $(".phone").each(function (i) {
            $(this).attr('id','group-'+ (i+1));
            $(this).find('input').attr('name','telefono-'+(i+1));
            $(this).find('a').attr('id','btn-'+(i+1));
        });

        nphone--;

    });

});
