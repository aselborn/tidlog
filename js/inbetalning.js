

function DisplayCurrentTime() {
    
    var date = new Date();
    var hours = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
    var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
    var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
    var time = hours + ":" + minutes + ":" + seconds;
    
    return time;
};




$(document).ready(function() {

    var totalBelopp = parseInt(0);
    $(document).on('click', "#tblInbetalning tbody tr", function(){

        $(this).toggleClass('selected');
        $('table tr').css('background','#ffffff');
        $(this).css('background','#37bade'); //Denna färg sätts.
    });
    

    $('.inp_belopp_binder').on('click', (event) =>{
        const button = $(event.currentTarget)
        var belopp = button.attr('belopp');

    
        console.log(belopp);
       
    });
  
    $('.inp_checkbox').on('click', (event) =>{
        
        var inp_belopp = parseInt($("#txt_belopp").val());

        const chkBox = $(event.currentTarget)
        
        var belopp = parseInt(chkBox.attr('belopp'));
        var isChecked = chkBox.prop('checked');
        if (isChecked === false)
            totalBelopp -= belopp;
        else
            totalBelopp += belopp;

        
        if (inp_belopp === totalBelopp){
            $("#btnRegistreraInbetalning").removeClass('d-none');
        } else {
            $("#btnRegistreraInbetalning").addClass('d-none');
        }

        $("#lblInbetaldSumma").text(totalBelopp);
        console.log("totalbelopp : " + totalBelopp) ;
    });

});