
$(document).ready(function() {
   
    var jobId = "";
    var saved_by = "";

    $("#frmInput").submit(function (event) {
    var formData = {
      job_date: $("#job_date").val(),
      job_hour: $("#job_hour").val(),
      job_fastighet: $("#job_fastighet").val(),
      job_description: $("#job_description").val(),
      job_username : $("#hidUserName").val()
    };

   
    event.preventDefault();

  });

 

  function saveOrUpdate(isSave)
  {
    var script = ""
    var myUserName = $("#hidUserName").val();
    const currentDate = new Date();

    if ($("#job_description").val() === ""){
      $.alert({
        title: 'Information!',
        content: 'Du <strong>måste</strong> ange en beskrivning om vad du gjort!',
        icon: 'fa fa-rocket',
        animation: 'scale',
        closeAnimation: 'scale',
        buttons: {
          okay: {
            text: 'Ok, jag fattar',
            btnClass: 'btn-blue'
          }
        }
      });

      return;
    }

    var formData = {
        JobId : jobId,
        job_date: $("#job_date").val(),
        job_hour: $("#job_hour").val(),
        job_fastighet: $("#job_fastighet").val(),
        job_description: $("#job_description").val(),
        job_username : $("#hidUserName").val(),
        job_savedby : saved_by
      };

      if (isSave === true){
        script = 'code/addtime.php';
      } else{
        script = 'code/update.php';

        if (myUserName !== saved_by){
          $.alert({
            title: 'Information!',
            content: 'Det är <strong>inte</strong> tillåtet att uppdatera andras registreringar!',
            icon: 'fa fa-rocket',
            animation: 'scale',
            closeAnimation: 'scale',
            buttons: {
              okay: {
                text: 'Ok, jag fattar, tror jag...',
                btnClass: 'btn-blue'
              }
            }
          });
  
          return;
        }

      }

  
      $.ajax({
          type: "POST",
          url: script,
          data: formData,
          dataType: "json",
          encode: true,
      }).done(function (data) {

          console.log(data);

          if (data.error !== undefined){
        
            alert(data.error);

          }

          window.location.reload();
  
      });
  }

  
  //en användare klickar på en rad. hämta data för den raden.
   $(document).on('click', "#jobTable tbody tr", function(){

      jobId = $(this).closest('tr').attr('id');
      saved_by = $(this).closest('tr').find("td:eq(1)").text();
      
      $("#hidClickedUserName").val(saved_by);
      $("#hidClickedJobId").val(jobId);

      
      $(this).addClass('selected');

      var formdata = {"jobId" : jobId};
      $.ajax({
        type: "POST",
        url: "code/getrecord.php",
        data: formdata,
        dataType: "json",
        encode: true,
    }).done(function (data) {

        console.log(data);

        $("#job_date").val(data.job_date);
        $("#job_hour").val(data.job_hour) ;
        $("#job_fastighet").val(data.job_fastighet);
        $("#job_description").val(data.job_description)  ;

        
    });

   });

    //RADERA
    $("#btnDelete").on('click', function(){
      
      var formdata = {"jobId" : jobId};

      var myUserName = $("#hidUserName").val();
      if (myUserName !== saved_by){
        $.alert({
          title: 'Information!',
          content: 'Det är <strong>inte</strong> tillåtet att radera andras registreringar!',
          icon: 'fa fa-rocket',
          animation: 'scale',
          closeAnimation: 'scale',
          buttons: {
            okay: {
              text: 'Ok, jag fattar',
              btnClass: 'btn-blue'
            }
          }
        });

        return;
      }


      $.confirm({
        title: 'Bekräfta att du vill ta bort registreringen',
        content: 'När registeringen tas bort, kan den inte återskapas',
        buttons: {
           
            ok : {
                text: 'Ta bort registrering?',
                btnClass: 'btn-blue',
                keys: ['enter', 'shift'],
                action: function(){
                    
                  var data = { nameOfFunction : 'remove_timereg', jobId : jobId }
                        
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
       
       

    });

   //logga ut
   $("#btnLogOut").on('click', function(e){
        window.location.href = "./logout.php";
   });
   
   
   //Markera den rad som användaren klickar på.
   $('#jobTable tr').each(function(a,b){

    var jobId = ($(this).attr('id'));

    $(b).click(function(){
         $('table tr').css('background','#ffffff');
         $(this).css('background','#37bade'); //Denna färg sätts.

         $("#btnSave").prop("value", "Uppdatera");
         

         $("#btnDelete").removeClass('disabled');
         $("#btnDelete").addClass('enabled');

         $("#btnNew").removeClass('disabled');
         $("#btnNew").addClass('enabled');
         
    });

    $("#btnSave").prop("value", "Spara");

    $("#btnDelete").removeClass('enabled');
    $("#btnDelete").addClass('disabled');

    $("#btnNew").removeClass('enabled');
    $("#btnNew").addClass('disabled');

  });

  $("#btnNew").on('click', function(){
    window.location.reload();
  });

});
