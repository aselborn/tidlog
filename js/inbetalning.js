

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
    createSums();
    var dataInbetalning = {};

    function createSums()
    {
        // $('input:checkbox[name=chk_inbetalt]').each( function() {
            
        //     if (this.checked){
                
        //     }

        // });

        $("#tblInbetalning tr").each( function (e){
            var data = e.currentTarget;
        });

                     
    }

    function setInbetalningEnabled(inp_belopp, aktuellSumma)
    {
        if ( (inp_belopp === totalBelopp) && (aktuellSumma == totalBelopp)){
            $("#btnRegistreraInbetalning").removeClass('d-none');
        } else {
            $("#btnRegistreraInbetalning").addClass('d-none');
        }
    }

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
  
    $('.inp_checkbox').on('click', (event) => {
        
        var inp_belopp = parseInt($("#txt_belopp").val());

        const chkBox = $(event.currentTarget)
        
        var origValue = event.currentTarget.defaultValue;
        var currentValue = event.currentTarget.value;

         var belopp = parseInt(chkBox.attr('belopp'));
         var isChecked = chkBox.prop('checked');
         if (isChecked === false)
             totalBelopp -= belopp;
         else
             totalBelopp += belopp;

        //totalBelopp = calculate_totalsumma(true);
        

        $("#lblInbetaldSumma").text(totalBelopp);
        console.log("totalbelopp : " + totalBelopp) ;

        setInbetalningEnabled(inp_belopp, totalBelopp);
        

    });

    $('.binder_inbetalt_belopp').on('change', (event) =>{

        const txtBelopp = $(event.currentTarget);
        
        var belopp = event.currentTarget.valueAsNumber;
        var rowId = parseInt(event.currentTarget.id.replace("row_", ""));
      
        var diff = parseInt(event.currentTarget.value) - parseInt(event.currentTarget.defaultValue);

        var isChecked = isRowChecked(rowId);

        var aktuellSumma = parseInt($("#lblInbetaldSumma").text());

        if (isChecked && diff !== 0){
            aktuellSumma += (diff)
            $("#lblInbetaldSumma").text(aktuellSumma);
        }

        setInbetalningEnabled(belopp, aktuellSumma);

        
        console.log(belopp);
        
    });

    //Registrera inbetalning
    $("#btnRegistreraInbetalning").on('click', function(e){

        alert('inbetalning !');

    });

    $("#txt_belopp").on('input', function(e){

        totalBelopp = parseInt($("#txt_belopp").val());

        var aktuellSumma = parseInt($("#lblInbetaldSumma").text());

        setInbetalningEnabled(totalBelopp, aktuellSumma);

        console.log(" Totalbelopp : " + totalBelopp);

    });

    $("#frmInbetalning").keypress(function (e){
        if (e.keyCode === 13){
            e.preventDefault();
            return false;
        }
    });

    function isRowChecked(row)
    {
        var isChecked = false;
        var cnt = 0;
        $('input:checkbox[name=chk_inbetalt]').each( function() {
            
            if (this.checked && cnt === row){
                //summa += parseInt($(this).attr('belopp'));
                isChecked = true;
                
            } 
            cnt++;
         });

         return isChecked;
    }
    
    function calc_sum()
    {
        var sum_checked = 0;
        $("#tblInbetalning > tbody > tr").each(function () {
            var $tr = $(this);
            if ($tr.find(".inp_checkbox").is(":checked")) {
              var $td = $tr.find("td");
              console.log($td.eq(1).text() + " " + $td.eq(2).text());

              sum_checked += parseInt($td.eq(2).text());
            }



          });

          return sum_checked;

    }

});