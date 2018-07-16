/**
 * Created by yopt on 08/07/2018.
 */

var handleSelect2 = function(op) {

    var action = '';
    var option0 = '';
    var min = -1;
    var validator = "";
    var div = $('#select-conten');
    var label = $("#label-type");
    console.log(op);

    switch (op)
    {
        case 1:
        case 2:
        case 3:
            action = "/site/getagencias";
            option0 = "Seleccione la empresa";
            min = 13;
            label.text("Empresa*");
            break;
        case 4:
            action = "/site/getagenciastrans";
            option0 = "Seleccione la empresa de transporte";
            min = 5;
            label.text("Empresa de Transporte*");
            break;
        // default:
        //     break;
    }

    div.empty();

    console.log(option0);
    console.log(action);

    if(action != '' )
    {
        var conten = "<select id='select-entity' name='type' class='form-control'  data-parsley-required='true'  data-size='10' data-live-search='true' " + validator + "></select>";
        div.append(conten);

        var select2 = $("#select-entity").select2(
        {
            language: "es",

            placeholder: option0,
            width: '100%',
            minimumInputLength:min,
            // allowClear: true,
            // tags: true,
            closeOnSelect: true,
            ajax: {
                url: homeUrl + action,
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
        }).on('select2:select', function (e)
        {
            var data = e.params.data;
        });
    }
    else
    {
        label.text("---");
    }

};

$(function ()
{
    $("#selectpicker-type").change(function()
    {
        handleSelect2(parseInt($(this).val()));
    });
});
