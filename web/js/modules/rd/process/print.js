/**
 * Created by yopt on 17/06/2018.
 */



$(function () {


$('#print-process').click(function(){
    var id = $(this).attr("abount");
    var url = homeUrl+'/rd/process/print?id='+id;
    window.open(url, 'Imprimir', 'menubar=0, toolbar=0, screenY=0 width=850, innerWidth=780, dependent=1, location=0, status=0, scrollbars=1');
});

});
