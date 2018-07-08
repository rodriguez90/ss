/**
 * Created by yopt on 08/07/2018.
 */

$(function () {
    $("#selectpicker-type").change(function(){
        var action = '';
        var option0 = '';
        var div = $('#select-conten');
        var label = $("#label-type");

         switch ($(this).val()){
             case "1":
                 action = "/site/getagencias";
                 option0 = "<option value='' selected=''>Seleccione agencia</option>";
                 label.text("Agencia*");
                 break;
             case "2":
                 action = "/site/getagenciastrans";
                 option0 = "<option value='' selected=''>Seleccione agencia de transporte</option>";
                 label.text("Compañía de Transporte*");
                 break;
             default:
                 action = '';
                 break;
         }

        if(action!=''){
            $.ajax({
                url: homeUrl+ action,
                type: 'get',
                dataType: "json",
                data:{},

                success:function(data){

                    div.empty();

                    var conten = "<select id='selectpicker-type' name='usertypeid' class='form-control'  data-parsley-required='true'  data-size='10' data-live-search='true'>";
                    conten += option0;

                    $.each(data,function(i){
                        conten += "<option value='"+ data[i].id+"' >" +data[i].name +"</option>";
                    })
                    conten+="</select>"
                    div.append(conten);

                },
                error: function(data) {
                    console.log(data.responseText);
                    alert(data.responseText);
                    result = false;
                    // return false;
                }
            });
        }else {
            div.empty();
            label.text("---");
        }


    });
});
