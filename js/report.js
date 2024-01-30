$(document).ready(function() {

    var options = $.extend({}, // empty object    
                $.datepicker.regional["sv-SE"], {  
                    dateFormat: "yy-mm-dd"  
                } // your custom options    
            );  
    
    $("#dtFom").datepicker(options);
    $("#dtTom").datepicker(options);
    
    $("#btnFilter").on('click', function() {
        var dtFom = $("#dtFom").val();
        var dtTom = $("#dtTom").val();
        var theFastighet = $("#job_fastighet option:selected").text();

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

        var data = { nameOfFunction : 'filter_report', fomDate: dtFom, tomDate: dtTom, fastighet: theFastighet };
        
        $.post("./code/util.php", data, function(response){
            
            if (response !== ""){
                
                var jsondata = JSON.parse(response);

                response.forEach(element => {
                    
                    console.log(element.job_description);

                });

            }

        });

    });

});