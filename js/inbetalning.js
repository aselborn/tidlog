

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
    var sumMatrix = [];
    var radSumma = {};


        
    function setSearchTableVisible(status){
        if (status === true){
            $("#tblInbetalning").removeClass('d-none');
        } else{
            $("#tblInbetalning").addClass('d-none');
        }
    }



    function setInbetalningEnabled(inp_belopp, aktuellSumma)
    {
        if ( (inp_belopp === totalBelopp) && (aktuellSumma == totalBelopp)){
            $("#btnRegistreraInbetalning").removeClass('d-none');
        } else {
            $("#btnRegistreraInbetalning").addClass('d-none');
        }

        $("#hidInbetaldDatum").val($("#bg_date").val());
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
            $("#lblTotSum").addClass("d-none");
            return;
        }

        $("#lblTotSum").removeClass("d-none");
        $("#lblTotSum").text("Antal markerade : " + sumarized.noChecked + " total summa : " + sumarized.totalSum);

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
        sumMatrix = [];
        var dtInbetald = $("#hidInbetaldDatum").val();
        $("#tblInbetalning > tbody > tr").each(function () {
            var $tr = $(this);
            if ($tr.find(".inp_checkbox").is(":checked")) {
                checkedItems++;

                var faktId = parseInt($tr.attr('id'));
                var newValue = parseInt($tr.find(".binder_inbetalt_belopp ").val());
                sumOfChecked += newValue;

                radSumma = {
                    fakturaId : faktId,
                    radSumma : newValue,
                    datum : dtInbetald
                }

                sumMatrix.push(radSumma)
            }

          });

          var sumarized = {
            noChecked: checkedItems,
            totalSum: sumOfChecked
          };

          console.log(sumMatrix);

          return (sumarized);
    }

    //Registrera inbetalning

    $("#btnRegistreraInbetalning").on('click', function(e){


        if (sumMatrix.length === 0){
            console.log('Listan är tom, konstigt nog.');
            return;
        }

        //Kontrollera datum. Om dagens datum måste detta verifieras.

        var inputDate = new Date(($("#bg_date").val()));
        var todaysDate = new Date();

        
        if(inputDate.setHours(0,0,0,0) == todaysDate.setHours(0,0,0,0)) {
            
            $.alert({
                title: 'Information!',
                content: 'Du registrerar inbetalning på dagens datum! Är det korrekt??',
                icon: 'fa fa-rocket',
                animation: 'scale',
                closeAnimation: 'scale',
                buttons: {
                  okay: {
                    text: 'Ok, fortsätt registrera.',
                    btnClass: 'btn-blue',
                    action: function(){
                    
                        var data = {"inbet": JSON.stringify(sumMatrix)};
                            
                    $.post("./code/reginbet.php", data, function(response){
    
                        if (response !== ""){
                            if (JSON.parse(response).reg_inbet === 'true'){
                                $("#tblInbetalning tbody > tr").empty();
                                
                                setInbetalningEnabled(-1, 2);
                                $("#lblTotSum").addClass("d-none");
                            }
                        }
    
                      });
    
                    }
                  }, 
                  nej : {
                    text: 'Avbryt',
                    btnClass: 'btn-red',
                    keys: ['enter', 'shift'],
                    action: function(){
                        $.alert('Ingen registrering gjordes!.');
                    }
                }
                }
              });



        } else {

            sumMatrix.forEach((item) => {
                console.log(item.fakturaId + " " +  item.radSumma);
            });
    
            var data = {"inbet": JSON.stringify(sumMatrix)};
    
            $.post("./code/reginbet.php", data, function(response){
                    
                if (response !== ""){
                    if (JSON.parse(response).reg_inbet === 'true'){
                        $("#tblInbetalning tbody > tr").empty();
                        
                        setInbetalningEnabled(-1, 2);
                        $("#lblTotSum").addClass("d-none");
                    }
                    //window.location.reload();        
                }
    
            });

        }

        
        


    });

    $("#txt_belopp").on('input', function(e){

        totalBelopp = parseInt($("#txt_belopp").val());

        var sumarized = numberChecked();

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
    
    

});