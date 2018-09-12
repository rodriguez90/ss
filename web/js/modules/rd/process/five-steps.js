
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

var colHeaderContainer = processType === 1 ? 'Contenedor' : 'Booking/Contenedor' ;

// el calendario se acota x la fecha de devolución d los contenedores relacionados en la recepcion
var minDeliveryDate = null;
var maxDeliveryDate = null;

// source for calendar
var calendarSlotEvents = {
    id:'calendarSlotEvents',
    events:[]
};
var ticketEvents = {
    id:'ticketEvents',
    events:[]
};

// utility data structure
var calendarEventMap = new Map(); // calendar event id - key
var ticketEventMap =  new Map(); // ticket event id - key
var containersMap = new Map();
var dateTicketMap = new Map(); // to validate transportation data
var ticketDataMap = new Map();
var transportationDataMap = new Map();

// current calendar event click
var currentCalendarEvent = null;

// selected container to
var selectedContainers = [];

var mode = '';

var toBack = false;

var cleanUI = function () {
    bl = null;
    processDeliveryDate = null;
    selectedContainers = [];
    containertDataMap.clear();
    calendarSlotEvents.events = [];

    $('#selectTransCompany').val('').trigger("change.select2");
    $("#wizard").bwizard("show",0);

    document.getElementById('oce').innerHTML = "OCE: -" ;
    document.getElementById('line').innerHTML = "LINEA: -";
    document.getElementById('staticLinks').style.display = 'none';
    hasErrorContainer = false;

    var table = $('#data-table-step1').DataTable();

    table
        .clear()
        .draw();

    table = $('#data-table-step2').DataTable();

    table
        .clear()
        .draw();

    table = $('#data-table-step4').DataTable();

    table
        .clear()
        .draw();

    table = $('#data-table-step5').DataTable();

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

    $('#select-all-step1').on('click', function(){

        var table = $('#data-table-step1').DataTable();
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
        var table = $('#data-table-step2').DataTable();

        table.rows().deselect();
        table.column(0).visible(true);
        $( table.column( 0 ).nodes() ).addClass( 'highlight' );
        $( table.column( 5 ).nodes() ).addClass( 'highlight' );

        $('#select-all-step2').on('click', function(){

            var table = $('#data-table-step2').DataTable();
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
        var table = $('#data-table-step2').DataTable();
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
        var table = $('#data-table-step2').DataTable();
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
        var table = $('#data-table-step2').DataTable();

        var data = e.params.data;
        // console.log(data);

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

var handleDataTableStep1 = function() {
    "use strict";

    if ($('#data-table-step1').length !== 0) {

        var  table = $('#data-table-step1').DataTable({
            // dom: '<"top"iflp<"clear">>rt',
            dom: '<"top"ip<"clear">>t',
            processing:true,
            lengthMenu: [5, 10, 15],
            pageLength: 10,
            language: lan,
            select: {
                // items: 'cells',
                style:    'multi',
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]],
            responsive: true,
            deferRender: true,
            rowCallback: function( row, data, index ) {
                // console.log("rowCallback to: " + data.name);
            },
            createdRow: function( row, data, dataIndex ) {
                // console.log('init select2: ' + data.name);
                if (!data.selectable ) {
                    $('td', row).eq(0).removeClass('select-checkbox');
                    $(row).addClass('text-danger');
                }
                else {
                    // var elementId =  String(data.name).replace(' ','');
                    // if(processType == 2)
                    // {
                    //     // var  html = '<input type=\"text\" class=\"form-control\" id=\"' + elementId +  '\" placeholder=\"Seleccionar\"' + 'value=\"' + moment(data.deliveryDate).format('DD/MM/YYYY') + '\" >';
                    //
                    //     // $('td', row).eq(3).html(html)
                    //
                    //     $('td:eq(3)', row).datepicker({
                    //         title:"Seleccione la Fecha Límite",
                    //         language: 'es',
                    //         autoclose: true,
                    //         immediateUpdates:true,
                    //         format:'dd-mm-yyyy'
                    //     }).on('changeDate', function(event){
                    //         // console.log(event.date);
                    //         // console.log(dateValue);
                    //         var dateValue = moment(event.date).utc().format('DD-MM-YYYY');
                    //         var mDateValue = moment(event.date)
                    //         var mProcessDD = moment(processDeliveryDate)
                    //         console.log("Container deliveryDate: " + dateValue);
                    //         console.log("Current deliveryDate: " + processDeliveryDate);
                    //         var result = mDateValue.isAfter(mProcessDD);
                    //         console.log(result);
                    //         if(result)
                    //         {
                    //             console.log("Change processDeliveryDate: " + dateValue);
                    //             processDeliveryDate = dateValue;
                    //         }
                    //         // data.deliveryDate = dateValue;
                    //         table.cell(dataIndex, 3).data(dateValue)
                    //     });
                    // }
                    if(processType == 1)
                    {
                        // $('td:eq(2)', row).select2(
                        // $('td', row).eq(2).select2(
                        // console.log(data);
                        // console.log(data.type);
                        $('select', row).select2(
                            {
                                language: "es",
                                placeholder: 'Seleccione Tipo de Contenedor',
                                width: '100%',
                                closeOnSelect: true,
                                data:containerTypeArray,
                            }).on('select2:select', function (e) {
                            var type = e.params.data;
                            var containerType = containerTypeMap.get(type.id);
                            containertDataMap.set(data.name,containerType);

                            // $('#mySelect2').val(type.id); // Select the option with a value of '1'
                            // $('#mySelect2').trigger('change:select2'); // Notify any JS components that the value changed
                            // table.row(dataIndex).data(data); -- esto prococa que la fila se repinte de nuevo y x tango perdemos la inicializacion del select
                            // return true;
                        }).val(data.type.id).trigger('change');
                        // $('select', row).val(data.type.id); // Select the option with a value of '1'
                        // $('select', row).trigger('change:select2'); // Notify any JS components that the value changed
                    }
                }
            },
            columns: [
                {
                    // "title": "Selecionar",
                    "data":'checkbox', // FIXME CHECK THIS
                },
                {
                    "title":colHeaderContainer,
                    "data":"name",
                },
                { "title": "Tipo/Tamaño",
                    "data":"type",
                },
                { "title": "Fecha Límite",
                    "data":"deliveryDate",
                },
                { "title": "Estado",
                    "data":"status"
                },
            ],
            columnDefs: [
                {
                    orderable: false,
                    searchable: false,
                    className: 'select-checkbox',
                    targets:   [0],
                },
                {
                    targets: [2],
                    data:'type',
                    render: function ( data, type, full, meta )
                    {
                        var elementId =  String(full.name).trim();
                        // console.log("render: " + elementId + " " + type);
                        if(type == 'display' && full.selectable && processType == 1)
                        {
                            var selectHtml = "<select class=\"form-control\" id=\"selectType" +elementId + "\"></select>";
                            return selectHtml;
                        }
                        return data.name;
                    },
                },
                // {
                //     targets: [3],
                //     data:'deliveryDate',
                //     render: function ( data, type, full, meta )
                //     {
                //         var elementId =  String(full.name).trim();
                //         // console.log("render: " + elementId + " " + type);
                //         // console.log("data: ");
                //         // console.log(data);
                //         if(type == 'display' && full.selectable && processType == 2)
                //         {
                //             var  html = '<input type=\"text\" class=\"form-control\" id=\"' + elementId +  '\" placeholder=\"Seleccionar\"' + ' value=\"' + data + '\"' + ' data-date=\"' +  data + '\" >';
                //             console.log(html)
                //             return html;
                //         }
                //
                //         return data;
                //     },
                // },
            ],
        });

        table.on( 'user-select', function ( e, dt, type, cell, originalEvent ) {
            // alert('user-select');
            var index = cell.index();
            // console.log(index);
            // console.log(dt.row(index.row, index.column).data());
            // var id = dt.row(index.row, index.column).data().id;
            // var name = dt.row(index.row, index.column).data().name;
            var status = dt.row(index.row, index.column).data().status;
            var errCode = dt.row(index.row, index.column).data().errCode;
            // if(status !== 'PENDIENTE' && !moment(status).isValid())
            var msg = '';
            if(errCode == 0)
            {
                msg = 'Este contenedor no puede ser seleccionado su estado es: ' + status
            }
            else if(dt.row(index.row, index.column).data().expired == 1)
            {
                msg = 'Este contenedor no puede ser seleccionado: ha expirado su fecha límite.';
            }
            else {
                msg = 'Este contenedor no puede ser seleccionado pendiente de facturación o crédito';
            }

            if(dt.row(index.row, index.column).data().selectable == false)
            {
                alert(msg);
                e.preventDefault();
                return false;
            }
        } );
    }
};

var handleDataTableStep2 = function () {
    "use strict";
    if ($('#data-table-step2').length !== 0) {
        $('#data-table-step2').DataTable({
            dom: '<"top"ip<"clear">>t',
            processing:true,
            lengthMenu: [5, 10, 15],
            "pageLength": 10,
            "language": lan,
            responsive: true,
            rowId: 'name',
            select: {
                // items: 'cells',
                style:    'multi',
                selector: 'td:first-child'
            },
            "columns": [
                {
                    // "title": "Seleccione",
                    "data":'checkbox', // FIXME CHECK THIS
                },
                {   "title":colHeaderContainer,
                    "data":"name",
                },
                { "title": "Tipo/Tamaño",
                    "data":"type"
                },
                { "title": "Fecha Límite",
                    "data":"deliveryDate",
                },
                { "title": "Estado",
                    "data":"status"
                },
                { "title": "Empresa de Transporte",
                    "data":"transCompany"
                },
            ],
            columnDefs: [
                {
                    orderable: false,
                    searchable: false,
                    className: 'select-checkbox',
                    targets:   [0],
                    visible:false
                    // data: null,
                },
                {
                    targets: [2],
                    title:"Tipo",
                    data:"type",
                    render: function ( data, type, full, meta ) {
                        return data.name;
                    },
                },
                {
                    targets: [3],
                    data:'deliveryDate',
                    render: function ( data, type, full, meta ) {
                        return data;
                    },
                },
                {
                    targets: [5],
                    render: function ( data, type, full, meta ) {
                        return data.name
                    },
                },
            ],
        });
    }

    var table3 = $('#data-table-step2').DataTable();
    table3.column(0).visible(false);
};

var handleDataTableStep4 = function() {
    if ($('#data-table-step4').length !== 0) {


        var  table = $('#data-table-step4').DataTable({
            dom: '<"top"iflp<"clear">>rt',
            pagingType: "full_numbers",
            responsive: true,
            info: true,
            processing:true,
            lengthMenu: [5, 10, 15],
            pageLength: 10,
            order: [[1, "asc"]],
            columns: [
                { title: colHeaderContainer,
                    "data":"name"
                },
                { title: "Tipo",
                    // data:"type",
                },
                { title: "Fecha Límite",
                    data:"deliveryDate"
                },
                { "title": "Estado",
                    "data":"status"
                },
                { title: "Fecha del Cupo",
                    "data":"dateTicket"
                },
                { "title": "Empresa de Transporte",
                    "data":"transCompany"
                },
                { title: "Placa del Carro",
                    "data":"registerTrunk",
                },
                { title: "Nombre del Chofer",
                    "data":"nameDriver"
                },
                { title: "Cédula del Chofer",
                    "data":"registerDriver",
                },
            ],
            "language": lan,
            "createdRow": function( row, data, dataIndex ) {
                // console.log('init select2: ' + data.name);
                if(ticketDataMap.has(data.name))
                {
                    $('td select', row).eq(0).select2(
                        {
                            language: "es",
                            placeholder: 'Seleccione la Placa',
                            // allowClear: true,
                            width: '100%',
                            closeOnSelect: true,
                            ajax:{
                                url: homeUrl + '/rd/trans-company/trunks',
                                type: "GET",
                                dataType: "json",
                                cache: true,
                                data: function (params) {
                                    // var transCompanyRuc = data.transCompany.ruc;
                                    var query = {
                                        term: params.term,
                                        code: data.transCompany.ruc,
                                        mode:systemMode
                                    }
                                    return query;
                                },
                                processResults: function (response) {
                                    // console.log(response);
                                    var results  = [];
                                    $.each(response.trunks, function (index, item) {
                                        // console.log(item);
                                        // [err_code], [err_msg], [placa], [rfid]
                                        results.push({
                                            id: item.placa,
                                            text: item.placa,
                                            err_code: item.err_code,
                                            err_msg: item.err_msg,
                                            rfid: item.rfid,
                                        });
                                    });
                                    return {
                                        results: results
                                    };
                                },
                            },
                        }).on('select2:select', function (e) {
                        // alert(e.params.data);
                        var trunk = e.params.data;
                        var transactionData = transportationDataMap.get(data.name);

                        if(trunk.err_code !== "0")
                        {
                            e.preventDefault();
                            transactionData.registerTrunk = "";
                            alert("Esta placa no puede ser seleccionada: " + trunk.err_msg);
                            $('td select', row).eq(0).val('').trigger("change.select2");
                        }
                        else
                        {
                            var valid = true;
                            var msg = '';
                            var containersArray = dateTicketMap.get(data.calendarId);
                            var containersByTrunk20= 0;
                            var containersByTrunk40 = 0;

                            for(var i=0, count = containersArray.length; i < count; i++)
                            {
                                var container = containersMap.get(containersArray[i]);
                                var cTransactionData = transportationDataMap.get(container.name);

                                if(cTransactionData.registerTrunk == trunk.id)
                                {
                                    if(container.type.tonnage == 20)
                                    {
                                        containersByTrunk20++;
                                    }
                                    else if(container.type.tonnage == 40)
                                    {
                                        containersByTrunk40++;
                                    }
                                }
                            }

                            if(containersByTrunk40 == 1) // ya la placa esta asignada en un contenedor de 40 para la misma fecha
                            {
                                valid = false;
                                msg = 'Esta placa esta asiganda a un contenedor de 40 toneladas en esta fecha.'
                            }
                            else if(containersByTrunk20 == 2) // ya la placa esta asignada a 2 contenedores de 20 para la misma fecha
                            {
                                valid = false;
                                msg = 'Esta placa esta asiganda a dos contenedores de 20 toneladas en esta fecha.'
                            }
                            else if(containersByTrunk20 == 1 && data.type.tonnage == 40) // no puede asiganr un contenedor de 40 toneladas
                            {
                                valid = false;
                                msg = 'Esta placa esta asiganda a un contenedor de 20 toneladas en esta fecha.'
                            }

                            if(valid)
                                transactionData.registerTrunk = trunk.id;
                            else
                            {
                                transactionData.registerTrunk = "";
                                alert(msg);
                                $('td select', row).eq(0).val('').trigger("change.select2");
                            }
                        }

                        transportationDataMap.set(data.name, transactionData);
                        // api.cell({row: meta.row, column: 5}).data(trunk.id);
                        // table.row(index).data(data)
                    });

                    $('td select', row).eq(1).select2(
                        {
                            language: "es",
                            placeholder: 'Seleccione el Chofer',
                            width: '100%',
                            closeOnSelect: true,
                            // matcher: matchCustom,
                            ajax:{
                                url: homeUrl + '/rd/trans-company/drivers',
                                type: "GET",
                                dataType: "json",
                                cache: true,
                                data: function (params) {
                                    var query = {
                                        term: params.term,
                                        code: data.transCompany.ruc,
                                        mode:systemMode
                                    }
                                    return query;
                                },
                                processResults: function (response) {
                                    // console.log(response);
                                    var results  = [];
                                    $.each(response.drivers, function (index, item) {
                                        results.push({
                                            id: item.chofer_ruc,
                                            text: item.chofer_nombre,
                                            err_code: item.err_code,
                                            err_msg: item.err_msg,
                                            chofer_ruc: item.chofer_ruc,
                                        });
                                    });
                                    return {
                                        results: results
                                    };
                                },
                            },
                        }).on('select2:select', function (e) {
                        var driver = e.params.data;
                        var transactionData = transportationDataMap.get(data.name);
                        if(driver.err_code !== "0")
                        {
                            e.preventDefault();
                            alert("Este Chofer no puede ser seleccionado: " + driver.err_msg);
                            transactionData.registerDriver = "";
                            transactionData.nameDriver = "";
                            table.cell({row: dataIndex, column: 8}).data("");
                            $('td select', row).eq(1).val('').trigger("change.select2");
                        }
                        else
                        {
                            var valid = true;
                            var msg = '';
                            var containersArray = dateTicketMap.get(data.calendarId);
                            var containersByTrunk20= 0;
                            var containersByTrunk40 = 0;
                            for(var i=0, count = containersArray.length; i < count; i++)
                            {
                                var container = containersMap.get(containersArray[i]);
                                var cTransactionData = transportationDataMap.get(container.name);

                                if(cTransactionData.registerDriver == driver.id)
                                {
                                    if(container.type.tonnage == 20)
                                    {
                                        containersByTrunk20++;
                                    }
                                    else if(container.type.tonnage == 40)
                                    {
                                        containersByTrunk40++;
                                    }
                                }
                            }

                            if(containersByTrunk40 == 1) // ya el chofer esta asociado a un contenedor de 40 para la misma fecha
                            {
                                valid = false;
                                msg = 'Esta chofer esta asociado a un contenedor de 40 toneladas en esta fecha.'
                            }
                            else if(containersByTrunk20 == 2) // ya la placa esta asignada a 2 contenedores de 20 para la misma fecha
                            {
                                valid = false;
                                msg = 'Este chofer esta asociado a dos contenedores de 20 toneladas en esta fecha.'
                            }
                            else if(containersByTrunk20 == 1 && data.type.tonnage == 40) // no puede asiganr un contenedor de 40 toneladas
                            {
                                valid = false;
                                msg = 'Este chofer ya esta asociado a un contenedor de 20 toneladas en esta fecha.'
                            }

                            if(valid)
                            {
                                transactionData.registerDriver = driver.id;
                                transactionData.nameDriver = driver.text;
                                table.cell({row: dataIndex, column: 8}).data(driver.id);
                            }
                            else
                            {
                                transactionData.registerDriver = "";
                                transactionData.nameDriver = "";
                                alert(msg);
                                $('td select', row).eq(1).val('').trigger("change.select2");
                                table.cell({row: dataIndex, column: 8}).data("");
                            }
                        }
                        transportationDataMap.set(data.name,transactionData);
                    });
                }
            },
            columnDefs: [
                {
                    targets: [1],
                    title:"Tipo",
                    data:null,
                    render: function ( data, type, full, meta ) {
                        return data.type.code + data.type.tonnage;
                    }
                },
                {
                    targets: [2],
                    data:'deliveryDate',
                    render: function ( data, type, full, meta ) {
                        return moment(data, "DD-MM-YYYY").format("DD/MM/YYYY");
                    },
                },
                {
                    targets: [4],
                    data:'dateTicket',
                    render: function ( data, type, full, meta ) {
                        var dateFormated = '-';
                        if(ticketDataMap.has(full.name))
                            dateFormated =  moment(data).format("DD/MM/YYYY HH:mm");
                        return dateFormated;
                    },
                },
                {
                    targets: [5],
                    render: function ( data, type, full, meta ) {
                        return data.name
                    },
                },
                {
                    targets: [6],
                    data:'registerTrunk',
                    render: function ( data, type, full, meta ) {
                        var elementId =  String(full.name).trim();
                        if(type == 'display')
                        {
                            if($("#selectTrunk"+elementId).length === 0)
                            {
                                var selectHtml = "-";
                                if(ticketDataMap.has(full.name)) {
                                    selectHtml = "<select class=\"form-control\" id=\"selectTrunk" + elementId + "\"></select>";
                                }
                            }
                            return selectHtml;
                        }
                        return data;
                    },
                },
                {
                    targets: [7],
                    data:'nameDriver',
                    render: function ( data, type, full, meta ) {
                        var elementId =  String(full.name).trim();

                        if(type == 'display')
                        {
                            var selectHtml = "-";
                            if(ticketDataMap.has(full.name))
                            {
                                selectHtml = "<select class=\"form-control\" id=\"selectDriver" +elementId + "\"></select>";
                            }

                            return selectHtml;
                        }
                        return data;
                    },
                },
            ],
        });
    }
};

var handleDataTableStep5 = function () {
    var columns = [
        {  "title":colHeaderContainer,
            "data":"name",
        },
        { "title": "Tipo/Tamaño",
            "data":"type",
        },
        { "title": "Fecha Límite",
            "data":"deliveryDate",
        },
        { "title": "Estado",
            "data":"status"
        },
        { title: "Fecha del Cupo",
            "data":"dateTicket"
        },
        { "title": "Empresa de Transporte",
            "data":"transCompany"
        },
        { title: "Placa del Carro",
            "data":"registerTrunk",
        },
        { title: "Nombre del Chofer",
            "data":"nameDriver"
        },
        { title: "Cédula del Chofer",
            "data":"registerDriver",
        },
    ];
    if ($('#data-table-step5').length !== 0) {

        $('#data-table-step5').DataTable({
            // dom: '<"top"iflp<"clear">>rt',
            dom: '<"top"ip<"clear">>t',
            "columns": columns,
            processing:true,
            lengthMenu: [5, 10, 15],
            pageLength: 10,
            "language": lan,
            responsive: true,
            columnDefs: [
                {
                    targets: [1],
                    title:"Tipo",
                    data:"type",
                    render: function ( data, type, full, meta ) {
                        return data.name;
                    },
                },
                {
                    targets: [2],
                    data:'deliveryDate',
                    render: function ( data, type, full, meta )
                    {
                        // console.log(data);
                        // return moment(data).format("DD/MM/YYYY");
                        return data;
                    },
                },
                {
                    targets: [4],
                    data:'dateTicket',
                    render: function ( data, type, full, meta )
                    {
                        var dateFormated = '-';
                        if(ticketDataMap.has(full.name))
                            dateFormated =  moment(data).format("DD/MM/YYYY HH:mm");
                        return dateFormated;
                    },
                },
                {
                    targets: [5],
                    data:'transCompany',
                    render: function ( data, type, full, meta ) {
                        return data.name
                    },
                },
            ],
            // language: {url: 'web/plugins/DataTables/i18/Spanish.json'
        });
    }
};

// init table in modal dialog
var handleTableInModal = function () {

    if ($('#data-table-modal').length !== 0) {

        $('#data-table-modal').DataTable({
            "columns": [
                {
                    // "title": "Selecionar",
                    "data":'checkbox', // FIXME CHECK THIS
                },
                { "title": "Contenedor",
                    "data":"name",
                },
                { "title": "Tipo",
                    // "data":"type",
                },
                { "title": "Fecha Limite",
                    "data":"deliveryDate",
                },
            ],
            processing:true,
            lengthMenu: [5, 10, 15],
            "pageLength": 10,
            "language": lan,
            // select: true,
            responsive: true,
            columnDefs: [
                {
                    orderable: false,
                    searchable: false,
                    className: 'select-checkbox',
                    targets:   [0],
                },
                {
                    targets: [2],
                    title:"Tipo",
                    data:null,
                    render: function ( data, type, full, meta ) {
                        return data.type+ data.tonnage;
                    },
                },
                {
                    targets: [3],
                    data:'deliveryDate',
                    render: function ( data, type, full, meta ) {
                        return moment(data, "DD-MM-YYYY").format("DD/MM/YYYY");
                    },
                },

            ],
            select: {
                // items: 'cells',
                style:    'multi',
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]]
        });

        var table = $('#data-table-modal').DataTable();

        table.on( 'user-select', function ( e, dt, type, cell, originalEvent ) {
            // alert('user-select');
            var count = dt.rows( { selected: true } ).count();
            // alert('Select : ' + type + ' selected: ' + indexes + ' count ' + count);
            var disponivility = currentCalendarEvent.count;
            // console.log($this);
            // console.log(e.target);
            // console.log(originalEvent.currentTarget);
            // console.log(originalEvent);
            // console.log(cell[0]);
            // var row = dt.row(cell[0]);
            // console.log(row.find());
            // console.log(row.node());
            // console.log(row.node().hasClass('selected'));
            //
            // if(currentCalendarEvent && (count + 1) > disponivility)
            // {
            //     alert('Solo hay ' + disponivility + ' cupos disponibles');
            //
            //     e.preventDefault();
            // }

            // if(count > 0)
            // {
            //     $('#aceptBtn').attr('disabled', false);
            // }
            // else
            // {
            //     $('#aceptBtn').attr('disabled', true);
            // }

            // var ticket = {
            //     "Ticket[process_transaction_id]":1, // FIXME THIS DEFINE BY USER WITH ROLE AGENCY OR IMPORTER/EXPORTER
            //     "Ticket[calendar_id]":1,
            //     "Ticket[status]":1,
            //     "Ticket[active]":1,
            // };

//             $.ajax({
//                 async:false,
//                 url: homeUrl + "/rd/api-ticket/prebooking",
//                 type: "POST",
//                 dataType: "json",
//                 data:  ticket,
// //                            contentType: "application/json; charset=utf-8",
//                 success: function (response) {
//                     // you will get response from your php page (what you echo or print)
//                     var obj = JSON.parse(response);
//                     console.log(obj);
//
//                     if(obj.success)
//                     {
//                         result = true;
//                         window.location.href = obj.url;
//                     }
//                     else
//                     {
//                         alert(obj.msg);
//                     }
//                     // return true;
//                 },
//                 error: function(data) {
//                     console.log(data.responseText);
//                     alert(responseText);
//                     result = false;
//                     // return false;
//                 }
//             });

        } );

//         table.on( 'select', function ( e, dt, type, indexes ) {
//
//         } );

        // table.on( 'select', function ( e, dt, type, indexes ) {
        //     // var rowData = table.rows( indexes ).data().toArray();
        //     // events.prepend( '<div><b>'+type+' <i>de</i>selection</b> - '+JSON.stringify( rowData )+'</div>' );
        // } );
    }
};

var TableManageTableSelect = function () {
    "use strict";
    return {
        //main function
        init: function () {
            handleTableInModal();
            handleDataTableStep1();
            handleDataTableStep2();
            handleDataTableStep4();
            handleDataTableStep5();
        }
    };
}();

var handleBootstrapWizardsValidation = function() {
    "use strict";
    $("#wizard").bwizard(
        {
            clickableSteps: false,
            activeIndexChanged:  function (e, ui)
            {
                if(ui.index == 0)
                {
                    $('ul.bwizard-buttons li.next a').text('Siguiente');
                }
                else if(ui.index == 1)
                {
                    $('ul.bwizard-buttons li.next a').text('Siguiente');

                    $('#selectTransCompany').val('').trigger("change.select2");

                    var table1 = $('#data-table-step1').DataTable();
                    var table2 = $('#data-table-step2').DataTable();

                    table2
                        .clear()
                        .draw();

                    table1
                        .rows( { selected: true } )
                        .data()
                        .each( function ( value, index ) {

                            if(value.selectable)
                            {
                                if(processType == 1)
                                {
                                    value.type = containertDataMap.get(value.name);
                                }

                                table2.row.add(
                                    value
                                ).draw();
                            }
                        });
                }
                else if(ui.index == 2)
                {
                    $('ul.bwizard-buttons li.next a').text('Siguiente');

                    /* TODO: reset data related:
                     calendar events
                     ticket events (transportation data*)
                     */

                    containersMap.clear();
                    ticketEventMap.clear();
                    ticketEvents.events = [];
                    ticketDataMap.clear();
                    transportationDataMap.clear();
                    selectedContainers = [];

                    var table2 = $('#data-table-step2').DataTable();
                    table2
                        .rows( )
                        .data()
                        .each( function ( value, index )
                        {
                           var transData = {
                               registerTrunk:'',
                               registerDriver:'',
                               nameDriver:''
                           };
                            containersMap.set(value.name, value);
                            transportationDataMap.set(value.name, transData);
                        });

                    // init calendar
                    $('.calendar').fullCalendar('destroy');
                    calendarSlotEvents.events = [];

                    Calendar.init();

                    minDeliveryDate = moment();
                    maxDeliveryDate = moment(processDeliveryDate, "DD-MM-YYYY");
                    maxDeliveryDate = maxDeliveryDate.utc();
                    maxDeliveryDate.set({'hours': 23, 'minutes': 59, 'seconds':59});

                    fetchCalendar(minDeliveryDate.format('YYYY-MM-DD HH:mm:ss'),
                                  maxDeliveryDate.format('YYYY-MM-DD HH:mm:ss'),
                                  true);
                }
                else if(ui.index == 3)
                {

                    $('ul.bwizard-buttons li.next a').text('Siguiente');

                    if(selectedContainers.length == 0)
                    {
                        if(toBack)
                        {
                            $("#wizard").bwizard("show","2");
                        }
                        else
                        {
                            $("#wizard").bwizard("show","4");
                        }
                    }
                    else {

                        if(!toBack)
                        {
                            var table4 = $('#data-table-step4').DataTable();

                            table4
                                .clear()
                                .draw();

                            transportationDataMap.clear();
                            dateTicketMap.clear();

                            containersMap.forEach(function(value, key)
                            {
                                var ticketData = ticketDataMap.has(key)? ticketDataMap.get(key): null;

                                var dateTicket = '';
                                var calendarId = '';

                                transportationDataMap.set(value.name, {
                                    registerTrunk: '',
                                    registerDriver: '',
                                    nameDriver: '',
                                });

                                if(selectedContainers.indexOf(key) != -1 && ticketData)
                                {
                                    dateTicket = ticketData.dateTicket;
                                    calendarId = ticketData.calendarId;

                                    var containersArray = [];

                                    if(dateTicketMap.has(ticketData.calendarId))
                                    {
                                        containersArray = dateTicketMap.get(ticketData.calendarId);
                                    }

                                    containersArray.push(value.name);
                                    dateTicketMap.set(ticketData.calendarId, containersArray);
                                }

                                var data = {
                                    name: value.name,
                                    type: value.type,
                                    deliveryDate: value.deliveryDate,
                                    dateTicket:dateTicket,
                                    calendarId:calendarId,
                                    registerTrunk: '',
                                    registerDriver: '',
                                    nameDriver: '',
                                    transCompany:value.transCompany,
                                    ptId:value.ptId,
                                    status:value.status,
                                    alias:value.alias,
                                    id:value.name
                                };

                                table4.row.add(
                                    data
                                ).draw();
                            });
                        }
                    }
                }
                else if(ui.index == 4)
                {
                    $('ul.bwizard-buttons li.next a').text('Finalizar');

                    $('#confirming').prop('checked', false);

                    // TODO: check if has ticket copy from data-table-step4
                    var sourceTable = selectedContainers.length > 0 ? $('#data-table-step4').DataTable(): $('#data-table-step2').DataTable();

                    var table5 = $('#data-table-step5').DataTable();

                    table5
                        .clear()
                        .draw();

                    sourceTable
                        .rows( )
                        .data()
                        .each( function ( value, index )
                        {
                            var transportationData = transportationDataMap.get(value.name);
                            value.registerTrunk = transportationData.registerTrunk;
                            value.nameDriver = transportationData.nameDriver;
                            value.registerDriver = transportationData.registerDriver;

                            table5.row.add(
                                value
                            ).draw();
                        });
                }
            },
            validating: function (e, ui) {
                var result = true;
                var index = parseInt(ui.index);
                var nextIndex = parseInt(ui.nextIndex);

                // // back navigation no check validation
                // console.log(ui);
                // console.log("validating step index: " +  ui.index );
                // console.log("validating step nextIndex: " + ui.nextIndex);
                // console.log("validating step parsed index: " + index);
                // console.log("validating step parsed nextIndex: " + nextIndex);


                if(index >= nextIndex)
                {
                    toBack = true;
                    // console.log("back o same");
                    return result;
                }
                else {
                    toBack = false;
                }

                if (index == 0)
                { // step-1 validation

                    var table = $('#data-table-step1').DataTable();

                    var count = table.rows( { selected: true } ).count();

                    if(count <= 0)
                    {
                        alert("Debe seleccionar al menos un contenedor en el paso 1.");
                        return false;
                    }

                    table
                        .rows( { selected: true } )
                        .data()
                        .each( function ( value, index ) {
                            // console.log( 'Data in index: '+index +' is: '+ value.name );
                            if(result && value.selectable)
                            {
                                if(processType == 1)
                                {
                                    value.type = containertDataMap.get(value.name);

                                    if(value.type.id == -1)
                                    {
                                        result = false;
                                        alert("Debe asignar un tipo para los contenedores seleccionados.");
                                        return false;
                                    }
                                }
                            }
                        } );

                    return result;

                }
                else if (index == 1)
                {

                    // step-1 validation
                    var table = $('#data-table-step2').DataTable();

                    table
                        .rows( )
                        .data()
                        .each( function ( value, index ) {

                            if(result && value.transCompany.id == -1){
                                result = false;
                                alert("Debe asignarle a todos los contenedores la empresa de transporte .");
                            }
                        });

                    return result
                }
                else if (index == 2)
                {
                    // var table = $('#data-table-step2').DataTable();
                    // var count = table.rows().count();
                    //
                    // if(selectedContainers.length == count)
                    // {
                    //     alert("Debe reservar cupos para todos los contenedores seleccionados.");
                    //     return false
                    // }

                    return true;
                }
                else if (ui.index == 3) { // paso 2: cedula, nombre del chofer, placa del carro

                    var table = $('#data-table-step4').DataTable();

                    table
                        .rows( )
                        .data()
                        .each( function ( value, index ) {

                            if(!result) return false;

                            if(selectedContainers.indexOf(value.name) != -1)
                            {
                                var transactionData = transportationDataMap.get(value.name);

                                if(!transactionData ||
                                    (transactionData.registerTrunk.length === 0 ||
                                    transactionData.registerDriver.length === 0 ||
                                    transactionData.nameDriver.length === 0))
                                {
                                    result = false;
                                    alert("Debe introducir la \"Placa del Carro\", \"Cédula\" y \"Nombre del Chofer\" para todo los contenedores.");
                                    return false;
                                }
                            }
                        });

                    return result;
                }
                else if (index == 4) {


                    if($("#confirming").prop('checked'))
                    {
                        // send info to server
                        var containers = [];

                        var table = $('#data-table-step5').DataTable();

                        table
                            .rows( )
                            .data()
                            .each( function ( value, index )
                            {

                                var container = {
                                    'calendarId':-1,
                                    'name':value.name,
                                    'transCompanyId':value.transCompany.id,
                                    'typeId':value.type.id,
                                    'nameDriver':value.nameDriver,
                                    'registerDriver':value.registerDriver,
                                    'registerTrunk':value.registerTrunk,
                                    'alias':value.alias,
                                    'ptId':value.ptId,
                                };

                                if(ticketDataMap.has(value.name))
                                {
                                    container.calendarId = ticketDataMap.get(value.name).calendarId;
                                }

                                containers.push(container);
                            } );

                        var process = {
                            "Process[agency_id]": agencyId, // FIXME THIS DEFINE BY USER WITH ROLE IMPORTER/EXPORTER
                            "Process[bl]":bl,
                            "Process[active]":1,
                            "Process[delivery_date]":processDeliveryDate,
                            "Process[type]":processType,
                            "Process[line_id]":lineNav.id,
                            "containers":containers
                        };

                        // console.log(process);
                        $.ajax({
                            // async:false,
                            url: homeUrl + "/rd/process/createfivesteps?type="+processType,
                            type: "POST",
                            dataType: "json",
                            data:  process,
//                            contentType: "application/json; charset=utf-8",
                            beforeSend:function () {
                                $("#modal-select-bussy").modal("show");
                            },
                            success: function (response) {

                                $("#modal-select-bussy").modal("hide");
                                // you will get response from your php page (what you echo or print)
                                // console.log(response);

                                if(response['success'])
                                {
                                    result = true;
                                    window.location.href = response['url'];
                                    // document.location.replace(response['url']);
                                }
                                else
                                {
                                    alert(response['msg']);
                                }
                                result = false;
                            },
                            error: function(data) {
                                $("#modal-select-bussy").modal("hide");
                                // console.log(data);
                                // console.log(data.responseText);
                                result = false;
                                // return false;
                            },
                        });

                        return result;
                    }

                    alert("Debe confirmar que la información es valida.");
                    return false;
                }
            },
            backBtnText:'Anterior',
            nextBtnText: 'Siguiente'
        }
    );
};

var FormWizardValidation = function () {
    "use strict";
    return {
        //main function
        init: function () {
            handleBootstrapWizardsValidation();
        }
    };
}();

var handleModal = function () {

    // select all in modal table
    $('#select-all-modal').on('click', function(){

        var table = $('#data-table-modal').DataTable();
        var count = table.rows( ).count();
        var disponivility = currentCalendarEvent.count;

        if(this.checked)
        {
            if(mode == 'create')
            {
                if(count <= disponivility)
                {
                    table.rows().select();
                }
                else {
                    this.checked = false;
                    alert('Solo hay ' + disponivility + ' cupos disponibles.');
                }
            }
            else if(mode == 'delete')
            {
                table.rows().select();
            }
            return;
        }
        table.rows().deselect();
    });

    $('#aceptBtn').on('click', function(){

        var table = $('#data-table-modal').DataTable();

        var count = table.rows( { selected: true } ).count();

        if(mode == 'create')
        {
            var disponivility = currentCalendarEvent.count;

            if(count > disponivility)
            {
                alert('La cantidad de contenedores seleccionados es superior a la disponibilidad: ' + count + ' de' + disponivility) ;
                return;
            }

            $('#calendar').fullCalendar('removeEventSources');

            table
                .rows( { selected: true } )
                .data()
                .each( function ( value, index ) {

                    if(selectedContainers.indexOf(value.name) === -1)
                    {
                        selectedContainers.push(value.name);

                        ticketDataMap.set(value.name, {
                            id:-1,
                            dateTicket:currentCalendarEvent.start,
                            calendarId:currentCalendarEvent.id,
                        });
                    }

                    currentCalendarEvent.count = currentCalendarEvent.count - 1;
                    currentCalendarEvent.title = String(currentCalendarEvent.count);

                    // create event ticket
                    var className = ['bg-blue-darker'];
                    var type = "";
                    var id = currentCalendarEvent.id;
                    if(String(value.tonnage) === "20")
                    {
                        id = currentCalendarEvent.id + "T20";
                        className = ['bg-green-darker'];
                        type = "T20";
                    }
                    else if(String(value.tonnage) === "40")
                    {
                        id = currentCalendarEvent.id + "T40";
                        className = ['bg-purple-darker'];
                        type = "T40";
                    }

                    var count = 1;
                    var result = findTicketEvent(id);

                    if(result.event)
                    {
                        result.event.count = result.event.count + count;
                        result.event.title = result.event.count;
                        ticketEvents[result.index] = result.event; // TODO CHECK THIS
                        result.event.containers.push(value.name);
                        // $('#calendar').fullCalendar('updateEvent', oldEvent);
                    }
                    else
                    {
                        var event = {
                            id: id,
                            title: count,
                            ticketId:-1,
                            start: currentCalendarEvent.start,//moment(currentCalendarEvent.start).utc() ,
                            end: currentCalendarEvent.end,//moment( currentCalendarEvent.end).utc() ,
                            allDay:false,
                            className : className ,
                            editable: false,
                            type:type,
                            count:count,
                            calendarId:currentCalendarEvent.id,
                            containers:[value.name]
                        };
                        ticketEvents.events.push(event);
                    }
                });

            calendarEventMap.set(currentCalendarEvent.id, currentCalendarEvent);

            calendarSlotEvents.events = Array.from(calendarEventMap.values());
        }
        else if(mode === 'delete')
        {
            if(count === 0)
            {
                alert('Debe seleccionar los cupos que desea eliminar.') ;
                return;
            }

            $('#calendar').fullCalendar('removeEventSources');

            table
                .rows( { selected: true } )
                .data()
                .each( function ( value, index ) {

                    var ticket = ticketDataMap.get(value.name, null);

                    if(ticket === null) //  ticket bug error
                    {
                        return false;
                    }

                    if(ticket.id === -1)
                    {
                        var id = currentCalendarEvent.id;
                        if(String(value.tonnage) === "20")
                        {
                            id = currentCalendarEvent.id + 'T20';
                        }
                        else if(String(value.tonnage) === "40")
                        {
                            id = currentCalendarEvent.id + 'T40';
                        }

                        var result = findTicketEvent(id);
                        if(result.event) // always
                        {
                            result.event.count = result.event.count - 1;
                            result.event.title = String(result.event.count);
                            var index = result.event.containers.indexOf(value.name)
                            result.event.containers.splice(index, 1);

                            if(result.event.count == 0)
                            {
                                ticketEvents.events.splice(result.index, 1);
                            }
                            else {
                                ticketEvents[result.index] = result.event;
                            }
                            var indexSelected = selectedContainers.indexOf(value.name);
                            selectedContainers.splice(indexSelected,1);

                            ticketDataMap.delete(value.name);
                            currentCalendarEvent.count = currentCalendarEvent.count + 1;
                        }
                    }
                });

            currentCalendarEvent.title = String(currentCalendarEvent.count);
            calendarEventMap.set(currentCalendarEvent.id, currentCalendarEvent);
            calendarSlotEvents.events = Array.from(calendarEventMap.values());
        }

        $('#calendar').fullCalendar('addEventSource',calendarSlotEvents);
        $('#calendar').fullCalendar('addEventSource',ticketEvents);
        $('#calendar').fullCalendar('refetchEventSources');
        $("#modal-select-containers").modal("hide");
        mode = null;
    });
};

var handleCalendar = function () {
    "use strict";

    // calendar
    var buttonSetting = {left: 'today prev,next ', center: 'title', right: 'month,agendaWeek,agendaDay'};
    // var buttonSetting = {left: 'today prev,next ', center: 'title', right: 'month,basicWeek,basicDay'};

    var calendar = $('#calendar').fullCalendar({
        // locale: 'es',
        height: 300,
        contentHeight:250,
        // aspectRatio:3.0,
        header: buttonSetting,
        selectable: true,
        editable: true,
        selectHelper: true,
        droppable:false,
        defaultView:'agendaWeek',
        allDaySlot: false,
        views: {
            day: {
                // titleFormat: 'MMM D, YYYY',
                allDaySlot:false,
                // allDayText:'',
            },
            month: {
                // titleFormat: 'MMM D, YYYY'
            },
            agenda: {
                // titleFormat: 'MMM D, YYYY',
                // contentHeight:'auto',       //auto
                allDaySlot: false, //Disable the allDay slot in agenda view
            }
        },
        firstHour:0,
        slotEventOverlap:false,
        eventOverlap: false,
        slotDuration:"00:60:00",
        slotLabelInterval:{hours:1},
        timeFormat: 'HH:mm',
        slotLabelFormat: 'HH:mm',
        // minTime:"00:00:00",
        // maxTime:"23:0:00",
        displayEventTime:false,
        displayEventEnd:false,
        // timezone:'UTC',
        eventOrder:'id',
        eventMouseover:function( event, jsEvent, view ) {
            var result = makePopoverContent(event);
            $(this).popover({
                html: true,
                title: result.title,
                content: result.conten,
                container: $('#page-container'),
                placement:'auto',
                selector:true
            });
            $(this).popover('show');
        },
        eventMouseout:function( event, jsEvent, view ) {
            $(this).popover("destroy");
        },
        dayClick: function( date, jsEvent, view, resourceObj ) {
            var view = $('#calendar').fullCalendar('getView');
            if(view.name === 'month')
            {
                alert('Mostar planificacion del dia');
            }
        },
        select: function(start, end, allDay) {

        },
        eventClick: function(calEvent, jsEvent, view) {
            if(calEvent.type === 'D')
            {
                // var result = findSlotEvent(calEvent.start, calEvent.end);
                var calendar = calendarEventMap.get(calEvent.id);
                currentCalendarEvent = calEvent;
                if(currentCalendarEvent)
                {
                    if(currentCalendarEvent.count <= 0 )
                    {
                        alert("No hay disponibilidad para esta fecha.");
                        return;
                    }

                    var table = $('#data-table-modal').DataTable();

                    var count = 0;
                    var count2 = 0;

                    table
                        .clear()
                        .draw();

                    var table2 = $('#data-table-step2').DataTable();

                    table2
                        .rows()
                        .data()
                        .each( function ( value, index ) {

                            // var container = containers.get(transaction.container_id);
                            var indexSelected = selectedContainers.indexOf(value.name);
                            var deliveryDate = moment(value.delivery_date).format('YYYY/MM/DD');
                            var calendarDeliveryDate = moment(currentCalendarEvent.end).format('YYYY/MM/DD');

                            console.log(deliveryDate);
                            console.log(calendarDeliveryDate);
                            var result = moment(calendarDeliveryDate) <= moment(deliveryDate);

                            if(indexSelected === -1)
                            {pera
                                if(result)
                                {
                                    table.row.add(
                                        {
                                            checkbox:"",
                                            name: value.name,
                                            type: value.type.code,
                                            tonnage: value.type.tonnage,
                                            deliveryDate:value.deliveryDate,
                                        }
                                    ).draw();
                                    count++;
                                }
                                else
                                {
                                    count2++;
                                }
                            }
                        });

                    if(count > 0)
                    {
                        mode = 'create';
                        $('#select-all-modal')[0].checked = false;
                        $("#modalTitle").get(0).textContent = 'Cupos disponibles: ' + currentCalendarEvent.title;
                        $("#modalTicket").get(0).textContent = moment(currentCalendarEvent.start).format("DD-MM-YYYY H:mm");
                        $("#aceptBtn").removeClass("btn-danger").addClass("btn-success");
                        $("#aceptBtn").text("Aceptar");
                        $("#modal-select-containers").modal("show");
                    }
                    else
                    {
                        if(count2 > 0)
                        {
                            alert('La fecha seleccionada en el calendario es mayor que la fecha límite de los contenedores.');
                            return false;
                        }
                        {
                            alert('Ya todas los contenedores de este proceso tienen turnos.');
                            return false;
                        }
                    }
                }
                else {
                    alert("Error buscando calendar event");
                    return false;
                }
            }
            else
            {
                var id = calEvent.calendarId; //calEvent.type === "T20"  ? calEvent.calendarId + "T20" : calEvent.calendarId + "T40" ;
                //console.log(id);
                currentCalendarEvent = calendarEventMap.get(id) ;

                if(!currentCalendarEvent)
                {
                    alert("Error buscando calendar");
                    return false;
                }

                var table = $('#data-table-modal').DataTable();

                table
                    .clear()
                    .draw();

                var count = 0;


                for(var i = 0, length = calEvent.containers.length ; i < length; i++) {

                    var cName = calEvent.containers[i];
                    var container = containersMap.get(cName);

                    var indexSelected = selectedContainers.indexOf(cName);

                    if(indexSelected !== -1)
                    {
                        table.row.add(
                            {
                                checkbox:"",
                                name: container.name,
                                type: container.type.code,
                                tonnage: container.type.tonnage,
                                deliveryDate:container.deliveryDate,
                            }
                        ).draw();
                        count++;
                    }
                }

                if(count > 0)
                {
                    mode = 'delete';
                    $('#select-all-modal')[0].checked = false;
                    $("#modalTitle").get(0).textContent = 'Eliminar Cupos';
                    $("#modalTicket").get(0).textContent = moment(currentCalendarEvent.start).format("DD-MM-YYYY H:mm");
                    $("#aceptBtn").removeClass("btn-success").addClass("btn-danger");
                    $("#aceptBtn").text("Eliminar");
                    $("#modal-select-containers").modal("show");
                }
            }
        },
        eventRender: function(event, element, calEvent) {
            element.attr('id', 'eee' + event.id);
        },
        eventAfterRender:function( event, element, view ) {

        },
    });

    $('#calendar').fullCalendar('addEventSource', calendarSlotEvents);
    $('#calendar').fullCalendar('refetchEventSources');
};

var Calendar = function () {
    "use strict";
    return {
        //main function
        init: function () {
            handleCalendar();
        }
    };
}();

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
            // console.log(response);

            if(response.success)
            {
                if(response['containers'].length)
                {
                    fetchContainerTypes(false);

                    var table = $('#data-table-step1').DataTable();
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

    var table = $('#data-table-step1').DataTable();

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
            // console.log(data);
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

var fetchCalendar = function (start, end, async) {

    $.ajax({
        async:async,
        url: homeUrl + "/rd/calendar/getcalendar",
        type: "get",
        dataType:'json',
        data: {
            start: start,
            end: end
        },
        success: function(response) {
            // console.log(response);

            $('#calendar').fullCalendar('removeEventSources', calendarSlotEvents.id);
            calendarSlotEvents.events = [];

            $.each(response,function (i) {
                var startDate = moment(response[i].start);
                var endDate = moment(response[i].end);
                // var startDate = response[i].start; // moment(response[i].start).toDate();
                // var endDate = response[i].end;//moment(response[i].end).toDate();

                var event = {
                    id: response[i].id,
                    title: String(response[i].count),
                    count: response[i].count,
                    start: startDate ,
                    end:  endDate  ,
                    allDay:false,
                    className : ['bg-blue-darker'],
                    editable: false,
                    type:'D',
                    calendarId: response[i].id
                }
                // $('#calendar').fullCalendar('renderEvent', event);

                calendarEventMap.set(response[i].id,event);
            });
            // console.log(calendarSlotEvents);
            // console.log(calendarEventMap.values());
            calendarSlotEvents.events = Array.from(calendarEventMap.values());

            $('#calendar').fullCalendar('addEventSource', calendarSlotEvents);
            $('#calendar').fullCalendar('refetchEventSources');
            $('#calendar').fullCalendar('gotoDate', moment(minDeliveryDate) );
        },
        error: function(response) {
            //console.log(response);
            //console.log(response.responseText);
            alert("Ah ocurrido un error al buscar las disponibilidad en el calendario.");
            result = false;
            // return false;
        }
    });
};

// make custom conten to popover by event
var makePopoverContent = function (event) {
    var result = {
        title:'',
        conten:''
    };
    var conten = '';
    if(event.type === 'D')
    {
        result.title = 'Cupos disponibles: ' + event.title;
    }
    else if(event.type === 'T20' || event.type === 'T40')
    {
        var containers = event.containers;
        result.title = 'Turnos para contenedores de ' +   event.type.replace('T','') + ' toneladas: ' + event.title;
        var containersConten  = '';
        $.each(containers, function (i) {
            var c = containersMap.get(containers[i]);
            containersConten += "<h5>" + c.name + " " + c.type.code + c.type.tonnage + "<h5>";
        });

        result.conten = containersConten;
    }

    return result;
};

var findTicketEvent = function (id) {
    var result = {
        index:-1,
        event:null
    };

    $.each(ticketEvents.events,function (i)
    {
        var event = ticketEvents.events[i];
        if(event.id === id)
        {   result.index = i;
            result.event = event;
            return false;
        }
    });
    return result;
};

$(document).ready(function ()
{
    // console.log(agencyId);
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

    // init calendar
    Calendar.init();

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

    // select2 to trans company
    handleSelectTransCompany();

    // get container types
    // fetchContainerTypes(true);

    // handle modal to select container
    handleModal();
});
