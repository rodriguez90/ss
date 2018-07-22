/**
 * Created by yopt on 27/06/2018.
 */

var systemMode = 1 // only for testing 0-offline  1-online

var handleSelectCompanies = function () {

    $("#agency_id").select2(
        {
            language: "es",
            placeholder: 'Seleccione la Empresa',
            width: '100%',
            closeOnSelect: true,
            allowClear:true,
            minimumInputLength:1,
            ajax: {
                url: homeUrl + '/rd/agency/likeagency',

                dataType: 'json',
                // delay: 250,
                cache: true,
                data: function (params) {
                    var query = {
                        term: params.term,
                    };

                    return query;
                },
                processResults: function (data) {
                    console.log(data);
                    var results  = [];

                    $.each(data.companies, function (index, item) {

                        console.log(item);
                        results.push({
                            id: item.id,
                            text: item.name,
                        });
                    });
                    return {
                        results: results
                    };
                },
            },
        });
};

var handleSelectTransCompanies = function () {
    $("#trans_company_id").select2(
        {
            language: "es",
            placeholder: 'Seleccione la Empresa de Tranporte',
            width: '100%',
            closeOnSelect: true,
            allowClear:true,
            minimumInputLength:5,
            // disabled:role === 'Cia_transporte',
            ajax: {
                url: homeUrl + (systemMode == 0 ? '/rd/api-trans-company': '/rd/trans-company/from-sp'),

                dataType: 'json',
                // delay: 250,
                cache: true,
                data: function (params) {
                    var query = {
                        code: params.term,
                    };

                    return query;
                },
                processResults: function (data) {
                    // console.log(data);
                    var results  = [];
                    var trans_companies = systemMode == 0 ? data : data.trans_companies;

                    $.each(trans_companies, function (index, item) {
                        results .push({
                            id: item.id,
                            text: item.name,
                            ruc: item.ruc
                        });
                    });
                    return {
                        results: results
                    };
                },
            },
        });

};

$(function ()
{
    console.log(role);
    $("#bl").select2(
    {
        language: "es",
        placeholder: 'Seleccione el BL',
        width: '100%',
        closeOnSelect: true,
        allowClear:true,
        minimumInputLength:1,
        ajax: {
            url: homeUrl + '/rd/process/likebl',

            dataType: 'json',
            // delay: 250,
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

    if( role === 'Importador_Exportador')
    {
        document.getElementById('trans_company_container').style.display = 'inline';
        handleSelectTransCompanies();
    }
    else if(role === 'Cia_transporte')
    {
        document.getElementById('agency_container').style.display = 'inline';
        handleSelectCompanies();
    }
    else if( role == 'Administracion')
    {
        document.getElementById('trans_company_container').style.display = 'inline';
        document.getElementById('trans_company_container').style.display = 'inline';
        handleSelectCompanies();
        handleSelectTransCompanies();
    }
});
