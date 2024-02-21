$(document).ready(function() {

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

    $("#btnParkering").on('click', function(){

        var lagenhetNo = $("#hidlagenhetNo").val();
        var park = $("#txtParkering").val();

        if (park === "0" || park === "" || park === undefined)
            return;

        var data = { nameOfFunction : 'add_hyra', lagenhetNo: lagenhetNo, hyra: 0, parkering: park };
        
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
    
})