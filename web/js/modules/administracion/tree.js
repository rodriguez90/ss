/**
 * Created by yopt on 13/05/18.
 */



var handleJstreeDefault = function() {
    $('#jstree-default').jstree({
        "core": {
            "themes": {
                "responsive": false
            }
        },
        "types": {
            "default": {
                "icon": "fa fa-folder text-warning fa-lg"
            },
            "file": {
                "icon": "fa fa-file text-inverse fa-lg"
            }
        },
        "plugins": ["types"]
    });

    /*
    $('#jstree-default').on('select_node.jstree', function(e,data) {

        var link = $('#' + data.selected).find('.parent');
        if (link.attr("href") != "#" && link.attr("href") != "javascript:;" && link.attr("href") != "") {
            if (link.attr("target") == "_blank") {
                link.attr("href").target = "_blank";
            }
            document.location.href = link.attr("href");
            return false;
        }


    });
    */
};


$(function (){

    handleJstreeDefault();

    $('.parent').click(function () {
        var link = $(this);
        if (link.attr("href") != "#" && link.attr("href") != "javascript:;" && link.attr("href") != "") {
            document.location.href = link.attr("href");
        }
    });
});
