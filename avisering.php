<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      $db = new DbManager();

      if (!isset($_GET['page'])) 
      {
          $page = 1;
      } else {
          $page = $_GET['page'];
      }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Avisering</title>
    </head>

    <body>
        
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Avisering</h2>
            <hr />
            <div class="container " >
            <div class="row ">
                    <div class="col-2">
                        <label  class="label-primary">Månad</label>
                        <div class="form-control">
                        <select class="form-select" id="selectedMonthFaktura">
                            <option value="1" >Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Mars</option>
                            <option value="4">April</option>
                            <option value="5">Maj</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Augusti</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">December</option>

                        </select>
                        </div>
                        
                        <!-- <input type="date" class="form-control" id="dtAviseringStart" name="dtFom"> -->
                    </div>
                    <div class="col-2">
                        <label  class="label-primary">År</label>
                        <div class="form-control">
                        <select class="form-select" id="selectedYearFaktura">
                            <option>2024</option>
                            <option>2025</option>
                            <option>2026</option>
                            <option>2027</option>
                            <option>2028</option>
                            <option>2029</option>
                            <option>2030</option>
                        </select>
                        </div>
                    </div>

                    <div class="col-2">
                        <label  class="label-primary">Skapa fakturor</label>
                        <input type="button" class="btn btn-success " id="btnSkapaFakturaUnderlag" name="skapaFaktura" value="Skapa underlag">
                    </div>
            </div>

                <table id="tblAvisering" class="table table-primary mt-3">

                    <tr>
                        <th scope="col" class="table-primary">Hyresgäst</th>
                        <th scope="col" class="table-primary">Lägenhet</th>
                        <th scope="col" class="table-primary">Belopp</th> 
                        <th scope="col" class="table-primary">Faktura</th>
                    </tr>

                </table>
                <form  action="./code/createpdf.php" method="post" enctype="multipart/form-data">
                    <input type="submit" value="Skapa PDF" id="btnPdf" class="btn btn-success" ></input>
                </form>
                
            </div>
        </body>
</html>