/**
 * Created by pedro on 30/05/2018.
 */

$(document).ready(function () {

    // init wizar
    FormWizardValidation.init();

    // init tables
    TableManageTableSelect.init()

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

        var data = [];
        var types = ["DRY", "RRF"];
        var tonnages = ["20", "40"];
        // alert("Random: " +);

        var table = $('#data-table').DataTable();

        // table.rows().delete();
        table
            .clear()
            .draw();


        for (var i = 0; i < 10; i++)
        {

            table.row.add(
                {
                    checkbox:"",
                    name:"Contenedor " + i,
                    type:types[Math.round(Math.random())] + tonnages[Math.round(Math.random())],
                    deliveryDate:new Date(),
                    agency:"Agency " + i,
                }
                ).draw();
        }

        // console.log(data);

        // table.rows.add(
        //     [[ "Tiger Nixon", "System Architect","$3,120" ],
        //         ["Tiger Nixon", "System Architect", "$3,120" ]]
        // ).draw();


        // if($('#data-table').length !== 0)
        // {
        //     $( '#data-table' ).dataTable().api().rows.add(data);
        // }
        return false;
    });

    // search agency
    $('#search-agency').click( function() {
        // ajax resquest service for agency
        alert("// ajax resquest service for agency");
        return false;
    });
});
