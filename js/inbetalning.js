

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
    
    var sumarized = {};


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

    //När man checkar / uncheckar.
  //https://gridjs.io/docs/examples/css-style
    $('.inp_checkbox').on('click', (event) => {
        
        var sumarized = numberChecked();

        totalBelopp = parseInt($("#txt_belopp").val());
        

        if (sumarized.noChecked === 0){
            totalBelopp = 0;
            $("#lblInbetaldSumma").text("0");
            return;
        }

        

        const chkBox = $(event.currentTarget)
        
        var origValue = event.currentTarget.defaultValue;
        var currentValue = event.currentTarget.value;
        

        $("#lblInbetaldSumma").text(sumarized.totalSum);
        console.log("antal markerade = " + sumarized.noChecked + " totalbelopp : " + sumarized.totalSum) ;

        setInbetalningEnabled(totalBelopp, sumarized.totalSum);
        

    });

    $('.binder_inbetalt_belopp').on('input', (event) =>{

        
        var belopp = event.currentTarget.valueAsNumber;
        var rowId = parseInt(event.currentTarget.id.replace("row_", ""));
      
        var sumarized = numberChecked();

        console.log("NoChecked = " + sumarized.noChecked + " SUMMA = " + sumarized.totalSum);
        
        $("#lblInbetaldSumma").text(sumarized.totalSum);
        setInbetalningEnabled(totalBelopp, sumarized.totalSum);
        
    });


    //hur många är checkade?
    function numberChecked()
    {
        var checkedItems = 0;
        var sumOfChecked =0;
        
        $("#tblInbetalning > tbody > tr").each(function () {
            var $tr = $(this);
            if ($tr.find(".inp_checkbox").is(":checked")) {
                checkedItems++;

                var newValue = parseInt($tr.find(".binder_inbetalt_belopp ").val());
                sumOfChecked += newValue;
            }

          });

          var sumarized = {
            noChecked: checkedItems,
            totalSum: sumOfChecked
          };

          return (sumarized);
    }

    //Registrera inbetalning

    $("#btnRegistreraInbetalning").on('click', function(e){

        var totInbetaltBelopp = 0;

        $("#tblInbetalning > tbody > tr").each(function () {
            var $tr = $(this);
            if ($tr.find(".inp_checkbox").is(":checked")) {
                $(this).find(".binder_inbetalt_belopp").each( function() {

                var inp = $(this).val();
                console.log(inp);
                totInbetaltBelopp += parseInt(inp);

              });

            }

          });

          console.log('Totalt inbetalt: ' + totInbetaltBelopp);


    });

    $("#txt_belopp").on('input', function(e){

        totalBelopp = parseInt($("#txt_belopp").val());

        var aktuellSumma = parseInt($("#lblInbetaldSumma").text());

        setInbetalningEnabled(totalBelopp, sumarized.totalSum);

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