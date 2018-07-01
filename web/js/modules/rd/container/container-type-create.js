/**
 * Created by pedro on 30/06/2018.
 */
var handleIonRangeSlider = function() {

    var $range = $("#default_rangeSlider");

    $range.ionRangeSlider({
        type: "single",
        values:[20,40],
        prettify: false,
        hasGrid: false,
        onStart: function (data) {
            console.log("onStart");
        },
        onChange: function (data) {
            console.log("onChange");
            console.log(data);
            // // var $this =  ;
            var value = $('#default_rangeSlider').prop("value", data.fromValue);
            //
            console.log("Value: " + data.fromValue);
        },
        onFinish: function (data) {
            console.log("onFinish");
            console.log(data);
            // // var $this =  ;
            var value = $('#default_rangeSlider').prop("value", data.fromValue);
            //
            console.log("Value: " + data.fromValue);

        },
        onUpdate: function (data) {
            console.log("onUpdate");
        }
    });

    $range.on("change", function () {
        var $this = $(this);
        var value = $this.prop("value");

        console.log("Value: " + value);
    });

    $('#default_rangeSlider').prop("value", modelTonnage);
};

var handleBootstrapCombobox = function() {
    $('.combobox').combobox();
};

$(document).ready(function() {
    handleIonRangeSlider();
    handleBootstrapCombobox();
});