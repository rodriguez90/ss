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
    "select":{
        _: "%d filas selecionadas",
    },
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


var selectedContainers = [];


var stop_watch_start = moment().hour(0).minute(29).second(59);
var timerId = null;


var cleanUI = function () {
    selectedContainers = [];
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

    // $("#wizard").bwizard();

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
                // console.log(index);
                // console.log(value);

                if(!value.selectable)
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

        // var table = $('#data-table').DataTable();

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
        width: 'auto',
        minimumInputLength:5,
        // allowClear: true,
        // tags: true,
        closeOnSelect: true,
        ajax: {
            url: homeUrl + '/rd/api-trans-company',
            dataType: 'json',
            // delay: 250,
            cache: true,
            processResults: function (data) {
                // console.log(data);
                var myResults  = [];
                $.each(data, function (index, item) {
                    // console.log(item);
                    myResults .push({
                        id: item.id,
                        text: item.name,
                        ruc: item.ruc
                    });
                });
                return {
                    results: myResults
                };
            },
        },
    });

    $('#selectTransCompany').on('select2:opening', function (e) {
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
    });

    $('#selectTransCompany').on('select2:select', function (e) {
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
        // table.draw();
    });
};

var fetchContainers = function (bl) {
    cleanUI();
    $.ajax({
        // async:false,
        url: homeUrl + "/rd/container/containers",
        type: "get",
        dataType:'json',
        data: {
            'bl': bl,
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
    var statusArray = [
                'PENDIENTE',
                 moment().format(),
                'PONCHADO',
                'TRASLADO',
                'EN PATIO',
                'EMBARCADO',
                'DESPACHADO'];

    var table = $('#data-table').DataTable();

    table
        .clear()
        .draw();

    for (var i = 0; i < 10; i++)
    {
        var type = types[Math.round(Math.random())];
        var tonnage = tonnages[Math.round(Math.random())];
        var randomIndex = Math.floor(Math.random() * 6);
        var status = statusArray[randomIndex];
        // console.log(status);
        var container =  {
            id:-1,
            checkbox:"",
            name:"Contenedor " + i,
            type: type,
            tonnage: tonnage,
            deliveryDate:new Date(),
            agency:agency.name,
            wharehouse:1,
            transCompany:{name:'', id:-1, ruc:""},
            status:status,
            selectable:true
        };
        var select = false;
        var statusIsDate = moment(status).isValid();
        if( container.status !== "PENDIENTE" &&
            !statusIsDate)
        {
            container.selectable = false
            // select = true;
        }
        // for(var j = 0, length = containers.length; j < length ; j++)
        // {
        //     var container2 = containers[j];
        //     status = container2.status;
        //     var statusIsDate = moment(status).isValid();
        //     //FIXME: Here importan condition
        //
        //     if(container2.name === container.name &&
        //         container2.status !== "PENDIENTE" &&
        //         !statusIsDate)
        //     {
        //         select = true;
        //         container.id = container2.id
        //         break;
        //     }
        // }

        table.row.add(
            container
        ).draw();

        // if(!container.selectable)
        //     table.row.add(
        //         container
        //     ).draw().select();
        // else
        //     table.row.add(
        //         container
        //     ).draw();
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
    timerId = setInterval(handleStopWatch, 1000);

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
