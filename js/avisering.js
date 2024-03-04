$(document).ready(function() {
    
    var date = new Date();

    var month = date.getMonth() +1;
    var year = date.getFullYear();

    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

    const offset = firstDay.getTimezoneOffset()
    
    firstDay = new Date(firstDay.getTime() - (offset*60*1000))
    var dtFirst = firstDay.toISOString().split('T')[0]

    lastDay = new Date(lastDay.getTime() - (offset*60*1000))
    var dtLast = lastDay.toISOString().split('T')[0]


    //Sätter dessa
    // $("#selectedYearFaktura").val(year).change();
    // $("#selectedMonthFaktura").val(month).change();
    

    // //Användaren väljer månad
    // $("#selectedMonthFaktura").on('change', function(e){
    //     var fakturaMonth = this.value;
    // });

    // //Användaren väljer år
    // $("#selectedYearFaktura").on('change', function(e){
    //     var fakturaYear = this.value;
    //     window.location.href = window.location.href.replace( /[\?#].*|$/, "?year=" + fakturaYear );
    // });


    $("#btnSelectPeriod").on('click', function(){

        var yr = $("#selectedYearFaktura").val();
        var mn = $("#selectedMonthFaktura").val();

        var data = { faktMonth : mn,  faktYear : yr };

        $.post("./code/util.php", data, function(response){

            $("#tblAvisering tbody").empty();
            $("#tblAvisering tfoot").empty();
                    

            if (response !== ""){

                if (JSON.parse(response).visa_period === 'false'){
                    alert('Kunde inte skapa fakturor! ' + JSON.parse(response).orsak);
                    return;
                } 
    
                var data = JSON.parse(response);
                if (data.visa_period.length > 0){

                    //Det finns data. Skriv dessa till tabellen!
                    data.visa_period.forEach(element => {
                        console.log(element.fnamn);

                        var park = (element.avgift === undefined || element.avgift === "" ? 0 : element.avgift);
                        var tot = (element.avgift === undefined || element.avgift ==="" ? 0 : element.avgift) + element.hyra;

                        var tdData = "<tr>";
                        tdData = tdData.concat("<td>"  + element.fnamn + " " + element.enamn + "</td>");
                        tdData = tdData.concat("<td>"  + element.lagenhet_nr + "</td>");
                        tdData = tdData.concat("<td>"  + element.fakturanummer + "</td>");
                        tdData = tdData.concat("<td>"  + element.faktura_year + "-" + element.faktura_month + "</td>");
                        tdData = tdData.concat("<td>"  + element.hyra + "</td>");
                        tdData = tdData.concat("<td>"  + park + "</td>");
                        tdData = tdData.concat("<td>"  + tot + "</td>");
                        tdData = tdData.concat("</tr>");

                        $("#tblAvisering tbody").append(tdData);

                    });

                }   
                
                
                
            }
    
        });
        
    });

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