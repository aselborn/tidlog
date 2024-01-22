
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

    $.ajax({
        type: "POST",
        url: "addtime.php",
        data: formData,
        dataType: "json",
        encode: true,
    }).done(function (data) {
        console.log(data);

        window.location.reload();

    });
    event.preventDefault();

  });

  //Hanterar spara och uppdatera.
  $("#btnSave").on('click', function()
  {
    var title = $("#btnSave").val();
    if (title === 'Spara'){
        saveOrUpdate(true)
    }

    if (title === 'Uppdatera'){
        saveOrUpdate(false);
    }

  });


  function saveOrUpdate(isSave)
  {
    var script = ""
    const currentDate = new Date();

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
        $.ajax({
            type: "POST",
            url: "delete.php",
            data: formdata,
            dataType: "json",
            encode: true,
        }).done(function (data) {
            console.log(data);
            window.location.reload();
        });

    });

   //logga ut
   $("#btnLogOut").on('click', function(e){
        window.location.href = "./logout.php";
   });
   
   
   //Markera den rad som användaren klickar på.
   $('table tr').each(function(a,b){

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
