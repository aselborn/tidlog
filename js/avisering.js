$(document).ready(function() {
    
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

    const offset = firstDay.getTimezoneOffset()
    
    firstDay = new Date(firstDay.getTime() - (offset*60*1000))
    var dtFirst = firstDay.toISOString().split('T')[0]

    lastDay = new Date(lastDay.getTime() - (offset*60*1000))
    var dtLast = lastDay.toISOString().split('T')[0]


    $("#dtAviseringStart").val(dtFirst);
    $("#dtAviseringSlut").val(dtLast);

    
    //Skapa fakturaunderlag
    $("#btnSkapaFakturaUnderlag").on('click', function(){

        var theMontNo = $("#selectedMonthFaktura").val();
        var themonth = $("#selectedMonthFaktura option:selected" ).text();

        var theyear =  $("#selectedYearFaktura").val();
        

    var data = { nameOfFunction : 'skapa_fakturor', month : themonth,  monthNo : theMontNo, year : theyear };


    $.post("./code/util.php", data, function(response){

        if (response !== ""){
            if (JSON.parse(response).skapa_fakturor === 'false'){
                alert('Kunde inte skapa fakturor! ' + JSON.parse(response).orsak);
                return;
            } 

            window.location.reload();
        }

    });
    
    });
});