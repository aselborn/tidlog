$(document).ready(function() {

    $("#btnSave").on('click', function(){

        var fastighetId = $("#fastighetId option:selected").val();
        var lagenhetNo = $("#lagenhetNo").val();
        var yta = $("#lagenhetYta").val();

        var data = { nameOfFunction : 'add_apartment', fastighet_Id: fastighetId, lagenhet_No: lagenhetNo, yta: yta };
        
        $.post("./code/util.php", data, function(response){

            if (response !== ""){
                alert('OK!');
            }

        });


    });

});