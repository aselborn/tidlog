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


    var postBackYear = $("#hdYear").val();
    var postBackMonth = $("#hdMonth").val();
    if (postBackYear !== undefined && postBackMonth !== undefined){
        $("#selectedYearFaktura").val(postBackYear).change();
        $("#selectedMonthFaktura").val(postBackMonth).change(); 
    } else{
    //Sätter dessa
         $("#selectedYearFaktura").val(year).change();
         $("#selectedMonthFaktura").val(month).change();
    }

    var tableRows = $("#hdRowCount").val();
    if (parseInt(tableRows) > 0){
        $("#btnSkapaFakturaUnderlag").addClass('disabled');
    }
  

    $("#selectedMonthFaktura").on('change', function(){
        $("#btnSelectPeriodPostBack").trigger('click');
    });

    $("#selectedYearFaktura").on('change', function(){
        $("#btnSelectPeriodPostBack").trigger('click');
    });


    $("#btnSelectPeriodPostBack").on('click', function(){

        var yr = $("#selectedYearFaktura").val();
        var mn = $("#selectedMonthFaktura").val();

        var fastighetId = $("#hdFastighet").val();

        var data = { faktMonth : mn,  faktYear : yr };

        var url = window.location.href;    
        
        // if (url.indexOf('?') > -1){
        //     url = url.substring( 0, url.indexOf( "?" ) );
        //     url += '?year=' + yr + '&month=' + mn;
        // }else{
        //     url += '?year=' + yr + '&month=' + mn;
        // }   

        if (url.indexOf('?') > -1){
            url = url.substring( 0, url.indexOf( "?" ) );
            //url += '?year=' + yr + '&month=' + mn;
            url += '?page=1' + '&fastighetId=' + fastighetId + '&year=' + yr + '&month=' +mn;
        }else{
            //url += '?year=' + yr + '&month=' + mn;
            url += '?page=1' + '&fastighetId=' + fastighetId + '&year=' + yr + '&month=' +mn;
        }   
        
        window.location.href = url;

    });

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

                    var totHyra = 0;
                    var totPark = 0;
                    //Det finns data. Skriv dessa till tabellen!
                    data.visa_period.forEach(element => {
                        console.log(element.fnamn);

                        var park = (element.avgift === null || element.avgift === "" ? "" : element.avgift);
                        var tot = (element.avgift === null || element.avgift ==="" ? 0 : element.avgift) + element.hyra;
                        totHyra = tot + totHyra;
                        totPark =  totPark + (element.avgift === null || element.avgift === "" ? 0 : element.avgift);

                        var tdData = "<tr>";
                        tdData = tdData.concat("<td>"  + element.fnamn + " " + element.enamn + "</td>");
                        tdData = tdData.concat("<td>"  + element.lagenhet_nr + "</td>");
                        tdData = tdData.concat("<td>"  + element.fakturanummer + "</td>");
                        tdData = tdData.concat("<td>"  + element.faktura_year + "-" + element.faktura_month + "</td>");
                        tdData = tdData.concat("<td>"  + element.hyra + "</td>");
                        tdData = tdData.concat("<td>"  + park + "</td>");
                        tdData = tdData.concat("<td>"  + tot + "</td>");
                        tdData = tdData.concat("<td><div class='align-items-center'>");
                        //tdData = tdData.concat("<input type='button' class='btn btn-link thebinder' faktura ='" + element.faktura_id + "'value='Skapa faktura'></input>");
                        tdData = tdData.concat("<input type='button' name='skapa_pdf' class='btn btn-primary thebinder' faktura ='" + element.faktura_id + "'value='Skapa faktura'></input>");
                        tdData = tdData.concat("</div></td>");
                        tdData = tdData.concat("</tr>");
                        
                        $("#tblAvisering tbody").append(tdData);

                       
                    });

                    tdData = "<tfoot>";
                    tdData = tdData.concat("<tr><th scope='row'>Total hyra</th>");
                    tdData = tdData.concat("<td>Perioden Hyra:  <strong>" + totHyra + " </strong></td>");
                    tdData = tdData.concat("<td>Perioden Parkering:  <strong>" + totPark + " </strong></td>");
                    tdData = tdData.concat("</tr></tfoot>");

                    $("#tblAvisering tfoot").append(tdData);

                }   
                
                
                
            }
    
        });
        
    });


    $('.binder_faktura_skicka').on('click', (event) => {
        
        const button = $(event.currentTarget);

        var fakturaId = button.attr('faktura');
        var hyresgastId = button.attr('hyresgast');

        var data = { faktura : fakturaId};

        $.post("./code/sendmail.php", data, function(response){

            if (response !== ""){
                // try{
                //     if (JSON.parse(response).skicka_faktura === true){
                //         window.location.reload();
                //     }
                // } catch (ex)
                // {
                //     alert(response);
                // }
                window.location.reload();
                
            }
    
            });

    });

    //Hantera hyresgäst, en knapp för varje rad.
    $('.thebinder').on('click', (event) =>
    {
        const button = $(event.currentTarget);

        var fakturaId = button.attr('faktura');
        var hyresgastId = button.attr('hyresgast');

        var data = {faktura_id : fakturaId, hyresgast_id : hyresgastId };
    
       $.post("./code/createpdf.php", data, function(response){

        if (response !== ""){
            
            window.location.reload();
        }

        window.location.reload();

        });
    })


    //Skapa fakturaunderlag
    $("#btnSkapaFakturaUnderlag").on('click', function(){

        
        var theMontNo = $("#selectedMonthFaktura").val();
        var themonth = $("#selectedMonthFaktura option:selected" ).text();

        var theyear =  $("#selectedYearFaktura").val();
        

    var data = { nameOfFunction : 'skapa_fakturor', month : themonth,  monthNo : theMontNo, year : theyear };


    $.post("./code/util.php", data, function(response){

        if (response !== ""){
            // if (JSON.parse(response).skapa_fakturor === 'false'){
            //     alert('Kunde inte skapa fakturor! ' + JSON.parse(response).orsak);
            //     return;
            // } 

            window.location.reload();
        }

       

    });
    
    });
});