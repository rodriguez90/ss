/**
 * Created by pedro on 30/05/2018.
 */

var lan = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        // "sFirst":    "Primero",
        "sFirst":    "<<",
        // "sLast":     "Último",
        "sLast":     ">>",
        // "sNext":     "Siguiente",
        "sNext":     ">",
        // "sPrevious": "Anterior"
        "sPrevious": "<"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};

var stop_watch_start = moment().hour(0).minute(29).second(59);
var stop_watch_end = moment(stop_watch_start).subtract({'minutes' : 30});
var selectedContainers = [];

var handleStopWatch = function()
{
    var c = $("#stop_watch");
    stop_watch_start.subtract({seconds: 1});

    if(stop_watch_start.minutes() < 10 )
    {
        $("#stop_watch_widget").removeClass("bg-green")
        $("#stop_watch_widget").addClass("bg-red")
    }

    if(stop_watch_start === stop_watch_end || stop_watch_start.minutes === 0)
    {
        alert("Ha espirado el tiempo de trabajo");
        window.location.reload();
        return;
    }
    c.text("00:" + stop_watch_start.format('mm:ss'));
};

var handleSelectAll = function () {
    $('#select-all').on('click', function(){

        var table = $('#data-table').DataTable();
        var checked = this.checked;

        table
            .rows()
            .data()
            .each( function ( value, index ) {
                // console.log(index);
                // console.log(value);

                if(value.id !== -1)
                {
                    return false;
                }
                else
                {
                    // var index = selectedContainers.indexOf(value.name);
                    // alert('Voy a trabajar la seleccion: ' + checked);
                    if(checked)
                    {
                        // dt.row(index.row, index.column)
                        table.row(index).select();
                        // if(index === -1) // seleccionando
                        //     selectedContainers.push(value.name);

                    }
                    else {
                        table.row(index).deselect();
                        // if(index !== -1) // seleccionando
                        //     selectedContainers.splice(value.name, 1);
                    }
                }
            } );
    });
};

var handleSelectTransCompany = function () {

    $('#yesRadio').on('click', function() {

        var table = $('#data-table').DataTable();

        var table3 = $('#data-table3').DataTable();

        table3
            .clear()
            .draw();

        table
            .rows( { selected: true } )
            .data()
            .each( function ( value, index ) {
                // console.log( 'Data in index: '+index +' is: '+ value.name );
                if(value.id === -1 || value.status === 'Pendiente')
                    table3.row.add(
                        value
                    ).draw();
            } );

        document.getElementById('tSingle').style.display = 'none';
        document.getElementById('tMultiple').style.display = 'inline';
    });

    $('#noRadio').on('click', function() {
        var table = $('#data-table3').DataTable();

        table
            .clear()
            .draw();

        document.getElementById('tMultiple').style.display = 'none';
        document.getElementById('tSingle').style.display = 'inline';
    });

    $("#select-agency").select2(
    {
        language: "es",

        placeholder: 'Seleccione la compañia de transporte',
        width: 'auto',
        minimumInputLength:5,
        // allowClear: true,
        // tags: true,
        closeOnSelect: false,
        ajax: {
            url: homeUrl + '/rd/api-trans-company',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                // console.log(data);
                var myResults  = [];
                $.each(data, function (index, item) {
                    // console.log(item);
                    myResults .push({
                        id: item.id,
                        text: item.name
                    });
                });
                return {
                    results: myResults
                };
            },
            cache: true,
        },
        // minimumInputLength: 2
    });
};

var fetchContainers = function (bl) {

    $.ajax({
        // async:false,
        url: homeUrl + "/rd/process/containers/",
        type: "get",
        dataType:'json',
        data: {
            bl: bl,
        },
        success: function(response) {
            console.log(response);

            fetchContainersWS(bl, response['containers']);

        },
        error: function(response) {
            console.log(response);
            console.log(response.responseText);
            result = false;
            // return false;
        }
    });
};

var fetchContainersWS = function (bl, containers) {
    var data = [];
    var types = ["DRY", "RRF"];
    var tonnages = [20, 40];
    // alert("Random: " +);

    var table = $('#data-table').DataTable();

    table
        .clear()
        .draw();


    for (var i = 0; i < 10; i++)
    {
        var type = types[Math.round(Math.random())];
        var tonnage = tonnages[Math.round(Math.random())]
        var container =  {
            id:-1,
            checkbox:"",
            name:"Contenedor " + i,
            type: type,
            tonnage: tonnage,
            deliveryDate:moment().format('YYYY-MM-DD'),
            agency:agency.name,
            wharehouse:1,
            transCompany:{name:'', id:-1},
            status:''
        };
        var select = false;
        var status = null;
        for(var j = 0, length = containers.length; j < length ; j++)
        {
            var container2 = containers[j];
            status = container2.status;
            var statusIsDate = moment(status).isValid();
            //FIXME: Here importan condition
            if(container2.name === container.name &&
                container2.status !== "Pendiente" &&
                !statusIsDate)
            {
                select = true;
                container.id = container2.id
                break;
            }
        }

        if(select)
            table.row.add(
                container
            ).draw().select();
        else
            table.row.add(
                container
            ).draw();
    }
};

$(document).ready(function () {

    // console.log(agency);
    console.log(processType);
    // init wizar
    FormWizardValidation.init();

    // init tables
    TableManageTableSelect.init()

    $('#blCode').parsley().on('field:success', function() {
        $('#search-container').prop('disabled', false)
    }).on('field:error', function () {
        $('#search-container').prop('disabled', true)
    });

    // stop watch
    setInterval(handleStopWatch, 1000);

    // select all
   handleSelectAll();

    // search container
    $('#search-container').click( function() {
        // ajax resquest service for container
        // alert("// ajax resquest service for container");

        console.log("BL CODE: "  + $('#blCode').val());

        $('#blCode').prop('disabled', true);
        var bl = $('#blCode').val();
        fetchContainers(bl);

        return false;
    });

    // select2 to agency
    handleSelectTransCompany();

});
