$(document).ready(function() {

    $("#btnNyArtikel").on('click', function(){

        var artikel = $("#artikel").val();
        var kommentar = $("#kommentar").val();

        if (artikel.length > 0 )
        {
       
            var data = { nameOfFunction: 'spara_artikel',  artikel : artikel,  kommentar : kommentar };
            $.post("./code/util.php", data, function(response){
                
                if (response !== ""){
                    if (JSON.parse(response).spara_artikel === 'false'){
                        alert('Kunde inte spara => ' + JSON.parse(response).orsak);
                        return;
                    } 
    
                    window.location.reload();
                }
            });

        }

    });

    $("#selectHyresgast").on('change', function(){

        var hyresgastId = $("#selectHyresgast").val();

        var data = { nameOfFunction: 'visa_extrakostnader',  hyresgastId : hyresgastId};

         $.post("./code/util.php", data, function(response){
                
            if (response !== "")
            {
                var jsondata = JSON.parse(response);

                if (jsondata.extra_artiklar.length > 0){
                    $("#tblExtraFaktura").find("tr:gt(0)").remove();
                    $("#divArtikel").removeClass('d-none');

                    jsondata.extra_artiklar.forEach(element => {                    
                        console.log(element.artikel);

                        $("#tblExtraFaktura tbody").append(
                            "<tr><td>" + element.artikel + "</td><td>" 
                            + element.totalbelopp +
                            "</td><td>"
                            + element.giltlig_from +
                            "</td><td>" 
                            + element.giltlig_tom + 
                            "</td><td>" + element.kommentar + "</tr>");

                    });
                    
                } else{
                    $("#divArtikel").addClass('d-none');
                }

            }
        });

    });
});