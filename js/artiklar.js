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