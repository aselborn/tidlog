$(document).ready(function() {

    
    $("#dtFom").datepicker();
    $("#dtTom").datepicker($.datepicker.regional["fr"]);

    $("#btnFilter").on('click', function() {
        var dtFom = $("#dtFom").val();
        var dtTom = $("#dtTom").val();
        
        if (dtFom === undefined || dtFom === ""){
            alert('För att filtrera måste startdatum anges!');
            $("#dtFom").focus();
            return;
        }

        if (dtTom === undefined || dtTom === ""){
            alert('För att filtrera måste slutdatum anges!');
            $("#dtTom").focus();
            return;
        }

        $.ajax({
            url : "./code/util.php",
            type: "POST",
            dataType: "json",
            data : {nameOfFunction : "filter_report"},
            success : function (result){
                alert('OK!');
            }
        });

    });

});