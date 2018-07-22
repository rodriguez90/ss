/**
 * Created by yopt on 17/06/2018.
 */



$(function () {

    $("#selectpicker-bl").select2(
        {
            language: "es",
            placeholder: 'Seleccione el BL',
            width: '100%',
            closeOnSelect: true,
            allowClear:true,
            minimumInputLength:1,
            ajax:
            {
                url: homeUrl + '/rd/process/likebl',

                dataType: 'json',
                delay: 250,
                cache: true,
                data: function (params) {
                    var query = {
                        bl: params.term,
                    };

                    return query;
                },
                processResults: function (data) {
                    console.log(data);
                    var results  = [];

                    $.each(data.bls, function (index, item) {
                        results .push({
                            id: item.bl,
                            text: item.bl,
                        });
                    });
                    return {
                        results: results
                    };
                },
            },
        });
});
