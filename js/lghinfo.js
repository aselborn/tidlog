$(document).ready(function() {

    setDateOnInput($("#dtDateGoneKontrakt"));
    setDateOnInput($("#dtDateGone"));
    setDateOnInput($("#dtGiltligFran"));
    
    $("#btnSparaMoms").on('click', function(){
        
        var moms = $("#lblMomsSum").text();
        if (moms === ''){
            alert('Moms kan inte vara tomt om det skall sparas');
            $("#lblMomsSum").focus();
            return ;
        }

        var lagenhetNo = $("#hidlagenhetNo").val();
        var momsprocent = $("#txtmomsProcent").val();
        
        var data = { nameOfFunction : 'add_moms', lagenhetNo: lagenhetNo, moms_procent: momsprocent, moms: moms };

        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).add_moms === 'false'){
                    alert('Kunde inte spara => ' + JSON.parse(response).orsak);
                    return;
                } 

                window.location.reload();
            }

        });


    });

    $("#txtmomsProcent").on('change', function(){

        var myPercentVal = parseInt($("#txtmomsProcent").val());
        
        var hyra = parseInt($("#hidHyra").val());
        var park = parseInt($("#hidPark").val());
        var fExists = $("#hidFskatt").val() !== undefined ? true : false;
        var fskatt = 0;

        if (fExists)
            fskatt = parseInt($("#hidFskatt").val()) / 12;

        var totMedMoms = parseFloat(myPercentVal/100) * (hyra + park + fskatt) ;

        $("#lblMomsSum").text(parseInt(totMedMoms));
        
    });

    $("#btnNyHyra").on('click', function(){

        var lagenhetNo = $("#hidlagenhetNo").val();
        var nyHyra = $("#txtNyHyra").val();
        var lagenhetId = $("#hidLagenhetId").val();
        var giltligFran = $("#dtGiltligFran").val();

        if (nyHyra === "0" || nyHyra === "" || nyHyra === undefined)
            return;

        var data = { nameOfFunction : 'update_hyra', lagenhetId : lagenhetId, lagenhetNo: lagenhetNo, hyra: nyHyra, giltligFran : giltligFran };
        
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).update_hyra === 'false'){
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
        var lagenhetId = $("#hidLagenhetId").val();

        var parkVal = $("#cboParkering").val();

        if (parkVal === "0" || parkVal === "" || parkVal === undefined)
            return;

        var data = { nameOfFunction : 'update_parkering', lagenhetId : lagenhetId, parkId: parkVal };
        
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).update_parkering === 'false'){
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


     //Spara vindsutrymme
    $("#cboVind").on('change', function(){
        
        var lagenhetNo = $("#hidlagenhetNo").val();
        var lagenhetId = $("#hidLagenhetId").val();

        var vindVal = $("#cboVind").val();

        if (vindVal === "0" || vindVal === "" || vindVal === undefined)
            return;

        var data = { nameOfFunction : 'update_vind', lagenhetId : lagenhetId, vindVal: vindVal };
        
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).update_vind === 'false'){
                    alert('Kunde inte spara => ' + JSON.parse(response).orsak);
                    return;
                } 

                window.location.reload();
            }

        });
    });

     //Spara källareutrymme
     $("#cboKallare").on('change', function(){
        
        var lagenhetNo = $("#hidlagenhetNo").val();
        var lagenhetId = $("#hidLagenhetId").val();

        var kallareVal = $("#cboKallare").val();

        if (kallareVal === "0" || kallareVal === "" || kallareVal === undefined)
            return;

        var data = { nameOfFunction : 'update_kallare', lagenhetId : lagenhetId, kallareVal: kallareVal };
        
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).update_vind === 'false'){
                    alert('Kunde inte spara => ' + JSON.parse(response).orsak);
                    return;
                } 

                window.location.reload();
            }

        });
    });

    //ta bort vind
    $("#btnRemoveVind").on('click', function(){
        
        var lagenhetNo = $("#hidlagenhetNo").val();
        var data = { nameOfFunction : 'remove_vind', lagenhetNo: lagenhetNo };
 
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).remove_vind === 'false'){
                    alert('Kunde inte spara => ' + JSON.parse(response).orsak);
                    return;
                } 

                window.location.reload();
            }

        });
    });

    //ta bort källare
    $("#btnRemoveKallare").on('click', function(){
        
        var lagenhetNo = $("#hidlagenhetNo").val();
        var data = { nameOfFunction : 'remove_kallare', lagenhetNo: lagenhetNo };
 
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                if (JSON.parse(response).remove_vind === 'false'){
                    alert('Kunde inte spara => ' + JSON.parse(response).orsak);
                    return;
                } 

                window.location.reload();
            }

        });
    });
})