<?php

//addtime.php
# Include connection
require_once "./config.php";
require_once "./managesession.php"

// $connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");

// $data = array(
//  ':first_name'  => $_POST["first_name"],
//  ':last_name'  => $_POST["last_name"]
// ); 

// $query = "
//  INSERT INTO tbl_sample 
// (first_name, last_name) 
// VALUES (:first_name, :last_name)
// ";

// $statement = $connect->prepare($query);

// if($statement->execute($data))
// {
//  $output = array(
//   'first_name' => $_POST['first_name'],
//   'last_name'  => $_POST['last_name']
//  );

//  echo json_encode($output);
// }

?>

<html>
 <head>
  <title>How to Use Ajax PHP to Append Last Inserted Data to HTML Tables | Using AJAX to append database rows to HTML tables</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
 </head>
 <body>
  <div class="container">
   <br />
   <br />
   <h2 align="center">How to Use Ajax PHP to Append Last Inserted Data to HTML Tables</h2><br />
   <h3 align="center">Add Details</h3>
   <br />
   <form method="post" id="add_details">
    <div class="form-group ">
     <label>Datum</label>
     <input type="text" name="date_executed" class="form-control" required />
    </div>
    <div class="form-group">
     <label>Last Name</label>
     <input type="text" name="last_name" class="form-control" required />
    </div>
    <div class="form-group">
     <input type="submit" name="add" id="add" class="btn btn-success" value="Add" />
    </div>
   </form>
   <br />
   <h3 align="center">View Details</h3>
   <br />
   <table class="table table-striped table-bordered">
    <thead>
     <tr>
      <th>First Name</th>
      <th>Last Name</th>
     </tr>
    </thead>
    <tbody id="table_data">
    <?php
    foreach($result as $row)
    {
     echo '
     <tr>
      <td>'.$row["first_name"].'</td>
      <td>'.$row["last_name"].'</td>
     </tr>
     ';
    }
    ?>
    </tbody>
   </table>
  </div>
 </body>
</html>

<script>
$(document).ready(function(){
 
 $('#add_details').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"insert.php",
   method:"POST",
   data:$(this).serialize(),
   dataType:"json",
   beforeSend:function(){
    $('#add').attr('disabled', 'disabled');
   },
   success:function(data){
    $('#add').attr('disabled', false);
    if(data.first_name)
    {
     var html = '<tr>';
     html += '<td>'+data.first_name+'</td>';
     html += '<td>'+data.last_name+'</td></tr>';
     $('#table_data').prepend(html);
     $('#add_details')[0].reset();
    }
   }
  })
 });
 
});
</script>