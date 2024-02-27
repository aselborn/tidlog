$(document).ready(function() {

    setDateOnInput($("#dtDateGoneKontrakt"));
    setDateOnInput($("#dtDateGone"));
    
    $("#btnNyHyra").on('click', function(){

        var lagenhetNo = $("#hidlagenhetNo").val();
        var nyHyra = $("#txtNyHyra").val();

        if (nyHyra === "0" || nyHyra === "" || nyHyra === undefined)
            return;

        var data = { nameOfFunction : 'add_hyra', lagenhetNo: lagenhetNo, hyra: nyHyra, parkering: 0 };
        
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).add_hyra === 'false'){
                    alert('Kunde inte spara => ' + JSON.parse(response).orsak);
                    return;
                } 

                window.location.reload();
            }

        });
    });

    $("#btnRemovePark").on('click', function(){
        
        var lagenhetNo = $("#hidlagenhetNo").val();
        var data = { nameOfFunction : 'remove_parkering', lagenhetNo: lagenhetNo };
 
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).remove_parkering === 'false'){
                    alert('Kunde inte spara => ' + JSON.parse(response).orsak);
                    return;
                } 

                window.location.reload();
            }

        });
    });

    $("#cboParkering").on('change', function(){
        
        var lagenhetNo = $("#hidlagenhetNo").val();
        var parkVal = $("#cboParkering").val();

        if (parkVal === "0" || parkVal === "" || parkVal === undefined)
            return;

        var data = { nameOfFunction : 'add_hyra', lagenhetNo: lagenhetNo, hyra: 0, parkering: parkVal };
        
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).add_hyra === 'false'){
                    alert('Kunde inte spara => ' + JSON.parse(response).orsak);
                    return;
                } 

                window.location.reload();
            }

        });
    });

    //Visa raden lägga till kontrakt
    
    $("#btnAddKontraktDokument").on('click', function(){
        $("#rowNyttKontrakt").removeClass('d-none');
        $("#txtKontraktNamn").focus();
        $(this).addClass('d-none');
     });

    //Visa raden lägga till dokument
     $("#btnAddNyckelDokument").on('click', function(){
        $("#rowNyNyckel").removeClass('d-none');
        $("#txtNyckelNamn").focus();
        $(this).addClass('d-none');
     });
    

     //Spara nyckeldokument
     $("#btnSparaNyckelDokument").on('click', function(){

        var nyckelNamn = $("#txtNyckelNamn").val();
        var dtUt = $("#dtDateGone").val();
        

     });
})