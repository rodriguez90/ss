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
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};

$(document).ready(function () {

    // init wizar
    FormWizardValidation.init();

    // init tables
    TableManageTableSelect.init()

    $('#blCode').parsley().on('field:success', function() {
        $('#search-container').prop('disabled', false)
    }).on('field:error', function () {
        $('#search-container').prop('disabled', true)
    });

    // $('#blCode').change(function () {
    //     // console.log($('#blCode').val());
    // });


    // cronometer
    setInterval(function () {
        var m = $("#minutes");
        var s = $("#seconds");
        var currentMinutes = parseInt(m.text());
        var currentSeconds = parseInt(s.text());
        currentSeconds--;

        if(currentSeconds == 0) {
            currentMinutes--;
            currentSeconds = 59;
        }

        if(currentMinutes==0)
        {
            alert("Ha espirado el tiempo de trabajo");
            window.location.reload();
        }

        m.text(currentMinutes);
        s.text(currentSeconds);

    }, 1000);

    // select all
    $('#select-all').on('click', function(){

        var table = $('#data-table').DataTable();

        if(this.checked)
        {
            table.rows().select();
            return;
        }

        table.rows().deselect();
    });

    // search container
    $('#search-container').click( function() {
        // ajax resquest service for container
        // alert("// ajax resquest service for container");

        console.log("BL CODE: "  + $('#blCode').val());

        $('#blCode').prop('disabled', true);

        var data = [];
        var types = ["DRY", "RRF"];
        var tonnages = [20, 40];
        // alert("Random: " +);

        var table = $('#data-table').DataTable();

        // table.rows().delete();

        // var rows = table
        //     .rows()
        //     .remove()
        //     .draw();

        table
            .clear()
            .draw();


        for (var i = 0; i < 10; i++)
        {
            var type = types[Math.round(Math.random())];
            var tonnage = tonnages[Math.round(Math.random())]
            table.row.add(
                {
                    checkbox:"",
                    name:"Contenedor " + i,
                    type: type,
                    tonnage: tonnage,
                    deliveryDate:moment().format('YYYY-MM-DD'),
                    agency:"Agency " + i,
                    wharehouse:1
                }
                ).draw();
        }
        return false;
    });

    // select2 to agency
    $("#select-agency").select2(
        {
        language: "es",
        placeholder: 'Seleccione la compañia de transporte',
        width: 'auto',
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

    // search agency
    $('#search-agency').click( function() {
        // ajax resquest service for agency
        // alert("// ajax resquest service for agency");

        return false;
    });
});
