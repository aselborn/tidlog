$(document).ready(function() {
    var hyresgastId ="";

    //hämta alla hyresgäster för en viss fastighet
    $("#cboFastighet").on('change', function(e){

        
        alert(this.value);

    });

    


    //Hantera hyresgäst, en knapp för varje rad.
    $('.binder').on('click', (event) =>
    {
        const button = $(event.currentTarget);
        hyresgastId = button.attr('hyresgast');
        
        var data = {hyresgast_id : hyresgastId };
        
        window.location.href = "hyrginfo.php?hyresgast_id=" + hyresgastId;
       
    })


   
    

    //Klick på tabellen
    //en användare klickar på en rad. hämta data för den raden.
   $(document).on('click', "#hyresgastTable tbody tr", function(){
    


        hyresgastId = $(this).closest('tr').attr('id').trim();

        $(".highlight").removeClass("highlight");
        $(this).addClass("highlight");

        //var lagenhetId = $("#lagenhetId option:selected").val();

        var fnamn =  $(this).closest('tr').find('td')[0].innerHTML;
        var enamn =  $(this).closest('tr').find('td')[1].innerHTML;
        
        var telefon =  $(this).closest('tr').find('td')[4].innerHTML;
        var epost =  $(this).closest('tr').find('td')[3].innerHTML;
        var selectedAppartment = $(this).closest('tr').find('td')[2].innerHTML;

        let text = $(this).closest('tr').find('td')[2].innerHTML;
        
        $("select option").filter(function() {
            //may want to use $.trim in here
            return $(this).text() == text;
            }).attr('selected', true);

        $("#fnamn").val(fnamn);
        $("#enamn").val(enamn);
        $("#telefon").val(telefon);
        $("#epost").val(epost);

        
        $("#btnSparaHyresgast").prop("value", "Uppdatera");

   });

});