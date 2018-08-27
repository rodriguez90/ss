/**
 * Created by pedro on 25/07/2018.
 */

$("input").keypress(function (event) {
    if(event.which == 13)
    {
        event.preventDefault();
        $("form").submit();
    }
});
