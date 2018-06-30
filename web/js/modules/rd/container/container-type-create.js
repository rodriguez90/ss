/**
 * Created by pedro on 30/06/2018.
 */
var handleIonRangeSlider = function() {

    var $range = $("#default_rangeSlider");

    // $range.ionRangeSlider({
    //     type: "single",
    //     min: 20,
    //     max: 40,
    //     from: 20,
    //     step: 20,
    //     prettify: false,
    //     // hasGrid: true,
    //     // onStart: function (data) {
    //     //     console.log("onStart");
    //     // },
    //     // // onChange: function (data) {
    //     // //     console.log("onChange");
    //     // // },
    //     // onFinish: function (data) {
    //     //     console.log("onFinish");
    //     //     // console.log(data);
    //     //     // // var $this =  ;
    //     //     // var value = $('#default_rangeSlider').prop("value", data);
    //     //     //
    //     //     // console.log("Value: " + value);
    //     //
    //     // },
    //     // onUpdate: function (data) {
    //     //     console.log("onUpdate");
    //     // }
    // });

    $range.ionRangeSlider({
        type: "single",
        values:[20,40],
        from: 20,
        // prettify: false,
        // hasGrid: true,
        // onStart: function (data) {
        //     console.log("onStart");
        // },
        // // onChange: function (data) {
        // //     console.log("onChange");
        // // },
        onFinish: function (data) {
            console.log("onFinish");
            // console.log(data);
            // // var $this =  ;
            // var value = $('#default_rangeSlider').prop("value", data);
            //
            // console.log("Value: " + value);

        },
        // onUpdate: function (data) {
        //     console.log("onUpdate");
        // }
    });

    $range.on("change", function () {
        var $this = $(this);
        var value = $this.prop("value");

        console.log("Value: " + value);
    });
};

var FormPlugins = function () {
    "use strict";
    return {
        //main function
        init: function () {
            handleIonRangeSlider();
        }
    };
}();

$(document).ready(function() {
    FormPlugins.init();
});