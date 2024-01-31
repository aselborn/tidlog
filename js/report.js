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

                if (jsondata.error !== undefined){
                    alert(jsondata.error); //gör detta till en text på sidan istället.
                    return;
                }

                if (jsondata.filtered_report.length > 0){
                    
                    $("#jobTable").find("tr:gt(0)").remove();

                    jsondata.filtered_report.forEach(element => {                    
                        console.log(element.job_description);

                        $("#jobTable tbody").append("<tr><td>" + element.job_date + "</td><td>" + element.job_hour +"</td><td>"+ element.job_fastighet +"</td><td>" + element.job_description + "</td></tr>");

                    });

                    $("#navigationDiv").remove();
    
                }
                
            }

        });

    });

});