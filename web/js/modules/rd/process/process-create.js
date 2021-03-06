/**
 * Created by pedro on 30/05/2018.
 */


var selectedContainers = [];

var stop_watch_start = moment().hour(0).minute(29).second(59);
var timerId = null;

var containerTypeMap = new Map();
var containerTypeArray = [];

var containertDataMap = new  Map();

var lineNav = null;
var processDeliveryDate = null;

var containerFetchUrl = '';

var hasErrorContainer = false;

var systemMode = 1; // only for testing 0-offline  1-online

var bl = null;

var processTypeStr = '';

var cleanUI = function () {
    bl = null;
    selectedContainers = [];
    containertDataMap.clear();

    $('#selectTransCompany').val('').trigger("change.select2");
    $("#wizard").bwizard("show",0);

    document.getElementById('oce').innerHTML = "OCE: -" ;
    document.getElementById('line').innerHTML = "LINEA: -";
    document.getElementById('staticLinks').style.display = 'none';
    hasErrorContainer = false;

    var table = $('#data-table').DataTable();

    table
        .clear()
        .draw();

    table = $('#data-table2').DataTable();

    table
        .clear()
        .draw();

    table = $('#data-table3').DataTable();

    table
        .clear()
        .draw();
}

var handleStopWatch = function()
{
    var sw = $("#stop_watch");
    stop_watch_start.subtract({seconds: 1});
    sw.text("00:" + stop_watch_start.format('mm:ss'));

    if(stop_watch_start.format('mm:ss') === "00:00")
    {
        clearTimeout(timerId);
        alert("Ha espirado el tiempo de trabajo");
         window.location.reload();
        return;
    }

    if(stop_watch_start.minutes() < 10 &&  !$("#stop_watch_widget").hasClass("bg-red") )
    {
        $("#stop_watch_widget").removeClass("bg-green")
        $("#stop_watch_widget").addClass("bg-red")
    }

};

var handleSelectAll = function () {
    $('#select-all').on('click', function(){

        var table = $('#data-table').DataTable();
        var checked = this.checked;

        table
            .rows()
            .data()
            .each( function ( value, index ) {
                if(!value.selectable)
                {
                    return false;
                }
                else
                {
                    if(checked)
                    {
                        table.row(index).select();
                    }
                    else {
                        table.row(index).deselect();
                    }
                }
            } );
    });
};

var handleSelectTransCompany = function () {

    $('#yesRadio').on('click', function() {
        var table = $('#data-table3').DataTable();

        table.rows().deselect();
        table.column(0).visible(true);
        $( table.column( 0 ).nodes() ).addClass( 'highlight' );
        $( table.column( 5 ).nodes() ).addClass( 'highlight' );

        $('#select_all2').on('click', function(){

            var table = $('#data-table3').DataTable();
            var checked = this.checked;

            if(checked)
            {
                table
                    .rows().select();
            }
            else {
                table
                    .rows().deselect();
            }
        });
    });

    $('#noRadio').on('click', function() {
        var table = $('#data-table3').DataTable();
        table.rows().deselect();
        table.column(0).visible(false);
    });

    $("#selectTransCompany").select2(
    {
            language: "es",

            placeholder: 'Seleccione la compañia de transporte',
            width: '100%',
            minimumInputLength:5,
            // allowClear: true,
            // tags: true,
            closeOnSelect: true,
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
    }).on('select2:opening', function (e) {
        var table = $('#data-table3').DataTable();
        var count = table.rows( { selected: true } ).count();
        var selectedValue = $("input[name='radio_default_inline']:checked").val();

        if(selectedValue === "1" && count <= 0)
        {
            e.stopPropagation();
            e.preventDefault();
            alert("Debe seleccionar los contenedores para asignar la Cia de Transporte");
            return false;
        }
    }).on('select2:select', function (e) {
        var table = $('#data-table3').DataTable();

        var data = e.params.data;
        console.log(data);

        var trans_company =  {
            "id":data.id,
            "name":data.text,
            "ruc":data.ruc,
        };

        var selectedValue = $("input[name='radio_default_inline']:checked").val();

        var condition = {};
        if(selectedValue === "1")
        {
            condition = { selected: true };
        }

        table
            .rows( condition )
            .indexes()
            .each( function ( value, index ) {
                var data = table.row(value).data();
                data.transCompany = trans_company;
                table.row(value).data( data).draw();
            } );

        table.rows().deselect();
    });
};

var fetchContainers = function (bl) {
    $.ajax({
        url: containerFetchUrl,
        type: "get",
        dataType:'json',
        data: {
            'bl': bl,
            'type': processType,
        },
        success: function(response) {
            console.log(response);

            if(response.success)
            {
                if(response['containers'].length)
                {
                    fetchContainerTypes(false);

                    var table = $('#data-table').DataTable();
                    table
                        .clear()
                        .draw();

                    lineNav = response['line'];

                    processDeliveryDate = response['deliveryDate'];


                    document.getElementById('oce').innerHTML = "OCE: " + lineNav.oce;
                    document.getElementById('line').innerHTML = "NOMBRE: " + lineNav.name;

                    for (var i = 0; i < response['containers'].length; i++)
                    {
                        addContainer(table, response['containers'][i])
                    }
                }
                else {
                    alert("No hay contenedores asociado al " + processTypeStr + " especificado.");
                }
            }
            else {
                alert(response.msg);
            }
        },
        error: function(response) {
            console.log(response);
            console.log(response.responseText);
            result = false;
        }
    });
};

