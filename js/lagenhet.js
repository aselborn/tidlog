$(document).ready(function() {

    $("#btnSave").on('click', function(){

        var fastighetId = $("#fastighetId option:selected").val();
        var lagenhetNo = $("#lagenhetNo").val();
        var yta = $("#lagenhetYta").val();

        var data = { nameOfFunction : 'add_apartment', fastighet_Id: fastighetId, lagenhet_No: lagenhetNo, yta: yta };
        
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

    $("#fastighetId").on('change', function(){

        var fastighet_id = $("#fastighetId option:selected").val();
        
        var data = { nameOfFunction : 'filter_lagenhet', fastighet_id: fastighet_id };
        
        $.post("./code/util.php", data, function(response){

            if (response !== undefined ){
                var data = JSON.parse(response);

                $("#lagenhetTable").find("tr:gt(0)").remove();

                data.filter_lagenhet.forEach(element => {                    
                    console.log(element.lagenhet_nr + " " + element.fastighet_namn + " " + element.yta);
                    
                    $("#lagenhetTable tbody").append("<tr><td>" + element.lagenhet_nr + "</td><td>" + element.fastighet_namn +"</td><td>"+ element.yta +"</td><td>");


                });
            }

        });

    });

});