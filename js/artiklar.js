$(document).ready(function() {

    var postBackHyresgast = $("#hdHyresgastId").val();
    
    if (postBackHyresgast !== undefined){
        $("#selectHyresgast").val(postBackHyresgast).change();
        
    } else{
    //Sätter dessa
         $("#selectHyresgast").val(postBackHyresgast).change();
    }

    // $("#btnRaderaExtraFaktura").on('click', function(){
    //     alert('ok');
    // });

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
        var fastighetId = $("#hidFastighetId").val();

        var url = window.location.href; 
        if (url.indexOf('?') > -1){
            url = url.substring( 0, url.indexOf( "?" ) );
            //url += '?year=' + yr + '&month=' + mn;
            url += '?page=1' + '&fastighetId=' + fastighetId + '&hyresgastId=' + hyresgastId;
        }else{
            //url += '?year=' + yr + '&month=' + mn;
            url += '?page=1' + '&fastighetId=' + fastighetId + '&hyresgastId=' + hyresgastId;
        }   
        
        window.location.href = url;

        // var data = { nameOfFunction: 'visa_extrakostnader',  hyresgastId : hyresgastId};

        //  $.post("./code/util.php", data, function(response){
                
        //     if (response !== "")
        //     {
        //         var jsondata = JSON.parse(response);

        //         if (jsondata.extra_artiklar.length > 0){
        //             $("#tblExtraFaktura").find("tr:gt(0)").remove();

        //             $("#divArtikel").removeClass('d-none');

        //             jsondata.extra_artiklar.forEach(element => {                    
        //                 console.log(element.artikel);

        //                 var buttonMap = "<td><input type=button class='btn btn-outline-success btn-sm rounded-5 radera_binder' ";
        //                 buttonMap = buttonMap.concat("id='btnRaderaExtraFaktura' value=radera </input> </td>");

        //                 var tddata = "<tr id='" + element.artikel_id + "'</td>";
        //                 tddata = tddata.concat("<td>" + element.artikel + "</td>");
        //                 tddata = tddata.concat("<td>" + element.totalbelopp + "</td>");
        //                 tddata = tddata.concat("<td>" + element.giltlig_from.replace(' 00:00:00', '') + "</td>");
        //                 tddata = tddata.concat("<td>" + element.giltlig_tom.replace(' 00:00:00', '') + "</td>");
        //                 tddata = tddata.concat("<td>" + element.kommentar + "</td>");

        //                 tddata = tddata.concat(buttonMap);

        //                 tddata = tddata.concat("</tr>");

        //                 $("#tblExtraFaktura tbody").append(tddata);

        //             });
                    
        //         } else{
        //             $("#divArtikel").addClass('d-none');
        //         }

        //     }
        // });

    });

    $('.radera_binder').on('click', (event) =>
    {
        const button = $(event.currentTarget);

        var artikelId = button.attr('artikel');
        
        $.alert({
            title: 'Information!',
            content: 'Vill du <strong>rader</strong> denna rad?!',
            icon: 'fa fa-rocket',
            animation: 'scale',
            closeAnimation: 'scale',
            buttons: {
              okay: {
                text: 'Ok, radera.',
                btnClass: 'btn-blue',
                action: function(){
                
                
                var data = { nameOfFunction : 'remove_extraartikel', artikelId : artikelId }
                        
                $.post("./code/util.php", data, function(response){

                      if (response !== ""){
                          
                          window.location.reload();
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

        

      //  });
    })
    
});