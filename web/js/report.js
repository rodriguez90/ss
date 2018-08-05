/**
 * Created by yopt on 27/06/2018.
 */

var systemMode = 1 // only for testing 0-offline  1-online

var bl=null;
var agencyId=null;
var transCompanyId=null;

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

var handleDataTable = function ()
{
    if ($('#data-table').length !== 0)
    {
        if($.fn.dataTable.isDataTable('#data-table'))
        {
            var table = $('#data-table').DataTable();
            table.clear();
            table.destroy();
        }

        table = $('#data-table').DataTable({
            dom: '<"top"i>flpt<"bottom"p><"clear">',
            pagingType: "full_numbers",
            processing:true,
            lengthMenu: [5, 10, 15],
            "pageLength": 10,
            "language": lan,
            responsive: true,
            rowId: 'id',
            // "processing": true,
            // "serverSide": true,
            "ajax": {
                url:homeUrl + "/site/report",
                type:'POST',
                "data": {
                    "bl": bl,
                    "agencyId": agencyId,
                    "transCompanyId": transCompanyId,
                },
                // "dataSrc": ""
            },
            "columns": [
                {
                    "title": "BL o Booking",
                    "data":'bl',
                },
                {
                    "title": "Empresa",
                    "data":"agencyName",
                },
                {
                    "title": "Fecha Límite",
                    "data":"delivery_date",
                },
                {
                    "title": "Contenedores",
                    "data":"containerAmount",
                },
                {
                    "title": "Proceso",
                    "data":"type",
                },
            ],
             columnDefs: [
                {
                    orderable: true,
                    searchable: true,
                    targets:   [0,1,2,3,4]
                },
                 {
                     targets: [2],
                     data:'delivery_date',
                     render: function (data, type, full, meta )
                     {
                         return moment(data).format('DD-MM-YY');
                     },
                 },
                {
                    targets: [4],
                    data:'type',
                    render: function ( data, type, full, meta )
                    {
                        return data == 1 ? 'Importación':'Exportación';
                    },
                },
            ],
        });

        table.on('search.dt', function()
        {
            var process = "";
            var flag = 0;
            var separator = ''
            table.rows({filter:'applied'}).data().each( function ( value, index )
            {
                if(flag == 0) separator = '?';
                else separator ='&';
                process += separator + "process[]=" + value.id;
                flag++;
            });

            $('#print-process').attr('href', homeUrl + '/site/printreport' + process);
        });
    }
};

$(function ()
{
    console.log(role);

    if(asociatedEntity !== null)
    {
        if(role == 'Importador_Exportador')
        {
            agencyId = asociatedEntity.id;
        }
        else if(role == 'Cia_transporte')
        {
            transCompanyId = asociatedEntity.id;
        }
    }

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

    // search container
    $('#search').click( function() {

        if($('#bl').select2('data').length > 0 )
        {
            bl = $('#bl').select2('data')[0].id;
        }
        else
        {
            bl = null;
        }

        if( role !== 'Importador_Exportador')
        {
            if($('#agency_id').select2('data').length > 0 )
            {
                agencyId = $('#agency_id').select2('data')[0].id;
            }
            else {
                agencyId = null;
            }
        }

        if(role !== 'Cia_transporte')
        {
            if($('#trans_company_id').select2('data').length > 0 )
            {
                transCompanyId = $('#trans_company_id').select2('data')[0].id;
            }
            else {
                transCompanyId = null;
            }
        }
        handleDataTable();
    });

    handleDataTable();
});
