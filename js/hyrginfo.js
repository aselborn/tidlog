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

    $("#btnNyHyresgast").on('click', function(){
        var fnamn = $("#fnamn").val();
        var enamn = $("#enamn").val();
        var telefon = $("#telefon").val();
        var epost = $("#epost").val();
        
        var hyresgastId = $("#hidHyresgastId").val();
        var fastighetId = $("#hidFastighetId").val();

        var adress = $("#adress").val();
        var lagenhetId = $("#lagenhetId").val();
    
        var data ="";

        var data = { nameOfFunction : 'add_hyresgast', hyresgast_id: hyresgastId, fnamn: fnamn, enamn: enamn, 
        adress : adress, telefon: telefon, epost: epost , andrahand: isAndrahand, lagenhetId: lagenhetId };
            
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).added_apartment === 'false'){
                    alert('Kunde inte spara => ' + JSON.parse(response).orsak);
                    return;
                } 

                
                window.location.href = "./hyresgaster.php?fastighetId=" + fastighetId;
            }

        });
    });


    $("#btnUppdateraHyresgast").on('click', function(){
      
        var fnamn = $("#fnamn").val();
        var enamn = $("#enamn").val();
        var telefon = $("#telefon").val();
        var epost = $("#epost").val();
        var hyresgastId = $("#hidHyresgastId").val();
        var adress = $("#adress").val();
        var lagenhetId = $("#lagenhetId").val();
    
        var data ="";

        
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

    function spara_hyresgast(upd){
        
    }

    $('.alert_me').on('click', function(){
        var hyresgastId = $("#hidHyresgastId").val();
        var lagenhetId = $("#hidlagenhetId").val();
        $.confirm({
            title: 'Bekräfta att du vill säga upp hyresgästen!',
            content: 'När hyresgästen tas bort, kommer historiken finnas kvar. Lägenheten kan nu hyras ut till annan person',
            buttons: {
               
                ok : {
                    text: 'Ta bort hyresgäst?',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){

                        var data = { nameOfFunction : 'tabort_hyresgast', hyresgastId : hyresgastId, lagenhetId : lagenhetId }
                        
                        $.post("./code/util.php", data, function(response){

                            if (response !== ""){
                                $.alert('Hyresgästen togs bort.');
                                window.location.href = "./hyresgaster.php";
                            }

                        });

                        
                    }
                },
                nej : {
                    text: 'Avbryt',
                    btnClass: 'btn-red',
                    keys: ['enter', 'shift'],
                    action: function(){
                        $.alert('Avbrutet.');
                    }
                }
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
