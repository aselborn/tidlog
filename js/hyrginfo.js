$(document).ready(function() {
    var hyresgastId =$("#hidHyresgastId").val();
    var alreadyUppsagdDatum = $("#hidKontraktUppsagdDatum").val();

    var isAndrahand = false;

    if (alreadyUppsagdDatum !== ""){
        $("#dtDateBackKontrakt").attr('disabled', 'disabled');
        $("#btnContractNoValid").addClass('d-none');
    }

    setDateOnInput($("#dtDateBackKontrakt"));
    setDateOnInput($("#dtDepositionDatum"));
    setDateOnInput($("#dtDepositionDatumAter"));

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

    //Visa raden LÄGGA TILL DEPOSITION.
    
      $("#btnNyDeposition").on('click', function(){
        $("#rowNyDeposition").removeClass('d-none');
        $("#idDepositionBelopp").focus();
        $(this).addClass('d-none');
     });


     //Ändra depositionen.
     $("#btnChangeDeposition").on('click', function(){
        $('.row_deposition').removeClass('d-none');
        $("#dtDepositionDatumAter").removeClass('d-none');
        $("#idBeloppAter").removeClass('d-none');
        $(this).addClass('d-none');
     });


  //Visa raden lägga till kontrakt
    $("#btnAddKontraktDokument").on('click', function(){
        $("#rowNyttKontrakt").removeClass('d-none');
        $("#txtKontraktNamn").focus();
        $(this).addClass('d-none');
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

    function setCurrentDate(){
        var d = new Date();

        var month = d.getMonth()+1;
        var day = d.getDate();
    
        var output = d.getFullYear() + '/' +
        (month<10 ? '0' : '') + month + '/' +
        (day<10 ? '0' : '') + day;

        return output;
    }
    
    //Hantera hyresgäst, en knapp för varje rad.
    $('.binderBelopp').on('change', (event) =>
    {
        const input = $(event.currentTarget);

        //var ids = $(".binderBelopp").map(function(index, element){return element.id});

        var inbetalt =  parseInt(input.val());

        var hyresgastId = input.attr('id');

        var tg = "#lblHyra" + hyresgastId;

        var hyra = parseInt($("#lblHyra" + hyresgastId).text());
        var park = parseInt($("#lblPark" + hyresgastId).text())
        if (isNaN(park))
            park = 0;

        var diff = (inbetalt - (hyra+park));

        
        $("#lblDiff" + hyresgastId).text(diff);
        if (diff < 0)
        {
            $("#lblDiff" + hyresgastId).addClass('text-warning fw-bold bg-danger')

        }
        if (diff > 0)
        {
            $("#lblDiff" + hyresgastId).addClass('text-warning fw-bold');
        }
        
        $("#btnSparaInbetalning" + hyresgastId).prop('disabled', false);
        
    })

    $('.binderHyreskoll').on('click', (event) =>{

        const button = $(event.currentTarget);
        
        var fakturaId = button.attr('faktura');
        var hyresgastId = button.attr('hyresgast');
        var diff = $("#lblDiff" + hyresgastId).text();
        var dtInbetald = $("#dtInbetald" + hyresgastId).val()
        var kolladAv = $("#hidUserName").val();
        
        
        var data = { nameOfFunction : 'spara_hyreskoll', fakturaId : fakturaId, hyresgastId : hyresgastId, diff : diff , dtInbetald : dtInbetald, kolladAv: kolladAv }
                        
        $.post("./code/util.php", data, function(response){

            window.location.reload();

        });



    });

});
