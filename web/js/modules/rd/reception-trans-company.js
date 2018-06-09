/**
 * Created by pedro on 30/05/2018.
 */

$(document).ready(function () {

    // init wizar
    FormWizardValidation.init();

    // init tables
    // TableManageTableSelect.init()

    Calendar.init();

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
});
