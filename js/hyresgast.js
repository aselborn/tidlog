$(document).ready(function() {

    $("#btnSparaHyresgast").on('click', function(){
      
        var lagenhetId = $("#lagenhetId option:selected").val();
        var fnamn = $("#fnamn").val();
        var enamn = $("#enamn").val();
        var telefon = $("#telefon").val();
        var epost = $("#epost").val();

        var data = { nameOfFunction : 'add_hyresgast', lagenhet_id: lagenhetId, fnamn: fnamn, enamn: enamn, telefon: telefon, epost: epost };
        
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

});