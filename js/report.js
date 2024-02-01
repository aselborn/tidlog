$(document).ready(function() {

    var options = $.extend({}, // empty object    
                $.datepicker.regional["sv-SE"], {  
                    dateFormat: "yy-mm-dd"  
                } // your custom options    
            );  
    
    $("#dtFom").datepicker(options);
    $("#dtTom").datepicker(options);
    
    var totalRowsUnfiltered = $("#totalRowCount").val();
    $("#lblTotalCount").text('Totalt antal registreringar : ' + totalRowsUnfiltered);

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

                $("#jobTable").find("tr:gt(0)").remove();
                if (jsondata.filtered_report.length === 0){
                    $("#lblErrorLabel").text('Inga rader!');
                }

                if (jsondata.filtered_report.length > 0){
                    
                    

                    var totHourT7 = 0;
                    var totU9 =0;

                    jsondata.filtered_report.forEach(element => {                    
                        console.log(element.job_description);
                        
                        if (element.job_fastighet === "T7")
                            totHourT7 += element.job_hour;
                        if (element.job_fastighet === "U9")
                            totU9 += element.job_hour;

                        $("#jobTable tbody").append("<tr><td>" + element.job_date + "</td><td>" + element.job_hour +"</td><td>"+ element.job_fastighet +"</td><td>" + element.job_description + "</td></tr>");


                    });

                    //Footer.
                    
                    $("#navigationDiv").remove();
    

                    //var rowCount = $("#totalRowCount").val();

                }
                
            }

        });

    });

});