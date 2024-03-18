<?php
      if (!isset($_SESSION)) { session_start(); }
      require_once "./code/dbmanager.php";
      require_once "./code/managesession.php";

      $db = new DbManager();

      $hyresgaster = $db->query(("SELECT * FROM tidlog_hyresgaster"))

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Skapa en faktura</title>        
    </head>

    <body>
        
        <?php include("./pages/sidebar.php") ?>

        <div class="col-sm  min-vh-100 border">
            <h2>Skapa en faktura</h2>
            <hr />
            <div class="container " >

            <div class="row mt-3">
                    <div class="col">
                        <table class="table table-hover table-striped " id="tblSpecialFaktura">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="table-primary">FakturaNr</th>
                                    <th scope="col" class="table-primary">Belopp</th>
                                    <th scope="col" class="table-primary">Moms</th>
                                    <th scope="col" class="table-primary">Total</th>
                                    <th scope="col" class="table-primary">Skapad</th>
                                    <th scope="col" class="table-primary">Betald</th>
                                    <th scope="col" class="table-primary"></th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="row mt-3 border">
                <!-- <form action="/action_page.php">
                    <div class="d-flex flex-nowrap">
                        <div class="order-2 p-1">
                            <label id="lblFastighet" for="idFaktura" class="label-primary">Fakturanummer</label>
                            <input type="text" id="idFaktura" class="form-control" />
                        </div>
                        <div class="order-2 p-1">
                            <label id="lblFastighet" for="idFaktura" class="label-primary">Belopp</label>
                            <input type="text" id="idFaktura" class="form-control" />
                        </div>
                        <div class="order-2 p-1">
                            <label id="lblFastighet" for="idFaktura" class="label-primary">Moms</label>
                            <input type="text" id="idFaktura" class="form-control" />
                        </div>
                        
                    </div>
                    
                </form> -->

            <form class="row g-3" action=./code/skapafaktura.php method="post" id="frmFaktura" >
                <div class="col-md-2">
                    <label for="inputEmail4" class="form-label">Fakturanummer</label>
                    <input type="text" class="form-control" id="fakturaNr" name="fakturaNr" required data-error="ange ett fakturanummer">
                </div>
                <div class="col-md-1">
                    <label for="inputPassword4" class="form-label">Belopp</label>
                    <input type="number" class="form-control" id="belopp" name ="belopp" required="required" data-error="ange belopp">
                </div>
                <div class="col-md-1">
                    <label for="inputPassword4" class="form-label">moms</label>
                    <input type="number" class="form-control" id="moms" name ="moms" required data-error="ange moms">
                </div>
                
                <div class="col-10">
                    <label for="inputAddress" class="form-label">Beskrivning</label>
                    <textarea id="idBeskrivning" name="beskrivning" class="form-control" placeholder="Ange en beskrivning. Dela upp på max tre rader" rows="3" required="required" data-error="Ge beskrivning till fakturan"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-outline-success rounded-5">Skapa faktura</button>
                </div>
            </form>
                
            
            
        </div>
    </body>
</html>