var fetchContainersOffLine = function (bl) {

    var types = ["DRY", "RRF"];
    var tonnages = [20, 40];
    var statusArray = [
        'PENDIENTE',
        moment().format(),
        '',
        '',
        'PENDIENTE',
        'EMBARCADO',
        'DESPACHADO'];

    var table = $('#data-table').DataTable();

    table
        .clear()
        .draw();

    lineNav = {
        id: 1,
        name:"TTT DDD",
        oce:"1111",
        code:"TTT",
    };

    processDeliveryDate = moment().utc().format("DD-MM-YYYY");

    document.getElementById('oce').innerHTML = "OCE: " + lineNav.oce;
    document.getElementById('line').innerHTML = "NOMBRE: " + lineNav.name;

    fetchContainerTypes(false);

    for (var i = 0; i < 10; i++)
    {

        var typeIndex = Math.floor(Math.random() * (containerTypeMap.size - 1));
        var v = null;
        var tonnage = tonnages[Math.round(Math.random())];
        var statusIndex = Math.floor(Math.random() * 6);
        var status = statusArray[statusIndex];
        type = Array.from(containerTypeMap.values())[typeIndex];


        var dataContainer = {
            id:-1,
            name:"ContainerName"+i,
            alias:"ContainerName"+i,
            ptId:-1,
            type: type,
            deliveryDate: processDeliveryDate,
            status: status,
            errCode:Math.round(Math.random()),
            expired:0,
        };
        addContainer(table, dataContainer);
    }
};

var fetchContainerTypes = function (async) {
    $.ajax({
        async:async,
        url: homeUrl + '/rd/container-type/types',
        type: "GET",
        dataType: "json",
        success: function (response) {
            if(response.success)
            {
                containerTypeArray = [];
                containerTypeMap.clear();
                containerTypeArray.push({id:-1, text:""});

                $.each(response.types, function (index, item) {
                    containerTypeMap.set(item.id, {
                        id: String(item.id),
                        name: item.name,
                        tonnage: item.tonnage,
                        code: item.code,
                    });
                    containerTypeArray.push({
                        id: String(item.id),
                        text: item.name
                    });
                });
            }
            else {
                alert(response.msg);
            }
        },
        error: function(data) {
            console.log(data);
            alert(data['msg']);
            result = false;
        }
    });
}

var addContainer = function (table, dataContainer) {

    var statusIsDate = moment(dataContainer.status).isValid();
    // console.log("Status Date Valid: " + statusIsDate);
    var errCode = parseInt(dataContainer.errCode);

    if(!hasErrorContainer && errCode == 1)
    {
        hasErrorContainer = true;
        document.getElementById('staticLinks').style.display = 'inline';
    }

    var container =  {
        id:dataContainer.id,
        ptId:dataContainer.ptId,
        name:dataContainer.name,
        alias:dataContainer.alias,
        type: dataContainer.type,
        deliveryDate:dataContainer.deliveryDate,
        expired:dataContainer.expired,
        transCompany:{name:'', id:-1, ruc:""},
        status:dataContainer.status,
        errCode:errCode,
        checkbox:"",
        statusIsDate:statusIsDate,
        selectable:false,
    };

    containertDataMap.set(container.name, container.type);

    if(statusIsDate)
    {
        container.status = moment(dataContainer.status).format("DD/MM/YYYY HH:mm");
    }

    if( (container.status == "PENDIENTE" ||
        container.status == "" ||
        statusIsDate == true )&&
        errCode == 0 && container.expired == 0)
    {
        container.selectable = true;
    }
    // console.log(container);

    table.row.add(
        container
    ).draw();

};

$(document).ready(function () {

    // console.log(agency);
    // console.log(processType);

    if(processType == 1)
    {
        containerFetchUrl = homeUrl + "/rd/process/sgtblcons";
        processTypeStr = 'BL';
    }
    else {
        containerFetchUrl = homeUrl + "/rd/process/sgtbookingcons";
        processTypeStr = 'Booking';

    }

    // init wizar
    FormWizardValidation.init();

    // init tables
    TableManageTableSelect.init();

    $('#blCode').parsley().on('field:success', function() {
        // alert('success');
        $('#search-container').prop('disabled', false)
    }).on('field:error', function () {
        cleanUI();
        $('#search-container').prop('disabled', true)
    });

    // $('#blCode').change(function() {
    //     cleanUI();
    // });

    // stop watch
    timerId = setInterval(handleStopWatch, 1000);

    // select all
    handleSelectAll();

    // search container
    $('#search-container').click( function() {
        cleanUI();

        bl = $('#blCode').val();

        if(systemMode == 1)
        {
            fetchContainers(bl);
        }
        else {
            fetchContainersOffLine();
        }

    //     return false;
    });

    // select2 to agency
    handleSelectTransCompany();

    // get container types
    // fetchContainerTypes(true);
});
