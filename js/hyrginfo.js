$(document).ready(function() {
    var hyresgastId =$("#hidHyresgastId").val();
    var alreadyUppsagdDatum = $("#hidKontraktUppsagdDatum").val();

    var isAndrahand = false;

    if (alreadyUppsagdDatum !== ""){
        $("#dtDateBackKontrakt").attr('disabled', 'disabled');
        $("#btnContractNoValid").addClass('d-none');
    }

    setDateOnInput($("#dtDateBackKontrakt"));

    $("#chkAndraHand").on('change', function() {

        isAndrahand = this.checked;

    });

    $("#btnUppdateraHyresgast").on('click', function(){
      
        //var lagenhetId = $("#lagenhetId option:selected").val();
        var fnamn = $("#fnamn").val();
        var enamn = $("#enamn").val();
        var telefon = $("#telefon").val();
        var epost = $("#epost").val();
        var hyresgastId = $("#hidHyresgastId").val();
        var adress = $("#adress").val();
    
        var data = { nameOfFunction : 'uppdatera_hyresgast', hyresgast_id: hyresgastId, fnamn: fnamn, enamn: enamn, 
            adress : adress, telefon: telefon, epost: epost , andrahand: isAndrahand };
        
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).added_apartment === 'false'){
                    alert('Kunde inte spara => ' + JSON.parse(response).orsak);
                    return;
                } 

                
                window.location.reload();
            }

        });
     

    });

    //Åter kontrakt.
    $("#btnContractNoValid").on('click', function(){
        
        var uppsagd_datum = $("#dtDateBackKontrakt").val();

        var data = { nameOfFunction : 'sag_upp_kontrakt', hyresgastId : hyresgastId, datum : uppsagd_datum };

        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).sag_upp_kontrakt === 'false'){
                    alert('Kunde inte spara => ' + JSON.parse(response).orsak);
                    return;
                } 

                
                window.location.reload();
            }

        });
     

    });

});
