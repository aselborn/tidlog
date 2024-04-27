
$('.inbetald_binder').on('click', (event) =>{
    const button = $(event.currentTarget)
});

function DisplayCurrentTime() {
    
    var date = new Date();
    var hours = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
    var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
    var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
    var time = hours + ":" + minutes + ":" + seconds;
    
    return time;
};

$(document).ready(function() {

    var faktNr = "";
   

    // $('#idFakturaId').on("input", function(e) {
        
    //     e.preventDefault();

    //     var dInput = this.value;
        
    //     var toSearch = String(dInput);
    //     if (toSearch.length >= 5)
    //     {
    //         if ($("#txt_belopp").val() == ''){
    //             $.alert({
    //                 title: 'Information!',
    //                 content: 'För att söka, måste du först ange ett totalbelopp',
    //                 icon: 'fa fa-rocket',
    //                 animation: 'scale',
    //                 closeAnimation: 'scale',
    //                 buttons: {
    //                   okay: {
    //                     text: 'Ok, jag anger väl ett totalbelopp, tror jag...',
    //                     btnClass: 'btn-blue',
    //                     action: function(){
    //                         $("#txt_belopp").focus();
    //                         e.preventDefault();
    //                         return;
    //                     }
    //                   }
    //                 }
    //               });

                  

                  
    //         };

            

    //         var data = { search_for : 'faktura_nummer', faktNr: dInput };
        
    //         $.post("./code/sokfaktura.php", data, function(response){
            
    //             if (response !== ""){

    //                 $('#tblInbetalning tbody').empty();
    //                 var jsondata = JSON.parse(response);
    
    //                 if (jsondata.error !== undefined){
    //                     alert(jsondata.error); //gör detta till en text på sidan istället.
    //                     return;
    //                 }

    //                 var resultSet = "<tr class='faktura_binder'>";
    //                 jsondata.fakturor.forEach(element => {
    //                     //console.log(element.fakturanummer);
    //                     resultSet = resultSet.concat("<td>" + element.fakturanummer + " </td>");
    //                     resultSet = resultSet.concat("<td>" + element.belopp + " </td>");
    //                     resultSet = resultSet.concat("<td>" + element.namn + " </td>");
    //                     resultSet = resultSet.concat("<td>" + element.lagenhetNo + " </td>");
    //                     resultSet = resultSet.concat("</tr>");
    //                 });

    //                 $("#tblInbetalning tbody").append(resultSet);
    //                 //var table = $('#tblInbetalning').DataTable();
    //                 //table.ajax.reload();
    //                 //$("#tblInbetalning").bootstrapTable();
    
    //             }
    //         });
    //     }

    // });

});